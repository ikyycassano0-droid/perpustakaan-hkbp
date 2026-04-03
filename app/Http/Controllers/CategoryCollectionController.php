<?php

namespace App\Http\Controllers;

use App\Models\CategoryCollection;
use Illuminate\Http\Request;

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
            'name' => 'required'
        ]);

        CategoryCollection::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Category berhasil ditambahkan');
    }

    // ================= AJAX STORE =================
    public function storeAjax(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $data = CategoryCollection::create([
                'name' => $request->name
            ]);

            return response()->json([
                'success' => true,
                'id' => $data->id,
                'name' => $data->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ================= UPDATE =================
    public function update(Request $request, CategoryCollection $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Category berhasil diupdate');
    }

    // ================= DESTROY =================
    public function destroy(CategoryCollection $category)
    {
        $category->collections()->detach();

        $category->delete();

        return back()->with('success', 'Category berhasil dihapus');
    }

    // ================= DELETE LAST =================
    public function deleteLast()
    {
        $data = CategoryCollection::latest()->first();

        if ($data) {
            $data->collections()->detach();
            $data->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }
}