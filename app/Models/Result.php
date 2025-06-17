<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'deliberation_id', 
        'student_id', 
        'is_eligible', 
        'file',
        'is_paid_labo',
        'is_paid_academic'
    ];

    public function deliberation()
    {
        return $this->belongsTo(Deliberation::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
