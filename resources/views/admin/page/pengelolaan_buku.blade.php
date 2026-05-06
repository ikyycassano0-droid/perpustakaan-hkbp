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
            </select>
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
            <div class="flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-white/70"></i>
                <h3 class="font-semibold text-white">Daftar Peminjaman Buku</h3>
            </div>
            <p class="text-slate-300 text-xs mt-0.5">Total: {{ $orders->count() }} peminjaman</p>
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
                <tbody>
                    @forelse($orders as $order)
                    <tr class="order-row border-b border-slate-50 hover:bg-slate-50/30 transition" data-status="{{ $order->status }}">
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
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    <i class="fas fa-check-circle text-[10px]"></i> APPROVED
                                </span>
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
                                <div class="{{ $order->is_late ? 'text-rose-600 font-bold' : 'text-slate-700' }}">
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
                            @else
                                -
                            @endif
                        </td>

                        <!-- DENDA -->
                        <td class="px-4 py-3 text-center">
                            <span class="text-rose-600 font-semibold text-sm">
                                Rp {{ number_format($order->fine ?? 0, 0, ',', '.') }}
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
                                            {{ $order->extension_count >= 3 || $order->is_late ? 'disabled' : '' }}>
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

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Filter berdasarkan status
        $('#filterStatus').change(function() {
            let status = $(this).val();
            if (status === 'all') {
                $('.order-row').show();
            } else {
                $('.order-row').hide();
                $('.order-row[data-status="' + status + '"]').show();
            }
        });

        // Search berdasarkan nama user atau judul buku
        $('#searchOrder').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('.order-row').filter(function() {
                let userName = $(this).find('td:first .font-semibold').text().toLowerCase();
                let bookTitle = $(this).find('td:nth-child(2)').text().toLowerCase();
                $(this).toggle(userName.indexOf(value) > -1 || bookTitle.indexOf(value) > -1);
            });
        });
    });

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