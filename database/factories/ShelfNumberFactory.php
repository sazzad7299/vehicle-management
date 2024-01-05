<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShelfNumber>
 */
class ShelfNumberFactory extends Factory
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
            'name' => fake()->numberBetween(1, 100).' '.fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']),
            'description' => fake()->text(),
            'status' => fake()->numberBetween(1, 2),
        ];
    }
}
