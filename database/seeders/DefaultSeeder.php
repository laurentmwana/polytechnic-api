<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Department;
use App\Models\YearAcademic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultSeeder extends Seeder
{


    private const DEPARTMENTS = [
        ['name' => 'Génie électrique'],
    ];

    private const YEARS = [
        ['name' => "2023-2024", "start" => 2023, "end" => 2024, 'is_closed' => true],
        ['name' => "2024-2025", "start" => 2024, "end" => 2025]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (self::DEPARTMENTS as $department) {
            Department::factory()->create($department);
        }

        foreach (self::YEARS as $year){
            YearAcademic::create($year);
        }
    }
}
