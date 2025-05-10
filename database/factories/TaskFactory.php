<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 4),
            'title' => fake()->word(),
            'project_name' => fake()->randomElement(['alpha', 'beta', 'omega', 'teta']),
            'content' => fake()->paragraph(),
            'undertaking' => fake()->randomElement(['ali', 'hasan', 'ahmad', 'admin']),
            'preference' => fake()->randomElement(['بالا', 'متوسط', 'کم']),
            'deadline' => fake()->date(),
            'status' => fake()->randomElement(['برای انجام', ' انجام شده', 'بازبینی', 'در حال انجام'])
        ];
    }
}
