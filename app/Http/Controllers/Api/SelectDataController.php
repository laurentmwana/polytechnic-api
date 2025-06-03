<?php

namespace App\Http\Controllers\Api;

use App\Models\Level;
use App\Models\Student;
use App\Models\YearAcademic;
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

    public function levels()
    {
        return response()->json(
            Level::with('option')->get()
        );
    }

      public function years()
    {
        return response()->json(
            YearAcademic::all()
        );
    }
}
