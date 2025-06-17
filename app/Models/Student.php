<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'firstname',
        'gender',
        'phone',
        'registration_token',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actualLevel()
    {
        return $this->hasOne(ActualLevel::class);
    }

    public function historicLevels()
    {
        return $this->hasMany(HistoricLevel::class);
    }


    public function courseFolloweds()
    {
        return $this->hasMany(CourseFollowed::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
