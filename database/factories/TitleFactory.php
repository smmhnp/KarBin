<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TitleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(['server', 'form', 'backend', 'frontend', 'UI', 'database', 'securety', 'DevOps', 'Test']),
            'user_id' => fake()->randomElement(['1', '2', '3', '4', '5']),
            'deadline' => fake()->date()
        ];
    }
}