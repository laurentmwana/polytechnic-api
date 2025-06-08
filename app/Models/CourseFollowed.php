<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFollowed extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFollowedFactory> */
    use HasFactory;

    protected $fillable = ['course_id', 'year_academic_id', 'student_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function yearAcademic()
    {
        return $this->belongsTo(YearAcademic::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
