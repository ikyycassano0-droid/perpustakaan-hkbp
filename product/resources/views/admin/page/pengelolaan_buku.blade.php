@extends('admin.component.main')

@section('title', 'Pengelolaan Peminjaman Buku - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pengelolaan Peminjaman Buku</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola peminjaman, persetujuan, pengembalian, dan perpanjangan buku</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" id="searchOrder" placeholder="Cari peminjaman..." class="pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-sm w-64 focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition bg-slate-50/30">
            </div>
            <select id="filterStatus" class="px-4 py-2 rounded-xl border border-slate-200 text-sm bg-slate-50/30 focus:outline-none focus:border-indigo-300">
                <option value="all">Semua Status</option>
                <option value="PENDING">Pending</option>
                <option value="APPROVED">Approved</option>
                <option value="REJECTED">Rejected</option>
                <option value="RETURNED">Returned</option>
                <option value="LATE">Terlambat (Belum Kembali)</option>
            </select>
        </div>
    </div>

    <!-- Filter Periode & Total Denda -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Filter Periode -->
        <div class="card-modern p-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                <i class="fas fa-calendar-alt text-indigo-500 mr-1"></i> Filter Periode Peminjaman
            </label>
            <div class="flex flex-wrap gap-2">
                <button onclick="setDateFilter('today')" class="date-filter-btn px-3 py-1.5 text-xs rounded-lg bg-slate-100 hover:bg-indigo-100 transition">Hari Ini</button>
                <button onclick="setDateFilter('week')" class="date-filter-btn px-3 py-1.5 text-xs rounded-lg bg-slate-100 hover:bg-indigo-100 transition">1 Minggu</button>
                <button onclick="setDateFilter('month')" class="date-filter-btn px-3 py-1.5 text-xs rounded-lg bg-slate-100 hover:bg-indigo-100 transition">1 Bulan</button>
                <button onclick="openCustomDateModal()" class="date-filter-btn px-3 py-1.5 text-xs rounded-lg bg-slate-100 hover:bg-indigo-100 transition">Custom</button>
            </div>
            <div id="activeFilterInfo" class="text-xs text-slate-500 mt-2">
                <i class="fas fa-info-circle"></i> Menampilkan semua data
            </div>
        </div>

        <!-- Statistik Denda -->
        <div class="card-modern p-4 bg-gradient-to-r from-rose-50 to-orange-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-rose-600 font-medium">TOTAL DENDA</p>
                    <p class="text-2xl font-bold text-rose-700" id="totalFineDisplay">Rp 0</p>
                    <p class="text-[10px] text-rose-500 mt-1">Dari peminjaman terlambat</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-rose-200 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-rose-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Statistik Terlambat -->
        <div class="card-modern p-4 bg-gradient-to-r from-amber-50 to-yellow-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-600 font-medium">PEMINJAMAN TERLAMBAT</p>
                    <p class="text-2xl font-bold text-amber-700" id="lateCountDisplay">0</p>
                    <p class="text-[10px] text-amber-500 mt-1">Belum mengembalikan buku</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-rose-500"></i>
            <p class="text-rose-700 text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <!-- TABLE DATA -->
    <div class="card-modern overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-800 to-slate-700 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart text-white/70"></i>
                    <h3 class="font-semibold text-white">Daftar Peminjaman Buku</h3>
                </div>
                <div class="text-white/60 text-xs">
                    Total: <span id="totalDisplay">{{ $orders->count() }}</span> peminjaman
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full" id="ordersTable">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Buku</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Order Info</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pinjam</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Denda</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider" width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    @forelse($orders as $order)
                    @php
                        $isLate = $order->status === 'APPROVED' && $order->due_date && now()->gt($order->due_date);
                    @endphp
                    <tr class="order-row border-b border-slate-50 hover:bg-slate-50/30 transition" 
                        data-status="{{ $order->status }}"
                        data-is-late="{{ $isLate ? 'true' : 'false' }}"
                        data-order-date="{{ $order->order_date?->format('Y-m-d') ?? '' }}"
                        data-borrow-date="{{ $order->borrow_date?->format('Y-m-d') ?? '' }}">
                        <!-- USER -->
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-500 text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $order->user->name ?? 'User tidak ditemukan' }}</div>
                                    <div class="text-slate-400 text-[10px] mt-0.5">ID: #{{ $order->id }}</div>
                                    @if($order->extension_count > 0)
                                        <div class="text-[9px] text-amber-600 mt-0.5">
                                            <i class="fas fa-calendar-plus"></i> Extend: {{ $order->extension_count }}/3
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- BUKU -->
                        <td class="px-4 py-3">
                            @forelse($order->details as $detail)
                                <div class="flex items-center gap-2 mb-1 last:mb-0">
                                    <i class="fas fa-book text-indigo-400 text-[10px]"></i>
                                    <span class="text-sm text-slate-700">{{ $detail->collection->title ?? 'Buku tidak ada' }}</span>
                                    <span class="text-[10px] text-slate-400">({{ $detail->collection->location->name ?? '-' }})</span>
                                </div>
                            @empty
                                <span class="text-rose-500 text-sm">Tidak ada detail</span>
                            @endforelse
                        </td>

                        <!-- STATUS -->
                        <td class="px-4 py-3 text-center">
                            @if($order->status == 'PENDING')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <i class="fas fa-clock text-[10px]"></i> PENDING
                                </span>
                            @elseif($order->status == 'APPROVED')
                                @if($isLate)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                        <i class="fas fa-exclamation-triangle text-[10px]"></i> TERLAMBAT
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        <i class="fas fa-check-circle text-[10px]"></i> APPROVED
                                    </span>
                                @endif
                            @elseif($order->status == 'REJECTED')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                    <i class="fas fa-times-circle text-[10px]"></i> REJECTED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-undo-alt text-[10px]"></i> RETURNED
                                </span>
                            @endif
                        </td>

                        <!-- ORDER INFO -->
                        <td class="px-4 py-3 text-center">
                            <div class="text-xs text-slate-600">
                                <div>{{ $order->order_date?->format('d-m-Y') ?? '-' }}</div>
                                <div class="text-slate-400 text-[10px]">Order #{{ $order->id }}</div>
                            </div>
                        </td>

                        <!-- BORROW DATE -->
                        <td class="px-4 py-3 text-center">
                            <span class="text-indigo-600 font-semibold text-sm">
                                {{ $order->borrow_date?->format('d-m-Y') ?? '-' }}
                            </span>
                        </td>

                        <!-- DUE DATE -->
                        <td class="px-4 py-3 text-center">
                            @if($order->due_date)
                                <div class="{{ $isLate ? 'text-rose-600 font-bold animate-pulse' : 'text-slate-700' }}">
                                    {{ $order->due_date->format('d-m-Y') }}
                                </div>
                                @php
                                    $borrow = \Carbon\Carbon::parse($order->borrow_date);
                                    $due = \Carbon\Carbon::parse($order->due_date);
                                    $diff = $borrow->diffInDays($due);
                                @endphp
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    Durasi: {{ $diff }} hari
                                    @if($diff > 3)
                                        <span class="text-rose-500 ml-1">(MELEBIHI 3 HARI!)</span>
                                    @endif
                                </div>
                                @if($order->original_due_date)
                                    <div class="text-[9px] text-amber-600 mt-1">
                                        <i class="fas fa-history"></i> Awal: {{ \Carbon\Carbon::parse($order->original_due_date)->format('d-m-Y') }}
                                    </div>
                                @endif
                                @if($isLate)
                                    @php
                                        $lateDays = now()->diffInDays($order->due_date, false);
                                        $calculatedFine = $lateDays > 0 ? $lateDays * 2000 : 0;
                                    @endphp
                                    <div class="text-[10px] text-rose-500 mt-1 font-bold">
                                        Terlambat {{ abs($lateDays) }} hari
                                    </div>
                                @endif
                            @else
                                -
                            @endif
                        </td>

                        <!-- DENDA -->
                        <td class="px-4 py-3 text-center">
                           @php
                                $fine = $order->fine ?? 0;
                                
                                // Hitung denda real-time untuk yang masih APPROVED & terlambat
                                if ($order->status === 'APPROVED' && $order->due_date && now()->gt($order->due_date)) {
                                    $dueDate = \Carbon\Carbon::parse($order->due_date)->startOfDay();
                                    $today = now()->startOfDay();
                                    $lateDays = $dueDate->diffInDays($today, false);
                                    
                                    $fine = 0;
                                    for ($i = 1; $i <= $lateDays; $i++) {
                                        $fine += ($i <= 3) ? 2000 : 5000;
                                    }
                                }
                            @endphp
                            <span class="text-rose-600 font-semibold text-sm fine-amount" data-fine="{{ $fine }}">
                                Rp {{ number_format($fine, 0, ',', '.') }}
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                @if($order->status === 'PENDING')
                                    <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1" title="Approve">
                                            <i class="fas fa-check text-[10px]"></i> Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-rose-600 rounded-lg hover:bg-rose-700 transition flex items-center gap-1" title="Reject">
                                            <i class="fas fa-times text-[10px]"></i> Reject
                                        </button>
                                    </form>

                                @elseif($order->status === 'APPROVED')
                                    <form action="{{ route('admin.orders.return', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition flex items-center gap-1" title="Return">
                                            <i class="fas fa-undo-alt text-[10px]"></i> Return
                                        </button>
                                    </form>

                                    <!-- Tombol Extend dengan Modal -->
                                    <button type="button" 
                                            onclick="openExtendModal({{ $order->id }})"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition flex items-center gap-1"
                                            {{ $order->extension_count >= 3 || $isLate ? 'disabled' : '' }}>
                                        <i class="fas fa-calendar-plus text-[10px]"></i> 
                                        Extend
                                    </button>

                                @else
                                    <span class="text-slate-400 text-xs">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data peminjaman</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Perpanjangan -->
<div id="extendModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Perpanjangan Peminjaman</h3>
            <button onclick="closeExtendModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="extendForm" method="POST">
            @csrf
            <input type="hidden" name="order_id" id="extend_order_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Durasi Perpanjangan</label>
                <select name="extend_days" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="1">1 Hari</option>
                    <option value="2">2 Hari</option>
                    <option value="3">3 Hari (Maksimal)</option>
                </select>
                <p class="text-xs text-slate-500 mt-2">
                    <i class="fas fa-info-circle text-amber-500"></i> 
                    Maksimal perpanjangan 3 kali
                </p>
            </div>
            
            <div class="flex gap-2">
                <button type="button" 
                        onclick="closeExtendModal()" 
                        class="flex-1 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                    <i class="fas fa-calendar-plus"></i> Perpanjang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Custom Date -->
<div id="customDateModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Filter Custom Tanggal</h3>
            <button onclick="closeCustomDateModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">Dari Tanggal</label>
            <input type="date" id="startDate" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">Sampai Tanggal</label>
            <input type="date" id="endDate" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        
        <div class="flex gap-2">
            <button type="button" 
                    onclick="closeCustomDateModal()" 
                    class="flex-1 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                Batal
            </button>
            <button type="button" 
                    onclick="applyCustomDateFilter()" 
                    class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-filter"></i> Terapkan
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<script>
    let currentDateFilter = 'all';
    let customStartDate = null;
    let customEndDate = null;

    $(document).ready(function() {
        // Filter berdasarkan status
        $('#filterStatus').change(function() {
            applyAllFilters();
        });

        // Search berdasarkan nama user atau judul buku
        $('#searchOrder').on('keyup', function() {
            applyAllFilters();
        });
        updateStatistics();
    });

    function applyAllFilters() {
        let status = $('#filterStatus').val();
        let searchValue = $('#searchOrder').val().toLowerCase();
        
        $('.order-row').each(function() {
            let showByStatus = true;
            let showBySearch = true;
            let showByDate = true;
            
            // Filter Status
            let rowStatus = $(this).data('status');
            let isLate = $(this).data('is-late') === 'true';
            
            if (status === 'LATE') {
                showByStatus = isLate;
            } else if (status !== 'all') {
                showByStatus = rowStatus === status;
            }
            
            // Filter Search
            if (searchValue) {
                let userName = $(this).find('td:first .font-semibold').text().toLowerCase();
                let bookTitle = $(this).find('td:nth-child(2)').text().toLowerCase();
                showBySearch = userName.indexOf(searchValue) > -1 || bookTitle.indexOf(searchValue) > -1;
            }
            
            // Filter Date
            let orderDate = $(this).data('order-date');
            let borrowDate = $(this).data('borrow-date');
            let filterDate = orderDate || borrowDate;
            
            if (currentDateFilter !== 'all' && filterDate) {
                let filterDateObj = new Date(filterDate);
                let today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (currentDateFilter === 'today') {
                    showByDate = filterDateObj.toDateString() === today.toDateString();
                } else if (currentDateFilter === 'week') {
                    let weekAgo = new Date(today);
                    weekAgo.setDate(today.getDate() - 7);
                    showByDate = filterDateObj >= weekAgo && filterDateObj <= today;
                } else if (currentDateFilter === 'month') {
                    let monthAgo = new Date(today);
                    monthAgo.setMonth(today.getMonth() - 1);
                    showByDate = filterDateObj >= monthAgo && filterDateObj <= today;
                } else if (currentDateFilter === 'custom' && customStartDate && customEndDate) {
                    let start = new Date(customStartDate);
                    let end = new Date(customEndDate);
                    end.setHours(23, 59, 59);
                    showByDate = filterDateObj >= start && filterDateObj <= end;
                }
            }
            
            $(this).toggle(showByStatus && showBySearch && showByDate);
        });
        
        updateStatistics();
        updateTotalDisplay();
    }
    
    function setDateFilter(filter) {
        currentDateFilter = filter;
        
        // Reset active button styles
        $('.date-filter-btn').removeClass('bg-indigo-600 text-white').addClass('bg-slate-100');
        
        // Set active style and update info text
        if (filter === 'today') {
            $('.date-filter-btn:contains("Hari Ini")').removeClass('bg-slate-100').addClass('bg-indigo-600 text-white');
            $('#activeFilterInfo').html('<i class="fas fa-info-circle"></i> Menampilkan peminjaman hari ini');
        } else if (filter === 'week') {
            $('.date-filter-btn:contains("1 Minggu")').removeClass('bg-slate-100').addClass('bg-indigo-600 text-white');
            $('#activeFilterInfo').html('<i class="fas fa-info-circle"></i> Menampilkan peminjaman 1 minggu terakhir');
        } else if (filter === 'month') {
            $('.date-filter-btn:contains("1 Bulan")').removeClass('bg-slate-100').addClass('bg-indigo-600 text-white');
            $('#activeFilterInfo').html('<i class="fas fa-info-circle"></i> Menampilkan peminjaman 1 bulan terakhir');
        } else if (filter === 'custom') {
            $('#activeFilterInfo').html('<i class="fas fa-info-circle"></i> Menampilkan peminjaman custom: ' + 
                (customStartDate ? formatDate(customStartDate) : '') + ' s/d ' + 
                (customEndDate ? formatDate(customEndDate) : ''));
        } else {
            $('#activeFilterInfo').html('<i class="fas fa-info-circle"></i> Menampilkan semua data');
        }
        
        applyAllFilters();
    }
    
    function openCustomDateModal() {
        document.getElementById('customDateModal').classList.remove('hidden');
        document.getElementById('customDateModal').classList.add('flex');
        
        // Set default values
        let today = new Date().toISOString().split('T')[0];
        let weekAgo = new Date();
        weekAgo.setDate(weekAgo.getDate() - 7);
        
        document.getElementById('startDate').value = weekAgo.toISOString().split('T')[0];
        document.getElementById('endDate').value = today;
    }
    
    function closeCustomDateModal() {
        document.getElementById('customDateModal').classList.add('hidden');
        document.getElementById('customDateModal').classList.remove('flex');
    }
    
    function applyCustomDateFilter() {
        customStartDate = document.getElementById('startDate').value;
        customEndDate = document.getElementById('endDate').value;
        
        if (customStartDate && customEndDate) {
            currentDateFilter = 'custom';
            setDateFilter('custom');
            closeCustomDateModal();
        } else {
            alert('Silakan pilih tanggal mulai dan tanggal akhir');
        }
    }
    
    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }
    
    function updateStatistics() {
        let totalFine = 0;
        let lateCount = 0;
        
        $('.order-row:visible').each(function() {
            let isLate = $(this).data('is-late') === 'true';
            let status = $(this).data('status');
            let fine = parseFloat($(this).find('.fine-amount').data('fine')) || 0;
            
            // Hitung keterlambatan (APPROVED + overdue)
            if (isLate) {
                lateCount++;
            }
            
            // Hitung total denda (semua status)
            totalFine += fine;
        });
        
        $('#totalFineDisplay').text('Rp ' + totalFine.toLocaleString('id-ID'));
        $('#lateCountDisplay').text(lateCount);
    }
    
    function updateTotalDisplay() {
        let visibleCount = $('.order-row:visible').length;
        $('#totalDisplay').text(visibleCount);
    }

    // ================= MODAL EXTEND =================
    function openExtendModal(orderId) {
        const modal = document.getElementById('extendModal');
        const form = document.getElementById('extendForm');
        
        form.action = `/admin/orders/${orderId}/extend`;
        document.getElementById('extend_order_id').value = orderId;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeExtendModal() {
        const modal = document.getElementById('extendModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Klik luar modal
    document.getElementById('extendModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeExtendModal();
        }
    });
    
    document.getElementById('customDateModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCustomDateModal();
        }
    });

    // Auto close notifikasi
    setTimeout(function() {
        const alerts = document.querySelectorAll('.bg-emerald-50, .bg-rose-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 3000);
</script>

@endsection



