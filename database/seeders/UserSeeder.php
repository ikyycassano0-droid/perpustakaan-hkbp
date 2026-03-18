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
        // 1. Membuat Akun Admin
        // Admin menggunakan kolom 'npm' sebagai ID login (sesuai AuthController sebelumnya)
        User::create([
            'role_id'    => 1, // 1 = Admin
            'name'       => 'Administrator Perpustakaan',
            'npm'        => 'admin123', 
            'nidn'       => null,
            'password'   => Hash::make('admin123'),
            'birth_date' => '1990-01-01',
            'gender'     => 'Laki-laki',
            'phone'      => '081234567890',
            'active'     => true,
            'created_by' => 1,
        ]);

        // 2. Membuat Akun Dosen (Contoh)
        User::create([
            'role_id'    => 2, // 2 = Dosen
            'name'       => 'Dr. Ahmad Subarjo, M.Kom',
            'npm'        => null,
            'nidn'       => '12345678', // Dosen login pakai NIDN
            'password'   => Hash::make('dosen123'),
            'birth_date' => '1985-05-20',
            'gender'     => 'Laki-laki',
            'phone'      => '081211112222',
            'active'     => true,
            'created_by' => 1,
        ]);

        // 3. Membuat Akun Mahasiswa (Contoh)
        User::create([
            'role_id'    => 3, // 3 = Mahasiswa
            'name'       => 'Rizky Immanuel',
            'npm'        => '220101001', // Mahasiswa login pakai NPM
            'nidn'       => null,
            'password'   => Hash::make('user123'),
            'birth_date' => '2004-10-12',
            'gender'     => 'Laki-laki',
            'phone'      => '089988776655',
            'active'     => true,
            'created_by' => 1,
        ]);
        
        $this->command->info('User Seeder berhasil dijalankan dengan 3 role berbeda!');
    }
}