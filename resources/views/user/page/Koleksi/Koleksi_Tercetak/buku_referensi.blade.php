@extends('user.component.master')

@section('title', 'Koleksi Buku Referensi - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN BUKU REFERENSI
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
    
    /* Search input */
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
    
    /* Sidebar Menu */
    .sidebar-menu {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
    }
    
    .sidebar-item {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        color: #cbd5e1;
        font-size: 0.85rem;
    }
    
    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.15);
        color: white;
        padding-left: 24px;
    }
    
    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        color: #a5b4fc;
        border-left: 3px solid #6366f1;
    }
    
    .sidebar-title {
        font-weight: 700;
        color: #c7d2fe;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    /* Featured Book Card */
    .featured-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }
    
    .featured-card:hover {
        border-color: rgba(99, 102, 241, 0.7);
        transform: translateY(-3px);
    }
    
    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 1rem;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .data-table th {
        text-align: left;
        padding: 1rem 1rem;
        background: rgba(99, 102, 241, 0.15);
        color: #c7d2fe;
        font-weight: 600;
        font-size: 0.8rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .data-table td {
        padding: 1rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .data-table tr:hover {
        background: rgba(99, 102, 241, 0.08);
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-tersedia {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.5);
    }
    
    .status-dipinjam {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.5);
    }
    
    .status-kosong {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.7rem;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }
    
    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-outline {
        background: transparent;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.7rem;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    .btn-outline:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .btn-link {
        background: transparent;
        border: none;
        color: #a5b4fc;
        cursor: pointer;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .btn-link:hover {
        color: #818cf8;
        text-decoration: underline;
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
    
    .pagination-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
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
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(12px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
        visibility: visible;
        opacity: 1;
    }
    
    .modal-container {
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(99, 102, 241, 0.5);
        border-radius: 1.5rem;
        width: 100%;
        max-width: 28rem;
        margin: 1rem;
        transform: scale(0.9);
        transition: transform 0.3s ease;
    }
    
    .modal-overlay.active .modal-container {
        transform: scale(1);
    }
    
    /* Section spacing */
    .section {
        margin-top: 40px;
    }
    
    /* Kolom aksi dibuat tetap tidak pecah */
    .data-table th:last-child,
    .data-table td:last-child {
        white-space: nowrap;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
        .data-table th, 
        .data-table td {
            padding: 0.75rem;
            font-size: 0.75rem;
        }
        .btn-primary, .btn-outline {
            padding: 4px 8px;
            font-size: 0.65rem;
        }
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📚 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Koleksi Buku Referensi
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses ke sumber daya medis otoritatif untuk menunjang pembelajaran akademik.
        </p>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">

        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR -->
                    <div class="lg:col-span-1">

                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Koleksi Referensi</div>

                            <div class="sidebar-item active">📚 Semua Referensi</div>
                            <div class="sidebar-item">📖 Kamus</div>
                            <div class="sidebar-item">🏥 Klinis</div>
                            <div class="sidebar-item">🧬 Anatomi</div>
                            <div class="sidebar-item">💊 Farmakologi</div>
                            <div class="sidebar-item">👶 Pediatri</div>
                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH -->
                        <form method="GET" class="mb-6">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="search-input"
                                   placeholder="🔍 Cari buku...">
                        </form>

                        <!-- FEATURED (ambil 4 pertama dari pagination data) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

                            @foreach($collections->take(4) as $item)
                                @php
                                    $borrowStatus = $userBorrowStatus[$item->id] ?? null;
                                @endphp
                                <div class="featured-card p-4">

                                    <div class="flex items-start gap-3">
                                        <div class="text-3xl">📘</div>

                                        <div class="flex-1">
                                            <h3 class="font-semibold text-indigo-200 text-sm">
                                                {{ $item->title }}
                                            </h3>

                                            <p class="text-xs text-gray-400">
                                                {{ $item->author_string }}
                                            </p>

                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ \Illuminate\Support\Str::limit($item->description ?? '', 80) }}
                                            </p>

                                            <div class="flex items-center justify-between mt-2">

                                                <span class="status-badge {{ $item->available_stock > 0 ? 'status-tersedia' : 'status-kosong' }}">
                                                    {{ $item->available_stock > 0 ? '✓ TERSEDIA' : '⚡ KOSONG' }}
                                                </span>

                                                @auth
                                                    @if($borrowStatus && in_array($borrowStatus['status'], ['PENDING', 'APPROVED']))
                                                        <button class="btn-outline text-xs" style="padding: 4px 10px;" disabled>
                                                            {{ $borrowStatus['status'] == 'PENDING' ? 'Diproses' : 'Dipinjam' }}
                                                        </button>
                                                    @elseif($item->available_stock > 0)
                                                        <button onclick="openModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                                                                class="btn-primary text-xs" style="padding: 4px 10px;">
                                                            Pinjam
                                                        </button>
                                                    @else
                                                        <button class="btn-outline text-xs" style="padding: 4px 10px;" disabled>
                                                            Habis
                                                        </button>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="btn-primary text-xs" style="padding: 4px 10px;">
                                                        Login
                                                    </a>
                                                @endauth

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <!-- TABLE -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-indigo-200 mb-4">
                                📋 Daftar Buku Referensi
                            </h3>

                            <div class="table-container">
                                <table class="data-table">

                                    <thead>
                                        <tr>
                                            <th>INFORMASI</th>
                                            <th>TAHUN</th>
                                            <th>KATEGORI</th>
                                            <th>STATUS</th>
                                            <th style="width: 85px;">DETAIL</th>
                                            <th style="width: 85px;">PINJAM</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($collections as $item)
                                        @php
                                            $borrowStatus = $userBorrowStatus[$item->id] ?? null;
                                        @endphp
                                        <tr>

                                            <!-- INFORMASI -->
                                            <td>
                                                <div class="font-semibold text-indigo-200 text-sm">
                                                    {{ $item->title }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $item->author_string }}
                                                </div>
                                            </td>

                                            <!-- TAHUN -->
                                            <td>
                                                <div class="text-sm">
                                                    {{ $item->publication_year ?? '-' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $item->edition ?? '-' }}
                                                </div>
                                            </td>

                                            <!-- KATEGORI -->
                                            <td>
                                                <span class="text-xs text-gray-300">
                                                    {{ $item->categories->first()->name ?? 'Umum' }}
                                                </span>
                                            </td>

                                            <!-- STATUS -->
                                            <td>
                                                <span class="status-badge {{ $item->available_stock > 0 ? 'status-tersedia' : 'status-kosong' }}">
                                                    {{ $item->available_stock > 0 ? '✓ TERSEDIA' : '⚡ KOSONG' }}
                                                </span>
                                            </td>

                                            <!-- DETAIL -->
                                            <td>
                                                <a href="{{ route('user.koleksi.detail', $item->id) }}"
                                                   class="btn-primary">
                                                    Detail
                                                </a>
                                            </td>

                                            <!-- PINJAM -->
                                            <td>
                                                @auth
                                                    @if($borrowStatus && in_array($borrowStatus['status'], ['PENDING', 'APPROVED']))
                                                        @if($borrowStatus['status'] == 'PENDING')
                                                            <button class="btn-outline" disabled>
                                                                Diproses
                                                            </button>
                                                        @else
                                                            <button class="btn-outline" disabled>
                                                                Dipinjam
                                                            </button>
                                                        @endif
                                                    @elseif($item->available_stock > 0)
                                                        <button onclick="openModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                                                                class="btn-primary">
                                                            Pinjam
                                                        </button>
                                                    @else
                                                        <button class="btn-outline" disabled>
                                                            Habis
                                                        </button>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="btn-primary">
                                                        Login
                                                    </a>
                                                @endauth
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-8 text-gray-400">
                                                📭 Data tidak ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <!-- PAGINATION LARAVEL -->
                        <div class="flex justify-center mt-6">
                            {{ $collections->withQueryString()->links() }}
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>

</div>

{{-- ================= MODAL PINJAM ================= --}}
<div id="pinjamModal" class="modal-overlay">
    <div class="modal-container p-6">

        <h2 class="text-xl font-bold text-indigo-300 mb-4">
            Form Peminjaman
        </h2>

        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf

            <input type="hidden" name="collection_id" id="collection_id">

            <div class="mb-3">
                <label class="text-xs text-gray-400">Judul Buku</label>
                <input type="text" id="book_title"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       readonly>
            </div>

            <div class="mb-3">  
                <label class="text-xs text-gray-400">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       required>
            </div>

            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Kembali</label>
                <input type="date" name="return_date" id="return_date"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       required>
            </div>

            <div class="flex gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="w-full py-2 rounded bg-gray-700 text-white">
                    Batal
                </button>

                <button type="submit"
                        id="submitPinjamBtn"
                        class="w-full py-2 rounded bg-indigo-600 text-white font-semibold">
                    Pinjam
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>

// ================= FORMAT DATE =================
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// ================= OPEN MODAL =================
function openModal(id, title) {
    const modal = document.getElementById('pinjamModal');
    modal.classList.add('active');

    document.getElementById('collection_id').value = id;
    document.getElementById('book_title').value = title;

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const borrowInput = document.getElementById('borrow_date');
    const returnInput = document.getElementById('return_date');

    // Reset value
    borrowInput.value = '';
    returnInput.value = '';

    // Set borrow date = hari ini
    borrowInput.min = formatDate(today);
    borrowInput.value = formatDate(today);

    const minReturn = new Date(today);
    minReturn.setDate(minReturn.getDate() + 1);

    // ✅ MAKSIMAL 3 HARI
    const maxReturn = new Date(today);
    maxReturn.setDate(maxReturn.getDate() + 3);

    returnInput.min = formatDate(minReturn);
    returnInput.max = formatDate(maxReturn);
    returnInput.value = formatDate(minReturn);
}

// ================= CLOSE MODAL =================
function closeModal() {
    const modal = document.getElementById('pinjamModal');
    modal.classList.remove('active');
    
    // Reset form
    document.getElementById('pinjamForm').reset();
    
    // Enable submit button
    const submitBtn = document.getElementById('submitPinjamBtn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Pinjam';
    }
}

// Klik luar modal untuk menutup
document.addEventListener('click', function(e) {
    const modal = document.getElementById('pinjamModal');
    if (e.target === modal) {
        closeModal();
    }
});

// ================= UPDATE RETURN DINAMIS =================
document.addEventListener('change', function(e) {
    if (e.target.id === 'borrow_date') {
        const borrow = new Date(e.target.value);
        borrow.setHours(0, 0, 0, 0);

        const returnInput = document.getElementById('return_date');
        const minReturn = new Date(borrow);
        minReturn.setDate(minReturn.getDate() + 1);
        
        // ✅ MAKSIMAL 3 HARI
        const maxReturn = new Date(borrow);
        maxReturn.setDate(maxReturn.getDate() + 3);

        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);

        const currentReturn = new Date(returnInput.value);
        if (currentReturn < minReturn || currentReturn > maxReturn) {
            returnInput.value = formatDate(minReturn);
        }
    }
});

// ================= VALIDASI SUBMIT =================
document.addEventListener('submit', function(e) {
    if (e.target.id === 'pinjamForm') {
        const borrow = new Date(document.getElementById('borrow_date').value);
        const ret = new Date(document.getElementById('return_date').value);

        borrow.setHours(0, 0, 0, 0);
        ret.setHours(0, 0, 0, 0);

        const diff = (ret - borrow) / (1000 * 60 * 60 * 24);

        if (diff < 1) {
            alert('Minimal peminjaman 1 hari');
            e.preventDefault();
            return;
        }

        // ✅ CEK MAKSIMAL 3 HARI
        if (diff > 3) {
            alert('Maksimal peminjaman hanya 3 hari');
            e.preventDefault();
            return;
        }

        const btn = document.getElementById('submitPinjamBtn');
        if (btn) {
            btn.innerText = 'Memproses...';
            btn.disabled = true;
        }
    }
});

// ============================================
// NOTIFICATION AUTO CLOSE
// ============================================
setTimeout(function() {
    const notif = document.getElementById('notif');
    if (notif) {
        notif.classList.add('show');
        setTimeout(function() {
            notif.style.transform = 'translateX(120%)';
        }, 4000);
    }
}, 100);

console.log('📚 Buku Referensi page loaded (Maksimal pinjam 3 hari)');

</script>
@endpush