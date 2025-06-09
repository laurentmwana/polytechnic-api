<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseItemResource;
use App\Http\Resources\Course\CourseCollectionResource;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['teacher', 'level'])
            ->orderByDesc('updated_at')
            ->paginate();

        return CourseCollectionResource::collection($courses);
    }


    public function show(string $id)
    {
        $course = Course::findOrFail($id);

        return new CourseItemResource($course);
    }
}
