<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;

        $profiles = Profile::when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->orderBy('order')
            ->get();

        return view('admin.page.profile.index', compact('profiles'));
    }

    // ================= GUEST =================

    public function showVisiMisi()
    {
        $visi = Profile::where('type', 'visi_misi')
            ->where('sub_type', 'visi')
            ->where('active', true)
            ->first();

        $misi = Profile::where('type', 'visi_misi')
            ->where('sub_type', 'misi')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $about = Profile::where('type', 'visi_misi')
            ->where('sub_type', 'about')
            ->where('active', true)
            ->first();

        return view('guest.page.profile.visi-misi', compact('visi', 'misi', 'about'));
    }

        public function showVisiMisiMahasiswa()
    {
        $visi = Profile::where('type', 'visi_misi')
            ->where('sub_type', 'visi')
            ->where('active', true)
            ->first();

        $misi = Profile::where('type', 'visi_misi')
            ->where('sub_type', 'misi')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $about = Profile::where('type', 'visi_misi')
            ->where('sub_type', 'about')
            ->where('active', true)
            ->first();

        return view('user.page.profile.visi-misi', compact('visi', 'misi', 'about'));
    }



    public function showTugasFungsi()
    {
        $tugas = Profile::where('type', 'tugas_fungsi')
            ->where('sub_type', 'tugas')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $fungsi = Profile::where('type', 'tugas_fungsi')
            ->where('sub_type', 'fungsi')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $tujuan = Profile::where('type', 'tugas_fungsi')
            ->where('sub_type', 'tujuan')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('guest.page.profile.tugas-fungsi', compact('tugas', 'fungsi', 'tujuan'));
    }

        public function showTugasFungsiMahasiswa()
    {
        $tugas = Profile::where('type', 'tugas_fungsi')
            ->where('sub_type', 'tugas')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $fungsi = Profile::where('type', 'tugas_fungsi')
            ->where('sub_type', 'fungsi')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $tujuan = Profile::where('type', 'tugas_fungsi')
            ->where('sub_type', 'tujuan')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('user.page.profile.tugas-fungsi', compact('tugas', 'fungsi', 'tujuan'));
    }

    public function showStruktur()
    {
        $struktur = Profile::where('type', 'struktur')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('guest.page.profile.struktur-pengurus', compact('struktur'));
    }

    public function showStrukturMahasiswa()
    {
        $struktur = Profile::where('type', 'struktur')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('user.page.profile.struktur-pengurus', compact('struktur'));
    }


    public function showKerjasama()
    {
        $kerjasama = Profile::where('type', 'kerjasama')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('guest.page.profile.kerjasama', compact('kerjasama'));
    }

    public function showKerjasamaMahasiswa()
    {
        $kerjasama = Profile::where('type', 'kerjasama')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('user.page.profile.kerjasama', compact('kerjasama'));
    }

    // ================= ADMIN =================

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'sub_type' => 'nullable',
            'title' => 'required',
            'order' => 'required|integer|min:1',
        ]);

        $order = (int) $request->order;

        if ($order < 1) $order = 1;
        $query = Profile::where('type', $request->type);

        if ($request->sub_type) {
            $query->where('sub_type', $request->sub_type);
        } else {
            $query->whereNull('sub_type');
        }

        // SHIFT
        $query->where('order', '>=', $order)->increment('order');

        Profile::create([
            'type'        => $request->type,
            'sub_type'    => $request->sub_type,
            'title'       => $request->title,
            'description' => $request->description,
            'jabatan'     => $request->jabatan,
            'icon'        => $request->icon,
            'order'       => $order,
            'active'      => true,
            'created_by'  => session('user_id'),
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $item = Profile::findOrFail($id);

        $request->validate([
            'order' => 'required|integer|min:1',
        ]);

        $newOrder = (int) $request->order;
        $oldOrder = $item->order;

        if ($newOrder < 1) $newOrder = 1;

        if ($newOrder != $oldOrder) {

            if ($newOrder < $oldOrder) {
                // NAIK → geser ke bawah
                Profile::where('type', $item->type)
                    ->where('sub_type', $item->sub_type)
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } else {
                // TURUN → geser ke atas
                Profile::where('type', $item->type)
                    ->where('sub_type', $item->sub_type)
                    ->whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            }
        }

        $item->update([
            'title' => $request->title,
            'order' => $newOrder,
        ]);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Profile::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}