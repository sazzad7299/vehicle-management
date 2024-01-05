<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leaf>
 */
class LeafFactory extends Factory
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
            'leaf_type' => fake()->name(),
            'number_per_box' => fake()->numberBetween(10, 20),
            'description' => fake()->text(),
            'status' => fake()->numberBetween(1, 2),
        ];
    }
}
