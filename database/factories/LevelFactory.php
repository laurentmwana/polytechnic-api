<?php

namespace Database\Factories;

use App\Enums\LevelProgrammeEnum;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'alias' => fake()->name(),
            'programme' => fake()->randomElement(LevelProgrammeEnum::cases())->value,
        ];
    }
}
