<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Http\Resources\Teacher\TeacherCollectionResource;
use App\Http\Resources\Teacher\TeacherItemResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function index(Request $request)
    {
        $builder = Teacher::with(['courses', 'department'])
            ->orderByDesc('updated_at');

        $search = $request->query->get('search');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_TEACHER);
                $query->orWhereHas('department', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_DEPARTMENT);
                });
            });
        }

        $teachers = $builder->paginate();

        return TeacherCollectionResource::collection($teachers);
    }


    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return response()->json([
            'state' => $teacher !== null,
        ]);
    }

    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        return new TeacherItemResource($teacher);
    }

    public function update(TeacherRequest $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $state = $teacher->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }


    public function destroy(string $id)
    {
        $deliberation = Teacher::findOrFail($id);

        $state = $deliberation->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
