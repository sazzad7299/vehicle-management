<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Strength>
 */
class StrengthFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pharmacy_id' => fake()->numberBetween(1, 10),
            'name' => fake()->numberBetween(1, 1000).' mg',
            'description' => fake()->text(),
            'status' => fake()->numberBetween(1, 2),
        ];
    }
}
