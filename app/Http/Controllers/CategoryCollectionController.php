<?php

namespace App\Http\Controllers;

use App\Models\CategoryCollection;
use Illuminate\Http\Request;

class CategoryCollectionController extends Controller
{
    public function index()
    {
        $data = CategoryCollection::latest()->get();
        return view('admin.page.category', compact('data'));
    }

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

    // AJAX
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = CategoryCollection::create([
            'name' => $request->name
        ]);

        return response()->json($data);
    }

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

    public function destroy(CategoryCollection $category)
    {
        $category->delete();

        return back()->with('success', 'Category berhasil dihapus');
    }

    // DELETE LAST
    public function deleteLast()
    {
        $data = CategoryCollection::latest()->first();

        if ($data) {
            $data->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }
}