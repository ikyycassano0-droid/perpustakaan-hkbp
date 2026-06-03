<?php

namespace App\Http\Controllers;

use App\Models\CategoryCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryCollectionController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $data = CategoryCollection::latest()->get();

        return view('admin.page.category', compact('data'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CategoryCollection::create([
            'name' => $request->name,
            'active' => true,
            'created_by' => session('user_id'),
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    // ================= STORE AJAX =================
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = CategoryCollection::create([
            'name' => $request->name,
            'active' => true,
            'created_by' => session('user_id'),
        ]);

        return response()->json([
            'id' => $data->id,
            'name' => $data->name
        ]);
    }

    // ================= UPDATE =================
    public function update(Request $request, CategoryCollection $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'active' => $request->has('active') ? $request->active : $category->active,
            'updated_by' => session('user_id'),
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        $category = CategoryCollection::find($id);
        
        if (!$category) {
            return back()->with('error', 'Kategori tidak ditemukan');
        }

        DB::transaction(function () use ($category) {
            if (method_exists($category, 'collections')) {
                $category->collections()->detach();
            }
            $category->delete();
        });

        return back()->with('success', 'Kategori berhasil dihapus');
    }

    // ================= TOGGLE STATUS =================
    public function toggle($id)
    {
        $category = CategoryCollection::findOrFail($id);

        $category->update([
            'active' => !$category->active,
            'updated_by' => session('user_id'),
        ]);

        return back()->with('success', 'Status kategori diubah');
    }

    // ================= DELETE LAST (AJAX) =================
    public function destroyAjax($id)
    {
        $category = CategoryCollection::find($id);
        
        if (!$category) {
            return response()->json(['message' => 'Data sudah dihapus'], 200);
        }

        DB::transaction(function () use ($category) {
            if (method_exists($category, 'collections')) {
                $category->collections()->detach();
            }
            $category->delete();
        });

        return response()->json(['success' => true]);
    }
}