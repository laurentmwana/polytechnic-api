<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;

    protected $fillable = ['name', 'firstname', 'gender', 'departmen_id', 'phone'];

    public function juries()
    {
        return $this->hasMany(Jury::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
