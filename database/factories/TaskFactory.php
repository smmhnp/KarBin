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
            'user_id' => fake()->randomElement(['1', '2', '3', '4', '5']),
            'title_id' => fake()->randomElement(['1', '2', '3']),
            'project_name' => fake()->randomElement(['alpha', 'beta', 'omega', 'teta']),
            'content' => fake()->paragraph(),
            'undertaking' => fake()->randomElement(['ali', 'ahmad', 'admin']),
            'preference' => fake()->randomElement(['بالا', 'متوسط', 'پایین']),
            'deadline' => fake()->date(),
            'status' => fake()->randomElement(['برای انجام', 'انجام شده', 'بازبینی', 'در حال انجام']),
            'attachment_path' => fake()->filePath()
        ];
    }
}
