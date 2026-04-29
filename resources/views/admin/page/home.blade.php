@extends('admin.component.main')

@section('title', 'Dashboard')
@section('content')

<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-0.5">Welcome back, Alex. Here's your business overview.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 text-sm border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition flex items-center gap-2">
                <i class="fas fa-download text-xs"></i> Export
            </button>
            <button class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-calendar-alt text-xs"></i> {{ date('M d, Y') }}
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Revenue</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">$48,293</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-arrow-up text-emerald-500 text-[10px]"></i>
                        <span class="text-emerald-600 text-xs font-medium">+12.5%</span>
                        <span class="text-slate-400 text-xs ml-1">vs last month</span>
                    </div>
                </div>
                <div class="stat-icon bg-indigo-50">
                    <i class="fas fa-dollar-sign text-indigo-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Users</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">12,482</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-arrow-up text-emerald-500 text-[10px]"></i>
                        <span class="text-emerald-600 text-xs font-medium">+8.2%</span>
                        <span class="text-slate-400 text-xs ml-1">this week</span>
                    </div>
                </div>
                <div class="stat-icon bg-emerald-50">
                    <i class="fas fa-users text-emerald-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Orders</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">3,892</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-arrow-down text-rose-500 text-[10px]"></i>
                        <span class="text-rose-600 text-xs font-medium">-3.1%</span>
                        <span class="text-slate-400 text-xs ml-1">vs last week</span>
                    </div>
                </div>
                <div class="stat-icon bg-amber-50">
                    <i class="fas fa-shopping-cart text-amber-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-modern p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">Conversion</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">24.8%</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-arrow-up text-emerald-500 text-[10px]"></i>
                        <span class="text-emerald-600 text-xs font-medium">+5.4%</span>
                        <span class="text-slate-400 text-xs ml-1">improved</span>
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
        <!-- Revenue Chart -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Revenue Overview</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Monthly performance</p>
                </div>
                <select class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 bg-white text-slate-600 focus:outline-none focus:border-indigo-300">
                    <option>2025</option>
                    <option>2024</option>
                </select>
            </div>
            <div id="revenueChart"></div>
        </div>

        <!-- Traffic Chart -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Traffic Overview</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Last 7 days</p>
                </div>
                <div class="flex gap-1">
                    <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg font-medium">Daily</span>
                    <span class="text-xs text-slate-500 px-2 py-1 rounded-lg cursor-pointer hover:bg-slate-100">Weekly</span>
                </div>
            </div>
            <div id="trafficChart"></div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Devices Distribution -->
        <div class="card-modern p-5">
            <h3 class="font-semibold text-slate-800 mb-4">Device Distribution</h3>
            <div id="donutChart"></div>
            <div class="flex justify-center gap-5 mt-3">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                    <span class="text-xs text-slate-600">Mobile (45%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                    <span class="text-xs text-slate-600">Desktop (35%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                    <span class="text-xs text-slate-600">Tablet (20%)</span>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="card-modern p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Top Products</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Best selling items</p>
                </div>
                <i class="fas fa-ellipsis-h text-slate-400 cursor-pointer hover:text-slate-600"></i>
            </div>
            <div id="barChart"></div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card-modern overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-slate-800">Recent Transactions</h3>
                <p class="text-slate-400 text-xs mt-0.5">Latest 5 orders</p>
            </div>
            <button class="text-indigo-600 text-xs font-medium hover:text-indigo-700">View all <i class="fas fa-arrow-right ml-1 text-[10px]"></i></button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#INV-001234</td>
                        <td class="px-5 py-3 text-sm text-slate-600">John Doe</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-800">$299.00</td>
                        <td class="px-5 py-3"><span class="badge-success">Completed</span></td>
                        <td class="px-5 py-3 text-sm text-slate-400">Jan 15, 2025</td>
                    </tr>
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#INV-001235</td>
                        <td class="px-5 py-3 text-sm text-slate-600">Sarah Johnson</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-800">$149.00</td>
                        <td class="px-5 py-3"><span class="badge-warning">Pending</span></td>
                        <td class="px-5 py-3 text-sm text-slate-400">Jan 14, 2025</td>
                    </tr>
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#INV-001236</td>
                        <td class="px-5 py-3 text-sm text-slate-600">Mike Chen</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-800">$599.00</td>
                        <td class="px-5 py-3"><span class="badge-success">Completed</span></td>
                        <td class="px-5 py-3 text-sm text-slate-400">Jan 14, 2025</td>
                    </tr>
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#INV-001237</td>
                        <td class="px-5 py-3 text-sm text-slate-600">Emma Watson</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-800">$89.00</td>
                        <td class="px-5 py-3"><span class="badge-danger">Cancelled</span></td>
                        <td class="px-5 py-3 text-sm text-slate-400">Jan 13, 2025</td>
                    </tr>
                    <tr class="hover:bg-slate-50/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-slate-700">#INV-001238</td>
                        <td class="px-5 py-3 text-sm text-slate-600">David Kim</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-800">$1,299.00</td>
                        <td class="px-5 py-3"><span class="badge-success">Completed</span></td>
                        <td class="px-5 py-3 text-sm text-slate-400">Jan 12, 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart - Area
        var revenueOptions = {
            series: [{
                name: 'Revenue',
                data: [31, 40, 28, 51, 42, 59, 68, 74, 82, 91, 105, 120]
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Inter, sans-serif'
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2, colors: ['#6366f1'] },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.05,
                    colorStops: [
                        { offset: 0, color: '#6366f1', opacity: 0.3 },
                        { offset: 100, color: '#6366f1', opacity: 0.05 }
                    ]
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: { style: { colors: '#94a3b8', fontSize: '10px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { formatter: (val) => '$' + val + 'k', style: { colors: '#94a3b8', fontSize: '10px' } },
                show: true
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4, show: true },
            tooltip: { y: { formatter: (val) => '$' + val + 'k' } },
            colors: ['#6366f1']
        };
        var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
        revenueChart.render();

        // Traffic Chart - Line
        var trafficOptions = {
            series: [
                { name: 'Visitors', data: [1250, 1320, 1480, 1620, 1890, 2150, 2430], color: '#6366f1' },
                { name: 'Page Views', data: [3200, 3500, 3900, 4300, 4900, 5600, 6200], color: '#f59e0b' }
            ],
            chart: { type: 'line', height: 300, toolbar: { show: false }, zoom: { enabled: false }, fontFamily: 'Inter, sans-serif' },
            stroke: { curve: 'smooth', width: 2 },
            markers: { size: 3, colors: ['#6366f1', '#f59e0b'], strokeColors: '#fff', strokeWidth: 2 },
            xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], labels: { style: { colors: '#94a3b8', fontSize: '10px' } }, axisBorder: { show: false } },
            yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '10px' } } },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            legend: { position: 'top', horizontalAlign: 'right', labels: { colors: '#475569', useSeriesColors: false } },
            tooltip: { shared: true }
        };
        var trafficChart = new ApexCharts(document.querySelector("#trafficChart"), trafficOptions);
        trafficChart.render();

        // Donut Chart
        var donutOptions = {
            series: [45, 35, 20],
            chart: { type: 'donut', height: 240, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            labels: ['Mobile', 'Desktop', 'Tablet'],
            colors: ['#6366f1', '#10b981', '#f59e0b'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: { size: '70%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '11px', color: '#64748b', formatter: () => '100%' } } }
                }
            },
            stroke: { show: false },
            tooltip: { y: { formatter: (val) => val + '%' } }
        };
        var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
        donutChart.render();

        // Horizontal Bar Chart
        var barOptions = {
            series: [{ data: [340, 280, 190, 120, 85] }],
            chart: { type: 'bar', height: 260, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            plotOptions: { bar: { borderRadius: 8, horizontal: true, barHeight: '35%', dataLabels: { position: 'top' } } },
            dataLabels: { enabled: true, formatter: (val) => val + ' sold', offsetX: 10, style: { fontSize: '10px', colors: ['#475569'], fontWeight: '500' } },
            xaxis: { categories: ['Smartphone Pro', 'Laptop Ultra', 'Headphone X', 'Smartwatch', 'Tablet Air'], labels: { style: { fontSize: '11px', colors: '#475569' } }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { style: { fontSize: '11px', fontWeight: 500 } } },
            colors: ['#6366f1'],
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4, xaxis: { lines: { show: true } } },
            tooltip: { y: { formatter: (val) => val + ' units' } }
        };
        var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
        barChart.render();
    });
</script>
@endpush