<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliberation extends Model
{
    /** @use HasFactory<\Database\Factories\DeliberationFactory> */
    use HasFactory;

    protected $fillable = ['level_id', 'year_academic_id', 'criteria', 'start_at'];

    public function juries()
    {
        return $this->hasMany(Jury::class);
    }

    public function level()
    {
        return $this->belongsTo(YearAcademic::class);
    }

    public function yearAcaddemic()
    {
        return $this->belongsTo(YearAcademic::class);
    }
}
