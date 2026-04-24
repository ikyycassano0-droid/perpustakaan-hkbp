<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CategoryCollection;
use App\Models\Classification;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    // ================= ADMIN =================
    public function index_admin()
    {
        $collections = Collection::with(['classifications', 'categories', 'location'])
            ->latest()
            ->get();

        return view('admin.page.collection', [
            'collections' => $collections,
            'categories' => CategoryCollection::all(),
            'classifications' => Classification::all(),
            'locations' => Location::all(),
        ]);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required|integer|min:1',
        ]);

        $cover = $request->file('cover_image')
            ? $request->file('cover_image')->store('collections/cover', 'public')
            : null;

        $file = $request->file('file_url')
            ? $request->file('file_url')->store('collections/file', 'public')
            : null;

        $collection = Collection::create([
            'title' => $request->title,

            // FIX AUTHOR WAJIB ARRAY
            'author' => is_array($request->author)
                ? $request->author
                : [$request->author],

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'edition' => $request->edition,
            'subject' => $request->subject,
            'description' => $request->description,

            'location_id' => $request->location_id,
            'file_url' => $file,
            'cover_image' => $cover,
            'format' => $request->format,

            'stock' => (int) $request->stock,
            'available_stock' => (int) $request->stock,
            'is_available' => 1,

            'menu_type' => $request->menu_type,
            'active' => 1,

            'created_by' => session('user_id'),
        ]);

        // RELASI PIVOT
        $collection->classifications()->sync($request->classification_id ?? []);
        $collection->categories()->sync($request->category_collection_id ?? []);

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil ditambahkan');
    }

    // ================= UPDATE =================
   public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required|integer|min:1',
        ]);

        // ================= HITUNG YANG SEDANG DIPINJAM =================
        $dipinjam = $collection->stock - $collection->available_stock;

        if ($request->stock < $dipinjam) {
            return back()->with('error', 'Stock tidak boleh lebih kecil dari yang sedang dipinjam');
        }

        $available = $request->stock - $dipinjam;

        // ================= UPDATE DATA =================
        $data = [
            'title' => $request->title,

            // 🔥 FIX AUTHOR (AMAN ARRAY / STRING)
            'author' => is_array($request->author)
                ? $request->author
                : [$request->author],

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'edition' => $request->edition,
            'subject' => $request->subject,
            'description' => $request->description,

            'location_id' => $request->location_id,
            'format' => $request->format,

            // 🔥 STOCK SYSTEM
            'stock' => (int) $request->stock,
            'available_stock' => (int) $available,

            'menu_type' => $request->menu_type,

            'updated_by' => session('user_id'),
        ];

        // ================= COVER IMAGE =================
        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image) {
                Storage::disk('public')->delete($collection->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('collections/cover', 'public');
        }

        // ================= FILE =================
        if ($request->hasFile('file_url')) {
            if ($collection->file_url) {
                Storage::disk('public')->delete($collection->file_url);
            }

            $data['file_url'] = $request->file('file_url')
                ->store('collections/file', 'public');
        }

        // ================= UPDATE =================
        $collection->update($data);

        // ================= SYNC RELASI MANY TO MANY =================
        $collection->classifications()->sync($request->classification_id ?? []);
        $collection->categories()->sync($request->category_collection_id ?? []);

        return back()->with('success', 'Koleksi berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(Collection $collection)
    {
        Storage::disk('public')->delete([$collection->cover_image, $collection->file_url]);

        $collection->delete();

        return back()->with('success', 'Koleksi berhasil dihapus');
    }

    // ================= SHOW =================
    public function show($id)
    {
        $collection = Collection::with(['classifications', 'categories', 'location'])
            ->findOrFail($id);

        return view('guest.page.collection_detail', compact('collection'));
    }

    public function showUserMenu($menu_type)
    {
        $collections = Collection::with(['categories', 'location'])
            ->where('menu_type', $menu_type)
            ->get();

        // mapping view berdasarkan menu_type
        $viewMap = [
            'jurnal' => 'user.page.Koleksi.Koleksi Tercetak.jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi Tercetak.buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi Tercetak.buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi Tercetak.majalah',
        ];

        // fallback kalau tidak ditemukan
        $view = $viewMap[$menu_type] ?? 'user.page.Koleksi.Koleksi Tercetak.buku_referensi';

        return view($view, [
            'collections' => $collections,
            'menuType' => $menu_type
        ]);

        
    }
}