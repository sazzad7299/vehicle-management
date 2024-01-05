<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomNumber(1, 20),
            'company_name' => fake()->name(),
            'mobile_no' => fake()->unique()->numerify('01#########'),
            'logo' => null,
            // 'logo' => fake()->image(public_path(''), 400, 300, null, false),
            'website' => fake()->url(),
            'country' => 'Bangladesh',
            'division_id' => fake()->numberBetween(1, 8),
            'district_id' => fake()->numberBetween(1, 64),
            'upazilas_id' => fake()->numberBetween(1, 100),
            'union_id' => fake()->numberBetween(1, 100),
            'zip_code' => fake()->numberBetween(1000, 9999),
            'street_address' => fake()->streetAddress(),
            'google_map_location' => fake()->latitude().fake()->longitude(),
            'reffer_by_name' => fake()->name(),
            'reffer_by_phone' => fake()->numerify('01#########'),
            'note' => fake()->text(),
            'status' => fake()->numberBetween(1, 1),
        ];
    }
}
