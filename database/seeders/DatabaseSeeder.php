<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\Option;
use App\Models\Student;
use App\Models\Department;
use App\Enums\RoleUserEnum;
use App\Models\ActualLevel;
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
            'roles' => [RoleUserEnum::ADMIN->value],
        ]);

        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'roles' => [RoleUserEnum::STUDENT->value, RoleUserEnum::DISABLE->value],
        ]);

        User::factory(100)->create([
            'roles' => [RoleUserEnum::STUDENT->value],
        ])->each(function (User $user) {
            Student::factory()->create(['user_id' => $user]);
        });

        Student::factory(10)->create();



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


        foreach (Student::all() as $student) {

            $actual = ActualLevel::create([
                'student_id' => $student->id,
                'year_academic_id' => YearAcademic::all()->random()->id,
                'level_id' => Level::all()->random()->id,
            ]);

            for ($index = 0; $index < 3; $index++) {
                $actual->update([
                    'year_academic_id' => YearAcademic::all()->random()->id,
                    'level_id' => Level::all()->random()->id,
                ]);
            }

            // course followed
        }
    }
}
