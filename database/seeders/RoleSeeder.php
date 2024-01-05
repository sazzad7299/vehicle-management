<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super-admin',
            ],
            [
                'name' => 'admin',
            ],
            [
                'name' => 'owner',
            ],
            [
                'name' => 'user',
            ],
            [
                'name' => 'worker',
            ],
        ];

        Role::insert($roles);

    }
}
