<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Student;
use App\Enums\RoleUserEnum;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserItemResource;
use App\Http\Resources\User\UserCollectionResource;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with(['student'])
            ->where(function ($builder) {
                $builder->where('roles', 'like', '%' . RoleUserEnum::STUDENT->value . '%')
                    ->orWhere('roles', 'like', '%' . RoleUserEnum::DISABLE->value . '%');
            })
            ->orderByDesc('updated_at')
            ->paginate(15);

        return UserCollectionResource::collection($users);
    }


    public function store(UserRequest $request)
    {
        $user = User::create([
            ...$this->getDataInsert($request),
            'roles' => [RoleUserEnum::STUDENT->value],
            'password' => Hash::make($request->validated('password'))
        ]);

        $this->addInStudent(
            $user,
            $request->validated('student_id')
        );

        $state = $user->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return new UserItemResource($user);
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $state = $user->update([
            ...$this->getDataInsert($request),
            'password' => Hash::make($request->validated('password'))
        ]);

        $this->addInStudent(
            $user,
            $request->validated('student_id')
        );

        return response()->json([
            'state' => $state
        ]);
    }

    public function lock(string $id)
    {
        $user = User::findOrFail($id);

        $disableRole = RoleUserEnum::DISABLE->value;

        $roles = in_array($disableRole, $user->roles)
            ? array_filter($user->roles, fn($v) => $v != $disableRole)
            : [...$user->roles, $disableRole];

        $state = $user->update([
            'roles' => $roles,
        ]);

        return response()->json([
            'state' => $state
        ]);
    }


    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $state = $user->delete();

        return response()->json([
            'state' => $state
        ]);
    }

    private function getDataInsert(UserRequest $request): array
    {
        return [
            'name' => $request->validated('name'),
            'firstname' => $request->validated('firstname'),
            'email' => $request->validated('email'),
        ];
    }

    private function addInStudent(User $user, int $studentId)
    {
        $student = Student::find($studentId);

        $student->update([
            'user_id' => $user->id,
        ]);
    }
}
