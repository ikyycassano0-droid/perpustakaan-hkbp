<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FinalProject;
use App\Models\CategoryFinalProject;
use App\Models\User;
use App\Models\Classification;
use App\Models\CategoryCollection;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class FinalProjectController extends Controller
{
    // ================= USER =================
public function index(Request $request, $category = 'kti')
{

    if ($category !== 'kti') {
        return $this->showAdminUpload($request, $category);
    }

    $ktiCategory = CategoryFinalProject::where('slug', 'kti')
        ->orWhere('name', 'kti')
        ->first();

    if (!$ktiCategory) {
        // Buat category jika belum ada
        $ktiCategory = CategoryFinalProject::create([
            'name' => 'KTI',
            'slug' => 'kti',
            'description' => 'Karya Tulis Ilmiah Mahasiswa'
        ]);
    }


    $allApprovedKtis = FinalProject::with(['category', 'firstSupervisor', 'secondSupervisor', 'user'])
        ->where('status', 'Approved')
        ->where('category_final_project_id', $ktiCategory->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $myKtis = FinalProject::with(['category', 'firstSupervisor', 'secondSupervisor'])
        ->where('user_id', user_id())
        ->where('category_final_project_id', $ktiCategory->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Ambil data dosen untuk dropdown (untuk form upload)
    $supervisors = User::whereHas('role', function ($q) {
        $q->where('name', 'Dosen');
    })->get();

    return view('user.page.Koleksi_Elektronik.kti', [
        'allApprovedKtis' => $allApprovedKtis,
        'myKtis' => $myKtis,
        'supervisors' => $supervisors,
    ]);
}

    public function uploadForm()
    {
        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'Dosen');
        })->get();

        return view('user.page.Koleksi_Elektronik.kti', compact('supervisors'));
    }

    // Store user (upload KTI)
// Store user (upload KTI)
public function store(Request $request)
{
    // ================= CUSTOM VALIDATION PDF =================
    \Validator::extend('is_real_pdf', function ($attribute, $value, $parameters, $validator) {
        if (!$value || !$value->isValid()) {
            return false;
        }

        try {
            $handle = fopen($value->getRealPath(), 'rb');
            $first200bytes = fread($handle, 200);
            fclose($handle);
            return strpos($first200bytes, '%PDF') !== false;
        } catch (\Exception $e) {
            \Log::error('PDF Validation Error: ' . $e->getMessage());
            return false;
        }
    });

    // ================= VALIDASI =================
    $request->validate([
        'npm' => 'required|string|max:50',
        'study_program' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'first_supervisor_id' => 'required|exists:users,id',
        'second_supervisor_id' => 'nullable|exists:users,id|different:first_supervisor_id',
        'abstract' => 'nullable|string',
        'file_url' => 'required|file|is_real_pdf|max:10240', // ← GANTI mimes:pdf,docx jadi is_real_pdf
    ]);

    // Upload file
    $file = $request->file('file_url');
    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
    $path = $file->storeAs('final_project_files', $filename, 'public');

    // Cari category KTI
    $category = CategoryFinalProject::where('name', 'kti')->orWhere('slug', 'kti')->first();

    if (!$category) {
        $category = CategoryFinalProject::create([
            'name' => 'kti',
            'slug' => 'kti',
            'description' => 'Karya Tulis Ilmiah'
        ]);
    }

    // Simpan data
    $kti = FinalProject::create([
        'user_id' => user_id(),
        'student_name' => current_user()->name,
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

    return redirect('/final-project/kti?t=' . time())
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
    public function index_admin()
    {
        // Ambil ID kategori KTI
        $ktiCategory = CategoryFinalProject::where('slug', 'kti')->orWhere('name', 'kti')->first();

        $data = FinalProject::with(['category', 'classifications', 'categoriesMany'])
            ->where('status', 'Approved')
            ->when($ktiCategory, function($query) use ($ktiCategory) {
                // JANGAN tampilkan yang kategori KTI
                $query->where('category_final_project_id', '!=', $ktiCategory->id);
            })
            ->latest()
            ->get();

        $categories = CategoryFinalProject::all();
        $classifications = Classification::all();
        $categoriesCollection = CategoryCollection::all();

        return view('admin.page.koleksi_elektronik', compact(
            'data', 'categories', 'classifications', 'categoriesCollection'
        ));
    }

    // List semua KTI untuk admin
    public function index_kti_admin(Request $request)
    {
        $query = FinalProject::with('category', 'firstSupervisor', 'secondSupervisor');

        // Filter status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter periode
        if ($request->period == 'today') {
            $query->whereDate('created_at', today());
        } elseif ($request->period == 'week') {
            $query->whereBetween('created_at', [now()->subWeek(), now()]);
        } elseif ($request->period == 'month') {
            $query->whereBetween('created_at', [now()->subMonth(), now()]);
        } elseif ($request->start && $request->end) {
            $query->whereBetween('created_at', [$request->start, $request->end]);
        }

        $data = $query->latest()->get();
        return view('admin.page.kti', compact('data'));
    }

    // Store & update Koleksi Elektronik admin
    public function store_admin(Request $request)
    {
        // =======================================================
        // TAMBAHAN: Custom Validation Rule untuk PDF
        // =======================================================
        \Validator::extend('is_real_pdf', function ($attribute, $value, $parameters, $validator) {
            if (!$value || !$value->isValid()) {
                return false;
            }

            try {
                // Baca 200 byte pertama file
                $handle = fopen($value->getRealPath(), 'rb');
                $first200bytes = fread($handle, 200);
                fclose($handle);

                // Cek apakah ada string '%PDF' di mana pun dalam 200 byte pertama
                return strpos($first200bytes, '%PDF') !== false;
            } catch (\Exception $e) {
                \Log::error('PDF Validation Error: ' . $e->getMessage());
                return false;
            }
        });

        // =======================================================
        // VALIDASI (diubah: mimes:pdf diganti is_real_pdf)
        // =======================================================
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:2099',
            'isbn' => 'nullable|string|max:100',
            'category_final_project_id' => 'required|exists:category_final_projects,id',
            'file_url' => 'required|file|is_real_pdf|max:10240', // ← GANTI mimes:pdf jadi is_real_pdf
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'classification_id' => 'nullable|array',
            'classification_id.*' => 'exists:classifications,id',
            'category_collection_id' => 'nullable|array',
            'category_collection_id.*' => 'exists:category_collections,id',
        ]);

        $data = $request->only([
            'title',
            'abstract',
            'isbn',
            'category_final_project_id',
            'year',
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
        $item->classifications()->sync($request->classification_id ?? []);
        $item->categoriesMany()->sync($request->category_collection_id ?? []);

        return back()->with('success', 'Berhasil ditambahkan');
    }

    public function update_admin(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:2099',
            'isbn' => 'nullable|string|max:100',
            'category_final_project_id'=> 'required|exists:category_final_projects,id',
            'file_url'=> 'nullable|file|mimes:pdf,docx,mp3,mp4|max:10240',
            'cover_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'classification_id' => 'nullable|array',
            'classification_id.*' => 'exists:classifications,id',
            'category_collection_id' => 'nullable|array',
            'category_collection_id.*'=> 'exists:category_collections,id',
        ]);

        $item = FinalProject::findOrFail($id);

        $data = $request->only([
            'title',
            'abstract',
            'isbn',
            'year',
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

         Notification::create([
            'user_id' => $kti->user_id,
            'title' => 'KTI Disetujui',
            'message' => "KTI dengan judul \"{$kti->title}\" telah disetujui oleh admin."
        ]);

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

        Notification::create([
            'user_id' => $kti->user_id,
            'title' => 'KTI Ditolak',
            'message' => "Maaf, KTI dengan judul \"{$kti->title}\" ditolak. Silakan periksa kembali."
        ]);
        return redirect()->back()->with('success', 'KTI berhasil di-reject.');
    }

        // ================= Koleksi Elektronik (Admin Upload) =================
        public function showAdminUpload(Request $request, $category)
        {
            $viewMap = [
                'ebook'     => 'e_book',
                'e-article' => 'e_article',
                'cd'        => 'cd',
                'video'     => 'video',
            ];

            $categoryData = CategoryFinalProject::where('slug', $category)->firstOrFail();

            $query = FinalProject::with(['category', 'user'])
                ->where('category_final_project_id', $categoryData->id)
                ->where('status', 'Approved');

            // 🔍 SEARCH
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('abstract', 'like', '%' . $request->search . '%');
                });
            }

            // 🔍 FILTER KATEGORI (dari CategoryCollection)
            $selectedCategory = $request->category;
            $noCategoryMessage = null;

            if ($request->filled('category')) {
                $query->whereHas('categoriesMany', function ($q) use ($request) {
                    $q->where('name', $request->category);
                });
                // Jika setelah filter tidak ada data, siapkan pesan untuk view
                if ($query->count() === 0) {
                    $noCategoryMessage = "Maaf, untuk kategori <strong>" . e($request->category) . "</strong> belum ada koleksi.";
                }
            }

            // 🔍 SORT
            if ($request->sort === 'title_asc') {
                $query->orderBy('title', 'asc');
            } elseif ($request->sort === 'title_desc') {
                $query->orderBy('title', 'desc');
            } else {
                $query->latest();
            }

            $data = $query->paginate(6)->appends($request->query());
            $filterCategories = CategoryCollection::all();

            $viewData = [
                'data'              => $data,
                'ebooks'            => $data,
                'videos'            => $data,
                'filterCategories'  => $filterCategories,
                'selectedCategory'  => $selectedCategory,
                'noCategoryMessage' => $noCategoryMessage,
            ];

            return view(
                'user.page.Koleksi_Elektronik.' . $viewMap[$category],
                $viewData
            );
        }

    public function showAdminUploadGuest(Request $request, $category)
    {
        $viewMap = [
            'ebook'     => 'e_book',
            'e-article' => 'e_article',
            'cd'        => 'cd',
            'video'     => 'video',
        ];

        $categoryData = CategoryFinalProject::where('slug', $category)->firstOrFail();

        $query = FinalProject::with(['category', 'user'])
            ->where('category_final_project_id', $categoryData->id)
            ->where('status', 'Approved');

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('abstract', 'like', '%' . $request->search . '%');
            });
        }

        // 🔍 FILTER KATEGORI (dari CategoryCollection)
        $selectedCategory = $request->category;
        $noCategoryMessage = null;

        if ($request->filled('category')) {
            $query->whereHas('categoriesMany', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
            // Jika setelah filter tidak ada data, siapkan pesan untuk view
            if ($query->count() === 0) {
                $noCategoryMessage = "Maaf, untuk kategori <strong>" . e($request->category) . "</strong> belum ada koleksi.";
            }
        }

        // 🔍 SORT
        if ($request->sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($request->sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
            $query->latest();
        }

        $data = $query->paginate(6)->appends($request->query());
        $filterCategories = CategoryCollection::all();

        $viewData = [
            'data'              => $data,
            'ebooks'            => $data,
            'videos'            => $data,
            'filterCategories'  => $filterCategories,
            'selectedCategory'  => $selectedCategory,
            'noCategoryMessage' => $noCategoryMessage,
        ];

        return view(
            'guest.page.Koleksi_Elektronik.' . $viewMap[$category],
            $viewData
        );
    }

    public function download($id)
    {
            \Log::info('Download hit', [
        'auth_check' => auth()->check(),
        'user_id' => auth()->id(),
        'session_id' => session()->getId(),
        'request_url' => request()->fullUrl(),
    ]);
        $file = FinalProject::findOrFail($id);


        if ($file->status !== 'Approved') {
            abort(403, 'File belum tersedia.');
        }


        if (!$file->file_url) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $file->file_url);


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

    public function detailUser($id)
    {
        $item = FinalProject::with([
            'category',
            'classifications',
            'categoriesMany',
            'user'
        ])->findOrFail($id);

        if ($item->status !== 'Approved') {
            abort(403);
        }

        $slug = $item->category->slug ?? 'ebook';
        
        // View untuk user
        $viewMap = [
            'ebook' => 'user.page.Koleksi_Elektronik.detail',
            'e-article' => 'user.page.Koleksi_Elektronik.detail', // EBOOK & E-ARTICLE PAKAI VIEW SAMA
            'cd' => 'user.page.Koleksi_Elektronik.detail_cd',
            'video' => 'user.page.Koleksi_Elektronik.detail_video',
        ];

        $view = $viewMap[$slug] ?? 'user.page.Koleksi_Elektronik.detail';

        return view($view, compact('item'));
    }

        public function detailGuest($id)
    {
        $item = FinalProject::with([
            'category',
            'classifications',
            'categoriesMany',
            'user'
        ])->findOrFail($id);

        if ($item->status !== 'Approved') {
            abort(403);
        }

        $slug = $item->category->slug ?? 'ebook';
        
        // View untuk guest
        $viewMap = [
            'ebook' => 'guest.page.Koleksi_Elektronik.detail',
            'e-article' => 'guest.page.Koleksi_Elektronik.detail', // EBOOK & E-ARTICLE PAKAI VIEW SAMA
            'cd' => 'guest.page.Koleksi_Elektronik.detail_cd',
            'video' => 'guest.page.Koleksi_Elektronik.detail_video',
        ];

        $view = $viewMap[$slug] ?? 'guest.page.Koleksi_Elektronik.detail';

        return view($view, compact('item'));
    }
}
