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

    // ================= STORE (NORMAL) =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classifications,name',
            'description' => 'nullable|string'
        ]);

        $code = 'CLS-' . strtoupper(substr($request->name, 0, 3)) . time();

        Classification::create([
            'name' => $request->name,
            'code' => $code,
        ]);

        return back()->with('success', 'Classification berhasil ditambahkan');
    }


    // ================= UPDATE =================
    public function update(Request $request, Classification $classification)
    {
        $request->validate([
            'name' => 'required|unique:classifications,name,' . $classification->id,
            'description' => 'nullable|string'
        ]);

        $classification->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Classification berhasil diupdate');
    }

    // ================= TOGGLE ACTIVE (DIHAPUS FIELDNYA) =================
    public function toggle(Classification $classification)
    {
        // karena tidak ada field active di DB, kita skip logic ini
        return back()->with('error', 'Field active tidak tersedia di database');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        $classification = Classification::find($id);
        
        if (!$classification) {
            return back()->with('error', 'Classification tidak ditemukan');
        }

        if (method_exists($classification, 'collections')) {
            $classification->collections()->detach();
        }

        $classification->delete();

        return back()->with('success', 'Classification berhasil dihapus');
    }

    // ================= DESTROY (AJAX) =================
    public function destroyAjax($id)
    {
        $classification = Classification::find($id);
        
        if (!$classification) {
            return response()->json(['message' => 'Data sudah dihapus'], 200);
        }

        if (method_exists($classification, 'collections')) {
            $classification->collections()->detach();
        }

        $classification->delete();

        return response()->json(['success' => true]);
    }

    public function storeAjax(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $classification = Classification::create([
        'name' => $request->name,
        'code' => $request->name, // atau generate otomatis: strtoupper(substr($request->name, 0, 3)) . rand(100, 999)
    ]);

    return response()->json([
        'id' => $classification->id,
        'name' => $classification->name,
    ]);
}
}