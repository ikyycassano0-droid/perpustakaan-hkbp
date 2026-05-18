<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'active' => true],
            ['name' => 'Mahasiswa', 'active' => true],
            ['name' => 'Dosen', 'active' => true],
            ['name' => 'Member', 'active' => true],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}