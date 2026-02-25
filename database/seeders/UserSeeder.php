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
            'name'     => 'Administrator Perpustakaan',
            'nim'      => 'admin123', // NIM ini akan jadi username login
            'password' => Hash::make('admin123'), // Password di-hash otomatis
            'role'     => 'admin',
        ]);

        // Membuat Akun User Contoh (Optional)
        User::create([
            'name'     => 'Rizky Pratama',
            'nim'      => '220101001',
            'password' => Hash::make('user123'),
            'role'     => 'user',
        ]);
        
        $this->command->info('User Seeder berhasil dijalankan!');
    }
}