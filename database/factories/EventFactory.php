<?php

namespace Database\Factories;

use App\Models\Level;
use App\Models\YearAcademic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = ['Horaire', 'Délibération', "Décès d'un professeur"];

        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'content' => fake()->paragraph(3),
            'level_id' => Level::all()->random()->id,
            'year_academic_id' => YearAcademic::all()->random()->id,
            'tags' => [fake()->randomElement($tags)]
        ];
    }
}
