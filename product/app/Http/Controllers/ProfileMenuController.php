<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\FinalProject;
use App\Models\User;

class ProfileMenuController extends Controller
{
    /**
     * Halaman menu profil (setelah klik ikon profil)
     */
    public function index()
    {
        return view('profileAkun.menu');
    }

    /**
     * Tampilkan form edit profil
     */
    public function editProfile()
    {
        $user = User::find(session('user_id'));
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update data profil user
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(session('user_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'npm' => 'nullable|string|max:20',
            'study_program' => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:4',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->npm = $request->npm;
        $user->study_program = $request->study_program;
        $user->angkatan = $request->angkatan;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tampilkan halaman profil (detail)
     */
    public function show()
    {
        $user = User::find(session('user_id'));
        $unreadNotif = $user->unreadNotifications->count();
        $totalPinjam = Order::where('user_id', $user->id)->count();
        $aktifPinjam = Order::where('user_id', $user->id)
                        ->where('status', 'approved')
                        ->whereNull('returned_at')
                        ->count();
        $totalKti = FinalProject::where('user_id', $user->id)->count();
        $point = 0; // sesuaikan jika ada sistem poin

        return view('user.profile.show', compact('user', 'unreadNotif', 'totalPinjam', 'aktifPinjam', 'totalKti', 'point'));
    }
}