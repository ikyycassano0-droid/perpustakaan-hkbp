<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CategoryCollection;
use App\Models\Classification;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class CollectionController extends Controller
{
    // ================= ADMIN =================
    public function index_admin()
    {
        $collections = Collection::with(['classifications','categories','location'])->latest()->get();

        $categories = CategoryCollection::all();
        $classifications = Classification::all();
        $locations = Location::all();

        return view('admin.page.collection', compact(
            'collections',
            'categories',
            'classifications',
            'locations'
        ));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required|array',
            'author.*' => 'required|string',

            'publication_year' => 'nullable|numeric',

            'file_url' => 'nullable|file|mimes:pdf,mp3,wav,ogg|max:20000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload
        $cover = $request->hasFile('cover_image')
            ? $request->file('cover_image')->store('collections/cover', 'public')
            : null;

        $file = $request->hasFile('file_url')
            ? $request->file('file_url')->store('collections/file', 'public')
            : null;

        // CREATE COLLECTION TANPA FK
        $collection = Collection::create([
            'title' => $request->title,

            'author' => $request->author,
            'responsibility_statement' => $request->responsibility_statement ?? [],
            'content_type' => $request->content_type ?? [],
            'media_type' => $request->media_type ?? [],

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'description' => $request->description,

            'carrier_type' => $request->carrier_type,
            'specific_detail_info' => $request->specific_detail_info,

            'location_id' => $request->location_id,

            'cover_image' => $cover,
            'file_url' => $file,

            'created_by' => session('user_id'),
        ]);

        // MANY TO MANY (INI YANG PENTING)
        $collection->classifications()->sync($request->classification_id ?? []);
        $collection->categories()->sync($request->category_collection_id ?? []);

        return redirect()->route('admin.collections.index')->with('success', 'Koleksi berhasil ditambahkan'); 
    }

    // ================= UPDATE =================
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required|array',
            'author.*' => 'required|string',
            'stock' => 'required|integer|min:0',
            'file_url' => 'nullable|file|mimes:pdf,mp3,wav,ogg|max:20000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'title' => $request->title,

            'author' => $request->author,
            'responsibility_statement' => $request->responsibility_statement ?? [],
            'content_type' => $request->content_type ?? [],
            'media_type' => $request->media_type ?? [],

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'description' => $request->description,

            'carrier_type' => $request->carrier_type,
            'specific_detail_info' => $request->specific_detail_info,

            'location_id' => $request->location_id,
            'stock' => max(0, (int) $request->stock),

            'updated_by' => session('user_id'),
        ];

        // cover
        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image) {
                Storage::disk('public')->delete($collection->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('collections/cover', 'public');
        }

        // file
        if ($request->hasFile('file_url')) {
            if ($collection->file_url) {
                Storage::disk('public')->delete($collection->file_url);
            }

            $data['file_url'] = $request->file('file_url')->store('collections/file', 'public');
        }

        $collection->update($data);

        $collection->classifications()->sync($request->classification_id ?? []);
        $collection->categories()->sync($request->category_collection_id ?? []);

        return redirect()->route('admin.collections.index')->with('success', 'Koleksi berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(Collection $collection)
    {
        $collection->classifications()->detach();
        $collection->categories()->detach();

        if ($collection->cover_image) {
            Storage::disk('public')->delete($collection->cover_image);
        }

        if ($collection->file_url) {
            Storage::disk('public')->delete($collection->file_url);
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')->with('success', 'Koleksi berhasil dihapus');
    }

    public function pinjam(Request $request)
    {
        // Ambil semua koleksi beserta relasi location, classifications, categories
        $collections = Collection::with(['location', 'classifications', 'categories'])
            ->latest()
            ->get();

        // Kirim ke blade
        return view('user.page.Koleksi.Koleksi Tercetak.pinbal', compact('collections'));
    }

    // ================= GUEST =================
    public function index()
    {
        $collections = Collection::with(['classifications','categories'])->latest()->paginate(9);

        return view('guest.page.collection', compact('collections'));
    }

    public function show($id)
    {
        $collection = Collection::with(['classifications','categories','location'])->findOrFail($id);

        return view('guest.page.collection_detail', compact('collection'));
    }

    public function pengelolaanBuku()
    {
        $collections = Collection::all();
        $orders = Order::with(['user','details.collection'])->latest()->get();
        $locations = Location::all(); // ini supaya blade bisa pakai $locations

        return view('admin.page.pengelolaan_buku', compact(
            'collections',
            'orders',
            'locations'
        ));
    }

    public function showUserMenu($menu_type)
    {
        // Ambil koleksi sesuai menu_type
        $collections = Collection::with(['classifications', 'categories', 'location'])
            ->where('menu_type', $menu_type) // pastikan field menu_type ada di table collections
            ->get();

        // Tentukan blade mana yang dipakai berdasarkan menu_type
        $blade = match($menu_type) {
            'jurnal' => 'user.page.Koleksi.Koleksi Tercetak.jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi Tercetak.buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi Tercetak.buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi Tercetak.majalah',
            default => abort(404),
        };

        return view($blade, compact('collections'));
    }
}