<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashInOut>
 */
class CashInOutFactory extends Factory
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
            'type' => fake()->numberBetween(1, 2),
            'receipt_no' => fake()->numerify('rn#######'),
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'amount' => fake()->randomFloat(2, 0, 1000),
            'image' => 'image',
            'source' => 'source',
            'reference_by' => fake()->numberBetween(1, 20),
            'note' => fake()->text(),
            'status' => fake()->numberBetween(1, 2),
        ];
    }
}
