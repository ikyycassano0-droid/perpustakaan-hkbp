<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'name' => 'Administrator Perpustakaan',
            'email' => 'admin@local.test',
            'email_verified_at' => now(),
            'npm' => '000000',
            'password' => Hash::make('admin123'),
            'active' => true,
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Rizky Pratama',
            'email' => 'rizky@example.com',
            'npm' => '220101001',
            'password' => Hash::make('user123'),
            'active' => true,
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@example.com',
            'nidn' => '12345678',
            'password' => Hash::make('dosen123'),
            'active' => true,
        ]);
    }
}
