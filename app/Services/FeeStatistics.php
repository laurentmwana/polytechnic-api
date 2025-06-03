<?php

namespace App\Services;

use App\Models\FeesAcademic;
use App\Models\FeesLaboratory;
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

        $academicFees = FeesAcademic::selectRaw('year_academic_id, SUM(amount) as total')
            ->groupBy('year_academic_id')
            ->get();

        $laboratoryFees = FeesLaboratory::selectRaw('year_academic_id, SUM(amount) as total')
            ->groupBy('year_academic_id')
            ->get();

        return [
            'academic' => $academicFees,
            'laboratory' => $laboratoryFees
        ];
    }

    public function getLevelStatistics()
    {
        if (!$this->request->user()) {
            return [];
        }

        $feesAcademics = FeesAcademic::select('level_id', DB::raw('SUM(amount) as total'))
            ->groupBy('level_id');

        $feesLaboratories = FeesLaboratory::select('level_id', DB::raw('SUM(amount) as total'))
            ->groupBy('level_id');

        $unionSql = $feesAcademics->toSql() . ' UNION ALL ' . $feesLaboratories->toSql();

        $data = DB::table(DB::raw("({$unionSql}) as combined"))
            ->mergeBindings($feesAcademics->getQuery())
            ->mergeBindings($feesLaboratories->getQuery())
            ->select('level_id', DB::raw('SUM(total) as total'))
            ->groupBy('level_id')
            ->get();

        return $data->map(fn($item) => [
            'level_id' => $item->level_id,
            'total' => $item->total,
        ]);
    }

    private function getYearlyData($yearAcademicId)
    {
        if (!$this->request->user()) {
            return collect();
        }

        $academicFees = FeesAcademic::select('level_id', DB::raw('SUM(amount) as total_amount'))
            ->where('year_academic_id', $yearAcademicId)
            ->groupBy('level_id')
            ->get()
            ->keyBy('level_id');

        $laboratoryFees = FeesLaboratory::select('level_id', DB::raw('SUM(amount) as total_amount'))
            ->where('year_academic_id', $yearAcademicId)
            ->groupBy('level_id')
            ->get()
            ->keyBy('level_id');

        return $academicFees->merge($laboratoryFees)->groupBy('level_id')->map(fn($items) => $items->sum('total_amount'));
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
