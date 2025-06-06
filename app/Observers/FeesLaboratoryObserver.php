<?php

namespace App\Observers;

use App\Models\ActualLevel;
use App\Models\FeesLaboratory;
use App\Models\PaidLaboratory;

class FeesLaboratoryObserver
{
    public function created(FeesLaboratory $feesLaboratory): void
    {
        $actualLevels = ActualLevel::where('level_id', '=', $feesLaboratory->level_id)
            ->where('year_academic_id', '=', $feesLaboratory->year_academic_id)
            ->get();

        foreach ($actualLevels as $actualLevel) {

            PaidLaboratory::create([
                'student_id' => $actualLevel->student_id,
                'fees_laboratory_id' => $feesLaboratory->id,
            ]);
        }
    }
}
