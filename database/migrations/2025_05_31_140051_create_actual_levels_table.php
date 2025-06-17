<?php

namespace App\Services;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeStatistics
{
    public function __construct(private Request $request) {}

    public function getAnnualStatistics(Request $request)
    {
        if (!$this->request->user()) {
            return [
                'chartData' => [],
                'totals' => [
                    'currentYear' => 0,
                    'previousYear' => 0,
                ]
            ];
        }

        $currentYearId = $request->input('year_academic_id');
        $previousYearId = $currentYearId - 1;

        $currentYearData = $this->getYearlyData($currentYearId);
        $previousYearData = $this->getYearlyData($previousYearId);

        return [
            'chartData' => $this->formatChartData($currentYearData, $previousYearData),
            'totals' => [
                'currentYear' => $currentYearData->sum(),
                'previousYear' => $previousYearData->sum(),
            ]
        ];
    }

    public function getFeeTypeStatistics()
    {
        if (!$this->request->user()) {
            return [];
        }

        return Result::select('deliberations.year_academic_id')
            ->selectRaw('SUM(CASE WHEN is_paid_academic THEN 1 ELSE 0 END) as total_academic')
            ->selectRaw('SUM(CASE WHEN is_paid_labo THEN 1 ELSE 0 END) as total_laboratory')
            ->join('deliberations', 'results.deliberation_id', '=', 'deliberations.id')
            ->groupBy('deliberations.year_academic_id')
            ->get();
    }

    public function getLevelStatistics()
    {
        if (!$this->request->user()) {
            return [];
        }

        return Result::select('actual_levels.level_id')
            ->selectRaw('SUM(CASE WHEN is_paid_academic THEN 1 ELSE 0 END + CASE WHEN is_paid_labo THEN 1 ELSE 0 END) as total')
            ->join('students', 'results.student_id', '=', 'students.id')
            ->join('actual_levels', function ($join) {
                $join->on('students.id', '=', 'actual_levels.student_id')
                     ->where('actual_levels.year_academic_id', '=', DB::raw('deliberations.year_academic_id'));
            })
            ->join('deliberations', 'results.deliberation_id', '=', 'deliberations.id')
            ->groupBy('actual_levels.level_id')
            ->get()
            ->map(fn($item) => [
                'level_id' => $item->level_id,
                'total' => $item->total,
            ]);
    }

    private function getYearlyData($yearAcademicId)
    {
        if (!$this->request->user()) {
            return collect();
        }

        return Result::select('actual_levels.level_id')
            ->selectRaw('SUM(CASE WHEN is_paid_academic THEN 1 ELSE 0 END + CASE WHEN is_paid_labo THEN 1 ELSE 0 END) as total_amount')
            ->join('students', 'results.student_id', '=', 'students.id')
            ->join('actual_levels', function ($join) use ($yearAcademicId) {
                $join->on('students.id', '=', 'actual_levels.student_id')
                     ->where('actual_levels.year_academic_id', '=', $yearAcademicId);
            })
            ->join('deliberations', 'results.deliberation_id', '=', 'deliberations.id')
            ->where('deliberations.year_academic_id', $yearAcademicId)
            ->groupBy('actual_levels.level_id')
            ->get()
            ->keyBy('level_id')
            ->map(fn($item) => $item->total_amount);
    }

    private function formatChartData($currentYearData, $previousYearData)
    {
        $levels = DB::table('levels')->pluck('id');
        $chartData = [];

        foreach ($levels as $levelId) {
            $chartData[] = [
                'level' => $levelId,
                'currentYear' => $currentYearData->get($levelId, 0),
                'previousYear' => $previousYearData->get($levelId, 0),
            ];
        }

        return $chartData;
    }
}
