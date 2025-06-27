<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\SemesterEnum;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\Course\CourseItemResource;
use App\Http\Resources\Course\CourseCollectionResource;
use App\Services\SearchData;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index(Request $request)
    {
        $builder = Course::with(['teacher', 'level'])
            ->orderByDesc('updated_at');

        $semester = $request->query->get('semester');
        $search = $request->query->get('search');

        $builder = Course::with(['teacher', 'level']);

        if (!empty($semester) && isset($semesters[$semester])) {
            if (!isset($semesters[$semester])) {
                abort(401, "Nous n'avons pas trouvé le semestre $semester");
            }

            $builder->where('semester', '=', QUERY_SEMESTERS[$semester]);
        }

        if ($search && !empty($search)) {
            $builder = SearchData::handle($builder, $search, SEARCH_FIELDS_COURSE);
        }

        $courses = $builder->paginate();

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
