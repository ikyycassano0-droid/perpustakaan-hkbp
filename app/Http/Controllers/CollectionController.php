<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CategoryCollection;
use App\Models\Classification;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\FinalProject;

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
            'isbn' => 'nullable|unique:collections,isbn',
        ]);

        // FILE
        $cover = $request->file('cover_image')
            ? $request->file('cover_image')->store('collections/cover', 'public')
            : null;

        $file = $request->file('file_url')
            ? $request->file('file_url')->store('collections/file', 'public')
            : null;

        // SIMPAN DATA
        $collection = Collection::create([
            'title' => $request->title,
            'series_title' => $request->series_title,

            'author' => is_array($request->author)
                ? $request->author
                : [$request->author],

            'responsibility_statement' => $request->responsibility_statement,
            'content_type' => $request->content_type,
            'media_type' => $request->media_type,

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'edition' => $request->edition,
            'subject' => $request->subject,
            'description' => $request->description,
            'carrier_type' => $request->carrier_type,
            'specific_detail_info' => $request->specific_detail_info,

            'keywords' => $request->keywords
                ? explode(',', $request->keywords)
                : null,

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

        // RELASI
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
            'isbn' => 'nullable|unique:collections,isbn,' . $collection->id,
        ]);

        // HITUNG DIPINJAM
        $dipinjam = $collection->stock - $collection->available_stock;

        if ($request->stock < $dipinjam) {
            return back()->with('error', 'Stock tidak boleh lebih kecil dari yang sedang dipinjam');
        }

        $available = $request->stock - $dipinjam;

        $data = [
            'title' => $request->title,
            'series_title' => $request->series_title,

            'author' => is_array($request->author)
                ? $request->author
                : [$request->author],

            'responsibility_statement' => $request->responsibility_statement,
            'content_type' => $request->content_type,
            'media_type' => $request->media_type,

            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'edition' => $request->edition,
            'subject' => $request->subject,
            'description' => $request->description,
            'carrier_type' => $request->carrier_type,
            'specific_detail_info' => $request->specific_detail_info,

            'keywords' => $request->keywords
                ? explode(',', $request->keywords)
                : null,

            'location_id' => $request->location_id,
            'format' => $request->format,

            'stock' => (int) $request->stock,
            'available_stock' => (int) $available,

            'menu_type' => $request->menu_type,
            'updated_by' => session('user_id'),
        ];

        // COVER
        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image) {
                Storage::disk('public')->delete($collection->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('collections/cover', 'public');
        }

        // FILE
        if ($request->hasFile('file_url')) {
            if ($collection->file_url) {
                Storage::disk('public')->delete($collection->file_url);
            }

            $data['file_url'] = $request->file('file_url')
                ->store('collections/file', 'public');
        }

        $collection->update($data);

        $collection->classifications()->sync($request->classification_id ?? []);
        $collection->categories()->sync($request->category_collection_id ?? []);

        return back()->with('success', 'Koleksi berhasil diupdate');
    }

    public function edit(Collection $collection)
    {
        return view('admin.page.edit_collection', [
            'collection' => $collection,
            'categories' => CategoryCollection::all(),
            'classifications' => Classification::all(),
            'locations' => Location::all(),
        ]);
    }
    // ================= DELETE =================
    public function destroy(Collection $collection)
    {
        Storage::disk('public')->delete([
            $collection->cover_image,
            $collection->file_url
        ]);

        $collection->delete();

        return back()->with('success', 'Koleksi berhasil dihapus');
    }

    public function pinjam()
    {
        $collections = Collection::with(['location', 'classifications', 'categories'])
            ->latest()
            ->get();

        return view('user.page.Koleksi.Koleksi_Tercetak.pinbal', compact('collections'));
    }

    // ================= User =================
    public function index()
    {
        $collections = Collection::with(['classifications','categories'])->latest()->paginate(9);

        return view('user.page.collection', compact('collections'));
    }

        // ================= SHOW DETAIL =================
    public function show($id)
    {
        $collection = Collection::with(['classifications', 'categories', 'location'])
            ->findOrFail($id);

        if ($collection->is_restricted && !auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk mengakses Koleksi Tercetak');
        }

        $viewMap = [
            'jurnal' => 'user.page.Koleksi.Koleksi_Tercetak.detail_jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi_Tercetak.detail_majalah',
        ];

        $view = $viewMap[$collection->menu_type]
            ?? 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_pengayaan';

        return view($view, compact('collection'));
    }

    public function showUserMenu(Request $request, $menu_type)
    {
        $query = Collection::with(['categories', 'location'])
            ->where('menu_type', $menu_type)
            ->where('active', 1);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $collections = $query->paginate(9);

        $viewMap = [
            'jurnal' => 'user.page.Koleksi.Koleksi_Tercetak.jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi_Tercetak.buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi_Tercetak.buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi_Tercetak.majalah',
        ];

        $view = $viewMap[$menu_type] ?? $viewMap['buku_referensi'];

        return view($view, compact('collections', 'menu_type'));
    }

    // ================= GLOBAL SEARCH =================
    public function globalSearch(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = strtolower($request->keyword);

        $collections = Collection::with(['categories'])
            ->where('active', true)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%")
                    ->orWhere('publisher', 'LIKE', "%$keyword%")
                    ->orWhereJsonContains('author', $keyword); // ✅ FIX
            })
            ->get()
            ->map(function ($item) use ($keyword) {

                $score = 0;

                if (str_contains(strtolower($item->title), $keyword)) $score += 5;

                foreach ($item->author ?? [] as $author) {
                    if (str_contains(strtolower($author), $keyword)) {
                        $score += 4;
                    }
                }

                if ($item->description && str_contains(strtolower($item->description), $keyword)) {
                    $score += 2;
                }

                $item->score = $score;
                $item->type = 'collection';
                $item->is_restricted = $item->is_restricted ?? false;

                return $item;
            });

        $finalProjects = FinalProject::with(['category'])
    ->where('status', 'Approved') // 🔥 WAJIB
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('abstract', 'LIKE', "%$keyword%")
                    ->orWhere('student_name', 'LIKE', "%$keyword%");
            })
            ->get()
            ->map(function ($item) use ($keyword) {

                $score = 0;

                if (str_contains(strtolower($item->title), $keyword)) $score += 5; // ✅ FIX

                $item->score = $score;
                $item->type = 'final_project';

                return $item;
            });

        $results = $collections
            ->merge($finalProjects)
            ->sortByDesc('score')
            ->values();

        return view('user.page.search_results', compact('results', 'keyword'));
    }

    // ================= LIVE SEARCH =================
    public function liveSearch(Request $request)
    {
        $keyword = $request->keyword;

        if (!$keyword) {
            return response()->json([]);
        }

        $collections = Collection::where('active', true) // ✅ FIX
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%")
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(author, '$')) LIKE ?", ["%$keyword%"]);
            })
            ->limit(50)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => 'collection',
                    'file_url' => null,
                    'is_restricted' => $item->is_restricted ?? false
                ];
            });

        $finalProjects = FinalProject::where('status', 'Approved') // 🔥 WAJIB
                ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('abstract', 'LIKE', "%$keyword%")
                    ->orWhere('student_name', 'LIKE', "%$keyword%");
            })
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => 'final_project', // ✅ FIX
                    'file_url' => null,
                    'is_restricted' => false
                ];
            });

        return response()->json(
            $collections->merge($finalProjects)
        );
        return view($view, [
            'collections' => $collections,
            'menuType' => $menu_type
        ]);
    }
}
