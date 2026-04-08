<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinalProject;
use App\Models\CategoryFinalProject;

class FinalProjectController extends Controller
{
    // ================= USER =================
    public function index($category)
    {
        $categoryData = CategoryFinalProject::where('name', $category)->firstOrFail();

        $data = FinalProject::with('category')
            ->where('category_final_project_id', $categoryData->id)
            ->latest()
            ->get();

        return view('user.page.final_project.index', compact('data', 'category'));
    }

    // ================= ADMIN =================
    public function index_admin()
    {
        $data = FinalProject::with('category')->latest()->get();
        $categories = CategoryFinalProject::all();

        return view('admin.page.koleksi_elektronik', compact('data', 'categories'));
    }

    // ================= STORE =================
// ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'npm' => 'required|string|max:50',
            'study_program' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'category_final_project_id' => 'required|exists:category_final_projects,id',
            'category_target' => 'required|string', // menu tujuan CRUD
            'file_url' => 'nullable|file|mimes:pdf,mp4,mp3,docx|max:20480'
        ]);

        $data = $request->all();

        // upload file
        if ($request->hasFile('file_url')) {
            $file = $request->file('file_url')->store('final_project_files', 'public');
            $data['file_url'] = $file;
        }

        FinalProject::create($data);

        // Redirect bisa ke page admin atau langsung ke menu CRUD
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $item = FinalProject::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('file_url')) {
            $file = $request->file('file_url')->store('final_project_files', 'public');
            $data['file_url'] = $file;
        }

        $item->update($data);

        return back()->with('success', 'Data berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $item = FinalProject::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}