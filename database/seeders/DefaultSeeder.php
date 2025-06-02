<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Option;
use App\Models\Faculty;
use App\Models\Programme;
use App\Models\Department;
use App\Models\University;
use App\Models\YearAcademic;
use Illuminate\Database\Seeder;
use App\Enums\LevelProgrammeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultSeeder extends Seeder
{

    private const DEPARTMENTS = [
        ['name' => 'Génie Electrique'],
        ['name' => 'Informatique'],
    ];

    private const PROGRAMMES = [
        ['name' => "Licence 1", "alias" => "L1", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Licence 2", "alias" => "L2", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Licence 3", "alias" => "L3", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Master 1", "alias" => "M1", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Master 1", "alias" => "M1", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Master 2", "alias" => "M2", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Doctorat 1", "alias" => "D1", "programme" => LevelProgrammeEnum::AFTER->value],

        ['name' => "Doctorat 2", "alias" => "D2", "programme" => LevelProgrammeEnum::AFTER->value],


        ['name' => "Graduat 1", "alias" => "G1", "programme" => LevelProgrammeEnum::BEFORE->value],

        ['name' => "Graduat 2", "alias" => "G2", "programme" => LevelProgrammeEnum::BEFORE->value],

        ['name' => "Graduat 3", "alias" => "G3", "programme" => LevelProgrammeEnum::BEFORE->value],

        ['name' => "Licence 1", "alias" => "L1", "programme" => LevelProgrammeEnum::BEFORE->value],

        ['name' => "Licence 2", "alias" => "L2", "programme" => LevelProgrammeEnum::BEFORE->value],

        ['name' => "Doctorat 1", "alias" => "D1", "programme" => LevelProgrammeEnum::BEFORE->value],

        ['name' => "Doctorat 2", "alias" => "D2", "programme" => LevelProgrammeEnum::BEFORE->value],
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
        Option::factory(12)->create();

        foreach (Option::all() as $option) {
            foreach (self::PROGRAMMES as $programme) {
                Level::create([
                    ...$programme,
                    'option_id' => $option->id,
                ]);
            }
        }

        foreach (self::YEARS as $year){
            YearAcademic::create($year);
        }
    }
}
