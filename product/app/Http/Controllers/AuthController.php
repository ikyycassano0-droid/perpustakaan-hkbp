<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    try {
        $response = Http::timeout(5)
            ->post("{$this->authServiceUrl}/auth/login", [
                'npm' => $request->npm,
                'password' => $request->password
            ]);

        $data = $response->json();

        if ($response->successful() && ($data['success'] ?? false)) {
            session([
                'auth_token' => $data['data']['token'],
                'user' => $data['data']['user'],
                'user_id' => $data['data']['user']['id']
            ]);

            // ✅ Sinkronkan user ke database lokal
            $userData = $data['data']['user'];
            $localUser = \App\Models\User::updateOrCreate(
                ['email' => $userData['email']], // cari berdasarkan email (unik)
                [
                    'role_id' => $userData['role_id'],
                    'name' => $userData['name'],
                    'npm' => $userData['npm'],
                    'password' => bcrypt($request->password),
                    'active' => 1,
                ]
            );

            session(['user_id' => $localUser->id]);

            if ($data['data']['user']['role_id'] == 1) {
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->with('error', $data['message'] ?? 'NPM atau password salah');

    } catch (\Exception $e) {
    \Log::error('Auth service connection error: ' . $e->getMessage());
    return back()->with('error', 'Layanan autentikasi sedang tidak tersedia. Error: ' . $e->getMessage());
}
}

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
