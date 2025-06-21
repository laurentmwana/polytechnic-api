<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Level;

class DepartmentObserver
{
    private const LEVEL_BASE = [
        ['name' => 'Licence 1 LMD', 'alias' => 'L1 LMD'],
    ];

    private const LEVELS = [
        ['name' => 'Licence 2 LMD', 'alias' => 'L2 LMD'],
        ['name' => 'Licence 2 LMD', 'alias' => 'L3 LMD'],
        ['name' => 'Master 1 LMD', 'alias' => 'M1 LMD'],
        ['name' => 'Master 1 LMD', 'alias' => 'M2 LMD'],
        ['name' => 'Doctorat 1  LMD', 'alias' => 'D1 LMD'],
        ['name' => 'Doctorat 2  LMD', 'alias' => 'D2 LMD'],
    ];

    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
        Level::where('name', '=', self::LEVEL_BASE[0]['name'])
            ->firstOrCreate(self::LEVEL_BASE[0]);

        foreach (self::LEVELS as $value) {
            $department->levels()->create($value);
        }
    }
}
