<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;

    protected $fillable = ['name', 'alias', 'option_id', 'year_academic_id'];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }


    public function year(): BelongsTo
    {
        return $this->belongsTo(YearAcademic::class);
    }
}
