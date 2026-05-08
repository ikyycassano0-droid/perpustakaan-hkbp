@extends('admin.component.main')

@section('title', 'Dashboard - Admin AKPER HKBP Balige')
@section('content')

<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-0.5">Selamat datang, {{ auth()->user()->name ?? 'Admin' }}. Berikut ringkasan data perpustakaan.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 text-sm border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition flex items-center gap-2" onclick="window.print()">
                <i class="fas fa-print text-xs"></i> Cetak Laporan
            </button>
            <div class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-calendar-alt text-xs"></i> {{ date('d M Y') }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Koleksi -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Total Koleksi</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalCollections ?? 0 }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-book text-indigo-500 text-[10px]"></i>
                        <span class="text-indigo-600 text-xs font-medium">Buku, Jurnal, Majalah</span>
                    </div>
                </div>
                <div class="stat-icon bg-indigo-50">
                    <i class="fas fa-book text-indigo-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Anggota Aktif -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Anggota Aktif</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $activeMembers ?? 0 }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-user-plus text-emerald-500 text-[10px]"></i>
                        <span class="text-emerald-600 text-xs font-medium">+{{ $newMembersThisMonth ?? 0 }} bulan ini</span>
                    </div>
                </div>
                <div class="stat-icon bg-emerald-50">
                    <i class="fas fa-users text-emerald-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Peminjaman Aktif</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $activeLoans ?? 0 }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-hourglass-half text-amber-500 text-[10px]"></i>
                        <span class="text-amber-600 text-xs font-medium">{{ $pendingApprovals ?? 0 }} menunggu persetujuan</span>
                    </div>
                </div>
                <div class="stat-icon bg-amber-50">
                    <i class="fas fa-hand-holding-heart text-amber-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pengunjung -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Pengunjung (Bulan Ini)</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $monthlyVisitors ?? 0 }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-chart-line text-purple-500 text-[10px]"></i>
                        <span class="text-purple-600 text-xs font-medium">+{{ $visitorGrowth ?? 0 }}% dari bulan lalu</span>
                    </div>
                </div>
                <div class="stat-icon bg-purple-50">
                    <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Peminjaman Bulanan Chart -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Statistik Peminjaman</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Jumlah peminjaman per bulan</p>
                </div>
                <select id="yearSelect" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 bg-white text-slate-600 focus:outline-none focus:border-indigo-300">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>
            <div id="loanChart"></div>
        </div>

        <!-- Kategori Koleksi Chart -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Distribusi Koleksi</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Berdasarkan jenis koleksi</p>
                </div>
            </div>
            <div id="collectionChart"></div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Status Peminjaman -->
        <div class="card-modern p-5">
            <h3 class="font-semibold text-slate-800 mb-4">Status Peminjaman</h3>
            <div id="statusDonutChart"></div>
            <div class="flex justify-center gap-5 mt-3">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                    <span class="text-xs text-slate-600">Dipinjam ({{ $borrowedCount ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                    <span class="text-xs text-slate-600">Dikembalikan ({{ $returnedCount ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                    <span class="text-xs text-slate-600">Menunggu ({{ $pendingCount ?? 0 }})</span>
                </div>
            </div>
        </div>

        <!-- Buku Terpopuler -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Buku Terpopuler</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Berdasarkan jumlah peminjaman</p>
                </div>
                <i class="fas fa-ellipsis-h text-slate-400 cursor-pointer hover:text-slate-600"></i>
            </div>
            <div id="popularBooksChart"></div>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="card-modern overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-slate-800">Peminjaman Terbaru</h3>
                <p class="text-slate-400 text-xs mt-0.5">5 peminjaman terakhir</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 text-xs font-medium hover:text-indigo-700">
                Lihat semua <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No. Peminjaman</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Peminjam</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans ?? [] as $loan)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#{{ $loan->order_number ?? $loan->id }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $loan->user->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $loan->details->first()->collection->title ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($loan->status == 'PENDING')
                                <span class="badge-warning">Menunggu</span>
                            @elseif($loan->status == 'APPROVED')
                                <span class="badge-success">Dipinjam</span>
                            @elseif($loan->status == 'REJECTED')
                                <span class="badge-danger">Ditolak</span>
                            @elseif($loan->status == 'RETURNED')
                                <span class="badge-info">Dikembalikan</span>
                            @else
                                <span class="badge-secondary">{{ $loan->status }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-slate-400">{{ $loan->created_at ? $loan->created_at->format('d-m-Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada data peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Anggota Terbaru -->
    <div class="card-modern overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-slate-800">Anggota Terbaru</h3>
                <p class="text-slate-400 text-xs mt-0.5">5 anggota yang baru bergabung</p>
            </div>
            <!-- HAPUS LINK YANG BELUM ADA -->
            <span class="text-indigo-600 text-xs font-medium">Anggota Perpustakaan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">NPM/NIDN</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Program Studi</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers ?? [] as $user)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">{{ $user->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $user->npm ?? $user->nidn ?? '-' }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $user->study_program ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if(($user->is_active ?? 1) == 1)
                                <span class="badge-success">Aktif</span>
                            @else
                                <span class="badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-slate-400">{{ $user->created_at ? $user->created_at->format('d-m-Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada data anggota</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari server
        var loanData = @json($monthlyLoans ?? []);
        var collectionData = @json($categoryCollection ?? []);
        var popularBooks = @json($popularBooks ?? []);
        
        // Loan Chart - Bar
        var loanOptions = {
            series: [{
                name: 'Peminjaman',
                data: loanData.length ? loanData : [12, 19, 15, 25, 22, 30, 35, 42, 38, 45, 50, 48]
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '60%',
                    colors: {
                        ranges: [{
                            from: 0,
                            to: 100,
                            color: '#6366f1'
                        }]
                    }
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: false },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                labels: { style: { colors: '#94a3b8', fontSize: '10px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#94a3b8', fontSize: '10px' } },
                title: { text: 'Jumlah Peminjaman', style: { fontSize: '10px', color: '#94a3b8' } }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4, show: true },
            colors: ['#6366f1'],
            tooltip: { y: { formatter: (val) => val + ' peminjaman' } }
        };
        var loanChart = new ApexCharts(document.querySelector("#loanChart"), loanOptions);
        loanChart.render();

        // Collection Pie Chart
        var collectionOptions = {
            series: collectionData.length ? collectionData.map(function(c) { return c.total; }) : [45, 25, 15, 10, 5],
            chart: { type: 'donut', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            labels: collectionData.length ? collectionData.map(function(c) { return c.name; }) : ['Buku Pengayaan', 'Buku Referensi', 'Jurnal', 'Majalah', 'E-Book'],
            colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            legend: { position: 'bottom', labels: { colors: '#475569', useSeriesColors: false } },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: { 
                        size: '65%',
                        labels: { 
                            show: true, 
                            total: { 
                                show: true, 
                                label: 'Total', 
                                fontSize: '11px', 
                                color: '#64748b', 
                                formatter: function(w) {
                                    var total = 0;
                                    for (var i = 0; i < w.config.series.length; i++) {
                                        total += w.config.series[i];
                                    }
                                    return total;
                                }
                            } 
                        } 
                    }
                }
            },
            stroke: { show: false },
            tooltip: { y: { formatter: function(val) { return val + ' koleksi'; } } }
        };
        var collectionChart = new ApexCharts(document.querySelector("#collectionChart"), collectionOptions);
        collectionChart.render();

        // Status Donut Chart
        var statusOptions = {
            series: [{{ $borrowedCount ?? 35 }}, {{ $returnedCount ?? 45 }}, {{ $pendingCount ?? 20 }}],
            chart: { type: 'donut', height: 240, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            labels: ['Dipinjam', 'Dikembalikan', 'Menunggu'],
            colors: ['#6366f1', '#10b981', '#f59e0b'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: { 
                        size: '70%',
                        labels: { 
                            show: true, 
                            total: { 
                                show: true, 
                                label: 'Total', 
                                fontSize: '11px', 
                                color: '#64748b',
                                formatter: function(w) {
                                    var total = 0;
                                    for (var i = 0; i < w.config.series.length; i++) {
                                        total += w.config.series[i];
                                    }
                                    return total;
                                }
                            } 
                        }
                    }
                }
            },
            stroke: { show: false },
            tooltip: { y: { formatter: function(val) { return val + ' peminjaman'; } } }
        };
        var statusChart = new ApexCharts(document.querySelector("#statusDonutChart"), statusOptions);
        statusChart.render();

        // Popular Books Horizontal Bar Chart
        var bookTitles = popularBooks.length ? popularBooks.map(function(b) { 
            return b.title.length > 20 ? b.title.substring(0, 20) + '...' : b.title; 
        }) : ['Prinsip Dasar Keperawatan', 'Anatomi Manusia', 'Farmakologi Dasar', 'Etika Keperawatan', 'Keperawatan Anak'];
        var bookCounts = popularBooks.length ? popularBooks.map(function(b) { return b.total_borrowed; }) : [45, 38, 32, 28, 25];
        
        var barOptions = {
            series: [{ data: bookCounts }],
            chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            plotOptions: { bar: { borderRadius: 8, horizontal: true, barHeight: '35%', dataLabels: { position: 'top' } } },
            dataLabels: { enabled: true, formatter: function(val) { return val + ' kali'; }, offsetX: 10, style: { fontSize: '10px', colors: ['#475569'], fontWeight: '500' } },
            xaxis: { categories: bookTitles, labels: { style: { fontSize: '11px', colors: '#475569' } }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { style: { fontSize: '11px', fontWeight: 500 } } },
            colors: ['#6366f1'],
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4, xaxis: { lines: { show: true } } },
            tooltip: { y: { formatter: function(val) { return val + ' kali dipinjam'; } } }
        };
        var barChart = new ApexCharts(document.querySelector("#popularBooksChart"), barOptions);
        barChart.render();
    });
</script>
@endpush