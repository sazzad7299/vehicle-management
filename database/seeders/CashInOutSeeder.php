<?php

namespace Database\Seeders;

use App\Models\CashInOut;
use Illuminate\Database\Seeder;

class CashInOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CashInOut::factory(1000)->create();
    }
}
