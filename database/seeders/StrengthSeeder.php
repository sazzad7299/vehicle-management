<?php

namespace Database\Seeders;

use App\Models\Strength;
use Illuminate\Database\Seeder;

class StrengthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Strength::factory(20)->create();
    }
}
