<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        // Ambil data mitra (sub_type = 'mitra')
        $mitra = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'mitra')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        // Ambil data bentuk kerjasama (sub_type = 'bentuk')
        $bentukKerjasama = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'bentuk')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        // Ambil data kolaborasi (sub_type = 'kolaborasi')
        $kolaborasi = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'kolaborasi')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        // Ambil deskripsi umum kerjasama (bisa dari sub_type null atau yang memiliki description)
        $deskripsiKerjasama = Profile::where('type', 'kerjasama')
            ->whereNull('sub_type')
            ->where('active', true)
            ->first();

        // Jika tidak ada deskripsi khusus, ambil dari data pertama yang memiliki description
        if (!$deskripsiKerjasama) {
            $deskripsiKerjasama = Profile::where('type', 'kerjasama')
                ->where('active', true)
                ->whereNotNull('description')
                ->first();
        }

        return view('guest.page.profile.kerjasama', compact('mitra', 'bentukKerjasama', 'kolaborasi', 'deskripsiKerjasama'));
    }

    public function showKerjasamaMahasiswa()
    {
        // Sama seperti di atas untuk user/mahasiswa
        $mitra = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'mitra')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $bentukKerjasama = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'bentuk')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $kolaborasi = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'kolaborasi')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        $deskripsiKerjasama = Profile::where('type', 'kerjasama')
            ->whereNull('sub_type')
            ->where('active', true)
            ->first();

        if (!$deskripsiKerjasama) {
            $deskripsiKerjasama = Profile::where('type', 'kerjasama')
                ->where('active', true)
                ->whereNotNull('description')
                ->first();
        }

        return view('user.page.profile.kerjasama', compact('mitra', 'bentukKerjasama', 'kolaborasi', 'deskripsiKerjasama'));
    }

    // ================= ADMIN CRUD =================

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:visi_misi,tugas_fungsi,struktur,kerjasama',
            'sub_type' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'jabatan' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // CEK DUPLIKAT UNTUK VISI DAN ABOUT - HANYA BOLEH 1
        if ($request->type == 'visi_misi' && in_array($request->sub_type, ['visi', 'about'])) {
            $existing = Profile::where('type', $request->type)
                ->where('sub_type', $request->sub_type)
                ->where('active', true)
                ->exists();

            if ($existing) {
                return back()->with('error', ucfirst($request->sub_type) . ' sudah ada. Tidak dapat menambahkan ' . $request->sub_type . ' baru. Silakan edit yang sudah ada.')->withInput();
            }
        }

        // CEK DUPLIKAT UNTUK DESKRIPSI (Jaringan Mitra Strategis) - HANYA BOLEH 1
        if ($request->type == 'kerjasama' && $request->sub_type == 'deskripsi') {
            $existing = Profile::where('type', $request->type)
                ->where('sub_type', 'deskripsi')
                ->where('active', true)
                ->exists();

            if ($existing) {
                return back()->with('error', 'Deskripsi Jaringan Mitra Strategis sudah ada. Tidak dapat menambahkan lagi. Silakan edit yang sudah ada.')->withInput();
            }
        }

        // CEK JUMLAH MAKSIMAL UNTUK BENTUK KERJASAMA (maksimal 3)
        if ($request->type == 'kerjasama' && $request->sub_type == 'bentuk') {
            $count = Profile::where('type', $request->type)
                ->where('sub_type', 'bentuk')
                ->where('active', true)
                ->count();

            if ($count >= 3) {
                return back()->with('error', 'Bentuk Kerjasama maksimal 3 data. Silakan nonaktifkan atau hapus salah satu terlebih dahulu.')->withInput();
            }
        }

        // VALIDASI KHUSUS UNTUK KOLABORASI - WAJIB ADA GAMBAR
        if ($request->type == 'kerjasama' && $request->sub_type == 'kolaborasi') {
            if (!$request->hasFile('image')) {
                return back()->with('error', 'Kolaborasi wajib menyertakan gambar/logo.')->withInput();
            }
            $request->merge(['order' => 1]);
        }

        // VALIDASI UNTUK STRUKTUR - WAJIB ADA JABATAN
        if ($request->type == 'struktur' && empty($request->jabatan)) {
            return back()->with('error', 'Jabatan wajib diisi untuk data struktur.')->withInput();
        }

        $order = (int) $request->order;
        if ($order < 1) $order = 1;

        // Update order untuk data yang lebih besar atau sama (kecuali deskripsi dan kolaborasi)
        $skipOrderFor = ['deskripsi', 'kolaborasi'];
        if (!in_array($request->sub_type, $skipOrderFor)) {
            $query = Profile::where('type', $request->type);
            if ($request->sub_type) {
                $query->where('sub_type', $request->sub_type);
            } else {
                $query->whereNull('sub_type');
            }
            $query->where('order', '>=', $order)->increment('order');
        }

        // Upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('profiles', $filename, 'public');
            Log::info('Image uploaded: ' . $imagePath);
        }

        // Set order untuk deskripsi dan kolaborasi
        $finalOrder = $order;
        if (in_array($request->sub_type, ['deskripsi', 'kolaborasi'])) {
            $finalOrder = 999; // Taruh di akhir
        }

        // Set order untuk bentuk kerjasama (berurutan otomatis)
        if ($request->type == 'kerjasama' && $request->sub_type == 'bentuk') {
            $maxOrder = Profile::where('type', 'kerjasama')
                ->where('sub_type', 'bentuk')
                ->max('order');
            $finalOrder = ($maxOrder ?? 0) + 1;
        }

        // Set order untuk mitra (bisa banyak, urut berdasarkan input)
        if ($request->type == 'kerjasama' && $request->sub_type == 'mitra') {
            $finalOrder = $order;
        }

        Profile::create([
            'type'        => $request->type,
            'sub_type'    => $request->sub_type,
            'title'       => $request->title,
            'description' => $request->description,
            'jabatan'     => $request->jabatan,
            'icon'        => $request->icon,
            'image'       => $imagePath,
            'order'       => $finalOrder,
            'active'      => $request->has('active') ? true : false,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $item = Profile::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'jabatan' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // VALIDASI UNTUK STRUKTUR - WAJIB ADA JABATAN
        if ($item->type == 'struktur' && empty($request->jabatan)) {
            return back()->with('error', 'Jabatan wajib diisi untuk data struktur.')->withInput();
        }

        // CEK JIKA MENGUBAH KE VISI/ABOUT YANG SUDAH ADA
        if ($request->type != $item->type && $request->type == 'visi_misi' && in_array($request->sub_type, ['visi', 'about'])) {
            $existing = Profile::where('type', $request->type)
                ->where('sub_type', $request->sub_type)
                ->where('active', true)
                ->where('id', '!=', $id)
                ->exists();

            if ($existing) {
                return back()->with('error', ucfirst($request->sub_type) . ' sudah ada. Tidak dapat mengubah data ini menjadi ' . $request->sub_type . '.')->withInput();
            }
        }

        // CEK UNTUK DATA DESKRIPSI - Jangan biarkan ada 2 data deskripsi aktif
        if ($item->type == 'kerjasama' && $item->sub_type == 'deskripsi') {
            $existing = Profile::where('type', 'kerjasama')
                ->where('sub_type', 'deskripsi')
                ->where('active', true)
                ->where('id', '!=', $id)
                ->exists();

            if ($existing) {
                return back()->with('error', 'Deskripsi Jaringan Mitra Strategis sudah ada. Tidak dapat mengaktifkan deskripsi lain.')->withInput();
            }
        }

        // CEK JUMLAH MAKSIMAL UNTUK BENTUK KERJASAMA (maksimal 3) saat mengaktifkan
        if ($item->type == 'kerjasama' && $item->sub_type == 'bentuk' && $request->has('active') && $request->active) {
            $count = Profile::where('type', 'kerjasama')
                ->where('sub_type', 'bentuk')
                ->where('active', true)
                ->where('id', '!=', $id)
                ->count();

            if ($count >= 3) {
                return back()->with('error', 'Bentuk Kerjasama maksimal 3 data. Silakan nonaktifkan salah satu terlebih dahulu.')->withInput();
            }
        }

        $newOrder = (int) $request->order;
        $oldOrder = $item->order;
        $skipOrderFor = ['deskripsi', 'kolaborasi'];

        // Update order hanya jika bukan deskripsi atau kolaborasi
        if (!in_array($item->sub_type, $skipOrderFor) && $newOrder != $oldOrder) {
            if ($newOrder < $oldOrder) {
                Profile::where('type', $item->type)
                    ->where(function($q) use ($item) {
                        if ($item->sub_type) {
                            $q->where('sub_type', $item->sub_type);
                        } else {
                            $q->whereNull('sub_type');
                        }
                    })
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } else {
                Profile::where('type', $item->type)
                    ->where(function($q) use ($item) {
                        if ($item->sub_type) {
                            $q->where('sub_type', $item->sub_type);
                        } else {
                            $q->whereNull('sub_type');
                        }
                    })
                    ->whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            }
        }

        // Upload gambar baru
        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('profiles', $filename, 'public');

            Log::info('Image updated: ' . $imagePath);
        }

        // Set final order untuk deskripsi dan kolaborasi (pertahankan order lama)
        $finalOrder = $newOrder;
        if (in_array($item->sub_type, $skipOrderFor)) {
            $finalOrder = $item->order;
        }

        // Untuk bentuk kerjasama yang diubah ordernya
        if ($item->type == 'kerjasama' && $item->sub_type == 'bentuk') {
            $finalOrder = $newOrder;
        }

        // Untuk mitra (bisa banyak, update sesuai order baru)
        if ($item->type == 'kerjasama' && $item->sub_type == 'mitra') {
            $finalOrder = $newOrder;
        }

        $item->update([
            'title'       => $request->title,
            'description' => $request->description,
            'jabatan'     => $request->jabatan,
            'icon'        => $request->icon,
            'image'       => $imagePath,
            'order'       => $finalOrder,
            'active'      => $request->has('active') ? true : false,
        ]);

        // Jika ada perubahan order pada bentuk kerjasama, reorder ulang
        if ($item->type == 'kerjasama' && $item->sub_type == 'bentuk' && $newOrder != $oldOrder) {
            $this->reorderBentukKerjasama();
        }

        return back()->with('success', 'Data berhasil diupdate');
    }

    private function reorderBentukKerjasama()
    {
        $bentukItems = Profile::where('type', 'kerjasama')
            ->where('sub_type', 'bentuk')
            ->orderBy('order')
            ->get();

        $order = 1;
        foreach ($bentukItems as $item) {
            $item->order = $order;
            $item->save();
            $order++;
        }
    }

    public function destroy($id)
    {
        $item = Profile::findOrFail($id);

        // Hapus gambar jika ada
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    // ================= USER (MAHASISWA) =================
    public function studentProfile()
    {
        $user = auth()->user();

        $totalPinjam = \App\Models\Order::where('user_id', $user->id)->count();
        $aktifPinjam = \App\Models\Order::where('user_id', $user->id)
                        ->where('status', 'dipinjam')
                        ->count();

        $totalKti = \App\Models\FinalProject::where('user_id', $user->id)
                    ->where('status', 'Approved')
                    ->count();

        $unreadNotif = \App\Models\Notification::where('user_id', $user->id)
                       ->where('is_read', false)
                       ->count();

        $point = 0;

        return view('profileAkun.menu', compact(
            'totalPinjam', 'aktifPinjam', 'totalKti', 'unreadNotif', 'point'
        ));
    }
}
