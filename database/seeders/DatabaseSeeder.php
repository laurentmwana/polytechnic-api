<?php

namespace Database\Seeders;

use App\Models\Actuality;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Result;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Enums\RoleUserEnum;
use App\Models\ActualLevel;
use App\Models\Deliberation;
use App\Models\YearAcademic;
use Illuminate\Database\Seeder;
use Database\Seeders\JurySeeder;
use Database\Seeders\DefaultSeeder;

class DatabaseSeeder extends Seeder
{
    private const ADMIN_USERS = [
        ['name' => 'Graciella', 'email' => "graciellamabs@gmail.com"],
        ['name' => 'Glodi', 'email' => "glodintumba50@gmail.com"],
        ['name' => 'Yves', 'email' => "yvesmetena137@gmail.com"],
        ['name' => 'Joel', 'email' => "joeltshipamba2024@gmail.com"],
        ['name' => 'Labeya', 'email' => "laurentmwn@gmail.com"],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DefaultSeeder::class);

        foreach (self::ADMIN_USERS as $value) {
            User::factory()->create([
                ...$value,
                'roles' => [RoleUserEnum::ADMIN->value],
            ]);
        }


        $users = User::factory(20)->create([
            'roles' => [RoleUserEnum::STUDENT->value],
        ])->each(function (User $user) {
            Student::factory()->create(['user_id' => $user]);
        });

        Teacher::factory(40)->create();

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

        Event::factory(20)->create();

        $actualities = Actuality::factory(30)->create();

        foreach ($users as $user) {
            for ($i=0; $i < 5 ; $i++) {
                $actuality = Actuality::all()->random();
                Comment::factory()->create([
                    'actuality_id' => $actuality->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        foreach ($actualities as $actuality) {
           for ($i=0; $i < 20 ; $i++) {
                Comment::factory()->create([
                    'actuality_id' => $actuality->id
                ]);
           }
        }
    }
}
