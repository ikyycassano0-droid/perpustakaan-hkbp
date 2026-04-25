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
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.75rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }
    
    .btn-outline {
        background: transparent;
        padding: 8px 16px;
        border-radius: 30px;
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
    
    /* Section spacing */
    .section {
        margin-top: 40px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            padding: 0.75rem;
            font-size: 0.75rem;
        }
    }
</style>
@endpush


@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
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

                            <div class="sidebar-item active" data-category="all">📚 Semua Referensi</div>
                            <div class="sidebar-item" data-category="kamus">📖 Kamus</div>
                            <div class="sidebar-item" data-category="klinis">🏥 Klinis</div>
                            <div class="sidebar-item" data-category="anatomi">🧬 Anatomi</div>
                            <div class="sidebar-item" data-category="farmakologi">💊 Farmakologi</div>
                            <div class="sidebar-item" data-category="pediatri">👶 Pediatri</div>
                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH -->
                        <div class="mb-6">
                            <input type="text" id="searchInput"
                                class="search-input"
                                placeholder="🔍 Cari buku...">
                        </div>

                        <!-- FEATURED -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8" id="featuredBooks"></div>

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
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- PAGINATION -->
                        <div class="flex justify-between items-center mt-6">
                            <div id="paginationInfo" class="text-sm text-gray-400"></div>
                            <div id="paginationButtons" class="flex gap-2"></div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

</div>
@endsection


@push('scripts')

<script>
// ============================================
// DATA DARI LARAVEL (CRUD READY)
// ============================================

// ambil data dari backend Laravel
let referenceBooks = @json($collections ?? []);

// mapping agar sesuai format JS kamu
referenceBooks = referenceBooks.map(item => ({
    id: item.id,
    title: item.title,
    author: item.author_string ?? (item.author ? item.author.join(', ') : '-'),
    edition: item.edition ?? '-',
    year: item.publication_year ?? '-',
    category: item.category?.slug ?? 'umum',
    categoryName: item.category?.name ?? 'Tidak ada kategori',
    status: item.stock > 0 ? 'tersedia' : 'kosong',
    location: item.location?.name ?? '-',
    returnDate: null,
    description: item.description ?? '-'
}));

// fallback jika kosong
if (referenceBooks.length === 0) {
    referenceBooks = [];
}

// Featured books
let featuredBooks = referenceBooks.slice(0, 4);

// ============================================
// RENDER FEATURED
// ============================================
function renderFeaturedBooks() {
    const container = document.getElementById('featuredBooks');
    container.innerHTML = '';

    featuredBooks.forEach(book => {
        const card = document.createElement('div');
        card.className = 'featured-card p-4';

        card.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="text-3xl">📘</div>
                <div class="flex-1">
                    <h3 class="font-semibold text-indigo-200 text-sm">${book.title}</h3>
                    <p class="text-xs text-gray-400">${book.author}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        ${book.description.substring(0, 80)}...
                    </p>

                    <div class="flex items-center justify-between mt-2">
                        <span class="status-badge status-${book.status}">
                            ${book.status === 'tersedia' ? '✓ TERSEDIA' : '⚡ KOSONG'}
                        </span>

                        <button class="btn-link text-xs" onclick="showDetail(${book.id})">
                            Lihat Detail →
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

// ============================================
// TABLE RENDER (CRUD READY)
// ============================================
let currentPage = 1;
const itemsPerPage = 10;
let currentCategory = 'all';
let searchQuery = '';

function renderTable() {
    let filteredData = [...referenceBooks];

    if (searchQuery) {
        filteredData = filteredData.filter(item =>
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.author.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }

    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item =>
            item.category === currentCategory
        );
    }

    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;

    const currentData = filteredData.slice(startIndex, endIndex);

    document.getElementById('paginationInfo').innerHTML =
        `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, totalItems)} dari ${totalItems} buku referensi`;

    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';

    if (currentData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">
                    📭 Tidak ada data dari database
                </td>
            </tr>
        `;
        return;
    }

    currentData.forEach(book => {
        const row = tbody.insertRow();

        row.insertCell(0).innerHTML = `
            <div class="font-semibold text-indigo-200 text-sm">${book.title}</div>
            <div class="text-xs text-gray-400">${book.author}</div>
        `;

        row.insertCell(1).innerHTML = `
            <div class="text-sm">${book.year}</div>
            <div class="text-xs text-gray-500">${book.edition}</div>
        `;

        row.insertCell(2).innerHTML = `
            <span class="text-xs">${book.categoryName}</span>
        `;

        row.insertCell(3).innerHTML = `
            <span class="status-badge status-${book.status}">
                ${book.status === 'tersedia' ? '✓ TERSEDIA' : '⚡ KOSONG'}
            </span>
        `;

        row.insertCell(4).innerHTML = `
            <button class="btn-primary text-xs" onclick="showDetail(${book.id})">
                Detail
            </button>
        `;
    });

    renderPagination(totalPages);
}

// ============================================
// PAGINATION (TETAP)
// ============================================
function renderPagination(totalPages) {
    const container = document.getElementById('paginationButtons');
    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }

    let html = `<div class="flex gap-2">`;

    html += `
        <button class="pagination-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
            ◀
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button class="pagination-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
            ▶
        </button>
    `;

    html += `</div>`;
    container.innerHTML = html;
}

function changePage(page) {
    currentPage = page;
    renderTable();
}

// ============================================
// DETAIL
// ============================================
function showDetail(id) {
    const book = referenceBooks.find(b => b.id === id);
    if (book) {
        alert(`${book.title}\n${book.author}\nRak: ${book.location}`);
    }
}

// ============================================
// INIT
// ============================================
renderFeaturedBooks();
renderTable();

</script>
@endpush