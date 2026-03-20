<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Halaman Utama Admin (Daftar semua profil untuk dikelola)
    public function index()
    {
        $profiles = Profile::all();
        return view('admin.page.profile.index', compact('profiles'));
    }

    //Guest

    // Method untuk Visi Misi
    public function showVisiMisi()
    {
        $visi = Profile::where('key', 'visi')->where('active', true)->first();
        $misi = Profile::where('key', 'misi')->where('active', true)->orderBy('sequence')->get();

        return view('guest.page.profile.visi-misi', compact('visi', 'misi'));
    }

    // Method untuk Tugas, Fungsi, Tujuan
    public function showTugasFungsi() {
        $tugas = Profile::where('key', 'tugas')->where('active', true)->orderBy('sequence')->get();
        $fungsi = Profile::where('key', 'fungsi')->where('active', true)->orderBy('sequence')->get();
        $tujuan = Profile::where('key', 'tujuan')->where('active', true)->orderBy('sequence')->get();

        return view('guest.page.profile.tugas-fungsi', compact('tugas', 'fungsi', 'tujuan'));
    }

    // Method untuk Struktur
    public function showStruktur() {
        $struktur = Profile::where('key', 'struktur')->where('active', true)->orderBy('sequence')->get();
        
        return view('guest.page.profile.struktur pengurus', compact('struktur'));
    }
    // ==========================================
    // ADMIN ACTIONS (STORE, UPDATE, DESTROY)
    // ==========================================

    public function store(Request $request)
    {
        Profile::create([
            'key'         => $request->key,
            'title'       => $request->title, 
            'description' => $request->description, 
            'sequence'    => $request->sequence ?? 0,
            'active'      => true,
            'created_by'  => Auth::id(),
        ]);

        return back()->with('success', 'Data baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Profile::findOrFail($id);
        
        $item->update([
            'title'       => $request->title,
            'description' => $request->description,
            'sequence'    => $request->sequence,
            'active'      => $request->has('active'),
            'updated_by'  => Auth::id(),
        ]);

        return back()->with('success', 'Baris berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Profile::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Baris berhasil dihapus.');
    }
}