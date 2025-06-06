<?php

namespace Database\Factories;

use App\Models\Level;
use App\Models\YearAcademic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deliberation>
 */
class DeliberationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'level_id' => Level::all()->random()->id,
            'year_academic_id' => YearAcademic::all()->random()->id,
            'start_at' => now()->addDays(5),
            'criteria' => fake()->paragraph()
        ];
    }
}
