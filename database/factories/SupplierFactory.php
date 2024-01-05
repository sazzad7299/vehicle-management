<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
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
            'name' => fake()->name(),
            'email' => fake()->freeEmail(),
            'phone' => fake()->numerify('01#########'),
            'company' => fake()->company(),
            'company_phone' => fake()->numerify('01#########'),
            'image' => 'image',
            'address' => fake()->address(),
            'description' => fake()->text(),
            'status' => fake()->numberBetween(1, 2),
        ];
    }
}
