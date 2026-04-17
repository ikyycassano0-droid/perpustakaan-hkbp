<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinalProject;
use App\Models\CategoryFinalProject;
use App\Models\User;

class FinalProjectController extends Controller
{
    // ================= USER =================
    // Halaman list final project user berdasarkan kategori
    public function index(Request $request, $category = 'kti')
{
    $viewMap = [
        'ebook' => 'e_book',
        'e-article' => 'e_article',
        'cd' => 'cd',
        'video' => 'video',
        'kti' => 'kti',
    ];

    if (!isset($viewMap[$category])) abort(404);

    if ($category === 'kti') {
        // User hanya melihat KTI miliknya sendiri
        $data = FinalProject::with('category')
            ->where('student_name', auth()->user()->name)
            ->latest()
            ->get();

        $supervisors = User::whereHas('role', function ($q) {
            $q->where('name', 'Dosen');
        })->get();

        return view('user.page.Koleksi_Elektronik.' . $viewMap[$category], 
            compact('data','category','supervisors')
        );
    }

    // Kategori lain → Koleksi elektronik admin upload
    return $this->showAdminUpload($category);
}

    // Store user (upload KTI)
    public function store(Request $request)
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
                'exists:users,id'
            ],
            'abstract' => 'nullable|string',
            'file_url' => 'required|file|mimes:pdf,docx|max:10240', // 10MB
        ]);

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
            $data['file_url'] = $request->file('file_url')->store('final_project_files', 'public');
        }
        

        // Default status pending
        $data['status'] = 'Pending';

        FinalProject::create($data);

        return redirect()->route('final_project.kti')
            ->with('success', 'KTI berhasil diupload');
    }

    // Update user (edit KTI)
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
                'exists:users,id'
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
        $data = FinalProject::with('category')->latest()->get();
        $categories = CategoryFinalProject::all();

        return view('admin.page.koleksi_elektronik', compact('data', 'categories'));
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
            'keywords' => 'nullable|string|max:255',
            'category_final_project_id' => 'nullable|exists:category_final_projects,id',
            'file_url' => 'nullable|file|mimes:pdf,docx,mp3,mp4|max:10240',
            'active' => 'boolean',
        ]);

        $data = $request->only([
            'title', 'abstract', 'keywords', 'category_final_project_id', 'file_url', 'active',
        ]);

        if ($request->hasFile('file_url')) {
            $data['file_url'] = $request->file('file_url')->store('final_project_files', 'public');
        }

        FinalProject::create($data);

        return back()->with('success', 'Data berhasil ditambahkan (Admin)');
    }

    public function update_admin(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string|max:255',
            'category_final_project_id' => 'nullable|exists:category_final_projects,id',
            'file_url' => 'nullable|file|mimes:pdf,docx,mp3,mp4|max:10240',
            'active' => 'boolean',
        ]);

        $item = FinalProject::findOrFail($id);

        $data = $request->only([
            'title', 'abstract', 'keywords', 'category_final_project_id', 'file_url', 'active',
        ]);

        if ($request->hasFile('file_url')) {
            $data['file_url'] = $request->file('file_url')->store('final_project_files', 'public');
        }

        $item->update($data);

        return back()->with('success', 'Data berhasil diupdate (Admin)');
    }

    // Delete
    public function destroy($id)
    {
        $item = FinalProject::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Data berhasil dihapus');
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
        $kti->status = 'Rejected'; // ganti ke Rejected
        $kti->save();

        return redirect()->back()->with('success', 'KTI berhasil di-reject.');
    }

    // ================= Koleksi Elektronik (Admin Upload) =================
    public function showAdminUpload($category)
    {
        // 🔥 TARUH viewMap DI SINI
        $viewMap = [
            'ebook' => 'e_book',
            'e-article' => 'e_article',
            'cd' => 'cd',
            'video' => 'video',
            'kti' => 'kti',
        ];

        // ambil kategori dari database
        $categoryData = CategoryFinalProject::where('slug', $category)->firstOrFail();

        $data = FinalProject::with('category')
            ->where('category_final_project_id', $categoryData->id)
            ->where('status', 'Approved')
            ->latest()
            ->get();

        // 🔥 PAKAI viewMap DI SINI
        return view('user.page.Koleksi_Elektronik.' . $viewMap[$category], 
            compact('data','category')
        );
    }
}