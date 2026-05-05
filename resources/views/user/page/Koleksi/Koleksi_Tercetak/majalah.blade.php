@extends('user.component.master')

@section('title', 'Koleksi Majalah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI MAJALAH
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
        display: block;
        text-decoration: none;
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
    
    /* Stat Card */
    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.6);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }
    
    /* Magazine Card */
    .magazine-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .magazine-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }
    
    .magazine-cover {
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .featured-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    /* Featured Hero Card */
    .hero-magazine {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 1.5rem;
        overflow: hidden;
    }
    
    /* Category List */
    .category-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: rgba(15, 23, 42, 0.6);
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-item:hover {
        background: rgba(99, 102, 241, 0.15);
        transform: translateX(5px);
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
    
    /* Accreditation Badge */
    .accreditation-badge {
        display: inline-block;
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    /* Status Badge */
    .status-tersedia {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.5);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
    }
    
    .status-diproses {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.5);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
    }
    
    .status-habis {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
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
    
    /* Action Buttons */
    .card-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
        .btn-primary, .btn-outline {
            padding: 4px 10px;
            font-size: 0.65rem;
        }
    }
</style>
@endpush

@section('content')

<div class="main-content">

    <!-- HERO -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📰 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Koleksi Majalah
        </h1>
    </section>

    <!-- CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">

        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Kategori</div>

                            <a href="#" class="sidebar-item">📰 Semua Majalah</a>
                            <a href="#" class="sidebar-item">🔬 Riset Keperawatan</a>
                            <a href="#" class="sidebar-item">🏥 Klinis & Bedah</a>
                        </div>
                    </div>

                    <!-- GRID -->
                    <div class="lg:col-span-3">

                        <form method="GET" class="mb-6">
                            <input type="text" name="search" class="search-input"
                                   placeholder="🔍 Cari majalah...">
                        </form>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                            @forelse ($collections as $item)
                                @php
                                    $hasPending = in_array($item->id, $pendingCollectionIds ?? []);
                                @endphp

                                <div class="magazine-card">

                                    <div class="magazine-cover"
                                         style="background-image: url('{{ asset('storage/'.$item->cover_image) }}')">
                                    </div>

                                    <div class="p-4">

                                        <div class="flex justify-between mb-2">
                                            <span class="text-xs text-indigo-300">
                                                {{ $item->category ?? '-' }}
                                            </span>

                                            <span class="text-xs text-gray-500">
                                                {{ $item->created_at->format('d M Y') }}
                                            </span>
                                        </div>

                                        <h3 class="font-semibold text-indigo-200 text-sm">
                                            {{ $item->title }}
                                        </h3>

                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500">
                                                📚 Stok: {{ $item->stock }}
                                            </span>

                                            @if($item->stock > 0)
                                                <span class="status-tersedia">✓ Tersedia</span>
                                            @else
                                                <span class="status-habis">✗ Habis</span>
                                            @endif
                                        </div>

                                        <div class="card-actions">
                                            <a href="{{ route('user.koleksi.show', $item->id) }}" class="btn-link text-xs">
                                                Detail →
                                            </a>

                                            @auth
                                                @if($hasPending)
                                                    <button class="btn-outline" disabled style="flex:1; text-align:center;">
                                                        Diproses
                                                    </button>
                                                @elseif($item->stock > 0)
                                                    <button onclick="openModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                                                            class="btn-primary" style="flex:1; text-align:center;">
                                                        Pinjam
                                                    </button>
                                                @else
                                                    <button class="btn-outline" disabled style="flex:1; text-align:center;">
                                                        Habis
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn-primary" style="flex:1; text-align:center;">
                                                    Login
                                                </a>
                                            @endauth
                                        </div>

                                    </div>

                                </div>

                            @empty
                                <div class="col-span-3 text-center text-gray-400 py-10">
                                    📭 Data majalah belum tersedia
                                </div>
                            @endforelse

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
                <label class="text-xs text-gray-400">Judul Majalah</label>
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

    const maxReturn = new Date(today);
    maxReturn.setDate(maxReturn.getDate() + 7);

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
        const maxReturn = new Date(borrow);
        maxReturn.setDate(maxReturn.getDate() + 7);

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

        if (diff > 7) {
            alert('Maksimal peminjaman hanya 7 hari');
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
// NOTIFICATION
// ============================================
function showNotification(message, type = 'success') {
    const n = document.createElement('div');
    n.className = 'notification show';
    n.innerHTML = message;
    document.body.appendChild(n);

    setTimeout(() => {
        n.remove();
    }, 2500);
}

console.log('Majalah page ready with pinjam feature');

</script>
@endpush