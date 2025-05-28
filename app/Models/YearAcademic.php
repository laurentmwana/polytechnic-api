<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YearAcademic extends Model
{
    protected $fillable = ['name', 'start', 'end', 'is_closed'];
}
