<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Http\Resources\Deliberation\DeliberationItemResource;
use App\Http\Resources\Deliberation\DeliberationCollectionResource;

class AdminTeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['courses', 'department'])
            ->orderByDesc('updated_at')
            ->paginate();

        return DeliberationCollectionResource::collection($teachers);
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

        return new DeliberationItemResource($teacher);
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
