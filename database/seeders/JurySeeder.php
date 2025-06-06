<?php

namespace Database\Seeders;

use App\Models\Deliberation;
use App\Models\Jury;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\YearAcademic;
use Illuminate\Database\Seeder;

class JurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (Deliberation::all() as $deliberation) {
            $numberJuries = random_int(7, 8);

            for ($i = 0; $i < $numberJuries; $i++) {
              Jury::create([
                'deliberation_id' => $deliberation->id,
                'teacher_id' => Teacher::all()->random()->id,
            ]);
            }
        }
    }
}
