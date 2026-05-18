<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected string $authServiceUrl;

    public function __construct()
    {
        $this->authServiceUrl = env('AUTH_SERVICE_URL', 'http://localhost:8001/api/v1');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'npm' => 'required|string',
            'password' => 'required|string'
        ]);

        // 🔥 PANGGIL AUTH SERVICE
        try {
            $response = Http::timeout(5)
                ->post("{$this->authServiceUrl}/auth/login", [
                    'npm' => $request->npm,
                    'password' => $request->password
                ]);

            $data = $response->json();

            if ($response->successful() && ($data['success'] ?? false)) {
                // Simpan token & user dari Auth Service
                session([
                    'auth_token' => $data['data']['token'],
                    'user' => $data['data']['user']
                ]);

                // 🔀 REDIRECT SESUAI ROLE
                if ($data['data']['user']['role_id'] == 1) {
                    return redirect()->route('admin.home');
                } else {
                    return redirect()->route('user.dashboard');
                }
            }

            // Email belum verifikasi (dari Auth Service)
            if (($data['needs_verification'] ?? false) === true) {
                return back()->with('error', $data['message']);
            }

            // Gagal dari Auth Service
            return back()->with('error', $data['message'] ?? 'NPM atau password salah');

        } catch (\Exception $e) {
            Log::error('Auth Service tidak tersedia: ' . $e->getMessage());
            return back()->with('error', 'Layanan autentikasi sedang tidak tersedia. Silakan coba lagi nanti.');
        }
    }

    public function logout(Request $request)
    {
        // Logout dari Auth Service
        try {
            $token = session('auth_token');
            if ($token) {
                Http::withToken($token)
                    ->timeout(3)
                    ->post("{$this->authServiceUrl}/auth/logout");
            }
        } catch (\Exception $e) {
            // Silent
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
