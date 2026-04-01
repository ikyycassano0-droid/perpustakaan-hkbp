<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function index()
    {
        $data = Classification::latest()->get();
        return view('admin.page.classification', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Classification::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Classification berhasil ditambahkan');
    }

    // ================= AJAX STORE =================
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = Classification::create([
            'name' => $request->name
        ]);

        return response()->json($data);
    }

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
    public function destroy(Classification $classification)
    {
        $classification->delete();

        return back()->with('success', 'Classification berhasil dihapus');
    }

    // ================= DELETE LAST =================
    public function deleteLast()
    {
        $data = Classification::latest()->first();

        if ($data) {
            $data->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }
}