<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Collection;
use App\Models\CategoryCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Koleksi
        $totalCollections = Collection::where('active', 1)->count();
        
        // Anggota Aktif
        $activeMembers = User::where('is_active', 1)
            ->whereHas('role', function($q) {
                $q->where('name', 'Mahasiswa');
            })
            ->count();
        $newMembersThisMonth = User::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        
        // Peminjaman Aktif
        $activeLoans = Order::where('status', 'APPROVED')->count();
        $pendingApprovals = Order::where('status', 'PENDING')->count();
        
        // Pengunjung (contoh: dari log atau session, atau bisa data dummy)
        $monthlyVisitors = 1245;
        $visitorGrowth = 12;
        
        // Data untuk Chart Peminjaman per Bulan
        $monthlyLoans = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return $item->total;
            });
        
        // Data untuk Chart Kategori Koleksi
        $categoryCollection = CategoryCollection::withCount('collections')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->name,
                    'total' => $item->collections_count
                ];
            });
        
        // Data untuk Status Peminjaman
        $borrowedCount = Order::where('status', 'APPROVED')->count();
        $returnedCount = Order::where('status', 'RETURNED')->count();
        $pendingCount = Order::where('status', 'PENDING')->count();
        
        // Data untuk Buku Terpopuler
        $popularBooks = Collection::select('collections.id', 'collections.title', DB::raw('COUNT(order_details.id) as total_borrowed'))
            ->join('order_details', 'collections.id', '=', 'order_details.collection_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'APPROVED')
            ->groupBy('collections.id', 'collections.title')
            ->orderBy('total_borrowed', 'desc')
            ->limit(5)
            ->get();
        
        // Peminjaman Terbaru
        $recentLoans = Order::with(['user', 'details.collection'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Anggota Terbaru
        $recentUsers = User::whereHas('role', function($q) {
                $q->where('name', 'Mahasiswa');
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.page.dashboard', compact(
            'totalCollections',
            'activeMembers',
            'newMembersThisMonth',
            'activeLoans',
            'pendingApprovals',
            'monthlyVisitors',
            'visitorGrowth',
            'monthlyLoans',
            'categoryCollection',
            'borrowedCount',
            'returnedCount',
            'pendingCount',
            'popularBooks',
            'recentLoans',
            'recentUsers'
        ));
    }
}