<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'credits' => fake()->randomDigit(),
            'code' => fake()->firstName(),
            'name' => fake()->name(),
            'teacher_id' => Teacher::all()->random()->id,
        ];
    }
}
