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

    // ================= STORE AJAX =================
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classifications,name'
        ]);

        $classification = Classification::create([
            'name' => $request->name
        ]);

        return response()->json([
            'id' => $classification->id,
            'name' => $classification->name
        ], 200);
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
    public function destroy(Classification $classification)
    {
        // aman kalau relasi tidak ada data
        if (method_exists($classification, 'collections')) {
            $classification->collections()->detach();
        }

        $classification->delete();

        return back()->with('success', 'Classification berhasil dihapus');
    }

    // ================= DELETE LAST (AJAX) =================
    public function deleteLast()
    {
        $last = Classification::latest()->first();

        if (!$last) {
            return response()->json(['message' => 'empty'], 404);
        }

        $id = $last->id;

        $last->delete();

        return response()->json([
            'id' => $id
        ]);
    }
}