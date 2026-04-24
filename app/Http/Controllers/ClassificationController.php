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

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classifications,name',
            'description' => 'nullable|string'
        ]);

        $code = $this->generateUniqueCode($request->name);

        Classification::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'active' => true,
            'created_by' => session('user_id'),
        ]);

        return back()->with('success', 'Classification berhasil ditambahkan');
    }

    // ================= STORE AJAX =================
public function storeAjax(Request $request)
{
    $request->validate([
        'name' => 'required|unique:classifications,name',
    ]);

    try {

        $data = Classification::create([
            'name' => $request->name,
            'code' => strtoupper(substr($request->name, 0, 3)) . rand(100,999),
            'active' => true,
            'created_by' => auth()->id() ?? 0,
        ]);

        return response()->json([
            'id' => $data->id,
            'name' => $data->name
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'message' => $e->getMessage()
        ], 500);
    }
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
            'description' => $request->description,
            'updated_by' => session('user_id'),
        ]);

        return back()->with('success', 'Classification berhasil diupdate');
    }

    // ================= TOGGLE ACTIVE =================
    public function toggle(Classification $classification)
    {
        $classification->update([
            'active' => !$classification->active,
            'updated_by' => session('user_id'),
        ]);

        return back()->with('success', 'Status classification diubah');
    }

    // ================= DESTROY =================
    public function destroy(Classification $classification)
    {
        $classification->collections()->detach();
        $classification->delete();

        return back()->with('success', 'Classification berhasil dihapus');
    }

    // ================= HELPER =================
    private function generateUniqueCode($name)
    {
        do {
            $code = strtoupper(substr($name, 0, 3)) . rand(100,999);
        } while (Classification::where('code', $code)->exists());

        return $code;
    }

    // ================= DELETE LAST (AJAX) =================
public function deleteLast()
{
    $last = Classification::latest()->first();

    if (!$last) {
        return response()->json(['message' => 'empty'], 404);
    }

    $id = $last->id;

    // ❌ MATIKAN INI DULU
    // $last->collections()->detach();

    $last->delete();

    return response()->json([
        'id' => $id
    ]);
}

    
}