<?php

namespace App\Http\Controllers;
use App\Models\Collection;
use App\Models\User;
use App\Models\Order;
use App\Models\News;
use App\Models\Gallery;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homes = Home::all();
        return view('user.page.home', compact('homes'));
    }

    public function index_user()
    {
        $homes = Home::with('additionalSections')->latest()->first();

        $berita_terbaru = News::latest()->limit(4)-> get();

        if (!$homes) {
            // Jika tidak ada data About, kirim $about null ke view
            return view('user.page.home', [
                'about' => null,
                'berita_terbaru' => $berita_terbaru
            ]);
        }
        
        return view('user.page.home', compact('homes', 'berita_terbaru'));
    }

    public function admin()
    {
        $homes = \App\Models\Home::all();
        
        // Data statis untuk pertama load (tanpa filter)
        $totalPhysicalCollections = \App\Models\Collection::where('active', 1)->count();
        
        // Pisahkan koleksi
        $enrichmentBooks = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'Buku Pengayaan')->count();
        $referenceBooks = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'Buku Referensi')->count();
        $journals = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'Jurnal')->count();
        $magazines = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'Majalah')->count();
        
        // Koleksi elektronik
        $ebooks = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'E-Book')->count();
        $earticles = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'E-Article')->count();
        $theses = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'KTI/Skripsi')->count();
        $multimedia = \App\Models\Collection::where('active', 1)
            ->where('menu_type', 'CD/DVD/Video')->count();
        
        $totalElectronicCollections = $ebooks + $earticles + $theses + $multimedia;
        
        $activeMembers = \App\Models\User::where('active', 1)->count();
        $newMembersThisMonth = \App\Models\User::where('active', 1)
            ->whereMonth('created_at', now()->month)->count();
        
        $activeLoans = \App\Models\Order::where('status', 'APPROVED')
            ->whereNull('actual_return_date')->count();
        $pendingApprovals = \App\Models\Order::where('status', 'PENDING')->count();
        
        // Data periode all (semua waktu)
        $totalLoansPeriod = \App\Models\Order::count();
        $totalReturnsPeriod = \App\Models\Order::where('status', 'RETURNED')->count();
        $totalFinesPeriod = \App\Models\Order::sum('fine');

        $borrowedCountPeriod = \App\Models\Order::where('status', 'APPROVED')
            ->whereNull('actual_return_date')->count();
        $returnedCountPeriod = \App\Models\Order::where('status', 'RETURNED')->count();
        $pendingCountPeriod = \App\Models\Order::where('status', 'PENDING')->count();
        
        // Monthly chart data
        $monthlyLoans = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLoans[] = \App\Models\Order::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $i)->count();
        }
        
        
        $physicalCollectionData = [
            ['name' => 'Buku Pengayaan', 'total' => $enrichmentBooks],
            ['name' => 'Buku Referensi', 'total' => $referenceBooks],
            ['name' => 'Jurnal', 'total' => $journals],
            ['name' => 'Majalah', 'total' => $magazines],
        ];
        
        $electronicCollectionData = [
            ['name' => 'E-Book', 'total' => $ebooks],
            ['name' => 'E-Article', 'total' => $earticles],
            ['name' => 'KTI/Skripsi', 'total' => $theses],
            ['name' => 'CD/DVD/Video', 'total' => $multimedia],
        ];
        
        $statusData = [
            'borrowed' => $borrowedCountPeriod,
            'returned' => $returnedCountPeriod,
            'pending' => $pendingCountPeriod,
        ];
        
        $popularBooks = \App\Models\Order::selectRaw('collections.title, count(*) as total_borrowed')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('collections', 'order_details.collection_id', '=', 'collections.id')
            ->where('orders.status', 'APPROVED')
            ->groupBy('collections.id', 'collections.title')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();
        
        $recentLoans = \App\Models\Order::with(['user', 'details.collection'])
            ->latest()
            ->limit(5)
            ->get();
        
        $recentUsers = \App\Models\User::latest()->limit(5)->get();
        
        return view('admin.page.home', compact(
            'homes',
            'totalPhysicalCollections',
            'totalElectronicCollections',
            'enrichmentBooks',
            'referenceBooks',
            'journals',
            'magazines',
            'ebooks',
            'earticles',
            'theses',
            'multimedia',
            'activeMembers',
            'newMembersThisMonth',
            'activeLoans',
            'pendingApprovals',
            'totalLoansPeriod',
            'totalReturnsPeriod',
            'totalFinesPeriod',
            'borrowedCountPeriod',
            'returnedCountPeriod',
            'pendingCountPeriod',
            'monthlyLoans',
            'physicalCollectionData',
            'electronicCollectionData',
            'statusData',
            'popularBooks',
            'recentLoans',
            'recentUsers'
        ));
    }

    public function adminFilter(Request $request)
    {
        $period = $request->get('period', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        list($start, $end) = $this->getDateFilter($period, $startDate, $endDate);
        
        // ==================== KOLEKSI FISIK ====================
        // Gunakan Collection dengan namespace yang sudah di-import
        $enrichmentBooks = Collection::where('active', 1)
            ->where('menu_type', 'Buku Pengayaan')->count();
        $referenceBooks = Collection::where('active', 1)
            ->where('menu_type', 'Buku Referensi')->count();
        $journals = Collection::where('active', 1)
            ->where('menu_type', 'Jurnal')->count();
        $magazines = Collection::where('active', 1)
            ->where('menu_type', 'Majalah')->count();
        
        $totalPhysicalCollections = $enrichmentBooks + $referenceBooks + $journals + $magazines;
        
        // ==================== KOLEKSI ELEKTRONIK ====================
        $ebooks = Collection::where('active', 1)
            ->where('menu_type', 'E-Book')->count();
        $earticles = Collection::where('active', 1)
            ->where('menu_type', 'E-Article')->count();
        $theses = Collection::where('active', 1)
            ->where('menu_type', 'KTI/Skripsi')->count();
        $multimedia = Collection::where('active', 1)
            ->where('menu_type', 'CD/DVD/Video')->count();
        
        $totalElectronicCollections = $ebooks + $earticles + $theses + $multimedia;
        
        // ==================== ANGGOTA ====================
        $activeMembers = User::where('active', 1)->count();
        
        $newMembersPeriod = User::where('active', 1)
            ->when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->count();
        
        // ==================== PEMINJAMAN ====================
        $activeLoans = Order::where('status', 'APPROVED')
            ->whereNull('actual_return_date')
            ->count();
        
        $pendingApprovals = Order::where('status', 'PENDING')->count();
        
        $totalLoansPeriod = Order::when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->count();
        
        $totalReturnsPeriod = Order::where('status', 'RETURNED')
            ->when($start, function($query) use ($start) {
                $query->whereDate('updated_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('updated_at', '<=', $end);
            })
            ->count();
        
        $totalFinesPeriod = Order::when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->sum('fine');
        
        $borrowedCountPeriod = Order::where('status', 'APPROVED')
            ->whereNull('actual_return_date')
            ->when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->count();
        
        $returnedCountPeriod = Order::where('status', 'RETURNED')
            ->when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->count();
        
        $pendingCountPeriod = Order::where('status', 'PENDING')
            ->when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->count();
        
        // ==================== CHART DATA ====================
        $monthlyLoans = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLoans[] = Order::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $i)
                ->when($start, function($query) use ($start) {
                    $query->whereDate('created_at', '>=', $start);
                })
                ->when($end, function($query) use ($end) {
                    $query->whereDate('created_at', '<=', $end);
                })
                ->count();
        }
        
        $physicalCollectionData = [
            ['name' => 'Buku Pengayaan', 'total' => $enrichmentBooks],
            ['name' => 'Buku Referensi', 'total' => $referenceBooks],
            ['name' => 'Jurnal', 'total' => $journals],
            ['name' => 'Majalah', 'total' => $magazines],
        ];
        
        $electronicCollectionData = [
            ['name' => 'E-Book', 'total' => $ebooks],
            ['name' => 'E-Article', 'total' => $earticles],
            ['name' => 'KTI/Skripsi', 'total' => $theses],
            ['name' => 'CD/DVD/Video', 'total' => $multimedia],
        ];
        
        $statusData = [
            'borrowed' => $borrowedCountPeriod,
            'returned' => $returnedCountPeriod,
            'pending' => $pendingCountPeriod,
        ];
        
        // Buku terpopuler periode ini
        $popularBooks = Order::selectRaw('collections.title, count(*) as total_borrowed')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('collections', 'order_details.collection_id', '=', 'collections.id')
            ->where('orders.status', 'APPROVED')
            ->when($start, function($query) use ($start) {
                $query->whereDate('orders.created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('orders.created_at', '<=', $end);
            })
            ->groupBy('collections.id', 'collections.title')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();
        
        // Peminjaman terbaru periode ini
        $recentLoans = Order::with(['user', 'details.collection'])
            ->when($start, function($query) use ($start) {
                $query->whereDate('created_at', '>=', $start);
            })
            ->when($end, function($query) use ($end) {
                $query->whereDate('created_at', '<=', $end);
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(function($loan) {
                return (object)[
                    'id' => $loan->id,
                    'order_number' => $loan->order_number ?? $loan->id,
                    'user_name' => $loan->user->name ?? '-',
                    'book_title' => $loan->details->first()->collection->title ?? '-',
                    'status' => $loan->status,
                    'created_at' => $loan->created_at?->format('d-m-Y') ?? '-',
                ];
            });
        
        return response()->json([
            'totalPhysicalCollections' => $totalPhysicalCollections,
            'totalElectronicCollections' => $totalElectronicCollections,
            'enrichmentBooks' => $enrichmentBooks,
            'referenceBooks' => $referenceBooks,
            'journals' => $journals,
            'magazines' => $magazines,
            'ebooks' => $ebooks,
            'earticles' => $earticles,
            'theses' => $theses,
            'multimedia' => $multimedia,
            'activeMembers' => $activeMembers,
            'newMembersPeriod' => $newMembersPeriod,
            'activeLoans' => $activeLoans,
            'pendingApprovals' => $pendingApprovals,
            'totalLoansPeriod' => $totalLoansPeriod,
            'totalReturnsPeriod' => $totalReturnsPeriod,
            'totalFinesPeriod' => $totalFinesPeriod,
            'borrowedCountPeriod' => $borrowedCountPeriod,
            'returnedCountPeriod' => $returnedCountPeriod,
            'pendingCountPeriod' => $pendingCountPeriod,
            'monthlyLoans' => $monthlyLoans,
            'physicalCollectionData' => $physicalCollectionData,
            'electronicCollectionData' => $electronicCollectionData,
            'statusData' => $statusData,
            'popularBooks' => $popularBooks,
            'recentLoans' => $recentLoans,
        ]);
    }

    private function getDateFilter($period, $startDate = null, $endDate = null)
    {
        $start = null;
        $end = null;
        
        $today = Carbon::today();
        
        switch ($period) {
            case 'today':
                $start = $today;
                $end = $today;
                break;
            case 'week':
                $start = $today->copy()->subDays(7);
                $end = $today;
                break;
            case 'month':
                $start = $today->copy()->subDays(30);
                $end = $today;
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $start = Carbon::parse($startDate);
                    $end = Carbon::parse($endDate);
                }
                break;
            default:
                break;
        }
        
        return [$start, $end];
    }


    public function dosen()
    {
       $homes = Home::with('additionalSections')->latest()->first();

        $berita_terbaru = News::latest()->limit(4)-> get();

        if (!$homes) {
            // Jika tidak ada data About, kirim $about null ke view
            return view('dosen.page.home', [
                'about' => null,
                'berita_terbaru' => $berita_terbaru
            ]);
        }
        
        return view('dosen.page.home', compact('homes', 'berita_terbaru'));
    }

    // Export PDF (tetap pakai DOMPDF)
    public function exportPdf()
    {
        $data = $this->getDashboardData();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.page.exports', $data);
        return $pdf->download('laporan-perpustakaan-'.date('Y-m-d').'.pdf');
    }

    // Export CSV (tanpa package Excel)
    public function exportExcel()
    {
        $data = $this->getDashboardData();
        $filename = 'laporan-perpustakaan-'.date('Y-m-d').'.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];
        
        return response()->stream(function() use ($data) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($f, ['LAPORAN DASHBOARD PERPUSTAKAAN']);
            fputcsv($f, ['AKPER HKBP Balige - '.now()->format('d F Y')]);
            fputcsv($f, []);
            fputcsv($f, ['RINGKASAN']);
            fputcsv($f, ['Total Koleksi Fisik', $data['totalPhysicalCollections'] ?? 0]);
            fputcsv($f, ['Total Koleksi Elektronik', $data['totalElectronicCollections'] ?? 0]);
            fputcsv($f, ['Anggota Aktif', $data['activeMembers'] ?? 0]);
            fputcsv($f, ['Peminjaman Aktif', $data['activeLoans'] ?? 0]);
            fputcsv($f, ['Menunggu Persetujuan', $data['pendingApprovals'] ?? 0]);
            fputcsv($f, ['Total Denda', $data['totalFinesPeriod'] ?? 0]);
            fputcsv($f, []);
            fputcsv($f, ['STATUS PEMINJAMAN']);
            fputcsv($f, ['Dipinjam', 'Dikembalikan', 'Menunggu']);
            fputcsv($f, [$data['borrowedCountPeriod'] ?? 0, $data['returnedCountPeriod'] ?? 0, $data['pendingCountPeriod'] ?? 0]);
            fputcsv($f, []);
            fputcsv($f, ['PEMINJAMAN TERBARU']);
            fputcsv($f, ['No', 'Peminjam', 'Judul', 'Status', 'Tanggal']);
            foreach(($data['recentLoans'] ?? []) as $i => $loan) {
                fputcsv($f, [
                    $i+1, 
                    $loan->user->name ?? '-', 
                    $loan->details->first()->collection->title ?? '-',
                    $loan->status, 
                    $loan->created_at->format('d-m-Y')
                ]);
            }
            fclose($f);
        }, 200, $headers);
    }

    private function getDashboardData()
    {
        $enrichmentBooks = Collection::where('active', 1)->where('menu_type', 'Buku Pengayaan')->count();
        $referenceBooks = Collection::where('active', 1)->where('menu_type', 'Buku Referensi')->count();
        $journals = Collection::where('active', 1)->where('menu_type', 'Jurnal')->count();
        $magazines = Collection::where('active', 1)->where('menu_type', 'Majalah')->count();
        $ebooks = Collection::where('active', 1)->where('menu_type', 'E-Book')->count();
        $earticles = Collection::where('active', 1)->where('menu_type', 'E-Article')->count();
        $theses = Collection::where('active', 1)->where('menu_type', 'KTI/Skripsi')->count();
        $multimedia = Collection::where('active', 1)->where('menu_type', 'CD/DVD/Video')->count();
        
        $totalPhysical = $enrichmentBooks + $referenceBooks + $journals + $magazines;
        $totalElectronic = $ebooks + $earticles + $theses + $multimedia;
        
        $popularBooks = Order::selectRaw('collections.title, count(*) as total_borrowed')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('collections', 'order_details.collection_id', '=', 'collections.id')
            ->where('orders.status', 'APPROVED')
            ->groupBy('collections.id', 'collections.title')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();

        return [
            'totalCollections' => $totalPhysical + $totalElectronic,
            'activeMembers' => User::where('active', 1)->count(),
            'activeLoans' => Order::where('status', 'APPROVED')->whereNull('actual_return_date')->count(),
            'pendingApprovals' => Order::where('status', 'PENDING')->count(),
            'borrowedCount' => Order::where('status', 'APPROVED')->whereNull('actual_return_date')->count(),
            'returnedCount' => Order::where('status', 'RETURNED')->count(),
            'pendingCount' => Order::where('status', 'PENDING')->count(),
            'popularBooks' => $popularBooks,
            'recentLoans' => Order::with(['user', 'details.collection'])->latest()->limit(10)->get(),
            'recentUsers' => User::latest()->limit(5)->get(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_galeri' => 'required|string|max:255',
            'gambar_galeri' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar_galeri')) {
            $file = $request->file('gambar_galeri');
            // Buat nama file unik dan sanitasi
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('galeri', $filename, 'public');
        }

        Gallery::create([
            'user_id' => user_id(),
            'judul_galeri' => $validated['judul_galeri'],
            'gambar_galeri' => $path
        ]);

        return redirect()->route('galleries.index')->with('success', 'Data galeri berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }
}
