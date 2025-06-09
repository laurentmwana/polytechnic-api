<?php



namespace App\Helpers;

use App\Models\User;
use App\Models\CourseFollowed;

abstract class FollowStudent
{

    public static function isFollow(int $courseId, ?User $user): bool
    {
        if (!$user) return false;

        $follow = CourseFollowed::where('student_id', '=', $user->student->id)
            ->where('course_id', '=', $courseId)
            ->first();

        return $follow instanceof CourseFollowed;
    }
}
