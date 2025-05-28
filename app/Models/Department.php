<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\DepartmentRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $fillable = ['name', 'alias'];

    public function newEloquentBuilder($query): DepartmentRepository
    {
        return new DepartmentRepository($query);
    }
}
