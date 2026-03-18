<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin() {
        return view('auth.login');
    }

    // Menampilkan halaman register (Jika masih diperlukan)
    public function showRegister() {
        return view('auth.register');
    }

    // Proses Login
    public function login(Request $request) {
        // 1. Validasi input
        // Kita gunakan nama 'login_id' karena bisa berisi NPM atau NIDN
        $request->validate([
            'login_id' => ['required'], 
            'password' => ['required'],
        ]);

        $loginId = $request->login_id;
        $password = $request->password;

        // 2. Logika Autentikasi Fleksibel (Cek NPM dulu, jika gagal cek NIDN)
        // Coba login sebagai Mahasiswa/Admin (menggunakan kolom npm)
        $attemptNPM = Auth::attempt(['npm' => $loginId, 'password' => $password]);
        
        // Jika gagal, coba login sebagai Dosen (menggunakan kolom nidn)
        $attemptNIDN = false;
        if (!$attemptNPM) {
            $attemptNIDN = Auth::attempt(['nidn' => $loginId, 'password' => $password]);
        }

        // 3. Jika salah satu attempt berhasil
        if ($attemptNPM || $attemptNIDN) {
            $request->session()->regenerate();

            // REDIRECT LOGIC berdasarkan role_id
            // role_id 1 = Admin
            if (Auth::user()->role_id == 1) {
                return redirect()->intended('/admin/dashboard');
            }
            
            // role_id 2 atau 3 (Dosen/Mahasiswa) kembali ke landing page
            return redirect()->intended('/');
        }

        // 4. Jika semua attempt gagal
        return back()->withErrors([
            'login_id' => 'NPM/NIDN atau Password tidak cocok dengan data kami.',
        ])->onlyInput('login_id');
    }


    // Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}