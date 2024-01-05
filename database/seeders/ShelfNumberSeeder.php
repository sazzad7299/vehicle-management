<?php

namespace Database\Seeders;

use App\Models\ShelfNumber;
use Illuminate\Database\Seeder;

class ShelfNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShelfNumber::factory(50)->create();
    }
}
