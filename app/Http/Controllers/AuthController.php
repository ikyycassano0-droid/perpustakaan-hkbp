<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm() {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // Proses login
    public function login(Request $request) {
        $request->validate([
            'npm' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('npm', $request->npm)->first();

        if(!$user) {
            return back()->with('error', 'NPM tidak ditemukan.');
        }

        if(!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        if(!$user->active){
            return back()->with('error', 'Akun tidak aktif.');
        }

        // Login berhasil → simpan session
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_role', $user->role_id);

        // Redirect berdasarkan role
        if($user->role_id == 1){ // Admin
            return redirect()->route('admin.dashboard');
        } else { // User biasa
            return redirect()->route('user.dashboard');
        }
    }

    // Logout semua user
    public function logout() {
        Session::forget(['user_id','user_name','user_role']);
        return redirect()->route('login');
    }
}