<?php

namespace Database\Seeders;

use App\Models\Result;
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
use App\Models\FeesAcademic;
use App\Models\YearAcademic;
use App\Models\FeesLaboratory;
use Illuminate\Database\Seeder;
use Database\Seeders\JurySeeder;
use Database\Seeders\DefaultSeeder;

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

        User::factory(20)->create([
            'roles' => [RoleUserEnum::STUDENT->value],
        ])->each(function (User $user) {
            Student::factory()->create(['user_id' => $user]);
        });

        Teacher::factory(40)->create();

        $year = YearAcademic::where('is_closed', '=', false)->first();

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
        }

        foreach (Level::all() as $level) {
            for ($index = 0; $index < 15; $index++) {
                Course::factory()->create([
                    'level_id' => $level->id,
                ]);
            }

            FeesLaboratory::create([
                'level_id' => $level->id,
                'year_academic_id' => $year->id,
                'amount' => random_int(10, 50)
            ]);

            FeesAcademic::create([
                'level_id' => $level->id,
                'year_academic_id' => $year->id,
                'amount' => random_int(10, 50)
            ]);
        }

        Deliberation::factory(20)->create();

        $this->call(JurySeeder::class);


        foreach (Student::all() as $student) {

            $deliberations = Deliberation::where('level_id', '=', $student->actualLevel->level_id)
                ->get();

            foreach ($deliberations as $deliberation) {
                Result::create([
                    'deliberation_id' => $deliberation->id,
                    'student_id' => $student->id,
                    'is_eligible' => true,
                    'file'=> 'demo.pdf'
                ]);
            }
        }
    }
}
