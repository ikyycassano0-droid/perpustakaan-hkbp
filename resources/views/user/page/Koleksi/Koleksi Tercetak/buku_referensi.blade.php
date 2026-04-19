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
            Akses ke sumber daya medis otoritatif termasuk ensiklopedia klinis modern, kamus medis, dan panduan teknis keperawatan untuk menunjang studi akademik Anda.
        </p>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    
                    <!-- SIDEBAR KATEGORI -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Koleksi Referensi</div>
                            <div class="sidebar-item active" data-category="all">📚 Semua Referensi</div>
                            <div class="sidebar-item" data-category="kamus">📖 Kamus & Ensiklopedia</div>
                            <div class="sidebar-item" data-category="klinis">🏥 Panduan Klinis</div>
                            <div class="sidebar-item" data-category="anatomi">🧬 Anatomi & Fisiologi</div>
                            <div class="sidebar-item" data-category="farmakologi">💊 Farmakologi</div>
                            <div class="sidebar-item" data-category="pediatri">👶 Keperawatan Anak</div>
                            <div class="sidebar-item" data-category="keperawatan">👩‍⚕️ Keperawatan Umum</div>
                        </div>
                        
                        <!-- KOLEKSI LAINNYA -->
                        <div class="sidebar-menu mt-6">
                            <div class="sidebar-title">📖 Koleksi Lainnya</div>
                            <div class="sidebar-item" data-collection="buku-pengayaan">📘 Buku Pengayaan</div>
                            <div class="sidebar-item" data-collection="majalah">📰 Majalah</div>
                            <div class="sidebar-item" data-collection="e-book">📱 E-book</div>
                            <div class="sidebar-item" data-collection="e-article">📄 E-article</div>
                            <div class="sidebar-item" data-collection="cd">💿 CD</div>
                            <div class="sidebar-item" data-collection="video">🎬 Video</div>
                            <div class="sidebar-item" data-collection="kti">📑 Karya Tulis Ilmiah</div>
                        </div>
                    </div>
                    
                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">
                        
                        <!-- Search Bar -->
                        <div class="mb-6">
                            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul, penulis, atau nomor panggil...">
                        </div>
                        
                        <!-- FEATURED BOOKS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8" id="featuredBooks">
                            <!-- Featured books will be inserted here -->
                        </div>
                        
                        <!-- TABLE SECTION -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-indigo-200 mb-4">📋 Daftar Lengkap Koleksi Referensi</h3>
                            <div class="table-container">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>📖 INFORMASI BUKU</th>
                                            <th>📅 TAHUN / EDISI</th>
                                            <th>🏷️ KATEGORI</th>
                                            <th>📌 STATUS</th>
                                            <th>⚡ AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <!-- Table rows will be inserted by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Pagination Info & Buttons -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                            <div class="text-sm text-gray-400" id="paginationInfo">
                                Menampilkan 1-10 dari 48 buku referensi
                            </div>
                            <div class="flex gap-2" id="paginationButtons">
                                <!-- Pagination buttons will be inserted here -->
                            </div>
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
// JAVASCRIPT KHUSUS UNTUK HALAMAN BUKU REFERENSI
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA BUKU REFERENSI
let referenceBooks = [
    {
        id: 1,
        title: "Dorland's Illustrated Medical Dictionary",
        author: "Dorland",
        edition: "Edisi 33",
        year: 2023,
        category: "kamus",
        categoryName: "Kamus & Ensiklopedia",
        status: "tersedia",
        location: "Rak A-12",
        description: "Referensi standar internasional untuk terminologi medis dengan ilustrasi lengkap."
    },
    {
        id: 2,
        title: "Manual of Nursing Practice",
        author: "Lippincott",
        edition: "Edisi 11",
        year: 2022,
        category: "klinis",
        categoryName: "Panduan Klinis",
        status: "dipinjam",
        location: "Rak B-03",
        returnDate: "12 Desember 2024",
        description: "Handbook klinis utama untuk praktik keperawatan profesional."
    },
    {
        id: 3,
        title: "Miller-Keane Encyclopedia & Dictionary of Medicine",
        author: "Miller & Keane",
        edition: "Edisi 28",
        year: 2021,
        category: "kamus",
        categoryName: "Kamus & Ensiklopedia",
        status: "tersedia",
        location: "Rak A-15",
        description: "Sumber referensi terlengkap untuk terminologi medis dan praktik klinis keperawatan modern."
    },
    {
        id: 4,
        title: "MIMS Drug Reference 2024",
        author: "MIMS Indonesia",
        edition: "Edisi 28",
        year: 2024,
        category: "farmakologi",
        categoryName: "Farmakologi",
        status: "tersedia",
        location: "Rak D-05",
        description: "Katalog obat-obatan terintegrasi untuk praktik klinis."
    },
    {
        id: 5,
        title: "Gray's Anatomy for Students",
        author: "Richard Drake, et al.",
        edition: "Edisi 4",
        year: 2023,
        category: "anatomi",
        categoryName: "Anatomi & Fisiologi",
        status: "tersedia",
        location: "Rak B-02",
        description: "Atlas anatomi terlengkap untuk mahasiswa kedokteran dan keperawatan."
    },
    {
        id: 6,
        title: "Encyclopedia of Nursing Care Quality",
        author: "Gunawan, S. & Team",
        edition: "Edisi 2",
        year: 2023,
        category: "keperawatan",
        categoryName: "Keperawatan Umum",
        status: "tersedia",
        location: "Rak C-08",
        description: "Ensiklopedia mutu asuhan keperawatan."
    },
    {
        id: 7,
        title: "Kamus Kedokteran Indonesia",
        author: "Ramai, A. et al.",
        edition: "Edisi 28",
        year: 2021,
        category: "kamus",
        categoryName: "Kamus & Ensiklopedia",
        status: "kosong",
        location: "Rak A-18",
        description: "Kamus kedokteran terlengkap dalam bahasa Indonesia."
    },
    {
        id: 8,
        title: "Pocket Guide to Pediatric Nursing",
        author: "Hockenberry, M.J.",
        edition: "Edisi Baru",
        year: 2024,
        category: "pediatri",
        categoryName: "Keperawatan Anak",
        status: "tersedia",
        location: "Rak E-02",
        description: "Panduan saku untuk praktik keperawatan anak."
    },
    {
        id: 9,
        title: "Brunner & Suddarth's Textbook of Medical-Surgical Nursing",
        author: "Brunner & Suddarth",
        edition: "Edisi 15",
        year: 2022,
        category: "klinis",
        categoryName: "Panduan Klinis",
        status: "dipinjam",
        location: "Rak B-10",
        returnDate: "20 Januari 2025",
        description: "Buku teks standar untuk keperawatan medikal-bedah."
    },
    {
        id: 10,
        title: "NANDA International Nursing Diagnoses",
        author: "NANDA International",
        edition: "Edisi 12",
        year: 2023,
        category: "keperawatan",
        categoryName: "Keperawatan Umum",
        status: "tersedia",
        location: "Rak C-05",
        description: "Standar diagnosis keperawatan internasional."
    },
    {
        id: 11,
        title: "Pediatric Nursing Made Incredibly Easy",
        author: "Lippincott",
        edition: "Edisi 3",
        year: 2022,
        category: "pediatri",
        categoryName: "Keperawatan Anak",
        status: "tersedia",
        location: "Rak E-08",
        description: "Panduan keperawatan anak dengan pendekatan mudah dipahami."
    },
    {
        id: 12,
        title: "Pharmacology for Nurses",
        author: "Adams & Holland",
        edition: "Edisi 10",
        year: 2023,
        category: "farmakologi",
        categoryName: "Farmakologi",
        status: "tersedia",
        location: "Rak D-10",
        description: "Buku farmakologi untuk praktik keperawatan."
    },
    {
        id: 13,
        title: "Essentials of Pathophysiology",
        author: "Carol Mattson Porth",
        edition: "Edisi 5",
        year: 2021,
        category: "anatomi",
        categoryName: "Anatomi & Fisiologi",
        status: "dipinjam",
        location: "Rak B-15",
        returnDate: "05 Maret 2025",
        description: "Dasar-dasar patofisiologi untuk mahasiswa keperawatan."
    },
    {
        id: 14,
        title: "Community Health Nursing",
        author: "Mary A. Nies",
        edition: "Edisi 8",
        year: 2022,
        category: "keperawatan",
        categoryName: "Keperawatan Umum",
        status: "tersedia",
        location: "Rak C-12",
        description: "Buku teks keperawatan komunitas."
    }
];

// Featured books data (top 4)
let featuredBooks = referenceBooks.slice(0, 4);

// Render featured books
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
                    <p class="text-xs text-gray-500 mt-1">${book.description.substring(0, 80)}...</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="status-badge status-${book.status}">${book.status === 'tersedia' ? '✓ TERSEDIA' : book.status === 'dipinjam' ? '📖 DIPINJAM' : '⚡ KOSONG'}</span>
                        <button class="btn-link text-xs" onclick="showDetail(${book.id})">Lihat Detail →</button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

// Render table
let currentPage = 1;
const itemsPerPage = 10;
let currentCategory = 'all';
let searchQuery = '';

function renderTable() {
    let filteredData = [...referenceBooks];
    
    // Filter by search
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.author.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.description.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    
    // Filter by category
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item => item.category === currentCategory);
    }
    
    // Pagination
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = filteredData.slice(startIndex, endIndex);
    
    // Update pagination info
    document.getElementById('paginationInfo').innerHTML = 
        `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, totalItems)} dari ${totalItems} buku referensi`;
    
    // Generate table rows
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';
    
    if (currentData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">
                    📭 Tidak ada data buku referensi yang ditemukan
                </td>
            </tr>
        `;
    } else {
        currentData.forEach(book => {
            const row = tbody.insertRow();
            
            // Column: Informasi Buku
            const cellInfo = row.insertCell(0);
            cellInfo.innerHTML = `
                <div class="font-semibold text-indigo-200 text-sm">${book.title}</div>
                <div class="text-xs text-gray-400">${book.author}</div>
            `;
            
            // Column: Tahun/Edisi
            const cellEdition = row.insertCell(1);
            cellEdition.innerHTML = `
                <div class="text-sm">${book.year}</div>
                <div class="text-xs text-gray-500">${book.edition}</div>
            `;
            
            // Column: Kategori
            const cellCategory = row.insertCell(2);
            cellCategory.innerHTML = `<span class="text-xs">${book.categoryName}</span>`;
            
            // Column: Status
            const cellStatus = row.insertCell(3);
            let statusHtml = `<span class="status-badge status-${book.status}">`;
            if (book.status === 'tersedia') {
                statusHtml += '✓ ADA';
            } else if (book.status === 'dipinjam') {
                statusHtml += `📖 DIPINJAM<br><span class="text-xs">Kembali: ${book.returnDate}</span>`;
            } else {
                statusHtml += '⚡ KOSONG';
            }
            statusHtml += `</span>`;
            cellStatus.innerHTML = statusHtml;
            
            // Column: Aksi
            const cellAction = row.insertCell(4);
            if (book.status === 'tersedia') {
                cellAction.innerHTML = `
                    <button class="btn-primary text-xs py-1 px-3" onclick="pinjamBuku(${book.id})">
                        📖 Pesan Buku
                    </button>
                `;
            } else if (book.status === 'kosong') {
                cellAction.innerHTML = `
                    <button class="btn-outline text-xs py-1 px-3" onclick="remindMe(${book.id})">
                        🔔 Ingatkan Saya
                    </button>
                `;
            } else {
                cellAction.innerHTML = `
                    <button class="btn-outline text-xs py-1 px-3" disabled style="opacity:0.5;">
                        ⏳ Tidak Tersedia
                    </button>
                `;
            }
        });
    }
    
    // Render pagination
    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const paginationContainer = document.getElementById('paginationButtons');
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHtml = '<div class="flex gap-2">';
    
    paginationHtml += `
        <button class="pagination-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
            ◀
        </button>
    `;
    
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        paginationHtml += `<button class="pagination-btn" onclick="changePage(1)">1</button>`;
        if (startPage > 2) paginationHtml += `<span class="px-2 text-gray-500">...</span>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHtml += `
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) paginationHtml += `<span class="px-2 text-gray-500">...</span>`;
        paginationHtml += `<button class="pagination-btn" onclick="changePage(${totalPages})">${totalPages}</button>`;
    }
    
    paginationHtml += `
        <button class="pagination-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
            ▶
        </button>
    `;
    
    paginationHtml += '</div>';
    paginationContainer.innerHTML = paginationHtml;
}

function changePage(page) {
    let filteredData = [...referenceBooks];
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.author.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item => item.category === currentCategory);
    }
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderTable();
        window.scrollTo({ top: 500, behavior: 'smooth' });
    }
}

function showDetail(id) {
    const book = referenceBooks.find(b => b.id === id);
    if (book) {
        showNotification(`📖 ${book.title} - ${book.author}\n📍 Rak: ${book.location}`, 'info');
    }
}

function pinjamBuku(id) {
    const book = referenceBooks.find(b => b.id === id);
    if (book) {
        showNotification(`✅ Berhasil memesan "${book.title}". Silakan ambil di Rak ${book.location}.`, 'success');
    }
}

function remindMe(id) {
    const book = referenceBooks.find(b => b.id === id);
    if (book) {
        showNotification(`🔔 Anda akan diingatkan saat buku "${book.title}" tersedia.`, 'info');
    }
}

// Notification system
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Filter event listeners for sidebar
document.querySelectorAll('.sidebar-item[data-category]').forEach(item => {
    item.addEventListener('click', (e) => {
        const category = e.target.getAttribute('data-category');
        currentCategory = category;
        currentPage = 1;
        
        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        e.target.classList.add('active');
        
        renderTable();
    });
});

// Search event
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderTable();
});

// Make functions global
window.showDetail = showDetail;
window.pinjamBuku = pinjamBuku;
window.remindMe = remindMe;
window.changePage = changePage;

// Initialize
renderFeaturedBooks();
renderTable();

console.log('Halaman Koleksi Buku Referensi siap dengan 14 buku dan fitur filter!');
</script>
@endpush