<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Akun Admin

    User::create([
        'role_id' => 1,
        'name' => 'Administrator Perpustakaan',
        'npm' => 'admin123', 
        'password' => Hash::make('password'),
        'active' => true,
    ]);


        // Membuat Akun User Contoh 
    // Mahasiswa
    User::create([
        'role_id' => 2, 
        'name' => 'Rizky Pratama',
        'npm' => '220101001',
        'password' => Hash::make('user123'),
        'active' => true,
    ]);

    // Dosen
    User::create([
        'role_id' => 2,
        'name' => 'Dr. Budi Santoso',
        'nidn' => '12345678',
        'password' => Hash::make('dosen123'),
        'active' => true,
    ]);
}
}