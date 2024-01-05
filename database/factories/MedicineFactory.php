<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
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
            'barcode' => fake()->numerify('#1#########'),
            'name' => fake()->name(),
            'manufacturer_id' => fake()->numberBetween(1, 20),
            'strength_id' => fake()->numberBetween(1, 20),
            'leaf_id' => fake()->numberBetween(1, 20),
            'unit_id' => fake()->numberBetween(1, 20),
            'shelf_number_id' => fake()->numberBetween(1, 20),
            'category_id' => fake()->numberBetween(1, 20),
            'type_id' => fake()->numberBetween(1, 20),
            'buy_price' => fake()->randomFloat(2, 0, 1000),
            'sell_price' => fake()->randomFloat(2, 0, 1000),
            'vat' => fake()->randomFloat(2, 0, 1000),
            'image' => 'image',
            'description' => fake()->text(),
            'status' => fake()->numberBetween(1, 2),
        ];
    }
}
