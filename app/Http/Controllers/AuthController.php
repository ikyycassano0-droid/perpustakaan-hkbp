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

    // Menampilkan halaman register
    public function showRegister() {
        return view('auth.register');
    }

    // Proses Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'nim' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // REDIRECT LOGIC
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            // User biasa kembali ke landing page (welcome)
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'nim' => 'NIM atau Password tidak cocok dengan data kami.',
        ])->onlyInput('nim');
    }


    // Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}