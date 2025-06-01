<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;

class SelectDataController extends Controller
{
    public function students()
    {
        return response()->json(
            Student::all([
                'id',
                'name',
                'firstname'
            ])
        );
    }
}
