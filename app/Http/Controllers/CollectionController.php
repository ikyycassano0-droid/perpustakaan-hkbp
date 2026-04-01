<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    // ================= GUEST =================
    public function index()
    {
        $collections = Collection::where('active', true)
            ->latest()
            ->paginate(6);

        return view('guest.page.collection', compact('collections'));
    }

    public function show($id)
    {
        $collection = Collection::where('id', $id)
            ->where('active', true)
            ->firstOrFail();

        return view('guest.page.collection_detail', compact('collection'));
    }

    // ================= ADMIN =================
    public function index_admin()
    {
        $collections = Collection::latest()->get();

        return view('admin.page.collection', compact('collections'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'nullable',
            'publication_year' => 'nullable|integer',
            'isbn' => 'nullable',
            'description' => 'required',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_url' => 'nullable|file',
        ]);

        $coverPath = $request->hasFile('cover_image')
            ? $request->file('cover_image')->store('collections', 'public')
            : null;

        $filePath = $request->hasFile('file_url')
            ? $request->file('file_url')->store('files', 'public')
            : null;

        Collection::create([
            'title' => $request->title,
            'series_title' => $request->series_title,
            'author' => $request->author,
            'call_number' => $request->call_number,
            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'classification_id' => $request->classification_id,
            'edition' => $request->edition,
            'subject' => $request->subject,
            'description' => $request->description,
            'category_collection_id' => $request->category_collection_id,
            'location_id' => $request->location_id,
            'file_url' => $filePath,
            'format' => $request->format,
            'cover_image' => $coverPath,
            'created_by' => session('user_id'),
            'active' => true,
        ]);

        return back()->with('success', 'Koleksi berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only([
            'title',
            'series_title',
            'author',
            'call_number',
            'publisher',
            'publication_year',
            'language',
            'isbn',
            'classification_id',
            'edition',
            'subject',
            'description',
            'category_collection_id',
            'location_id',
            'format',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('collections', 'public');
        }

        if ($request->hasFile('file_url')) {
            $data['file_url'] = $request->file('file_url')->store('files', 'public');
        }

        $data['updated_by'] = session('user_id');

        $collection->update($data);

        return back()->with('success', 'Koleksi berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(Collection $collection)
    {
        if ($collection->cover_image) {
            \Storage::disk('public')->delete($collection->cover_image);
        }

        if ($collection->file_url) {
            \Storage::disk('public')->delete($collection->file_url);
        }

        $collection->delete();

        return back()->with('success', 'Koleksi berhasil dihapus');
    }
}