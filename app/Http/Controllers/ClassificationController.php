<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $data = Classification::latest()->get();
        return view('admin.page.classification', compact('data'));
    }

    // ================= STORE BIASA =================
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);

    Classification::create([
        'name' => $request->name,
        'code' => strtoupper(substr($request->name, 0, 3)) . rand(100,999)
    ]);

    return back()->with('success', 'Classification berhasil ditambahkan');
}

    // ================= STORE AJAX =================
   public function storeAjax(Request $request)
{
    
    $request->validate([
        'name' => 'required'
    ]);

    $data = Classification::create([
        'name' => $request->name,
        'code' => strtoupper(substr($request->name, 0, 3)) . rand(100,999)
    ]);

    return response()->json($data);
}

    // ================= UPDATE =================
    public function update(Request $request, Classification $classification)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $classification->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Classification berhasil diupdate');
    }

    // ================= DESTROY =================
    public function destroy(Classification $classification)
    {
        // 🔥 detach pivot dulu supaya tidak error di many-to-many
        $classification->collections()->detach();

        $classification->delete();

        return back()->with('success', 'Classification berhasil dihapus');
    }

    // ================= DELETE LAST =================
    public function deleteLast()
    {
        $data = Classification::latest()->first();

        if ($data) {
            $data->collections()->detach();
            $data->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }
}