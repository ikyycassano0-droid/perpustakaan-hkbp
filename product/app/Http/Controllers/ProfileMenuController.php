<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;

    class ProfileMenuController extends Controller
    {
        /**
         * Halaman profil user (hanya bisa diakses jika sudah login)
         */
        public function index()
        {
            // Pastikan user sudah login (session 'user' ada)
            if (!session()->has('user')) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $user = session('user');

            return view('profileAkun.menu', compact('user'));
        }

        /**
         * Update nama user melalui API service
         */
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
                ->put(env('AUTH_SERVICE_URL') . '/user/profile', [
                    'name' => $request->name,
                ]);

            $data = $response->json();

            if ($response->successful() && ($data['success'] ?? false)) {
                // Perbarui session user
                $user = session('user');
                $user['name'] = $request->name;
                session(['user' => $user]);

                return back()->with('success', 'Nama berhasil diperbarui.');
            }

            return back()->with('error', $data['message'] ?? 'Gagal memperbarui nama.');
        }

        /**
         * Update password user melalui API service
         */
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
                ->put(env('AUTH_SERVICE_URL') . '/user/password', [
                    'current_password' => $request->current_password,
                    'new_password'     => $request->new_password,
                ]);

            $data = $response->json();

            if ($response->successful() && ($data['success'] ?? false)) {
                return back()->with('success', 'Password berhasil diubah.');
            }

            return back()->with('error', $data['message'] ?? 'Gagal mengubah password.');
        }
    }
