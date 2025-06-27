<?php

namespace App\Http\Controllers\Api\Other;

use App\Enums\SemesterEnum;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseItemResource;
use App\Http\Resources\Course\CourseCollectionResource;
use App\Services\SearchData;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $semesters = [
            's1' => SemesterEnum::SEMESTER_1,
            's2' => SemesterEnum::SEMESTER_2,
        ];
        $semester = $request->query->get('semester');
        $search = $request->query->get('search');

        $builder = Course::with(['teacher', 'level']);

        if ($semester) {
            if (!isset($semesters[$semester])) {
                abort(401, "Nous n'avons pas trouvé le semestre $semester");
            }
            $semesterValue = $semesters[$semester];
            $builder->where('semester', '=', $semesterValue);
        }

        if ($search && !empty($search)) {
            $builder = SearchData::handle($builder, $search, [
                'id',
                'name',
                'credits'
            ]);
        }


        $courses = $builder->orderByDesc('updated_at')->paginate();

        return CourseCollectionResource::collection($courses);
    }


    public function show(string $id)
    {
        $course = Course::findOrFail($id);

        return new CourseItemResource($course);
    }
}
