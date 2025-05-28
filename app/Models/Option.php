<?php

namespace App\Models;

use App\Repositories\OptionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /** @use HasFactory<\Database\Factories\OptionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'alias', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
