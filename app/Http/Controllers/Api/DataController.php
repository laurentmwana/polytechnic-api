<?php

namespace App\Http\Controllers\Api;

use App\Models\Level;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\Deliberation;
use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Deliberation\DeliberationActionResource;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function students()
    {
        return response()->json(
            Student::select('id', 'name', 'firstname')->get()
        );
    }

    public function levels()
    {
        return response()->json(
            Level::with('department')->get()
        );
    }

    public function years()
    {
        return response()->json(
            YearAcademic::orderBy('is_closed')->get()
        );
    }

    public function departments()
    {
        return response()->json(
            Department::select('id', 'name', 'alias')->get()
        );
    }

    public function teachers()
    {
        return response()->json(
            Teacher::select('id', 'name', 'firstname', 'gender')->get()
        );
    }

    public function delibes(Request $request)
    {
        $year = $request->query('year', 'all');

        $builder = Deliberation::with(['yearAcademic', 'level', 'level.department']);

        if ($year === 'closed') {
            $builder->whereHas('yearAcademic', function ($query) {
                $query->where('is_closed', true);
            });
        } elseif ($year === 'no-closed') {
            $builder->whereHas('yearAcademic', function ($query) {
                $query->where('is_closed', false);
            });
        }

        // Tri par updated_at en ordre décroissant
        $delibes = $builder->orderByDesc('updated_at')->get();

        return DeliberationActionResource::collection($delibes);
    }
}
