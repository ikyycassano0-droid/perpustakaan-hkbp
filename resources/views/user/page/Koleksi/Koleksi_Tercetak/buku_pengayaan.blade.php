@extends('user.component.master')

@section('title', 'Koleksi Buku Pengayaan - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI BUKU PENGAYAAN
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
    
    /* Filter button */
    .filter-btn {
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        color: #cbd5e1;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }
    
    .filter-btn:hover {
        border-color: #6366f1;
        color: white;
    }
    
    /* Book Card */
    .book-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }
    
    .book-cover {
        height: 180px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-tersedia {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }
    
    .status-dipinjam {
        background: rgba(245, 158, 11, 0.9);
        color: white;
    }
    
    .rating {
        color: #fbbf24;
        font-size: 0.8rem;
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
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 16px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.75rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }
    
    .btn-outline {
        background: transparent;
        padding: 8px 16px;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.75rem;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    .btn-outline:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
    
    /* Section spacing */
    .section {
        margin-top: 40px;
    }
    
    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    
    /* Sidebar responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
    }
</style>
@endpush
@section('content')

<div class="main-content">

    {{-- 🔥 NOTIFICATION --}}
    @if(session('success'))
        <div id="notif" class="notification">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="notif" class="notification" style="border-color:red">
            {{ session('error') }}
        </div>
    @endif

    {{-- HERO --}}
    <section class="pt-28 pb-8 text-center px-5">
        <h1 class="text-4xl md:text-5xl font-bold title-main">
            Koleksi Buku Pengayaan
        </h1>
        <p class="text-gray-400 mt-4">
            Eksplorasi wawasan literasi non-klinis
        </p>
    </section>

    {{-- GRID --}}
    <section class="max-w-7xl mx-auto px-5 pb-20">

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">

            @forelse($collections as $book)

                @php
                    $hasPending = false;

                    if(auth()->check()) {
                        $hasPending = \App\Models\Order::where('user_id', auth()->id())
                            ->where('status', 'PENDING')
                            ->whereHas('details', function($q) use ($book) {
                                $q->where('collection_id', $book->id);
                            })
                            ->exists();
                    }
                @endphp

                <div class="book-card">

                    <div class="book-cover"
                         style="background-image:url('{{ $book->cover_url ?? asset('images/no-image.png') }}')">

                        <span class="status-badge {{ $book->available_stock > 0 ? 'status-tersedia' : 'status-dipinjam' }}">
                            {{ $book->available_stock > 0 ? 'TERSEDIA' : 'DIPINJAM' }}
                        </span>

                    </div>

                    <div class="p-4">

                        <h3 class="font-semibold text-indigo-200">
                            {{ $book->title }}
                        </h3>

                        <p class="text-xs text-gray-400">
                            {{ $book->author_string }}
                        </p>

                        <div class="flex gap-2 mt-3">

                            <a href="{{ route('user.koleksi.show', $book->id) }}"
                               class="btn-outline flex-1 text-center">
                                Detail
                            </a>

                            @auth
                                @if($hasPending)
                                    <button class="btn-outline flex-1 opacity-50" disabled>
                                        Diproses
                                    </button>

                                @elseif($book->available_stock > 0)
                                    <button onclick="openModal({{ $book->id }}, '{{ $book->title }}')"
                                            class="btn-primary flex-1">
                                        Pinjam
                                    </button>

                                @else
                                    <button class="btn-outline flex-1 opacity-50" disabled>
                                        Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-primary flex-1 text-center">
                                    Login
                                </a>
                            @endauth

                        </div>

                    </div>

                </div>

            @empty
                <div class="col-span-4 text-center text-gray-400 py-10">
                    📭 Tidak ada data buku
                </div>
            @endforelse

        </div>

    </section>

</div>

{{-- ================= MODAL PINJAM ================= --}}
<div id="pinjamModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">

    <div class="bg-slate-900 w-full max-w-md rounded-2xl border border-indigo-500/30 p-6">

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
    modal.classList.remove('hidden');

    document.getElementById('collection_id').value = id;
    document.getElementById('book_title').value = title;

    const today = new Date();
    today.setHours(0,0,0,0);

    const borrowInput = document.getElementById('borrow_date');
    const returnInput = document.getElementById('return_date');

    // 🔥 RESET VALUE DULU
    borrowInput.value = '';
    returnInput.value = '';

    // set ulang
    borrowInput.min = formatDate(today);
    borrowInput.value = formatDate(today);

    const minReturn = new Date(today);
    minReturn.setDate(minReturn.getDate() + 1);

    const maxReturn = new Date(today);
    maxReturn.setDate(maxReturn.getDate() + 7);

    returnInput.min = formatDate(minReturn);
    returnInput.max = formatDate(maxReturn);
    returnInput.value = formatDate(minReturn);

    console.log("TODAY:", formatDate(today));
}

// ================= CLOSE MODAL =================
function closeModal() {
    document.getElementById('pinjamModal').classList.add('hidden');
}

// klik luar modal
document.addEventListener('click', function(e){
    const modal = document.getElementById('pinjamModal');
    if (e.target === modal) closeModal();
});

// ================= UPDATE RETURN DINAMIS =================
document.addEventListener('change', function(e){

    if (e.target.id === 'borrow_date') {

        const borrow = new Date(e.target.value);
        borrow.setHours(0,0,0,0);

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
document.addEventListener('submit', function(e){

    if (e.target.id === 'pinjamForm') {

        const borrow = new Date(document.getElementById('borrow_date').value);
        const ret = new Date(document.getElementById('return_date').value);

        borrow.setHours(0,0,0,0);
        ret.setHours(0,0,0,0);

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

        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerText = 'Memproses...';
        btn.disabled = true;
    }
});

</script>
@endpush