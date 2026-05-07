<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FinalProject;
use App\Models\CategoryFinalProject;
use App\Models\User;
use App\Models\Classification;
use App\Models\CategoryCollection;

class FinalProjectController extends Controller
{
    // ================= USER =================
    public function index(Request $request, $category = 'kti')
    {
        if ($category !== 'kti') {
            return $this->showAdminUpload($request, $category);
        }

        // Ambil SEMUA KTI yang sudah APPROVED untuk ditampilkan di menu "Semua KTI"
        $allApprovedKtis = FinalProject::with(['category', 'firstSupervisor', 'secondSupervisor', 'user'])
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil KTI milik user yang sedang login (SEMUA STATUS)
        $myKtis = FinalProject::with(['category', 'firstSupervisor', 'secondSupervisor'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data dosen untuk dropdown (untuk form upload)
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'Dosen');
        })->get();

        return view('user.page.Koleksi_Elektronik.kti', [
            'allApprovedKtis' => $allApprovedKtis,  // Untuk menu "Semua KTI"
            'myKtis' => $myKtis,                    // Untuk menu "KTI Saya"
            'supervisors' => $supervisors,
        ]);
    }

    public function uploadForm()
    {
        // Ambil data KTI milik user yang sedang login
        $ktis = FinalProject::with(['category', 'firstSupervisor', 'secondSupervisor'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data dosen untuk dropdown
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'Dosen');
        })->get();

        return view('user.page.Layanan.upload_ta', [
            'ktis' => $ktis,
            'supervisors' => $supervisors,
        ]);
    }

    public function updateFromUpload(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'npm' => 'required|string|max:50',
            'study_program' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'first_supervisor_id' => 'required|exists:users,id',
            'second_supervisor_id' => 'nullable|exists:users,id|different:first_supervisor_id',
            'abstract' => 'nullable|string',
            'file_url' => 'nullable|file|mimes:pdf,docx|max:10240',
        ]);

        $item = FinalProject::findOrFail($id);
        
        // Pastikan user hanya bisa update miliknya sendiri
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->only([
            'student_name',
            'npm',
            'study_program',
            'title',
            'first_supervisor_id',
            'second_supervisor_id',
            'abstract',
        ]);

        if ($request->hasFile('file_url')) {
            if ($item->file_url && Storage::disk('public')->exists($item->file_url)) {
                Storage::disk('public')->delete($item->file_url);
            }
            $data['file_url'] = $request->file('file_url')->store('final_project_files', 'public');
        }

        $data['status'] = 'Pending';
        $item->update($data);

        return redirect()->route('final_project.upload')
            ->with('success', 'KTI berhasil diupdate dan akan diverifikasi ulang.');
    }

        public function destroyFromUpload($id)
    {
        $item = FinalProject::findOrFail($id);
        
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($item->file_url && Storage::disk('public')->exists($item->file_url)) {
            Storage::disk('public')->delete($item->file_url);
        }

        $item->delete();

        return redirect()->route('final_project.upload')
            ->with('success', 'KTI berhasil dihapus.');
    }

    // Store user (upload KTI)
    public function store(Request $request)
        {
            $request->validate([
                'npm' => 'required|string|max:50',
                'study_program' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'first_supervisor_id' => 'required|exists:users,id',
                'second_supervisor_id' => 'nullable|exists:users,id|different:first_supervisor_id',
                'abstract' => 'nullable|string',
                'file_url' => 'required|file|mimes:pdf,docx|max:10240',
            ]);

            // Upload file
            $file = $request->file('file_url');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('final_project_files', $filename, 'public');

            // Cari category KTI
            $category = CategoryFinalProject::where('name', 'kti')->orWhere('slug', 'kti')->first();
            
            if (!$category) {
                // Buat category jika belum ada
                $category = CategoryFinalProject::create([
                    'name' => 'kti',
                    'slug' => 'kti',
                    'description' => 'Karya Tulis Ilmiah'
                ]);
            }

            // Simpan data
            $kti = FinalProject::create([
                'user_id' => auth()->id(),
                'student_name' => auth()->user()->name,
                'npm' => $request->npm,
                'study_program' => $request->study_program,
                'title' => $request->title,
                'abstract' => $request->abstract,
                'first_supervisor_id' => $request->first_supervisor_id,
                'second_supervisor_id' => $request->second_supervisor_id,
                'file_url' => $path,
                'category_final_project_id' => $category->id,
                'status' => 'Pending',
            ]);

            // Redirect sesuai asal request
            if ($request->has('from') && $request->from === 'layanan') {
                return redirect()->route('final_project.upload.kti')
                    ->with('success', 'KTI berhasil diupload! Menunggu persetujuan admin.');
            }

            return redirect()->route('final_project.kti')
                ->with('success', 'KTI berhasil diupload! Menunggu persetujuan admin.');
        }



    public function update(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'npm' => 'required|string|max:50',
            'study_program' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'first_supervisor_id' => [
                'required',
                'exists:users,id'
            ],
            'second_supervisor_id' => [
                'nullable',
                'exists:users,id',
                'different:first_supervisor_id'
            ],
            'abstract' => 'nullable|string',
            'file_url' => 'nullable|file|mimes:pdf,docx|max:10240', // 10MB
        ]);

        $item = FinalProject::findOrFail($id);

        $data = $request->only([
            'student_name',
            'npm',
            'study_program',
            'title',
            'first_supervisor_id',
            'second_supervisor_id',
            'abstract',
        ]);
        $category = CategoryFinalProject::where('name', 'kti')->firstOrFail();
        $data['category_final_project_id'] = $category->id;

        if ($request->hasFile('file_url')) {

            // hapus file lama
            if ($item->file_url && Storage::disk('public')->exists($item->file_url)) {
                Storage::disk('public')->delete($item->file_url);
            }

            $data['file_url'] = $request->file('file_url')->store('final_project_files', 'public');
        }

        // Status tetap pending saat update
        $data['status'] = 'Pending';

        $item->update($data);

        return back()->with('success', 'Final Project berhasil diupdate, menunggu approval admin.');
    }

    // ================= ADMIN =================
    // List semua Koleksi Elektronik
    public function index_admin()
    {
        $data = FinalProject::with([
            'category',
            'classifications',
            'categoriesMany'
        ])->latest()->get();

        $categories = CategoryFinalProject::all();

        $classifications = Classification::all();

        $categoriesCollection = CategoryCollection::all();

        return view(
            'admin.page.koleksi_elektronik',
            compact(
                'data',
                'categories',
                'classifications',
                'categoriesCollection'
            )
        );
    }

    // List semua KTI untuk admin
    public function index_kti_admin()
    {
        $data = FinalProject::with('category', 'firstSupervisor', 'secondSupervisor')
                    ->latest()
                    ->get();

        return view('admin.page.kti', compact('data'));
    }

    // Store & update Koleksi Elektronik admin
    public function store_admin(Request $request)
    {
        $request->validate([

            'title' => 'required|string|max:255',

            'abstract' => 'nullable|string',

            'keywords' => 'nullable|string',

            // 🔥 TAMBAHAN ISBN
            'isbn' => 'nullable|string|max:100',

            'category_final_project_id'
                => 'required|exists:category_final_projects,id',

            'file_url'
                => 'required|file|mimes:pdf,docx,mp3,mp4|max:10240',

            'cover_image'
                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'classification_id' => 'nullable|array',
            'classification_id.*' => 'exists:classifications,id',

            'category_collection_id' => 'nullable|array',
            'category_collection_id.*'
                => 'exists:category_collections,id',

        ]);

        $data = $request->only([
            'title',
            'abstract',
            'isbn', // 🔥 TAMBAHAN
            'category_final_project_id',
        ]);

        // ================= FILE =================
        if ($request->hasFile('file_url')) {

            $data['file_url'] = $request->file('file_url')
                ->store('final_project_files', 'public');
        }

        // ================= COVER =================
        if ($request->hasFile('cover_image')) {

            $data['cover_image'] = $request->file('cover_image')
                ->store('final_project_covers', 'public');
        }

        // ================= KEYWORDS =================
        $data['keywords'] = $request->keywords
            ? array_map('trim', explode(',', $request->keywords))
            : null;

        // ================= STATUS =================
        $data['status'] = 'Approved';

        // ================= CREATE =================
        $item = FinalProject::create($data);

        // ================= SYNC RELATION =================
        $item->classifications()->sync(
            $request->classification_id ?? []
        );

        $item->categoriesMany()->sync(
            $request->category_collection_id ?? []
        );

        return back()->with(
            'success',
            'Berhasil ditambahkan'
        );
    }

    public function update_admin(Request $request, $id)
    {
        $request->validate([

            'title' => 'required|string|max:255',

            'abstract' => 'nullable|string',

            'keywords' => 'nullable|string',

            // 🔥 TAMBAHAN ISBN
            'isbn' => 'nullable|string|max:100',

            'category_final_project_id'
                => 'required|exists:category_final_projects,id',

            'file_url'
                => 'nullable|file|mimes:pdf,docx,mp3,mp4|max:10240',

            'cover_image'
                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'classification_id' => 'nullable|array',
            'classification_id.*' => 'exists:classifications,id',

            'category_collection_id' => 'nullable|array',
            'category_collection_id.*'
                => 'exists:category_collections,id',

        ]);

        $item = FinalProject::findOrFail($id);

        $data = $request->only([
            'title',
            'abstract',
            'isbn', // 🔥 TAMBAHAN
            'category_final_project_id',
        ]);

        // ================= KEYWORDS =================
        $data['keywords'] = $request->keywords
            ? array_map('trim', explode(',', $request->keywords))
            : null;

        // ================= STATUS =================
        $data['status'] = 'Approved';

        // ================= UPDATE FILE =================
        if ($request->hasFile('file_url')) {

            if (
                $item->file_url &&
                Storage::disk('public')->exists($item->file_url)
            ) {

                Storage::disk('public')->delete(
                    $item->file_url
                );
            }

            $data['file_url'] = $request->file('file_url')
                ->store('final_project_files', 'public');
        }

        // ================= UPDATE COVER =================
        if ($request->hasFile('cover_image')) {

            if (
                $item->cover_image &&
                Storage::disk('public')->exists($item->cover_image)
            ) {

                Storage::disk('public')->delete(
                    $item->cover_image
                );
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('final_project_covers', 'public');
        }

        // ================= UPDATE =================
        $item->update($data);

        // ================= SYNC =================
        $item->classifications()->sync(
            $request->classification_id ?? []
        );

        $item->categoriesMany()->sync(
            $request->category_collection_id ?? []
        );

        return back()->with(
            'success',
            'Data berhasil diupdate (Admin)'
        );
    }



    // Delete
    public function destroy($id)
    {
        $item = FinalProject::findOrFail($id);

        // hapus file
        if (
            $item->file_url &&
            Storage::disk('public')->exists($item->file_url)
        ) {

            Storage::disk('public')->delete(
                $item->file_url
            );
        }

        // hapus cover
        if (
            $item->cover_image &&
            Storage::disk('public')->exists($item->cover_image)
        ) {

            Storage::disk('public')->delete(
                $item->cover_image
            );
        }

        $item->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus'
        );
    }

    // ================= Pending / Approval KTI =================
    public function approve($id)
    {
        $kti = FinalProject::findOrFail($id);
        $kti->status = 'Approved'; // ganti ke Approved
        $kti->save();

        return redirect()->back()->with('success', 'KTI berhasil di-approve.');
    }

    public function reject($id)
    {
        $kti = FinalProject::findOrFail($id);


        if ($kti->file_url && Storage::disk('public')->exists($kti->file_url)) {
            Storage::disk('public')->delete($kti->file_url);
        }

        $kti->file_url = null; // optional (biar bersih di DB)
        $kti->status = 'Rejected';
        $kti->save();

        return redirect()->back()->with('success', 'KTI berhasil di-reject.');
    }

        // ================= Koleksi Elektronik (Admin Upload) =================
        public function showAdminUpload(Request $request, $category)
    {
        $viewMap = [
            'ebook' => 'e_book',
            'e-article' => 'e_article',
            'cd' => 'cd',
            'video' => 'video',
        ];

        $categoryData = CategoryFinalProject::where('slug', $category)->firstOrFail();

        $query = FinalProject::where('category_final_project_id', $categoryData->id)
            ->where('status', 'Approved');

        // 🔍 SEARCH (INI YANG BUTUH $request)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('abstract', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->latest()->paginate(6);

        $categories = CategoryFinalProject::all();

        return view(
            'user.page.Koleksi_Elektronik.' . $viewMap[$category],
            [
                'data' => $data,
                'ebooks' => $data,
                'videos' => $data,
                'categories' => $categories
            ]
        );
    }

    public function download($id)
    {
        $file = FinalProject::findOrFail($id);

        // 🔥 CEK STATUS
        if ($file->status !== 'Approved') {
            abort(403, 'File belum tersedia.');
        }

        // 🔥 CEK FILE ADA DI DB
        if (!$file->file_url) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $file->file_url);

        // 🔥 CEK FILE FISIK ADA
        if (!file_exists($path)) {
            abort(404, 'File fisik tidak ditemukan.');
        }

        return response()->download($path);
    }

    public function pending_admin()
    {
        $data = FinalProject::with('category', 'firstSupervisor', 'secondSupervisor')
            ->where('status', 'Pending')
            ->latest()
            ->get();

        return view('admin.page.kti', compact('data'));
    }

    public function tutorial_simulasi(Request $request)
    {
        $query = FinalProject::where('status', 'Approved')
            ->whereHas('category', function ($q) {
                $q->where('slug', 'video');
            });

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('abstract', 'like', '%' . $request->search . '%');
            });
        }

        $videos = $query->latest()->paginate(6);

        return view('user.page.Koleksi_Elektronik.video', compact('videos'));
    }

    public function create()
    {
        $supervisors = User::whereHas('role', function ($q) {
    $q->where('name', 'Dosen');
})->get();
        $categories = CategoryFinalProject::all();

        return view('user.page.Koleksi_Elektronik.create_kti', compact('supervisors', 'categories'));
    }
}
