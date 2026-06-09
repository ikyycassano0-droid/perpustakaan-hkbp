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

        return view('guest.page.profile.visi-misi', compact('visi', 'misi'));
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

        return view('user.page.profile.visi-misi', compact('visi', 'misi'));
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
        // Ambil semua data kerjasama (tanpa filter sub_type)
        $mitra = Profile::where('type', 'kerjasama')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('guest.page.profile.kerjasama', compact('mitra'));
    }

    public function showKerjasamaMahasiswa()
    {
        // Ambil semua data kerjasama (tanpa filter sub_type)
        $mitra = Profile::where('type', 'kerjasama')
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('user.page.profile.kerjasama', compact('mitra'));
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

        // Validasi khusus untuk kerjasama: title wajib diisi
        if ($request->type == 'kerjasama' && empty($request->title)) {
            return back()->with('error', 'Nama mitra / judul kerjasama wajib diisi.')->withInput();
        }

        // CEK DUPLIKAT UNTUK VISI
        if ($request->type == 'visi_misi' && $request->sub_type == 'visi') {
            $existing = Profile::where('type', $request->type)
                ->where('sub_type', $request->sub_type)
                ->where('active', true)
                ->exists();

            if ($existing) {
                return back()->with('error', 'Visi sudah ada. Tidak dapat menambahkan Visi baru.')->withInput();
            }
        }

        // VALIDASI UNTUK STRUKTUR - WAJIB ADA JABATAN
        if ($request->type == 'struktur' && empty($request->jabatan)) {
            return back()->with('error', 'Jabatan wajib diisi untuk data struktur.')->withInput();
        }

        // 1. Khusus Kerjasama: Hapus sub_type & jangan simpan gambar
        if ($request->type == 'kerjasama') {
            $request->merge(['sub_type' => null]);
        }

        // 2. Khusus Tugas & Fungsi: Hapus title, icon, jangan simpan gambar
        if ($request->type == 'tugas_fungsi') {
            $request->merge(['title' => null, 'icon' => null]);
        }

        $order = (int) $request->order;
        if ($order < 1) $order = 1;

        // Update order untuk data yang lebih besar atau sama (kecuali deskripsi)
        $skipOrderFor = ['deskripsi'];
        if (!in_array($request->sub_type, $skipOrderFor)) {
            $query = Profile::where('type', $request->type);
            if ($request->sub_type !== null) {
                $query->where('sub_type', $request->sub_type);
            } else {
                $query->whereNull('sub_type');
            }
            $query->where('order', '>=', $order)->increment('order');
        }

        // Upload gambar (kecuali untuk kerjasama & tugas_fungsi)
        $imagePath = null;
        if ($request->hasFile('image') && !in_array($request->type, ['kerjasama', 'tugas_fungsi'])) {
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('profiles', $filename, 'public');
            Log::info('Image uploaded: ' . $imagePath);
        }

        $finalOrder = $order;
        if ($request->sub_type == 'deskripsi') {
            $finalOrder = 999;
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

        // 1. Validasi
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'jabatan'     => 'nullable|string|max:255',
            'icon'        => 'nullable|string|max:100',
            'order'       => 'sometimes|integer|min:1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // 2. Validasi Khusus
        if ($item->type == 'kerjasama' && empty($request->title)) {
            return back()->with('error', 'Nama mitra / judul kerjasama wajib diisi.')->withInput();
        }

        if ($item->type == 'struktur' && empty($request->jabatan)) {
            return back()->with('error', 'Jabatan wajib diisi untuk data struktur.')->withInput();
        }

        // 3. Cek jika mengubah data menjadi VISI (hanya boleh ada 1 Visi aktif)
        if ($request->has('type') && $request->type != $item->type && $request->type == 'visi_misi' && $request->sub_type == 'visi') {
            $existing = Profile::where('type', $request->type)
                ->where('sub_type', $request->sub_type)
                ->where('active', true)
                ->where('id', '!=', $id)
                ->exists();

            if ($existing) {
                return back()->with('error', 'Visi sudah ada. Tidak dapat mengubah data ini menjadi Visi.')->withInput();
            }
        }

        // 4. Logic Update Order (Hanya jika order dikirim dan berubah)
        if ($request->has('order')) {
            $newOrder = (int) $request->order;
            $oldOrder = $item->order;
            $skipOrderFor = ['deskripsi'];

            if (!in_array($item->sub_type, $skipOrderFor) && $newOrder != $oldOrder) {
                if ($newOrder < $oldOrder) {
                    Profile::where('type', $item->type)
                        ->where(function($q) use ($item) {
                            if ($item->sub_type !== null) {
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
                            if ($item->sub_type !== null) {
                                $q->where('sub_type', $item->sub_type);
                            } else {
                                $q->whereNull('sub_type');
                            }
                        })
                        ->whereBetween('order', [$oldOrder + 1, $newOrder])
                        ->decrement('order');
                }
            }
        }

        // 5. Handle Gambar
        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            // Jika type kerjasama atau tugas_fungsi, abaikan gambar
            if (in_array($item->type, ['kerjasama', 'tugas_fungsi'])) {
                $imagePath = null;
            } else {
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $image = $request->file('image');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $image->getClientOriginalName());
                $imagePath = $image->storeAs('profiles', $filename, 'public');
                Log::info('Image updated: ' . $imagePath);
            }
        }

        // 6. Siapkan Data Update (HANYA update field yang dikirim)
        $updateData = [
            'active' => $request->has('active') ? true : false,
            'image'  => $imagePath,
        ];

        // 6a. Khusus Kerjasama: Sub type harus null dan gambar sudah ditangani di atas
        if ($item->type == 'kerjasama') {
            $updateData['sub_type'] = null;
            // Gambar sudah dipaksa null di atas jika ada upload
        }

        // 6b. Khusus Tugas & Fungsi: Title & Icon harus null
        if ($item->type == 'tugas_fungsi') {
            $updateData['title'] = null;
            $updateData['icon'] = null;
            // Gambar sudah dipaksa null di atas jika ada upload
        }

        // 6c. Field umum yang dikirim (hanya jika ada di request)
        if ($request->has('title') && !in_array($item->type, ['tugas_fungsi'])) {
            $updateData['title'] = $request->title;
        }
        if ($request->has('description')) {
            $updateData['description'] = $request->description;
        }
        if ($request->has('jabatan')) {
            $updateData['jabatan'] = $request->jabatan;
        }
        if ($request->has('icon') && !in_array($item->type, ['tugas_fungsi'])) {
            $updateData['icon'] = $request->icon;
        }

        // Set order hanya jika dikirim
        if ($request->has('order')) {
            $finalOrder = (int) $request->order;
            // Cegah order berubah untuk 'deskripsi' (jika masih ada di database)
            if (in_array($item->sub_type, ['deskripsi'])) {
                $finalOrder = $item->order;
            }
            $updateData['order'] = $finalOrder;
        }

        // 7. Eksekusi Update
        $item->update($updateData);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $item = Profile::findOrFail($id);

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    // ================= USER (MAHASISWA) =================
    public function studentProfile()
    {
        $userData = session('user');

        if (!$userData) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = $userData['id'];

        $totalPinjam = \App\Models\Order::where('user_id', $userId)->count();
        $aktifPinjam = \App\Models\Order::where('user_id', $userId)
                        ->where('status', 'dipinjam')
                        ->count();

        $totalKti = \App\Models\FinalProject::where('user_id', $userId)
                    ->where('status', 'Approved')
                    ->count();

        $unreadNotif = \App\Models\Notification::where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();

        $point = 0;

        return view('profileAkun.menu', compact(
            'totalPinjam', 'aktifPinjam', 'totalKti', 'unreadNotif', 'point'
        ));
    }
}