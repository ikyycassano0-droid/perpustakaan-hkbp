@extends('user.components.master')

@section('title', 'Sistem Pinbal Akademik - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN PINBAL
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.3s ease;
    }
    
    /* Title utama */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }
    
    /* Neon border */
    .neon-border {
        position: relative;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        transition: all 0.3s ease;
    }
    
    .neon-border:hover {
        box-shadow: 0 0 30px rgba(99,102,241,0.3);
    }
    
    .neon-inner {
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }
    
    /* Stat Card */
    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.3);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }
    
    /* Search Input */
    .search-input {
        width: 100%;
        padding: 12px 20px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 40px;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }
    
    .search-input::placeholder {
        color: #64748b;
    }
    
    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 1rem;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        text-align: left;
        padding: 1rem 1rem;
        background: rgba(99, 102, 241, 0.15);
        color: #c7d2fe;
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .data-table td {
        padding: 1rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
        font-size: 0.9rem;
        vertical-align: middle;
    }
    
    .data-table tr:hover {
        background: rgba(99, 102, 241, 0.08);
    }
    
    /* Book Image */
    .book-image {
        width: 50px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }
    
    .book-image:hover {
        transform: scale(1.1);
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-dipinjam {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.5);
    }
    
    .status-dikembalikan {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.5);
    }
    
    .status-terlambat {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }
    
    .btn-outline {
        background: transparent;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.85rem;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    /* Pagination */
    .pagination-btn {
        padding: 8px 14px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 8px;
        color: #c7d2fe;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .pagination-btn:hover:not(:disabled) {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Membership Badge */
    .membership-active {
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }
    
    /* Notification */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.5);
        border-radius: 12px;
        color: white;
        z-index: 1000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    /* Section spacing */
    .section {
        margin-top: 40px;
    }
</style>
@endpush

@section('content')
@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Sistem Pinbal Akademik
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kelola riwayat peminjaman buku perpustakaan Anda dengan presisi.
        </p>
    </section>


    <!-- STATISTIK SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📖</div>
                <div class="stat-number">{{ $aktifDipinjam ?? 0 }}</div>
                <div class="text-xs text-gray-400 mt-1">Aktif Dipinjam</div>
            </div>

            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">⏰</div>
                <div class="stat-number">{{ $mendekatiDeadline ?? 0 }}</div>
                <div class="text-xs text-gray-400 mt-1">Mendekati Deadline</div>
            </div>

            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📚</div>
                <div class="stat-number">{{ $totalRiwayat ?? 0 }}</div>
                <div class="text-xs text-gray-400 mt-1">Total Riwayat</div>
            </div>

            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">🎓</div>
                <div class="membership-active mx-auto">AKTIF</div>
                <div class="text-xs text-gray-400 mt-2">Status Keanggotaan</div>
            </div>

        </div>
    </section>


    <!-- TABLE SECTION (READY CRUD) -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- SEARCH -->
                <div class="mb-6">
                    <input type="text" id="searchInput"
                        class="search-input"
                        placeholder="🔍 Cari judul buku atau kode...">
                </div>

                <!-- FILTER -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <button class="btn-primary" data-filter="all">Semua</button>
                    <button class="btn-outline" data-filter="dipinjam">Dipinjam</button>
                    <button class="btn-outline" data-filter="dikembalikan">Dikembalikan</button>
                    <button class="btn-outline" data-filter="terlambat">Terlambat</button>
                </div>


                <!-- TABLE -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>📖 BUKU</th>
                                <th>📅 PINJAM</th>
                                <th>⏰ KEMBALI</th>
                                <th>📌 STATUS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($loans as $item)
                                <tr>

                                    <!-- BOOK -->
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $item->book_image ?? 'https://placehold.co/100x130' }}"
                                                 class="book-image">

                                            <div>
                                                <div class="font-semibold">
                                                    {{ $item->book_title }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $item->book_code }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- TANGGAL PINJAM -->
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}
                                    </td>

                                    <!-- BATAS -->
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->return_date)->format('d M Y') }}

                                        @if($item->status === 'dipinjam')
                                            <div class="text-xs text-gray-400">
                                                {{ $item->days_left }} hari lagi
                                            </div>
                                        @endif
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @if($item->status == 'dipinjam')
                                            <span class="status-badge status-dipinjam">📘 DIPINJAM</span>

                                        @elseif($item->status == 'dikembalikan')
                                            <span class="status-badge status-dikembalikan">✅ DIKEMBALIKAN</span>

                                        @else
                                            <span class="status-badge status-terlambat">⚠️ TERLAMBAT</span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-400">
                                        📭 Tidak ada data peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <!-- PAGINATION (READY CRUD) -->
                <div class="flex justify-between items-center mt-6">

                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $loans->firstItem() ?? 0 }}
                        -
                        {{ $loans->lastItem() ?? 0 }}
                        dari {{ $loans->total() ?? 0 }} data
                    </div>

                    <div class="flex gap-2">
                        {{ $loans->links() }}
                    </div>

                </div>

            </div>
        </div>
    </section>


    <!-- ACTION BUTTON -->
    <section class="section max-w-6xl mx-auto px-5 mb-16">
        <div class="flex flex-wrap justify-center gap-4">

            <button class="btn-primary">
                📖 Pinjam Buku
            </button>

            <button class="btn-outline">
                ↺ Kembalikan
            </button>

            <button class="btn-outline">
                🔄 Perpanjang
            </button>

        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// PINBAL JS (ENHANCEMENT ONLY - CRUD READY)
// ============================================

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    const filterButtons = document.querySelectorAll('[data-filter]');

    let activeFilter = 'all';


    // =========================
    // SEARCH FUNCTION
    // =========================
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const value = this.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();

                if (text.includes(value)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }


    // =========================
    // FILTER FUNCTION
    // =========================
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {

            const filter = this.getAttribute('data-filter');
            activeFilter = filter;

            // button style toggle
            filterButtons.forEach(b => {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline');
            });

            this.classList.remove('btn-outline');
            this.classList.add('btn-primary');


            // filter table
            tableRows.forEach(row => {

                const statusCell = row.querySelector('td:last-child');

                if (!statusCell) return;

                const statusText = statusCell.innerText.toLowerCase();

                if (filter === 'all') {
                    row.style.display = '';
                }
                else if (filter === 'dipinjam' && statusText.includes('dipinjam')) {
                    row.style.display = '';
                }
                else if (filter === 'dikembalikan' && statusText.includes('dikembalikan')) {
                    row.style.display = '';
                }
                else if (filter === 'terlambat' && statusText.includes('terlambat')) {
                    row.style.display = '';
                }
                else {
                    row.style.display = 'none';
                }
            });
        });
    });


    // =========================
    // NOTIFICATION SYSTEM
    // =========================
    window.showNotification = function (message, type = 'info') {

        const notif = document.createElement('div');
        notif.className = 'notification';

        let icon = 'ℹ️';
        if (type === 'success') icon = '✅';
        if (type === 'error') icon = '❌';
        if (type === 'warning') icon = '⚠️';

        notif.innerHTML = `
            <div class="flex items-center gap-2">
                <span>${icon}</span>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notif);

        setTimeout(() => notif.classList.add('show'), 100);

        setTimeout(() => {
            notif.classList.remove('show');
            setTimeout(() => notif.remove(), 300);
        }, 2500);
    };


    // =========================
    // ACTION BUTTONS (CRUD READY)
    // =========================
    const pinjamBtn = document.querySelector('.btn-primary');
    const kembalikanBtn = document.querySelectorAll('.btn-outline')[0];
    const perpanjangBtn = document.querySelectorAll('.btn-outline')[1];


    if (pinjamBtn) {
        pinjamBtn.addEventListener('click', () => {
            showNotification('📖 Fitur pinjam buku akan diarahkan ke form create', 'info');
        });
    }

    if (kembalikanBtn) {
        kembalikanBtn.addEventListener('click', () => {
            showNotification('↺ Pilih data untuk proses pengembalian', 'info');
        });
    }

    if (perpanjangBtn) {
        perpanjangBtn.addEventListener('click', () => {
            showNotification('🔄 Perpanjangan akan diproses via sistem admin', 'info');
        });
    }

});

</script>
@endpush