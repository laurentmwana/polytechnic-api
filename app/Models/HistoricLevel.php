<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricLevel extends Model
{
    protected $fillable = ['year_academic_id', 'level_id', 'student_id'];

    public function yearAcademic(): BelongsTo
    {
        return $this->BelongsTo(YearAcademic::class);
    }

    public function level(): BelongsTo
    {
        return $this->BelongsTo(Level::class);
    }

    public function student(): BelongsTo
    {
        return $this->BelongsTo(Student::class);
    }
}
