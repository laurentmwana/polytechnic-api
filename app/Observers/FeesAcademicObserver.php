<?php

namespace App\Observers;

use App\Models\FeesAcademic;
use App\Models\ActualLevel;
use App\Models\PaidAcademic;

class FeesAcademicObserver
{
    public function created(FeesAcademic $feesAcademic): void
    {
        $actualLevels = ActualLevel::where('level_id', '=', $feesAcademic->level_id)
            ->where('year_academic_id', '=', $feesAcademic->year_academic_id)
            ->get();

        foreach ($actualLevels as $actualLevel) {

            PaidAcademic::create([
                'student_id' => $actualLevel->student_id,
                'fees_academic_id' => $feesAcademic->id,
            ]);
        }
    }
}
