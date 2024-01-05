<?php

namespace Database\Seeders;

use App\Models\Leaf;
use Illuminate\Database\Seeder;

class LeafSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Leaf::factory(20)->create();
    }
}
