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
        $collections = Collection::with(['classification','category','location'])->latest()->get();

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
            'author' => 'required|string',
            'publication_year' => 'nullable|numeric',

            // 🔥 FIX: wajib min 1
            'stock' => 'required|integer|min:1',

            'file_url' => 'nullable|file|mimes:pdf,mp3,wav,ogg|max:20000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload cover
        $cover = $request->hasFile('cover_image')
            ? $request->file('cover_image')->store('collections/cover', 'public')
            : null;

        // upload file
        $file = $request->hasFile('file_url')
            ? $request->file('file_url')->store('collections/file', 'public')
            : null;

        $collection = Collection::create([
            'title' => $request->title,
            'series_title' => $request->series_title,
            'author' => $request->author,
            'call_number' => $request->call_number,

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'edition' => $request->edition,
            'isbn' => $request->isbn,
            'language' => $request->language,

            'classification_id' => $request->classification_id,
            'category_collection_id' => $request->category_collection_id,
            'subject' => $request->subject,

            'description' => $request->description,

            'format' => $request->format,
            'file_url' => $file,
            'cover_image' => $cover,

            'location_id' => $request->location_id,

            // 🔥 FIX STOCK
            'stock' => $request->stock,
            'available_stock' => $request->stock, // awal semua tersedia
            'is_available' => true,

            'max_loan_days' => $request->max_loan_days ?? 7,
            'penalty_per_day' => $request->penalty_per_day ?? 1000,

            'created_by' => session('user_id'),
            'active' => true,
        ]);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required|string',

            // 🔥 FIX: wajib min 1
            'stock' => 'required|integer|min:1',
        ]);

        // 🔥 HITUNG YANG SEDANG DIPINJAM
        $dipinjam = $collection->stock - $collection->available_stock;

        $newStock = $request->stock;

        // ❌ JANGAN SAMPAI lebih kecil dari yg dipinjam
        if ($newStock < $dipinjam) {
            return back()->with('error', 'Stock tidak boleh lebih kecil dari buku yang sedang dipinjam!');
        }

        // 🔥 HITUNG ULANG AVAILABLE
        $newAvailable = $newStock - $dipinjam;

        $data = [
            'title' => $request->title,
            'series_title' => $request->series_title,
            'author' => $request->author,
            'call_number' => $request->call_number,

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'edition' => $request->edition,
            'isbn' => $request->isbn,
            'language' => $request->language,

            'classification_id' => $request->classification_id,
            'category_collection_id' => $request->category_collection_id,
            'subject' => $request->subject,

            'description' => $request->description,
            'format' => $request->format,

            'location_id' => $request->location_id,

            // 🔥 FIX STOCK
            'stock' => $newStock,
            'available_stock' => $newAvailable,

            'max_loan_days' => $request->max_loan_days,
            'penalty_per_day' => $request->penalty_per_day,

            'updated_by' => session('user_id'),
        ];

        // cover
        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image) {
                Storage::disk('public')->delete($collection->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('collections/cover', 'public');
        }

        // file
        if ($request->hasFile('file_url')) {
            if ($collection->file_url) {
                Storage::disk('public')->delete($collection->file_url);
            }

            $data['file_url'] = $request->file('file_url')
                ->store('collections/file', 'public');
        }

        $collection->update($data);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(Collection $collection)
    {
        if ($collection->cover_image) {
            Storage::disk('public')->delete($collection->cover_image);
        }

        if ($collection->file_url) {
            Storage::disk('public')->delete($collection->file_url);
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil dihapus');
    }

    // ================= USER PINJAM =================
    public function pinjam()
    {
        $collections = Collection::with(['location','classification','category'])
            ->where('active', true)
            ->latest()
            ->get();

        return view('user.page.Koleksi.Koleksi Tercetak.pinbal', compact('collections'));
    }

    // ================= GUEST =================
    public function index()
    {
        $collections = Collection::with(['classification','category'])
            ->latest()
            ->paginate(9);

        return view('guest.page.collection', compact('collections'));
    }

    public function show($id)
    {
        $collection = Collection::with(['classification','category','location'])
            ->findOrFail($id);

        return view('guest.page.collection_detail', compact('collection'));
    }

    // ================= MENU USER =================
    public function showUserMenu($menu_type)
    {
        $collections = Collection::with(['classification','category','location'])
            ->where('menu_type', $menu_type)
            ->get();

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