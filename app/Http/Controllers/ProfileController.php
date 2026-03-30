<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::orderBy('key')->orderBy('sequence')->get();
        return view('admin.page.profile.index', compact('profiles'));
    }

    // ================= GUEST =================

    public function showVisiMisi()
    {
        $visi = Profile::where('key', 'visi')->where('active', true)->first();
        $misi = Profile::where('key', 'misi')->where('active', true)->orderBy('sequence')->get();

        return view('guest.page.profile.visi-misi', compact('visi', 'misi'));
    }

    public function showTugasFungsi()
    {
        $tugas = Profile::where('key', 'tugas')->where('active', true)->orderBy('sequence')->get();
        $fungsi = Profile::where('key', 'fungsi')->where('active', true)->orderBy('sequence')->get();
        $tujuan = Profile::where('key', 'tujuan')->where('active', true)->orderBy('sequence')->get();

        return view('guest.page.profile.tugas-fungsi', compact('tugas', 'fungsi', 'tujuan'));
    }

    public function showStruktur()
    {
        $struktur = Profile::where('key', 'struktur')
            ->where('active', true)
            ->orderBy('sequence')
            ->get();

        return view('guest.page.profile.struktur-pengurus', compact('struktur'));
    }

    // ================= Mahasiswa =================
    public function showVisiMisiMahasiswa()
    {
        $visi = Profile::where('key', 'visi')->where('active', true)->first();
        $misi = Profile::where('key', 'misi')->where('active', true)->orderBy('sequence')->get();

        return view('user.page.profile.visi-misi', compact('visi', 'misi'));
    }

    public function showTugasFungsiMahasiswa()
    {
        $tugas = Profile::where('key', 'tugas')->where('active', true)->orderBy('sequence')->get();
        $fungsi = Profile::where('key', 'fungsi')->where('active', true)->orderBy('sequence')->get();
        $tujuan = Profile::where('key', 'tujuan')->where('active', true)->orderBy('sequence')->get();

        return view('user.page.profile.tugas-fungsi', compact('tugas', 'fungsi', 'tujuan'));
    }

    public function showStrukturMahasiswa()
    {
        $struktur = Profile::where('key', 'struktur')
            ->where('active', true)
            ->orderBy('sequence')
            ->get();

        return view('user.page.profile.struktur-pengurus', compact('struktur'));
    }

    // ================= Dosen =================
    public function showVisiMisiDosen()
    {
        $visi = Profile::where('key', 'visi')->where('active', true)->first();
        $misi = Profile::where('key', 'misi')->where('active', true)->orderBy('sequence')->get();

        return view('dosen.page.profile.visi-misi', compact('visi', 'misi'));
    }

    public function showTugasFungsiDosen()
    {
        $tugas = Profile::where('key', 'tugas')->where('active', true)->orderBy('sequence')->get();
        $fungsi = Profile::where('key', 'fungsi')->where('active', true)->orderBy('sequence')->get();
        $tujuan = Profile::where('key', 'tujuan')->where('active', true)->orderBy('sequence')->get();

        return view('dosen.page.profile.tugas-fungsi', compact('tugas', 'fungsi', 'tujuan'));
    }

    public function showStrukturDosen()
    {
        $struktur = Profile::where('key', 'struktur')
            ->where('active', true)
            ->orderBy('sequence')
            ->get();

        return view('dosen.page.profile.struktur-pengurus', compact('struktur'));
    }

    // ================= ADMIN CRUD =================

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        Profile::create([
            'key'         => $request->key,
            'title'       => $request->title,
            'description' => $request->description,
            'sequence'    => $request->sequence ?? 0,
            'active'      => true,
            'created_by'  => session('user_id'), 
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $item = Profile::findOrFail($id);

        $item->update([
            'title'       => $request->title,
            'description' => $request->description,
            'sequence'    => $request->sequence,
            'active'      => $request->has('active'),
            'updated_by'  => session('user_id'),
        ]);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Profile::destroy($id);

        return back()->with('success', 'Data berhasil dihapus');
    }
}