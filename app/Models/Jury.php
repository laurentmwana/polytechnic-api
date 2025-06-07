<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jury extends Model
{
    /** @use HasFactory<\Database\Factories\JuryFactory> */
    use HasFactory;

    protected $fillable = ['teacher_id', 'deliberation_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function deliberation()
    {
        return $this->belongsTo(Deliberation::class);
    }
}
