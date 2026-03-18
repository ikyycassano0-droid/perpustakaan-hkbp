<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar Dosen dan Mahasiswa (Role 2 & 3).
     */
    public function index()
    {
        // Mengambil user yang bukan admin (role_id 2: Dosen, 3: Mahasiswa)
        $users = User::whereIn('role_id', [2, 3])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan data user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id'    => 'required|in:2,3',
            'name'       => 'required|string|max:150',
            'id_number'  => 'required|string|max:30', // NPM atau NIDN dari form
            'birth_date' => 'required|date',
            'gender'     => 'required|in:Laki-laki,Perempuan',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|min:6',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        
        // Enkripsi Password
        $data['password'] = Hash::make($request->password);
        
        // Logika penempatan ID (NPM atau NIDN)
        if ($request->role_id == 3) {
            $data['npm'] = $request->id_number;
            $data['nidn'] = null;
        } else {
            $data['nidn'] = $request->id_number;
            $data['npm'] = null;
        }

        // Upload Foto jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        // Set Audit Column
        $data['created_by'] = Auth::id();
        $data['active'] = true;

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Menampilkan detail user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id'    => 'required|in:2,3',
            'name'       => 'required|string|max:150',
            'id_number'  => 'required|string|max:30',
            'birth_date' => 'required|date',
            'gender'     => 'required|in:Laki-laki,Perempuan',
            'phone'      => 'required|string|max:20',
            'password'   => 'nullable|min:6', // Password boleh kosong jika tidak diganti
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Update Password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Update Logika ID (NPM/NIDN)
        if ($request->role_id == 3) {
            $data['npm'] = $request->id_number;
            $data['nidn'] = null;
        } else {
            $data['nidn'] = $request->id_number;
            $data['npm'] = null;
        }

        // Update Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui');
    }

    /**
     * Menghapus user dan fotonya.
     */
    public function destroy(User $user)
    {
        // Hapus file foto dari storage jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    /**
     * Mencetak kartu user.
     */
    public function printCard($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.print', compact('user'));
    }
}