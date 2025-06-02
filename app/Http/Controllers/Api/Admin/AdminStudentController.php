<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\Student\StudentItemResource;
use App\Http\Resources\Student\StudentActionResource;
use App\Http\Resources\Student\StudentCollectionResource;

class AdminStudentController extends Controller
{

    public function index()
    {
        $students = Student::with(['actualLevel'])->orderByDesc('updated_at')
            ->paginate();

        return StudentCollectionResource::collection($students);
    }

    public function store(StudentRequest $request)
    {
        $student = Student::create($request->validated());

        return new StudentActionResource($student);
    }

    public function show(string $id)
    {
        $student = Student::findOrFail($id);

        return new StudentItemResource($student);
    }


    public function update(StudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);

        $state = $student->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        $state = $student->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
