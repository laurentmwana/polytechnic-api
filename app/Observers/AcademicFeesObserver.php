<?php

namespace App\Observers;

use App\Models\AcademicFees;
use App\Models\ActualLevel;
use App\Models\PaidAcademic;

class AcademicFeesObserver
{
    public function created(AcademicFees $academicFees): void
    {
        $actualLevels = ActualLevel::where('level_id', '=', $academicFees->level_id)
            ->where('year_academic_id', '=', $academicFees->year_academic_id)
            ->get();

        foreach ($actualLevels as $actualLevel) {

            PaidAcademic::create([
                'student_id' => $actualLevel->student_id,
                'academic_fees_id' => $academicFees->id,
            ]);
        }
    }
}
