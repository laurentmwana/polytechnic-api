<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Course;
use App\Models\YearAcademic;
use Illuminate\Http\Request;
use App\Models\CourseFollowed;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseFollow\CourseFollowCollectionResource;

class CourseFollowedController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $paids = CourseFollowed::with(['student', 'yearAcademic', 'course'])
            ->where('student_id', '=', $user->student->id)
            ->orderByDesc('updated_at')->paginate();

        return CourseFollowCollectionResource::collection($paids);
    }

    public function follow(string $id, Request $request)
    {
        $user = $request->user();

        $course = Course::findOrFail($id);

        $year = YearAcademic::where('is_closed', '=', false)
            ->first();

        if (!($year instanceof YearAcademic)) {
            throw new \Exception("L'année académique en cours n'existe pas");
        }


        $follow = CourseFollowed::where('student_id', '=', $user->student->id)
            ->where('course_id', '=', $course->id)
            ->where('year_academic_id', '=', $year->id)
            ->first();


        if ($follow instanceof CourseFollowed) {
            $follow->delete();

            $state = false;
        } else {
            CourseFollowed::create([
                'student_id' => $user->student->id,
                'year_academic_id' => $year->id,
                'course_id' => $course->id,
            ]);
            $state = true;
        }

        return response()->json([
            'state' => $state
        ]);
    }
}
