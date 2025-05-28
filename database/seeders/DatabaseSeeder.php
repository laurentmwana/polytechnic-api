<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\Option;
use App\Models\Department;
use App\Models\YearAcademic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        for ($index = 2024; $index < 2025; $index++) {
            $start = $index;
            $end = $index + 1;

            YearAcademic::create([
                'name' => "{$start}-{$end}",
                'start' => $start,
                'end' => $end,
            ]);
        }

        Department::factory(2)->create();

        Option::factory(10)->create();

        foreach (YearAcademic::all() as $year) {
            Level::factory(10)->create([
                'year_academic_id' => $year->id,
            ]);
        }
    }
}
