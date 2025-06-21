<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver
{
    private const LEVELS = [
        ['name' => 'Licence 1 LMD', 'alias' => 'L1 LMD'],
        ['name' => 'Licence 2 LMD', 'alias' => 'L2 LMD'],
        ['name' => 'Licence 2 LMD', 'alias' => 'L3 LMD'],
        ['name' => 'Master 1 LMD', 'alias' => 'M1 LMD'],
        ['name' => 'Master 1 LMD', 'alias' => 'M2 LMD'],
        ['name' => 'Doctorat 1  LMD', 'alias' => 'D1 LMD'],
        ['name' => 'Doctorat 2  LMD', 'alias' => 'D2 LMD'],

        ['name' => 'Graduat 1', 'alias' => 'G1'],
        ['name' => 'Graduat 2', 'alias' => 'G2'],
        ['name' => 'Graduat 2', 'alias' => 'G3'],
        ['name' => 'Licence 1', 'alias' => 'L1'],
        ['name' => 'Licence 2', 'alias' => 'L2'],
        ['name' => 'Master 1', 'alias' => 'M1'],
        ['name' => 'Master 1', 'alias' => 'M2'],
        ['name' => 'Doctorat 1 ', 'alias' => 'D1'],
        ['name' => 'Doctorat 2 ', 'alias' => 'D2'],
    ];

    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
        foreach (self::LEVELS as $value) {
            $department->levels()->create($value);
        }
    }
}
