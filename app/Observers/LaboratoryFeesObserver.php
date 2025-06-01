<?php

namespace App\Observers;

use App\Models\ActualLevel;
use App\Models\LaboratoryFees;
use App\Models\PaidLaboratory;

class LaboratoryFeesObserver
{
    public function created(LaboratoryFees $laboratoryFees): void
    {
        $actualLevels = ActualLevel::where('level_id', '=', $laboratoryFees->level_id)
            ->where('year_academic_id', '=', $laboratoryFees->year_academic_id)
            ->get();

        foreach ($actualLevels as $actualLevel) {

            PaidLaboratory::create([
                'student_id' => $actualLevel->student_id,
                'laboratory_fees_id' => $laboratoryFees->id,
            ]);
        }
    }
}
