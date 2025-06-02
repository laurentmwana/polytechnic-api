<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\Course\CourseItemResource;
use App\Http\Resources\Course\CourseCollectionResource;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['teacher', 'level'])
            ->orderByDesc('updated_at')
            ->paginate();

        return CourseCollectionResource::collection($courses);
    }


    public function store(CourseRequest $request)
    {
        $course = Course::create($request->validated());

        return response()->json([
            'state' => $course !== null,
        ]);
    }

    public function show(string $id)
    {
        $course = Course::findOrFail($id);

        return new CourseItemResource($course);
    }

    public function update(CourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);

        $state = $course->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }


    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        $state = $course->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
