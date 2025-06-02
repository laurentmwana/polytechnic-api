<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\Course;
use App\Models\Option;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Department;
use App\Enums\RoleUserEnum;
use App\Models\ActualLevel;
use App\Models\Deliberation;
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

        $this->call(DefaultSeeder::class);

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

        Department::factory(2)->create();

        Teacher::factory(40)->create();

        Option::factory(10)->create();

        Level::factory(20)->create();

        foreach (Level::all() as $level) {
            for ($index = 0; $index < 15; $index++) {
                Course::factory()->create([
                    'level_id' => $level->id,
                ]);
            }
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

        Deliberation::factory(20)->create();

        $this->call(JurySeeder::class);
    }
}
