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

        $collection = Collection::create([
            'title' => $request->title,
            'series_title' => $request->series_title,
            'author' => $request->author,
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

        $dipinjam = $collection->stock - $collection->available_stock;

        if ($request->stock < $dipinjam) {
            return back()->with('error', 'Stock tidak boleh lebih kecil dari yang sedang dipinjam');
        }

        $available = $request->stock - $dipinjam;

        $data = [
            'title' => $request->title,
            'series_title' => $request->series_title,
            'author' => $request->author,

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
            'format' => $request->format,

            'stock' => (int) $request->stock,
            'available_stock' => (int) $available,

            'menu_type' => $request->menu_type,
            'updated_by' => session('user_id'),
        ];

        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image) {
                Storage::disk('public')->delete($collection->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('collections/cover', 'public');
        }

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

    // ================= SHOW DETAIL =================
    public function show($id)
    {
        $collection = Collection::query()
            ->select('id','title','menu_type','location_id','description','cover_image')
            ->with([
                'classifications:id,name',
                'categories:id,name',
                'location:id,name'
            ])
            ->findOrFail($id);

        $viewMap = [
            'jurnal' => 'user.page.Koleksi.Koleksi_Tercetak.detail_jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi_Tercetak.detail_buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi_Tercetak.detail_majalah',
        ];

        return view(
            $viewMap[$collection->menu_type]
                ?? $viewMap['buku_pengayaan'],
            compact('collection')
        );
    }


    public function pinbal()
{
    // Ambil riwayat peminjaman dengan relasi yang benar
    $peminjaman = Order::where('user_id', auth()->id())
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
            'user_id' => auth()->id(),
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
        // ================= COLLECTION DATA =================
        $collections = Collection::query()
            ->select(
                'id',
                'title',
                'author',
                'publisher',
                'menu_type',
                'location_id',
                'cover_image',
                'stock',
                'available_stock',
                'publication_year',
                'edition',
                'description',
                'created_at',
                'updated_at'
            )
            ->with([
                'categories:id,name',
                'location:id,name',
                'classifications:id,name'
            ])
            ->where('menu_type', $menu_type)
            ->where('active', 1)
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($q2) use ($search) {
                    $q2->where('title', 'like', "%$search%")
                        ->orWhere('publisher', 'like', "%$search%")
                        ->orWhere('author', 'like', "%$search%")
                        ->orWhere('keywords', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        // ================= USER BORROW STATUS =================
        $userBorrowStatus = [];

        if (auth()->check()) {
            // Ambil semua order aktif user (PENDING, APPROVED, REJECTED)
            $activeOrders = Order::where('user_id', auth()->id())
                ->whereIn('status', ['PENDING', 'APPROVED', 'REJECTED'])
                ->with('details')
                ->get();

            // Buat mapping collection_id => status
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

        // ================= VIEW MAP =================
        $viewMap = [
            'jurnal' => 'user.page.Koleksi.Koleksi_Tercetak.jurnal',
            'buku_pengayaan' => 'user.page.Koleksi.Koleksi_Tercetak.buku_pengayaan',
            'buku_referensi' => 'user.page.Koleksi.Koleksi_Tercetak.buku_referensi',
            'majalah' => 'user.page.Koleksi.Koleksi_Tercetak.majalah',
        ];

        $view = $viewMap[$menu_type] ?? $viewMap['buku_referensi'];

        return view($view, compact('collections', 'menu_type', 'userBorrowStatus'));
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
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(author, '$')) LIKE ?", ["%$keyword%"]);
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
        return view(
            $viewMap[$menu_type] ?? $viewMap['buku_referensi'],
            [
                'collections' => $collections,
                'menuType' => $menu_type,
                'pendingCollectionIds' => $pendingCollectionIds, // ✅ FIX UTAMA
            ]
        );
    }
}
