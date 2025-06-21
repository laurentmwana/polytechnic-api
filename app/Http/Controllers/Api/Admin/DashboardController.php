<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Level;

use App\Models\Teacher;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Services\FeeStatistics;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, FeeStatistics $statistic)
    {
        return response()->json([
            'departments' => Department::count('id'),
            'levels' => Level::count('id'),
            'teachers' => Teacher::count('id'),
            'statistics' => [
                'annual' => $statistic->getAnnualStatistics($request),
                'types' => $statistic->getFeeTypeStatistics(),
                'levels' => $statistic->getLevelStatistics(),
            ],
        ]);
    }
}
