@extends('admin.component.main')

@section('title', 'Dashboard - AKPER HKBP Balige')
@section('content')

<div class="space-y-6">
    {{-- Header & Filter --}}
    <div class="flex justify-between items-center mb-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-0.5">Selamat datang, {{ session('user')['name'] ?? 'Admin' }}. Berikut ringkasan data perpustakaan.</p>
        </div>
        <div class="flex gap-2">
            <select id="exportPeriod" class="px-3 py-2 text-sm border border-slate-200 rounded-xl bg-white text-slate-600 focus:outline-none focus:border-indigo-300">
                <option value="all">Semua Data</option>
                <option value="today">Hari Ini</option>
                <option value="week">1 Minggu Ini</option>
                <option value="month">1 Bulan Ini</option>
                <option value="custom">Custom</option>
            </select>
            <div id="customDateRange" class="hidden flex gap-2">
                <input type="date" id="startDate" class="px-3 py-2 text-sm border border-slate-200 rounded-xl">
                <input type="date" id="endDate" class="px-3 py-2 text-sm border border-slate-200 rounded-xl">
                <button onclick="applyCustomFilter()" class="px-3 py-2 text-sm bg-indigo-500 text-white rounded-xl hover:bg-indigo-600">Terapkan</button>
            </div>
            <a href="#" onclick="exportReport('pdf')" class="px-4 py-2 text-sm bg-red-500 text-white rounded-xl hover:bg-red-600 transition flex items-center gap-2">
                <i class="fas fa-file-pdf text-xs"></i> PDF
            </a>
            <a href="#" onclick="exportReport('excel')" class="px-4 py-2 text-sm bg-green-500 text-white rounded-xl hover:bg-green-600 transition flex items-center gap-2">
                <i class="fas fa-file-excel text-xs"></i> Excel
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Total Koleksi Fisik</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1" id="totalPhysicalCollections">{{ $totalPhysicalCollections ?? 0 }}</p>
                    <div class="flex flex-col gap-0.5 mt-2">
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-book text-blue-500 w-3"></i><span class="text-slate-500">Buku Pengayaan:</span>
                            <span class="font-semibold text-slate-700" id="enrichmentBooks">{{ $enrichmentBooks ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-book-open text-green-500 w-3"></i><span class="text-slate-500">Buku Referensi:</span>
                            <span class="font-semibold text-slate-700" id="referenceBooks">{{ $referenceBooks ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-newspaper text-amber-500 w-3"></i><span class="text-slate-500">Jurnal:</span>
                            <span class="font-semibold text-slate-700" id="journals">{{ $journals ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-magazine text-purple-500 w-3"></i><span class="text-slate-500">Majalah:</span>
                            <span class="font-semibold text-slate-700" id="magazines">{{ $magazines ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="stat-icon bg-indigo-50"><i class="fas fa-book text-indigo-500 text-xl"></i></div>
            </div>
        </div>

        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Koleksi Elektronik</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1" id="totalElectronicCollections">{{ $totalElectronicCollections ?? 0 }}</p>
                    <div class="flex flex-col gap-0.5 mt-2">
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-file-alt text-sky-500 w-3"></i><span class="text-slate-500">E-Book:</span>
                            <span class="font-semibold text-slate-700" id="ebooks">{{ $ebooks ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-file-pdf text-red-500 w-3"></i><span class="text-slate-500">E-Article:</span>
                            <span class="font-semibold text-slate-700" id="earticles">{{ $earticles ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-graduation-cap text-emerald-500 w-3"></i><span class="text-slate-500">KTI/Skripsi:</span>
                            <span class="font-semibold text-slate-700" id="theses">{{ $theses ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px]">
                            <i class="fas fa-compact-disc text-amber-500 w-3"></i><span class="text-slate-500">CD/DVD/Video:</span>
                            <span class="font-semibold text-slate-700" id="multimedia">{{ $multimedia ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="stat-icon bg-sky-50"><i class="fas fa-laptop text-sky-500 text-xl"></i></div>
            </div>
        </div>

        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Anggota Aktif</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1" id="activeMembers">{{ $activeMembers ?? 0 }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-user-plus text-emerald-500 text-[10px]"></i>
                        <span class="text-emerald-600 text-xs font-medium" id="newMembersPeriod">+{{ $newMembersPeriod ?? 0 }} periode ini</span>
                    </div>
                </div>
                <div class="stat-icon bg-emerald-50"><i class="fas fa-users text-emerald-500 text-xl"></i></div>
            </div>
        </div>

        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Peminjaman Aktif</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1" id="activeLoans">{{ $activeLoans ?? 0 }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-hourglass-half text-amber-500 text-[10px]"></i>
                        <span class="text-amber-600 text-xs font-medium" id="pendingApprovals">{{ $pendingApprovals ?? 0 }} menunggu persetujuan</span>
                    </div>
                </div>
                <div class="stat-icon bg-amber-50"><i class="fas fa-hand-holding-heart text-amber-500 text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- Additional Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="card-modern p-4 text-center">
            <i class="fas fa-chart-line text-indigo-500 text-lg mb-1"></i>
            <p class="text-2xl font-bold text-slate-800" id="totalLoansPeriod">{{ $totalLoansPeriod ?? 0 }}</p>
            <p class="text-xs text-slate-500">Total Peminjaman</p>
        </div>
        <div class="card-modern p-4 text-center">
            <i class="fas fa-undo-alt text-emerald-500 text-lg mb-1"></i>
            <p class="text-2xl font-bold text-slate-800" id="totalReturnsPeriod">{{ $totalReturnsPeriod ?? 0 }}</p>
            <p class="text-xs text-slate-500">Total Pengembalian</p>
        </div>
        <div class="card-modern p-4 text-center">
            <i class="fas fa-money-bill-wave text-rose-500 text-lg mb-1"></i>
            <p class="text-2xl font-bold text-slate-800" id="totalFinesPeriod">Rp {{ number_format($totalFinesPeriod ?? 0, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500">Total Denda</p>
        </div>
    </div>

    {{-- Charts Row 1 --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
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
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Distribusi Koleksi Fisik</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Berdasarkan jenis koleksi</p>
                </div>
            </div>
            <div id="collectionChart"></div>
        </div>
    </div>

    {{-- Charts Row 2 --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card-modern p-5">
            <h3 class="font-semibold text-slate-800 mb-4">Status Peminjaman (Periode Ini)</h3>
            <div id="statusDonutChart"></div>
            <div class="flex justify-center gap-5 mt-3">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                    <span class="text-xs text-slate-600">Dipinjam (<span id="borrowedCount">{{ $borrowedCountPeriod ?? 0 }}</span>)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                    <span class="text-xs text-slate-600">Dikembalikan (<span id="returnedCount">{{ $returnedCountPeriod ?? 0 }}</span>)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                    <span class="text-xs text-slate-600">Menunggu (<span id="pendingCount">{{ $pendingCountPeriod ?? 0 }}</span>)</span>
                </div>
            </div>
        </div>
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Distribusi Koleksi Elektronik</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Berdasarkan jenis</p>
                </div>
            </div>
            <div id="electronicChart"></div>
        </div>
    </div>

    {{-- Charts Row 3 - BUKU TERPOPULER --}}
    <div class="grid grid-cols-1 gap-5">
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Buku Terpopuler</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Berdasarkan jumlah peminjaman periode ini</p>
                </div>
            </div>
            {{-- Container dinamis untuk grafik atau placeholder --}}
            <div id="popularBooksChartContainer">
                @if(count($popularBooks ?? []) > 0)
                    <div id="popularBooksChart"></div>
                @else
                    <div class="text-center text-slate-400 py-10">
                        <i class="fas fa-book-open text-4xl mb-2"></i>
                        <p>Tidak ada data peminjaman pada periode ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="card-modern overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-slate-800">Peminjaman Terbaru</h3>
                <p class="text-slate-400 text-xs mt-0.5">5 peminjaman terakhir periode ini</p>
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
                <tbody id="recentLoansTable">
                    @foreach($recentLoans ?? [] as $loan)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#{{ $loan->order_number ?? $loan->id }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $loan->user->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $loan->details->first()->collection->title ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($loan->status == 'PENDING')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                </span>
                            @elseif($loan->status == 'APPROVED')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Dipinjam
                                </span>
                            @elseif($loan->status == 'REJECTED')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                </span>
                            @elseif($loan->status == 'RETURNED')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-slate-400">{{ $loan->created_at ? $loan->created_at->format('d-m-Y') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let currentFilter = 'all';
    let customStartDate = null;
    let customEndDate = null;

    let loanChart, collectionChart, statusChart, electronicChart, barChart = null;

    // Data awal dari server
    const serverData = {
        monthlyLoans: @json($monthlyLoans ?? array_fill(0, 12, 0)),
        physicalCollectionData: @json($physicalCollectionData ?? []),
        electronicCollectionData: @json($electronicCollectionData ?? []),
        statusData: {
            borrowed: {{ $borrowedCountPeriod ?? 0 }},
            returned: {{ $returnedCountPeriod ?? 0 }},
            pending: {{ $pendingCountPeriod ?? 0 }}
        },
        popularBooks: @json($popularBooks ?? [])
    };

    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();

        document.getElementById('exportPeriod').addEventListener('change', function() {
            currentFilter = this.value;
            if (currentFilter === 'custom') {
                document.getElementById('customDateRange').classList.remove('hidden');
            } else {
                document.getElementById('customDateRange').classList.add('hidden');
                loadFilteredData(currentFilter);
            }
        });
    });

    function initializeCharts() {
        // Loan Chart
        var loanOptions = {
            series: [{ name: 'Peminjaman', data: serverData.monthlyLoans }],
            chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            plotOptions: { bar: { borderRadius: 8, columnWidth: '60%' } },
            xaxis: { categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'], labels: { style: { colors: '#94a3b8', fontSize: '10px' } } },
            yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '10px' } } },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            colors: ['#6366f1'],
            tooltip: { y: { formatter: (val) => val + ' peminjaman' } }
        };
        loanChart = new ApexCharts(document.querySelector("#loanChart"), loanOptions);
        loanChart.render();

        // Collection Pie Chart (Fisik)
        var physicalData = serverData.physicalCollectionData;
        if (physicalData.length > 0) {
            var collectionOptions = {
                series: physicalData.map(c => c.total),
                chart: { type: 'donut', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                labels: physicalData.map(c => c.name),
                colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444'],
                legend: { position: 'bottom', labels: { colors: '#475569' } },
                dataLabels: { enabled: false },
                plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '11px', color: '#64748b' } } } } },
                tooltip: { y: { formatter: (val) => val + ' koleksi' } }
            };
            collectionChart = new ApexCharts(document.querySelector("#collectionChart"), collectionOptions);
            collectionChart.render();
        }

        // Electronic Pie Chart
        var electronicData = serverData.electronicCollectionData;
        if (electronicData.length > 0) {
            var electronicOptions = {
                series: electronicData.map(c => c.total),
                chart: { type: 'donut', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                labels: electronicData.map(c => c.name),
                colors: ['#0ea5e9', '#f43f5e', '#8b5cf6', '#f59e0b'],
                legend: { position: 'bottom', labels: { colors: '#475569' } },
                dataLabels: { enabled: false },
                plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '11px', color: '#64748b' } } } } },
                tooltip: { y: { formatter: (val) => val + ' koleksi' } }
            };
            electronicChart = new ApexCharts(document.querySelector("#electronicChart"), electronicOptions);
            electronicChart.render();
        }

        // Status Donut Chart
        var statusOptions = {
            series: [serverData.statusData.borrowed, serverData.statusData.returned, serverData.statusData.pending],
            chart: { type: 'donut', height: 240, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            labels: ['Dipinjam', 'Dikembalikan', 'Menunggu'],
            colors: ['#6366f1', '#10b981', '#f59e0b'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: { pie: { donut: { size: '70%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '11px', color: '#64748b' } } } } },
            tooltip: { y: { formatter: (val) => val + ' peminjaman' } }
        };
        statusChart = new ApexCharts(document.querySelector("#statusDonutChart"), statusOptions);
        statusChart.render();

        // Buku Terpopuler Chart (dynamic render)
        renderPopularBooksChart(serverData.popularBooks);
    }

    /**
     * Render atau update grafik buku terpopuler.
     * @param {Array} books - Array of { title, total_borrowed }
     */
    function renderPopularBooksChart(books) {
        const container = document.getElementById('popularBooksChartContainer');
        if (!container) return;

        // Bersihkan kontainer
        container.innerHTML = '';

        if (!books || books.length === 0) {
            container.innerHTML = `
                <div class="text-center text-slate-400 py-10">
                    <i class="fas fa-book-open text-4xl mb-2"></i>
                    <p>Tidak ada data peminjaman pada periode ini.</p>
                </div>
            `;
            barChart = null;
            return;
        }

        // Buat elemen chart baru
        const chartDiv = document.createElement('div');
        chartDiv.id = 'popularBooksChart';
        container.appendChild(chartDiv);

        // Hancurkan chart lama jika ada
        if (barChart) {
            barChart.destroy();
        }

        // Siapkan data, potong judul panjang
        const titles = books.map(b => b.title.length > 25 ? b.title.substring(0, 25) + '...' : b.title);
        const values = books.map(b => b.total_borrowed);

        const options = {
            series: [{ data: values }],
            chart: {
                type: 'bar',
                height: 280,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: true,
                    barHeight: '35%',
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: (val) => val + ' kali',
                offsetX: 10,
                style: { fontSize: '10px', colors: ['#475569'] }
            },
            xaxis: {
                categories: titles,
                labels: { style: { fontSize: '11px', colors: '#475569' } }
            },
            colors: ['#6366f1'],
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                xaxis: { lines: { show: true } }
            },
            tooltip: {
                y: { formatter: (val) => val + ' kali dipinjam' }
            }
        };

        barChart = new ApexCharts(chartDiv, options);
        barChart.render();
    }

    // Memuat data yang difilter via AJAX
    function loadFilteredData(filter) {
        let url = '/admin/dashboard/filter';
        let params = new URLSearchParams();

        if (filter === 'today') {
            params.append('period', 'today');
        } else if (filter === 'week') {
            params.append('period', 'week');
        } else if (filter === 'month') {
            params.append('period', 'month');
        } else if (filter === 'custom' && customStartDate && customEndDate) {
            params.append('start_date', customStartDate);
            params.append('end_date', customEndDate);
        }

        fetch(url + '?' + params.toString())
            .then(response => response.json())
            .then(data => updateDashboardData(data))
            .catch(error => console.error('Error:', error));
    }

    function updateDashboardData(data) {
        // Update angka
        document.getElementById('totalPhysicalCollections').textContent = data.totalPhysicalCollections || 0;
        document.getElementById('enrichmentBooks').textContent = data.enrichmentBooks || 0;
        document.getElementById('referenceBooks').textContent = data.referenceBooks || 0;
        document.getElementById('journals').textContent = data.journals || 0;
        document.getElementById('magazines').textContent = data.magazines || 0;
        document.getElementById('totalElectronicCollections').textContent = data.totalElectronicCollections || 0;
        document.getElementById('ebooks').textContent = data.ebooks || 0;
        document.getElementById('earticles').textContent = data.earticles || 0;
        document.getElementById('theses').textContent = data.theses || 0;
        document.getElementById('multimedia').textContent = data.multimedia || 0;
        document.getElementById('activeMembers').textContent = data.activeMembers || 0;
        document.getElementById('newMembersPeriod').textContent = '+ ' + (data.newMembersPeriod || 0) + ' periode ini';
        document.getElementById('activeLoans').textContent = data.activeLoans || 0;
        document.getElementById('pendingApprovals').textContent = (data.pendingApprovals || 0) + ' menunggu persetujuan';
        document.getElementById('totalLoansPeriod').textContent = data.totalLoansPeriod || 0;
        document.getElementById('totalReturnsPeriod').textContent = data.totalReturnsPeriod || 0;
        document.getElementById('totalFinesPeriod').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.totalFinesPeriod || 0);
        document.getElementById('borrowedCount').textContent = data.borrowedCountPeriod || 0;
        document.getElementById('returnedCount').textContent = data.returnedCountPeriod || 0;
        document.getElementById('pendingCount').textContent = data.pendingCountPeriod || 0;

        // Update chart bulanan
        if (data.monthlyLoans) {
            loanChart.updateSeries([{ data: data.monthlyLoans }]);
        }

        // Update koleksi fisik chart
        if (data.physicalCollectionData) {
            collectionChart.updateOptions({
                series: data.physicalCollectionData.map(c => c.total),
                labels: data.physicalCollectionData.map(c => c.name)
            });
        }

        // Update koleksi elektronik chart
        if (data.electronicCollectionData) {
            electronicChart.updateOptions({
                series: data.electronicCollectionData.map(c => c.total),
                labels: data.electronicCollectionData.map(c => c.name)
            });
        }

        // Update status chart
        if (data.statusData) {
            statusChart.updateSeries([data.statusData.borrowed || 0, data.statusData.returned || 0, data.statusData.pending || 0]);
        }

        // === UPDATE BUKU TERPOPULER ===
        if (data.popularBooks !== undefined) {
            renderPopularBooksChart(data.popularBooks);
        }

        // Update tabel peminjaman terbaru
        if (data.recentLoans) {
            updateRecentLoansTable(data.recentLoans);
        }
    }

    function updateRecentLoansTable(loans) {
        const tbody = document.getElementById('recentLoansTable');
        if (!tbody) return;
        if (loans.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">Tidak ada data peminjaman untuk periode ini</td></tr>';
            return;
        }
        tbody.innerHTML = loans.map(loan => `
            <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                <td class="px-5 py-3 text-sm font-medium text-slate-700">#${loan.order_number || loan.id}</td>
                <td class="px-5 py-3 text-sm text-slate-600">${loan.user_name || '-'}</td>
                <td class="px-5 py-3 text-sm text-slate-600">${loan.book_title || '-'}</td>
                <td class="px-5 py-3">${getStatusBadge(loan.status)}</td>
                <td class="px-5 py-3 text-sm text-slate-400">${loan.created_at || '-'}</td>
            </tr>
        `).join('');
    }

    function getStatusBadge(status) {
        const badges = {
            'PENDING': '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu</span>',
            'APPROVED': '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Dipinjam</span>',
            'REJECTED': '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak</span>',
            'RETURNED': '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Dikembalikan</span>'
        };
        return badges[status] || '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">' + status + '</span>';
    }

    function applyCustomFilter() {
        customStartDate = document.getElementById('startDate').value;
        customEndDate = document.getElementById('endDate').value;
        if (customStartDate && customEndDate) {
            loadFilteredData('custom');
        } else {
            alert('Silakan pilih tanggal mulai dan tanggal akhir');
        }
    }

    function exportReport(type) {
        let period = currentFilter;
        let params = new URLSearchParams();
        if (period === 'today') params.append('period', 'today');
        else if (period === 'week') params.append('period', 'week');
        else if (period === 'month') params.append('period', 'month');
        else if (period === 'custom' && customStartDate && customEndDate) {
            params.append('start_date', customStartDate);
            params.append('end_date', customEndDate);
        }
        let url = type === 'pdf' ? '/admin/export/pdf' : '/admin/export/excel';
        window.location.href = url + '?' + params.toString();
    }
</script>
@endpush