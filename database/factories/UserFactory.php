<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->randomElement(['ali', 'ahmad', 'hasan']),
            'lastname' => fake()->randomElement(['alavi', 'ahmadi', 'hasani']),
            'nickname' => fake()->randomElement(['asd', 'qwe', 'zxc']),
            'role' => fake()->randomElement(['admin', 'super_admin', 'developer', 'user']),
            'unit' => fake()->randomElement(['dev']),
            'email' => fake()->email(),
            'email_hash' => Hash('sha256', fake()->email()),
            'email_verified_at' => now(),
            'password' => fake()->password(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
