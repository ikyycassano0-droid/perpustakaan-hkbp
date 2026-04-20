<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'npm' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt([
            'npm' => $request->npm,
            'password' => $request->password,
            'active' => true
        ])) {

            $user = Auth::user();

            // 🔥 INI BAGIAN YANG KAMU TANYA (TARUH DI SINI)
            if (!$user->isAdmin() && !$user->hasVerifiedEmail()) {
                Auth::logout();

                return back()->with('error', 'Email belum diverifikasi. Silakan cek Gmail Anda.');
            }

            // 🔀 REDIRECT SESUAI ROLE
            if ($user->role_id == 1) {
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->with('error', 'NPM atau password salah');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}