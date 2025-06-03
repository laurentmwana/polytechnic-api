<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Student;
use App\Models\ActualLevel;
use Illuminate\Support\Str;
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
        $student = Student::create([
            ...$request->validated(),
            'registration_token' => Str::random(10),
        ]);

        ActualLevel::create([
            'student_id' => $student->id,
            'level_id' => $request->validated('level_id'),
            'year_academic_id' => $request->validated('year_academic_id')
        ]);


        return response()->json([
            'state' => $student !== null
        ]);

        return new StudentActionResource($student);
    }

    public function show(string $id)
    {
        $student = Student::with(['user', 'actualLevel'])
            ->findOrFail($id);

        return new StudentItemResource($student);
    }


    public function update(StudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);

        $state = $student->update($request->validated());

        $student->actualLevel()->update([
            'level_id' => $request->validated('level_id')
        ]);

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
