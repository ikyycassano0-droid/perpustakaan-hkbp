<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\User;
use App\Models\Order;
use App\Models\News;
use App\Models\Gallery;
use App\Models\FinalProject; // untuk koleksi elektronik
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class HomeController extends Controller
{

    private function getSharedHomeData()
    {
        // 1. Top 3 peminjam (reward) - dihitung dari total item yang pernah dipinjam (APPROVED & RETURNED)
        $topBorrowers = User::with('role:id,name')
            ->select(
                'users.id',
                'users.name',
                // Langsung generate avatar dari nama, tanpa kolom avatar
                DB::raw("CONCAT('https://ui-avatars.com/api/?name=', REPLACE(users.name, ' ', '+'), '&background=1e293b&color=fff&size=80') as avatar")
            )
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->whereIn('orders.status', ['APPROVED', 'RETURNED'])   // pastikan pakai array
            ->groupBy('users.id', 'users.name')   // tidak perlu group by avatar karena bukan kolom
            ->selectRaw('SUM(order_details.qty) as total_borrowed')
            ->selectRaw('MIN(orders.created_at) as first_order')
            ->orderByDesc('total_borrowed')
            ->orderBy('first_order', 'asc')
            ->limit(3)
            ->get();

        // Tambahkan jumlah judul buku unik yang pernah dipinjam masing-masing user
        $topBorrowers->transform(function ($user) {
            $distinctTitles = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('orders.user_id', $user->id)
                ->whereIn('orders.status', ['APPROVED', 'RETURNED'])
                ->distinct('collection_id')
                ->count('collection_id');
            $user->distinct_titles = $distinctTitles;
            return $user;
        });

        // 2. Top 4 buku (koleksi unggulan) - paling sering dipinjam
        $topBooks = Collection::select(
                'collections.id',
                'collections.title',
                'collections.cover_image',
                'collections.description'
            )
            ->join('order_details', 'collections.id', '=', 'order_details.collection_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['APPROVED', 'RETURNED'])
            ->groupBy('collections.id', 'collections.title', 'collections.cover_image', 'collections.description')
            ->selectRaw('SUM(order_details.qty) as total_borrowed')
            ->selectRaw('MIN(orders.created_at) as first_borrowed')
            ->orderByDesc('total_borrowed')
            ->orderBy('first_borrowed', 'asc')
            ->limit(4)
            ->get();

        // 3. Statistik
        $totalVerifiedUsers = User::whereNotNull('email_verified_at')->count();
        $totalPrintedCollections = Collection::where('active', 1)->count();
        $totalLoans = Order::where('status', 'APPROVED')->count();

        $printedTitles = Collection::where('active', 1)->pluck('title')
            ->map(fn($t) => strtolower(trim($t)))->toArray();
        $electronicTitles = FinalProject::where('status', 'Approved')->pluck('title')
            ->map(fn($t) => strtolower(trim($t)))->toArray();
        $totalUniqueTitles = count(array_unique(array_merge($printedTitles, $electronicTitles)));

        return compact(
            'topBorrowers',
            'topBooks',
            'totalVerifiedUsers',
            'totalPrintedCollections',
            'totalLoans',
            'totalUniqueTitles'
        );
    }
    // ==================== USER SIDE ====================
    public function index()
    {
        $homes = Home::all();
        $berita_terbaru = News::latest()->limit(4)->get();
        $shared = $this->getSharedHomeData();

        return view('guest.page.home', array_merge(compact('homes', 'berita_terbaru'), $shared));
    }

    public function index_user()
    {
        $homes = Home::with('additionalSections')->latest()->first();
        $berita_terbaru = News::latest()->limit(4)->get();
        $shared = $this->getSharedHomeData();

        if (!$homes) {
            return view('user.page.home', array_merge([
                'about' => null,
                'berita_terbaru' => $berita_terbaru,
            ], $shared));
        }

        return view('user.page.home', array_merge(compact('homes', 'berita_terbaru'), $shared));
    }

    // ==================== ADMIN DASHBOARD ====================
    public function admin(Request $request)
    {
        $homes = Home::all();

        // --- Filter periode ---
        $period = $request->input('period', 'all'); // all, this_month, this_year, custom
        $selectedMonth = (int) $request->input('month', now()->month);
        $selectedYear = (int) $request->input('year', now()->year);
        $customStart = $request->input('start_date');
        $customEnd = $request->input('end_date');

        $startDate = null;
        $endDate = null;

        if ($period == 'this_month') {
            $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } elseif ($period == 'this_year') {
            $startDate = Carbon::createFromDate($selectedYear, 1, 1)->startOfYear();
            $endDate = $startDate->copy()->endOfYear();
        } elseif ($period == 'custom' && $customStart && $customEnd) {
            $startDate = Carbon::parse($customStart)->startOfDay();
            $endDate = Carbon::parse($customEnd)->endOfDay();
        }

        // --- Koleksi Fisik (dari tabel collections) ---
        $enrichmentBooks = Collection::where('active', 1)
            ->where('menu_type', 'Buku Pengayaan')->count();
        $referenceBooks = Collection::where('active', 1)
            ->where('menu_type', 'Buku Referensi')->count();
        $journals = Collection::where('active', 1)
            ->where('menu_type', 'Jurnal')->count();
        $magazines = Collection::where('active', 1)
            ->where('menu_type', 'Majalah')->count();
        $totalPhysicalCollections = $enrichmentBooks + $referenceBooks + $journals + $magazines;

        // --- Koleksi Elektronik (dari tabel final_projects) ---
        $ebooks = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'ebook'))
            ->count();
        $earticles = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'e-article'))
            ->count();
        $theses = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'kti'))
            ->count();
        $multimedia = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->whereIn('slug', ['cd', 'video']))
            ->count();
        $totalElectronicCollections = $ebooks + $earticles + $theses + $multimedia;

        // --- Anggota ---
        $activeMembers = User::where('active', 1)->count();
        $newMembersPeriod = User::where('active', 1)
            ->when($startDate, fn($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        // --- Peminjaman ---
        $activeLoans = Order::where('status', 'APPROVED')
            ->whereNull('actual_return_date')->count();
        $pendingApprovals = Order::where('status', 'PENDING')->count();

        // Total, pengembalian, denda dalam periode
        $totalLoansPeriod = Order::when($startDate,
            fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
        )->count();
        $totalReturnsPeriod = Order::where('status', 'RETURNED')
            ->when($startDate,
                fn($q) => $q->whereBetween('updated_at', [$startDate, $endDate])
            )->count();
        $totalFinesPeriod = Order::when($startDate,
            fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
        )->sum('fine');

        $borrowedCountPeriod = Order::where('status', 'APPROVED')
            ->whereNull('actual_return_date')
            ->when($startDate,
                fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
            )->count();
        $returnedCountPeriod = Order::where('status', 'RETURNED')
            ->when($startDate,
                fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
            )->count();
        $pendingCountPeriod = Order::where('status', 'PENDING')
            ->when($startDate,
                fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
            )->count();

        // --- Chart bulanan (dalam tahun terpilih) ---
        $monthlyLoans = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLoans[] = Order::whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $i)
                ->when($startDate,
                    fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
                )->count();
        }

        // --- Buku paling sering dipinjam dalam periode ---
        $popularBooksQuery = Order::selectRaw('collections.title, collections.id, count(*) as total_borrowed')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('collections', 'order_details.collection_id', '=', 'collections.id')
            ->where('orders.status', 'APPROVED');
        if ($startDate && $endDate) {
            $popularBooksQuery->whereBetween('orders.borrow_date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ]);
        }
        $popularBooks = $popularBooksQuery->groupBy('collections.id', 'collections.title')
            ->orderByDesc('total_borrowed')
            ->limit(10)
            ->get();

        $chartLabels = $popularBooks->pluck('title')->toArray();
        $chartData = $popularBooks->pluck('total_borrowed')->toArray();

        // --- Data untuk dropdown bulan dan tahun ---
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = ['value' => $m, 'name' => Carbon::create()->month($m)->format('F')];
        }
        $years = range(now()->year - 5, now()->year);

        // --- Data chart pie/donut yang sudah ada ---
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

        // --- Peminjaman terbaru dalam periode ---
        $recentLoans = Order::with(['user', 'details.collection'])
            ->when($startDate,
                fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
            )
            ->latest()
            ->limit(5)
            ->get();

        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.page.home', compact(
            'homes',
            'totalPhysicalCollections', 'totalElectronicCollections',
            'enrichmentBooks', 'referenceBooks', 'journals', 'magazines',
            'ebooks', 'earticles', 'theses', 'multimedia',
            'activeMembers', 'newMembersPeriod', 'activeLoans', 'pendingApprovals',
            'totalLoansPeriod', 'totalReturnsPeriod', 'totalFinesPeriod',
            'borrowedCountPeriod', 'returnedCountPeriod', 'pendingCountPeriod',
            'monthlyLoans', 'physicalCollectionData', 'electronicCollectionData',
            'statusData', 'popularBooks', 'recentLoans', 'recentUsers',
            'chartLabels', 'chartData',
            'period', 'selectedMonth', 'selectedYear', 'customStart', 'customEnd',
            'months', 'years'
        ));
    }

    // ==================== ADMIN FILTER (AJAX) ====================
    public function adminFilter(Request $request)
    {
        $period = $request->get('period', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        list($start, $end) = $this->getDateFilter($period, $startDate, $endDate);

        // --- Koleksi Fisik ---
        $enrichmentBooks = Collection::where('active', 1)->where('menu_type', 'Buku Pengayaan')->count();
        $referenceBooks = Collection::where('active', 1)->where('menu_type', 'Buku Referensi')->count();
        $journals = Collection::where('active', 1)->where('menu_type', 'Jurnal')->count();
        $magazines = Collection::where('active', 1)->where('menu_type', 'Majalah')->count();
        $totalPhysicalCollections = $enrichmentBooks + $referenceBooks + $journals + $magazines;

        // --- Koleksi Elektronik (dari FinalProject) ---
        $ebooks = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'ebook'))->count();
        $earticles = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'e-article'))->count();
        $theses = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'kti'))->count();
        $multimedia = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->whereIn('slug', ['cd', 'video']))->count();
        $totalElectronicCollections = $ebooks + $earticles + $theses + $multimedia;

        // --- Anggota ---
        $activeMembers = User::where('active', 1)->count();
        $newMembersPeriod = User::where('active', 1)
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))
            ->count();

        // --- Peminjaman ---
        $activeLoans = Order::where('status', 'APPROVED')->whereNull('actual_return_date')->count();
        $pendingApprovals = Order::where('status', 'PENDING')->count();

        $totalLoansPeriod = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))->count();
        $totalReturnsPeriod = Order::where('status', 'RETURNED')
            ->when($start, fn($q) => $q->whereDate('updated_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('updated_at', '<=', $end))->count();
        $totalFinesPeriod = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))->sum('fine');

        $borrowedCountPeriod = Order::where('status', 'APPROVED')->whereNull('actual_return_date')
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))->count();
        $returnedCountPeriod = Order::where('status', 'RETURNED')
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))->count();
        $pendingCountPeriod = Order::where('status', 'PENDING')
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))->count();

        // --- Chart bulanan ---
        $monthlyLoans = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLoans[] = Order::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $i)
                ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))
                ->count();
        }

        // --- Buku terpopuler periode ini ---
        $popularBooksQuery = Order::selectRaw('collections.title, collections.id, count(*) as total_borrowed')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('collections', 'order_details.collection_id', '=', 'collections.id')
            ->where('orders.status', 'APPROVED');
        if ($start && $end) {
            $popularBooksQuery->whereBetween('orders.borrow_date', [
                $start->format('Y-m-d'), $end->format('Y-m-d')
            ]);
        }
        $popularBooks = $popularBooksQuery->groupBy('collections.id', 'collections.title')
            ->orderByDesc('total_borrowed')
            ->limit(10)
            ->get();

        // --- Peminjaman terbaru ---
        $recentLoans = Order::with(['user', 'details.collection'])
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))
            ->latest()->limit(5)->get()
            ->map(function ($loan) {
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
            'popularBooks' => $popularBooks,
            'recentLoans' => $recentLoans,
            'physicalCollectionData' => [
                ['name' => 'Buku Pengayaan', 'total' => $enrichmentBooks],
                ['name' => 'Buku Referensi', 'total' => $referenceBooks],
                ['name' => 'Jurnal', 'total' => $journals],
                ['name' => 'Majalah', 'total' => $magazines],
            ],
            'electronicCollectionData' => [
                ['name' => 'E-Book', 'total' => $ebooks],
                ['name' => 'E-Article', 'total' => $earticles],
                ['name' => 'KTI/Skripsi', 'total' => $theses],
                ['name' => 'CD/DVD/Video', 'total' => $multimedia],
            ],
            'statusData' => [
                'borrowed' => $borrowedCountPeriod,
                'returned' => $returnedCountPeriod,
                'pending' => $pendingCountPeriod,
            ],
        ]);
    }

    /**
     * Parsing filter tanggal dari string periode
     */
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
                    $start = Carbon::parse($startDate)->startOfDay();
                    $end = Carbon::parse($endDate)->endOfDay();
                }
                break;
            default:
                break;
        }

        return [$start, $end];
    }

    // ==================== DOSEN ====================
    public function dosen()
    {
        $homes = Home::with('additionalSections')->latest()->first();
        $berita_terbaru = News::latest()->limit(4)->get();
        $shared = $this->getSharedHomeData();

        if (!$homes) {
            return view('dosen.page.home', array_merge([
                'about' => null,
                'berita_terbaru' => $berita_terbaru,
            ], $shared));
        }

        return view('dosen.page.home', array_merge(compact('homes', 'berita_terbaru'), $shared));
    }

    // ==================== EXPORT ====================
    public function exportPdf()
    {
        $data = $this->getDashboardData();
        $pdf = PDF::loadView('admin.page.exports', $data);
        return $pdf->download('laporan-perpustakaan-'.date('Y-m-d').'.pdf');
    }

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

    /**
     * Data seragam untuk export.
     */
    private function getDashboardData()
    {
        $enrichmentBooks = Collection::where('active', 1)->where('menu_type', 'Buku Pengayaan')->count();
        $referenceBooks = Collection::where('active', 1)->where('menu_type', 'Buku Referensi')->count();
        $journals = Collection::where('active', 1)->where('menu_type', 'Jurnal')->count();
        $magazines = Collection::where('active', 1)->where('menu_type', 'Majalah')->count();
        $totalPhysical = $enrichmentBooks + $referenceBooks + $journals + $magazines;

        $ebooks = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'ebook'))->count();
        $earticles = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'e-article'))->count();
        $theses = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->where('slug', 'kti'))->count();
        $multimedia = FinalProject::where('status', 'Approved')
            ->whereHas('category', fn($q) => $q->whereIn('slug', ['cd', 'video']))->count();
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
            'totalPhysicalCollections' => $totalPhysical,
            'totalElectronicCollections' => $totalElectronic,
            'activeMembers' => User::where('active', 1)->count(),
            'activeLoans' => Order::where('status', 'APPROVED')->whereNull('actual_return_date')->count(),
            'pendingApprovals' => Order::where('status', 'PENDING')->count(),
            'borrowedCountPeriod' => Order::where('status', 'APPROVED')->whereNull('actual_return_date')->count(),
            'returnedCountPeriod' => Order::where('status', 'RETURNED')->count(),
            'pendingCountPeriod' => Order::where('status', 'PENDING')->count(),
            'totalFinesPeriod' => Order::sum('fine'),
            'popularBooks' => $popularBooks,
            'recentLoans' => Order::with(['user', 'details.collection'])->latest()->limit(10)->get(),
            'recentUsers' => User::latest()->limit(5)->get(),
        ];
    }

    // ==================== GALLERY (Opsional) ====================
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_galeri' => 'required|string|max:255',
            'gambar_galeri' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar_galeri')) {
            $file = $request->file('gambar_galeri');
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

    public function show(Home $home)
    {
        //
    }

    public function edit(Home $home)
    {
        //
    }

    public function update(Request $request, Home $home)
    {
        //
    }

    public function destroy(Home $home)
    {
        //
    }
}