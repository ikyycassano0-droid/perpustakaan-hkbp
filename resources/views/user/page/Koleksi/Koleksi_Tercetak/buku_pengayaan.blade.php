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

    {{-- HERO --}}
    <section class="pt-28 pb-8 text-center px-5">
        <h1 class="text-4xl md:text-5xl font-bold title-main">
            Koleksi Buku Pengayaan
        </h1>
        <p class="text-gray-400 mt-4">
            Eksplorasi wawasan literasi non-klinis
        </p>
    </section>

    {{-- CONTENT --}}
    <section class="max-w-7xl mx-auto px-5 pb-20">

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">

            @forelse($collections as $book)

                <div class="book-card">

                    {{-- COVER --}}
                    <div class="book-cover"
                         style="background-image:url('{{ $book->cover_url }}')">

                        <span class="status-badge {{ $book->available_stock > 0 ? 'status-tersedia' : 'status-dipinjam' }}">
                            {{ $book->available_stock > 0 ? 'TERSEDIA' : 'DIPINJAM' }}
                        </span>

                    </div>

                    {{-- BODY --}}
                    <div class="p-4">

                        <h3 class="text-indigo-200 font-semibold">
                            {{ $book->title }}
                        </h3>

                        <p class="text-xs text-gray-400">
                            {{ $book->author_string }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            📍 {{ $book->location->name ?? '-' }}
                        </p>

                        <p class="text-xs text-indigo-300 mt-2">
                            {{ $book->categories->first()->name ?? 'Umum' }}
                        </p>

                        {{-- BUTTON --}}
                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('user.koleksi.show', $book->id) }}" class="btn-outline w-full text-center">
                                Detail
                            </a>
                            @if($book->available_stock > 0)
                                <button class="btn-primary">
                                    Pinjam
                                </button>
                            @else
                                <button class="btn-outline opacity-50 cursor-not-allowed">
                                    Habis
                                </button>
                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-4 text-center text-gray-400">
                    Belum ada koleksi buku
                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection

@push('scripts')
<script>

// ================= DATA DARI LARAVEL =================
let booksData = @json($collections);

// ================= STATE =================
let currentPage = 1;
const itemsPerPage = 6;
let currentCategory = 'all';
let searchQuery = '';

// ================= RENDER =================
function renderBooks() {

    let filteredData = [...booksData];

    // SEARCH
    if (searchQuery) {
        filteredData = filteredData.filter(item =>
            (item.title ?? '').toLowerCase().includes(searchQuery.toLowerCase()) ||
            (item.author_string ?? '').toLowerCase().includes(searchQuery.toLowerCase())
        );
    }

    // CATEGORY (kalau ada relasi category pertama)
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item =>
            item.categories?.length &&
            item.categories[0].slug === currentCategory
        );
    }

    // PAGINATION
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const currentData = filteredData.slice(start, start + itemsPerPage);

    const grid = document.getElementById('booksGrid');
    grid.innerHTML = '';

    if (currentData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-2 text-center py-12 text-gray-400">
                📭 Tidak ada data buku
            </div>
        `;
        return;
    }

    currentData.forEach(book => {

        let cover = book.cover_url ?? 'https://via.placeholder.com/200x180';
        let status = (book.available_stock > 0);

        grid.innerHTML += `
            <div class="book-card">

                <div class="book-cover"
                    style="background-image:url('${cover}')">

                    <span class="status-badge ${status ? 'status-tersedia' : 'status-dipinjam'}">
                        ${status ? 'TERSEDIA' : 'DIPINJAM'}
                    </span>

                </div>

                <div class="p-4">

                    <span class="text-xs text-indigo-300">
                        ${book.categories?.[0]?.name ?? 'Umum'}
                    </span>

                    <h3 class="font-semibold text-indigo-200 mt-1">
                        ${book.title ?? '-'}
                    </h3>

                    <p class="text-xs text-gray-400">
                        ${book.author_string ?? '-'}
                    </p>

                    <p class="text-xs text-gray-500">
                        📍 ${book.location?.name ?? '-'}
                    </p>

                    <div class="flex gap-2 mt-3">

                        <button class="btn-outline flex-1" onclick="showDetail(${book.id})">
                            Detail
                        </button>

                        ${status ? `
                            <button class="btn-primary" onclick="pinjamBuku(${book.id})">
                                Pinjam
                            </button>
                        ` : `
                            <button class="btn-outline opacity-50" disabled>
                                Habis
                            </button>
                        `}

                    </div>

                </div>
            </div>
        `;
    });

    renderPagination(totalPages);
}

// ================= PAGINATION =================
function renderPagination(totalPages) {

    const el = document.getElementById('paginationButtons');
    if (!el) return;

    if (totalPages <= 1) {
        el.innerHTML = '';
        return;
    }

    let html = '';

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    el.innerHTML = html;
}

function changePage(page) {
    currentPage = page;
    renderBooks();
}

// ================= SEARCH =================
document.addEventListener('input', function(e){
    if (e.target.id === 'searchInput') {
        searchQuery = e.target.value;
        currentPage = 1;
        renderBooks();
    }
});

// ================= DETAIL =================
function showDetail(id) {
    let book = booksData.find(b => b.id === id);
    alert(book?.title ?? 'Tidak ditemukan');
}

// ================= PINJAM =================
function pinjamBuku(id) {
    let book = booksData.find(b => b.id === id);
    alert('Pinjam: ' + (book?.title ?? ''));
}

// ================= INIT =================
renderBooks();

</script>
@endpush