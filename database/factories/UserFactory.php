<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pharmacy_id' => fake()->numberBetween(1, 5),
            'name' => fake()->name(),
            'phone' => fake()->unique()->numerify('01#########'),
            'email' => fake()->unique()->freeEmail(),
            'image' => 'image',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'user_status' => fake()->numberBetween(1, 1),
            'division_id' => fake()->numberBetween(1, 8),
            'district_id' => fake()->numberBetween(1, 64),
            'upazilas_id' => fake()->numberBetween(1, 100),
            'union_id' => fake()->numberBetween(1, 100),
            'zip_code' => fake()->numberBetween(1000, 9999),
            'street_address' => fake()->streetAddress(),
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
