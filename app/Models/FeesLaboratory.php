<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesLaboratory extends Model
{
    protected $fillable = ['amount', 'level_id', 'year_academic_id'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function yearAcademic()
    {
        return $this->belongsTo(YearAcademic::class);
    }
}
