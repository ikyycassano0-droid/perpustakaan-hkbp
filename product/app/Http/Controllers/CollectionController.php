<?php

namespace App\Http\Controllers;
use App\Models\FinalProject;
use App\Models\Collection;
use App\Models\CategoryCollection;
use App\Models\Classification;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\OrderDetail;

class CollectionController extends Controller
{
    // ================= ADMIN =================
    public function index_admin()
    {
        $collections = Collection::query()
            ->select('id','title','series_title','location_id','stock','available_stock','menu_type','cover_image')
            ->with([
                'classifications:id,name',
                'categories:id,name',
                'location:id,name'
            ])
            ->latest()
            ->get();

        return view('admin.page.collection', [
            'collections' => $collections,
            'categories' => CategoryCollection::select('id','name')->get(),
            'classifications' => Classification::select('id','name')->get(),
            'locations' => Location::select('id','name')->get(),
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

        $cover = $request->file('cover_image')
            ? $request->file('cover_image')->store('collections/cover', 'public')
            : null;

        $file = $request->file('file_url')
            ? $request->file('file_url')->store('collections/file', 'public')
            : null;

        // Simpan author sebagai array JSON
        $authorArray = $request->author;
        if (is_array($authorArray)) {
            $authorArray = array_filter($authorArray);
        }

        $collection = Collection::create([
            'title' => $request->title,
            'series_title' => $request->series_title,
            'author' =>  $authorArray,
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
                ? array_map('trim', explode(',', $request->keywords))
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

        // === HITUNG STOK BARU ===
        $dipinjam = $collection->stock - $collection->available_stock;
        if ($request->stock < $dipinjam) {
            return back()->with('error', 'Stok tidak boleh lebih kecil dari yang sedang dipinjam');
        }
        $available = $request->stock - $dipinjam;
        $data = [];
        $data['stock'] = (int) $request->stock;
        $data['available_stock'] = (int) $available;

        // === FIELD YANG HANYA DIUPDATE JIKA DIKIRIM ===
        $fields = [
            'title',
            'series_title',
            'responsibility_statement',
            'content_type',
            'media_type',
            'publisher',
            'publication_year',
            'language',
            'edition',
            'subject',
            'description',
            'carrier_type',
            'specific_detail_info',
            'format',
            'menu_type',
            'location_id',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $data[$field] = $request->input($field);
            }
        }

        // === AUTHOR (KHUSUS) ===
        if ($request->has('author')) {
            $authorArray = $request->author;
            if (is_array($authorArray)) {
                $authorArray = array_filter($authorArray);
            }
            $data['author'] = $authorArray;
        }

        // === KEYWORDS (KHUSUS) ===
        if ($request->has('keywords')) {
            $data['keywords'] = $request->keywords
                ? array_map('trim', explode(',', $request->keywords))
                : null;
        }

        // === ISBN (KHUSUS) ===
        if ($request->has('isbn')) {
            $data['isbn'] = $request->isbn;
        }

        // === COVER & FILE ===
        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image) {
                Storage::disk('public')->delete($collection->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('collections/cover', 'public');
        }

        if ($request->hasFile('file_url')) {
            if ($collection->file_url) {
                Storage::disk('public')->delete($collection->file_url);
            }
            $data['file_url'] = $request->file('file_url')->store('collections/file', 'public');
        }

        // === SET UPDATED_BY ===
        $data['updated_by'] = session('user_id');

        // === UPDATE COLLECTION ===
        $collection->update($data);

        // === SYNC RELASI HANYA JIKA INPUT ADA ===
        if ($request->has('classification_id')) {
            $collection->classifications()->sync($request->classification_id ?? []);
        }
        if ($request->has('category_collection_id')) {
            $collection->categories()->sync($request->category_collection_id ?? []);
        }

        return back()->with('success', 'Koleksi berhasil diupdate');
    }



    // ================= DELETE =================
    public function destroy(Collection $collection)
    {
        // Filter null values before deletion
        $filesToDelete = array_filter([
            $collection->cover_image,
            $collection->file_url
        ]);

        if (!empty($filesToDelete)) {
            Storage::disk('public')->delete($filesToDelete);
        }

        $collection->delete();

        return back()->with('success', 'Koleksi berhasil dihapus');
    }

    // ================= SHOW DETAIL =================
    public function show($id)
    {
        $collection = Collection::with([
            'classifications:id,name',
            'categories:id,name',
            'location:id,name'
        ])->findOrFail($id);

        // Ambil status peminjaman untuk koleksi ini oleh user yang sedang login
        $borrowStatus = null;
        if (is_logged_in()) {
            $activeOrder = Order::where('user_id', user_id())
                ->whereHas('details', function ($q) use ($id) {
                    $q->where('collection_id', $id);
                })
                ->whereIn('status', ['PENDING', 'APPROVED', 'REJECTED'])
                ->first();
            if ($activeOrder) {
                $borrowStatus = [
                    'status' => $activeOrder->status,
                    'order_id' => $activeOrder->id,
                    'status_text' => $this->getStatusText($activeOrder->status)
                ];
            }
        }

        $viewMap = [
            'jurnal' => 'user.page.Koleksi.Koleksi_Tercetak.detail_jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi_Tercetak.detail_majalah',
        ];

        return view(
            $viewMap[$collection->menu_type] ?? $viewMap['buku_pengayaan'],
            compact('collection', 'borrowStatus')
        );
    }


    public function pinbal()
{
    // Ambil riwayat peminjaman dengan relasi yang benar
    $peminjaman = Order::where('user_id', user_id())
        ->with(['details' => function($query) {
            $query->with('collection'); // Load collection melalui details
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Ambil daftar buku yang tersedia untuk autocomplete
    $availableBooks = Collection::where('active', 1)
        ->where('available_stock', '>', 0)
        ->select('id', 'title', 'author')
        ->get();

    return view('user.page.Layanan.pinbal', compact('peminjaman', 'availableBooks'));
}

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'notes' => 'nullable|string'
        ]);

        $collection = Collection::find($request->collection_id);

        if ($collection->available_stock <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang kosong.');
        }

        $order = Order::create([
            'user_id' => user_id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'status' => 'PENDING',
            'notes' => $request->notes,
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'collection_id' => $request->collection_id,
            'jumlah' => 1,
        ]);

        return back()->with('success', 'Peminjaman berhasil diajukan! Silakan tunggu konfirmasi dari petugas.');
    }

    // ================= USER MENU =================
    public function showUserMenu(Request $request, $menu_type)
{
    // ================= RENTANG TAHUN UNTUK SLIDER =================
    // Hitung min & max publication_year dari koleksi aktif dengan menu_type yang sama
    $baseQuery = Collection::where('menu_type', $menu_type)->where('active', 1);

    $minYearGlobal = (clone $baseQuery)->min('publication_year') ?? 2000;
    $maxYearGlobal = (clone $baseQuery)->max('publication_year') ?? date('Y');

    // Nilai yang sedang difilter (dari request)
    $currentMinYear = $request->filled('year_min') ? (int)$request->year_min : $minYearGlobal;
    $currentMaxYear = $request->filled('year_max') ? (int)$request->year_max : $maxYearGlobal;

    // ================= QUERY DENGAN FILTER RANGE TAHUN =================
    $collections = Collection::query()
        ->select(
            'id','title','author','publisher','menu_type','location_id',
            'cover_image','stock','available_stock','publication_year',
            'edition','description','created_at','updated_at'
        )
        ->with(['categories:id,name', 'location:id,name', 'classifications:id,name'])
        ->where('menu_type', $menu_type)
        ->where('active', 1)
        // === RANGE TAHUN (baru) ===
        ->when($request->filled('year_min'), function ($q) use ($request) {
            $q->where('publication_year', '>=', (int)$request->year_min);
        })
        ->when($request->filled('year_max'), function ($q) use ($request) {
            $q->where('publication_year', '<=', (int)$request->year_max);
        })
        // === FILTER LAIN (search, category, sort) ===
        ->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($q2) use ($search) {
                $q2->where('title', 'like', "%$search%")
                    ->orWhere('publisher', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%")
                    ->orWhere('keywords', 'like', "%$search%");
            });
        })
        ->when($request->filled('category'), function ($q) use ($request) {
            $q->whereHas('categories', function ($q2) use ($request) {
                $q2->where('name', $request->category);
            });
        })
        ->when($request->sort == 'az', function ($q) {
            $q->orderBy('title', 'asc');
        }, function ($q) {
            $q->latest();
        })
        ->paginate(6);

    // ================= STATUS PEMINJAMAN USER =================
    $userBorrowStatus = [];
    if (is_logged_in()) {
        $activeOrders = Order::where('user_id', user_id())
            ->whereIn('status', ['PENDING', 'APPROVED', 'REJECTED'])
            ->with('details')
            ->get();
        foreach ($activeOrders as $order) {
            foreach ($order->details as $detail) {
                $userBorrowStatus[$detail->collection_id] = [
                    'status' => $order->status,
                    'order_id' => $order->id,
                    'status_text' => $this->getStatusText($order->status)
                ];
            }
        }
    }

    // ================= VIEW DAN DATA =================
    $viewMap = [
        'jurnal' => 'user.page.Koleksi.Koleksi_Tercetak.jurnal',
        'buku_pengayaan' => 'user.page.Koleksi.Koleksi_Tercetak.buku_pengayaan',
        'buku_referensi' => 'user.page.Koleksi.Koleksi_Tercetak.buku_referensi',
        'majalah' => 'user.page.Koleksi.Koleksi_Tercetak.majalah',
    ];

    $view = $viewMap[$menu_type] ?? $viewMap['buku_referensi'];
    $categories = CategoryCollection::select('id','name')->orderBy('name')->get();

    return view($view, compact(
        'collections', 'menu_type', 'userBorrowStatus', 'categories',
        'minYearGlobal', 'maxYearGlobal', 'currentMinYear', 'currentMaxYear'
    ));
}

    private function getStatusText($status)
    {
        return match($status) {
            'PENDING' => 'Menunggu Konfirmasi',
            'APPROVED' => 'Sedang Dipinjam',
            'REJECTED' => 'Ditolak',
            'RETURNED' => 'Dikembalikan',
            default => 'Sedang Diproses'
        };
    }

    public function globalSearch(Request $request)
{
    $request->validate([
        'keyword' => 'required|string|max:255',
        'type' => 'nullable|string',
        'classification' => 'nullable|string',
        'category' => 'nullable|string',
        'year' => 'nullable|string',
    ]);

    $keyword = strtolower($request->keyword);

    // ============ QUERY COLLECTIONS ============
    $collections = Collection::with(['categories', 'classifications'])
        ->where('active', true)
        ->where(function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('publisher', 'LIKE', "%$keyword%")
                // ✅ Cari di JSON string (tanpa tanda kutip)
                ->orWhereRaw('LOWER(author) LIKE ?', ['%' . $keyword . '%']);
        })
        // Filter classification
        ->when($request->classification, function ($q) use ($request) {
            $q->whereHas('classifications', function ($q2) use ($request) {
                $q2->where('name', $request->classification);
            });
        })
        // Filter category
        ->when($request->category, function ($q) use ($request) {
            $q->whereHas('categories', function ($q2) use ($request) {
                $q2->where('name', $request->category);
            });
        })
        // Filter tahun
        ->when($request->year, function ($q) use ($request) {
            $q->where('publication_year', $request->year);
        })
        ->get()
        ->map(function ($item) use ($keyword) {
            $score = 0;
            if (str_contains(strtolower($item->title), $keyword)) $score += 5;

            // ✅ Cek author (sekarang string)
            if ($item->author && str_contains(strtolower($item->author), $keyword)) {
                $score += 4;
            }

            if ($item->description && str_contains(strtolower($item->description), $keyword)) $score += 2;
            $item->score = $score;
            $item->type = 'collection';
            $item->is_restricted = $item->is_restricted ?? false;
            return $item;
        });

    // ============ QUERY FINAL PROJECTS ============
    $finalProjects = FinalProject::with(['category'])
        ->where('status', 'Approved')
        ->where(function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%$keyword%")
                ->orWhere('abstract', 'LIKE', "%$keyword%")
                ->orWhere('student_name', 'LIKE', "%$keyword%");
        })
        ->when($request->year, function ($q) use ($request) {
            $q->whereYear('created_at', $request->year);
        })
        ->get()
        ->map(function ($item) use ($keyword) {
            $score = 0;
            if (str_contains(strtolower($item->title), $keyword)) $score += 5;
            if (str_contains(strtolower($item->student_name ?? ''), $keyword)) $score += 4;
            $item->score = $score;
            $item->type = 'final_project';
            return $item;
        });

    $results = $collections
        ->merge($finalProjects)
        ->sortByDesc('score')
        ->values();

    // Data untuk filter dropdown
    $classifications = Classification::orderBy('name')->get();
    $categories = CategoryCollection::orderBy('name')->get();
    $years = Collection::whereNotNull('publication_year')
        ->distinct()
        ->orderBy('publication_year', 'desc')
        ->pluck('publication_year');

    return view('user.page.search_results', compact(
        'results', 'keyword', 'classifications', 'categories', 'years'
    ));
}

public function liveSearch(Request $request)
{
    $keyword = $request->keyword;

    if (!$keyword) {
        return response()->json([]);
    }

    $collections = Collection::where('active', true)
        ->where(function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('publisher', 'LIKE', "%$keyword%")
                // ✅ Cari di JSON string
                ->orWhereRaw('LOWER(author) LIKE ?', ['%' . $keyword . '%']);
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

    $finalProjects = FinalProject::where('status', 'Approved')
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
                'type' => 'final_project',
                'file_url' => null,
                'is_restricted' => false
            ];
        });

    return response()->json($collections->merge($finalProjects));
}
}
