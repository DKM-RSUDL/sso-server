<?php

namespace Database\Seeders;

use App\Models\SsoRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SsoRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
        ];

        foreach ($roles as $role) {
            SsoRole::create($role);
        }
    }
}
