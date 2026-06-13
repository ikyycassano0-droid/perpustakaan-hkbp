<?php

namespace App\Http\Controllers;

use App\Models\FinalProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileMenuController extends Controller
{
    protected string $authServiceUrl;

    public function __construct()
    {
        // pastikan environment AUTH_SERVICE_URL = http://auth-service:80/api/v1
        $this->authServiceUrl = rtrim(env('AUTH_SERVICE_URL', 'http://localhost:8001/api/v1'), '/');
    }

    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = session('user');
        return view('profileAkun.menu', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $token = session('auth_token');
        if (!$token) {
            return back()->with('error', 'Sesi habis, silakan login ulang.');
        }

        $response = Http::withToken($token)
            ->put(env('AUTH_SERVICE_URL') . '/auth/user/profile', [
                'name' => $request->name,
            ]);

        $data = $response->json();

        if ($response->successful() && ($data['success'] ?? false)) {
            // Perbarui session user
            $user = session('user');
            $user['name'] = $request->name;
            session(['user' => $user]);

            // Sinkronkan ke database lokal (users)
            $localUser = \App\Models\User::find(session('user_id'));
            if ($localUser) {
                $localUser->name = $request->name;
                $localUser->save();
            }

            // 🚀 Sinkronkan nama ke semua KTI milik user (berdasarkan NPM)
            $npm = $user['npm'] ?? null;
            if ($npm) {
                FinalProject::where('npm', $npm)->update(['student_name' => $request->name]);
            }

            return back()->with('success', 'Nama berhasil diperbarui.');
        }

        return back()->with('error', $data['message'] ?? 'Gagal memperbarui nama.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $token = session('auth_token');
        if (!$token) {
            return back()->with('error', 'Sesi habis, silakan login ulang.');
        }

        $response = Http::withToken($token)
            ->put($this->authServiceUrl . '/auth/user/password', [
                'current_password' => $request->current_password,
                'new_password'     => $request->new_password,
                'new_password_confirmation' => $request->new_password_confirmation,
            ]);

        $data = $response->json();

        if ($response->successful() && ($data['success'] ?? false)) {
            // Optional: update password di lokal jika diperlukan
            // \App\Models\User::where('id', session('user_id'))->update(['password' => bcrypt($request->new_password)]);

            return back()->with('success', 'Password berhasil diubah.');
        }

        return back()->with('error', $data['message'] ?? 'Gagal mengubah password.');
    }
}