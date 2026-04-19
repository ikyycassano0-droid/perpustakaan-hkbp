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

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Koleksi Buku Pengayaan
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Eksplorasi wawasan di luar kurikulum klinis. Kembangkan potensi diri, temukan inspirasi, dan perluas cakrawala literasi umum Anda.
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
                            <div class="sidebar-title">📖 Kategori</div>
                            <div class="sidebar-item active" data-category="all">📚 Semua Kategori</div>
                            <div class="sidebar-item" data-category="pengembangan-diri">🌱 Pengembangan Diri</div>
                            <div class="sidebar-item" data-category="motivasi">⚡ Motivasi</div>
                            <div class="sidebar-item" data-category="literasi-umum">📖 Literasi Umum</div>
                            <div class="sidebar-item" data-category="filosofi">🧠 Filosofi</div>
                            <div class="sidebar-item" data-category="biografi">👤 Biografi</div>
                            <div class="sidebar-item" data-category="kepemimpinan">👑 Kepemimpinan</div>
                        </div>
                        
                        <!-- KOLEKSI LAINNYA -->
                        <div class="sidebar-menu mt-6">
                            <div class="sidebar-title">📂 Koleksi Lainnya</div>
                            <div class="sidebar-item" data-collection="buku-referensi">📘 Buku Referensi</div>
                            <div class="sidebar-item" data-collection="majalah">📰 Majalah</div>
                            <div class="sidebar-item" data-collection="e-book">📱 E-book</div>
                            <div class="sidebar-item" data-collection="e-article">📄 E-article</div>
                            <div class="sidebar-item" data-collection="cd">💿 CD</div>
                            <div class="sidebar-item" data-collection="video">🎬 Video</div>
                            <div class="sidebar-item" data-collection="kti">📑 Karya Tulis Ilmiah</div>
                        </div>
                    </div>
                    
                    <!-- BOOK GRID -->
                    <div class="lg:col-span-3">
                        
                        <!-- Search Bar -->
                        <div class="mb-6">
                            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul buku, penulis, atau kata kunci...">
                        </div>
                        
                        <!-- Filter Chips -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            <button class="filter-btn active" data-filter="all">Semua Kategori</button>
                            <button class="filter-btn" data-filter="pengembangan-diri">Pengembangan Diri</button>
                            <button class="filter-btn" data-filter="motivasi">Motivasi</button>
                            <button class="filter-btn" data-filter="literasi-umum">Literasi Umum</button>
                            <button class="filter-btn" data-filter="filosofi">Filosofi</button>
                            <button class="filter-btn" data-filter="biografi">Biografi</button>
                            <button class="filter-btn" data-filter="kepemimpinan">Kepemimpinan</button>
                        </div>
                        
                        <!-- Books Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="booksGrid">
                            <!-- Books will be inserted by JavaScript -->
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex justify-center gap-2 mt-8" id="paginationButtons">
                            <!-- Pagination will be inserted by JavaScript -->
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
// JAVASCRIPT KHUSUS UNTUK HALAMAN KOLEKSI BUKU PENGAYAAN
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA BUKU PENGAYAAN
let booksData = [
    {
        id: 1,
        title: "Berani Tidak Disukai",
        author: "Ichiro Kishimi & Fumitake Koga",
        category: "pengembangan-diri",
        categoryName: "Pengembangan Diri",
        rating: 4.8,
        location: "Rak A-12",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=180&fit=crop",
        description: "Buku tentang psikologi Alfred Adler yang membahas kebebasan menjadi diri sendiri."
    },
    {
        id: 2,
        title: "Atomic Habits",
        author: "James Clear",
        category: "pengembangan-diri",
        categoryName: "Pengembangan Diri",
        rating: 4.9,
        location: "Rak A-15",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=180&fit=crop",
        description: "Perubahan kecil yang memberikan hasil luar biasa dalam membentuk kebiasaan."
    },
    {
        id: 3,
        title: "Filosofi Teras",
        author: "Henry Manampiring",
        category: "filosofi",
        categoryName: "Filosofi",
        rating: 4.7,
        location: "Rak B-03",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1532012197267-da84d127e765?w=200&h=180&fit=crop",
        description: "Filosofi Stoikisme yang diaplikasikan dalam kehidupan modern."
    },
    {
        id: 4,
        title: "Start with Why",
        author: "Simon Sinek",
        category: "kepemimpinan",
        categoryName: "Kepemimpinan",
        rating: 4.8,
        location: "Rak C-08",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=180&fit=crop",
        description: "Buku tentang bagaimana pemimpin hebat menginspirasi tindakan."
    },
    {
        id: 5,
        title: "The Psychology of Money",
        author: "Morgan Housel",
        category: "motivasi",
        categoryName: "Motivasi",
        rating: 4.9,
        location: "Rak D-02",
        status: "dipinjam",
        cover: "https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=200&h=180&fit=crop",
        description: "Pelajaran abadi tentang kekayaan, keserakahan, dan kebahagiaan."
    },
    {
        id: 6,
        title: "Sapiens: Riwayat Singkat Umat Manusia",
        author: "Yuval Noah Harari",
        category: "literasi-umum",
        categoryName: "Literasi Umum",
        rating: 4.8,
        location: "Rak E-05",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=200&h=180&fit=crop",
        description: "Perjalanan sejarah umat manusia dari masa prasejarah hingga modern."
    },
    {
        id: 7,
        title: "Cantik itu Luka",
        author: "Eka Kurniawan",
        category: "literasi-umum",
        categoryName: "Literasi Umum",
        rating: 4.7,
        location: "Rak E-08",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=200&h=180&fit=crop",
        description: "Novel epik yang mengisahkan kehidupan perempuan dalam sejarah Indonesia."
    },
    {
        id: 8,
        title: "Grit: Kekuatan Passion dan Kegigihan",
        author: "Angela Duckworth",
        category: "motivasi",
        categoryName: "Motivasi",
        rating: 4.8,
        location: "Rak D-05",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=180&fit=crop",
        description: "Mengapa kegigihan lebih penting daripada bakat dalam meraih kesuksesan."
    },
    {
        id: 9,
        title: "Steve Jobs: The Exclusive Biography",
        author: "Walter Isaacson",
        category: "biografi",
        categoryName: "Biografi",
        rating: 4.9,
        location: "Rak F-02",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1532012197267-da84d127e765?w=200&h=180&fit=crop",
        description: "Biografi resmi Steve Jobs, pendiri Apple."
    },
    {
        id: 10,
        title: "The 7 Habits of Highly Effective People",
        author: "Stephen R. Covey",
        category: "pengembangan-diri",
        categoryName: "Pengembangan Diri",
        rating: 4.8,
        location: "Rak A-20",
        status: "dipinjam",
        cover: "https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=200&h=180&fit=crop",
        description: "Tujuh kebiasaan yang membuat orang efektif mencapai kesuksesan."
    },
    {
        id: 11,
        title: "Meditations",
        author: "Marcus Aurelius",
        category: "filosofi",
        categoryName: "Filosofi",
        rating: 4.9,
        location: "Rak B-10",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1532012197267-da84d127e765?w=200&h=180&fit=crop",
        description: "Catatan pribadi Kaisar Romawi tentang filosofi Stoikisme."
    },
    {
        id: 12,
        title: "Leaders Eat Last",
        author: "Simon Sinek",
        category: "kepemimpinan",
        categoryName: "Kepemimpinan",
        rating: 4.7,
        location: "Rak C-12",
        status: "tersedia",
        cover: "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=180&fit=crop",
        description: "Mengapa beberapa tim dapat bekerja sama dan yang lainnya tidak."
    }
];

// Render books
let currentPage = 1;
const itemsPerPage = 6;
let currentCategory = 'all';
let searchQuery = '';

function renderBooks() {
    let filteredData = [...booksData];
    
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
    
    // Generate books grid
    const grid = document.getElementById('booksGrid');
    grid.innerHTML = '';
    
    if (currentData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-2 text-center py-12">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-400">Tidak ada buku yang ditemukan</p>
                <p class="text-sm text-gray-500 mt-1">Coba kata kunci lain atau pilih kategori berbeda</p>
            </div>
        `;
    } else {
        currentData.forEach(book => {
            const card = document.createElement('div');
            card.className = 'book-card fade-up';
            card.innerHTML = `
                <div class="book-cover" style="background-image: url('${book.cover}'); background-size: cover; background-position: center;">
                    <span class="status-badge ${book.status === 'tersedia' ? 'status-tersedia' : 'status-dipinjam'}">
                        ${book.status === 'tersedia' ? '✓ TERSEDIA' : '📖 Dipinjam'}
                    </span>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-indigo-300">${book.categoryName}</span>
                        <div class="rating">
                            ${'⭐'.repeat(Math.floor(book.rating))} ${book.rating}
                        </div>
                    </div>
                    <h3 class="font-semibold text-indigo-200 mb-1">${book.title}</h3>
                    <p class="text-xs text-gray-400 mb-2">${book.author}</p>
                    <p class="text-xs text-gray-500 mb-3">📍 ${book.location}</p>
                    <div class="flex gap-2">
                        <button class="btn-outline text-xs py-1 px-3 flex-1" onclick="showDetail(${book.id})">
                            📖 Detail
                        </button>
                        ${book.status === 'tersedia' ? 
                            `<button class="btn-primary text-xs py-1 px-3" onclick="pinjamBuku(${book.id})">
                                Pinjam
                            </button>` : 
                            `<button class="btn-outline text-xs py-1 px-3" disabled style="opacity:0.5;">
                                Tidak Tersedia
                            </button>`
                        }
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }
    
    // Add fade-up class
    setTimeout(() => {
        document.querySelectorAll('.book-card').forEach(el => {
            el.classList.add('show');
        });
    }, 50);
    
    // Render pagination
    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const paginationContainer = document.getElementById('paginationButtons');
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHtml = '<div class="flex gap-2 flex-wrap justify-center">';
    
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
    let filteredData = [...booksData];
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
        renderBooks();
        window.scrollTo({ top: 500, behavior: 'smooth' });
    }
}

function showDetail(id) {
    const book = booksData.find(b => b.id === id);
    if (book) {
        showNotification(`📖 ${book.title} - ${book.author}`, 'info');
    }
}

function pinjamBuku(id) {
    const book = booksData.find(b => b.id === id);
    if (book) {
        showNotification(`✅ Berhasil meminjam "${book.title}". Silakan ambil buku di perpustakaan.`, 'success');
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

// Filter event listeners
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const filter = e.target.getAttribute('data-filter');
        currentCategory = filter;
        currentPage = 1;
        
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        
        document.querySelectorAll('.sidebar-item[data-category]').forEach(item => {
            if (item.getAttribute('data-category') === filter) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
        
        renderBooks();
    });
});

// Sidebar category click
document.querySelectorAll('.sidebar-item[data-category]').forEach(item => {
    item.addEventListener('click', (e) => {
        const category = e.target.getAttribute('data-category');
        currentCategory = category;
        currentPage = 1;
        
        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        e.target.classList.add('active');
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.getAttribute('data-filter') === category) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
        
        renderBooks();
    });
});

// Search event
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderBooks();
});

// Make functions global
window.showDetail = showDetail;
window.pinjamBuku = pinjamBuku;
window.changePage = changePage;

// Initialize
renderBooks();

// Stagger animation for book cards
document.querySelectorAll('.book-card').forEach((card, idx) => {
    card.style.setProperty('--delay', `${idx * 0.05}s`);
});

console.log('Halaman Koleksi Buku Pengayaan siap dengan 12 buku dan fitur filter!');
</script>
@endpush