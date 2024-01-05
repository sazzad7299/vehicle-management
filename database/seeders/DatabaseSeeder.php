<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('BangladeshGeocode:setup');
        $this->call([
            UserSeeder::class,
            PharmacySeeder::class,
            ManufacturerSeeder::class,
            StrengthSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            LeafSeeder::class,
            TypeSeeder::class,
            ShelfNumberSeeder::class,
            SupplierSeeder::class,
            MedicineSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            // CashInOutSeeder::class,
        ]);
    }
}
