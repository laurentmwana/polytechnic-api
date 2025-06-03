<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Level;
use App\Models\Option;
use App\Models\Teacher;
use App\Models\Department;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'departments' => Department::count('id'),
            'options' => Option::count('id'),
            'levels' => Level::count('id'),
            'teachers' => Teacher::count('id'),
        ]);
    }
}
