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
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.8rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }
    
    .btn-outline {
        background: transparent;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.8rem;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    .btn-link {
        background: transparent;
        border: none;
        color: #a5b4fc;
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .btn-link:hover {
        color: #818cf8;
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
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📰 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Koleksi Majalah
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Eksplorasi wawasan terbaru dalam dunia keperawatan, riset klinis, dan dinamika kampus melalui koleksi majalah digital kami.
        </p>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📚</div>
                <div class="stat-number">250+</div>
                <div class="text-xs text-gray-400 mt-1">Edisi Tersedia</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">🏆</div>
                <div class="stat-number">12</div>
                <div class="text-xs text-gray-400 mt-1">Kategori Spesialis</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">⭐</div>
                <div class="stat-number">A</div>
                <div class="text-xs text-gray-400 mt-1">Status Akreditasi</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">👥</div>
                <div class="stat-number">5K+</div>
                <div class="text-xs text-gray-400 mt-1">Pembaca Aktif</div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    
                    <!-- SIDEBAR -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Koleksi Majalah</div>
                            <div class="sidebar-item active" data-category="all">📰 Semua Majalah</div>
                            <div class="sidebar-item" data-category="riset">🔬 Riset Keperawatan</div>
                            <div class="sidebar-item" data-category="klinis">🏥 Klinis & Bedah</div>
                            <div class="sidebar-item" data-category="pediatrik">👶 Pediatrik</div>
                            <div class="sidebar-item" data-category="wellness">🌿 Wellness & Kesehatan</div>
                            <div class="sidebar-item" data-category="leadership">👑 Leadership</div>
                            <div class="sidebar-item" data-category="teknologi">💻 Teknologi Kesehatan</div>
                        </div>
                        
                        <!-- ARSIP PER KATEGORI -->
                        <div class="sidebar-menu mt-6">
                            <div class="sidebar-title">📅 Arsip Per Kategori</div>
                            <div class="category-list p-3">
                                <div class="category-item" data-archive="pediatrik">
                                    <span>👶 Jurnal Pediatrik Terapan</span>
                                    <span class="text-xs text-indigo-400">Jan 2024</span>
                                </div>
                                <div class="category-item" data-archive="kritis">
                                    <span>🏥 Bedah & Perawatan Kritis</span>
                                    <span class="text-xs text-indigo-400">Des 2023</span>
                                </div>
                                <div class="category-item" data-archive="wellness">
                                    <span>🌿 Wellness & Kesehatan</span>
                                    <span class="text-xs text-indigo-400">Nov 2023</span>
                                </div>
                                <div class="category-item" data-archive="riset">
                                    <span>🔬 Riset Keperawatan</span>
                                    <span class="text-xs text-indigo-400">Okt 2023</span>
                                </div>
                                <div class="category-item" data-archive="leadership">
                                    <span>👑 Leadership In Nursing</span>
                                    <span class="text-xs text-indigo-400">Sep 2023</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- KOLEKSI LAINNYA -->
                        <div class="sidebar-menu mt-6">
                            <div class="sidebar-title">📖 Koleksi Lainnya</div>
                            <div class="sidebar-item" data-collection="buku-pengayaan">📘 Buku Pengayaan</div>
                            <div class="sidebar-item" data-collection="buku-referensi">📚 Buku Referensi</div>
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
                            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul majalah atau topik keperawatan...">
                        </div>
                        
                        <!-- FEATURED HERO MAGAZINE -->
                        <div class="hero-magazine mb-8" id="heroMagazine">
                            <!-- Hero magazine will be inserted by JavaScript -->
                        </div>
                        
                        <!-- RECOMMENDATION SECTION -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-indigo-200">✨ Rekomendasi Utama</h3>
                            <button class="btn-link" onclick="showAllRecommendations()">Lihat Semua →</button>
                        </div>
                        <div class="text-xs text-gray-500 mb-4">Edisi terbaru paling banyak dibaca bulan ini</div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8" id="recommendationsGrid">
                            <!-- Recommendation cards will be inserted here -->
                        </div>
                        
                        <!-- ALL MAGAZINES GRID -->
                        <h3 class="text-lg font-semibold text-indigo-200 mb-4">📚 Semua Koleksi Majalah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="magazinesGrid">
                            <!-- Magazine cards will be inserted by JavaScript -->
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex justify-center gap-2 mt-8" id="paginationButtons">
                            <!-- Pagination will be inserted here -->
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
// JAVASCRIPT KHUSUS UNTUK HALAMAN KOLEKSI MAJALAH
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA MAJALAH
let magazinesData = [
    {
        id: 1,
        title: "Nursing Research & Innovation",
        category: "riset",
        categoryName: "Riset Keperawatan",
        volume: "Vol. 12 Issue 4",
        date: "Januari 2024",
        cover: "https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=300&h=200&fit=crop",
        description: "Membahas secara mendalam tentang integrasi AI dalam pemantauan pasien rawat inap dan inovasi teknologi kesehatan terkini.",
        isFeatured: true,
        isHero: true,
        accreditation: "UNGUL A",
        readCount: 1245
    },
    {
        id: 2,
        title: "HKBP Nursing Life: Edisi Dies Natalis",
        category: "wellness",
        categoryName: "Wellness & Kesehatan",
        volume: "Edisi Khusus",
        date: "Desember 2023",
        cover: "https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=300&h=200&fit=crop",
        description: "Kelas balik perjalanan 45 tahun Akper HKBP Balige dan profil alumni berprestasi.",
        isFeatured: true,
        isHero: false,
        accreditation: "AKREDITASI A",
        readCount: 892
    },
    {
        id: 3,
        title: "Innovations in Clinical Nursing 2024",
        category: "klinis",
        categoryName: "Klinis & Bedah",
        volume: "Vol. 8 Issue 2",
        date: "Januari 2024",
        cover: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=300&h=200&fit=crop",
        description: "Teknik terbaru dalam perawatan kritis dan manajemen pasien pasca operasi.",
        isFeatured: true,
        isHero: false,
        accreditation: "TERAKREDITASI",
        readCount: 756
    },
    {
        id: 4,
        title: "Jurnal Pediatrik Terapan",
        category: "pediatrik",
        categoryName: "Pediatrik",
        volume: "Vol. 15 Issue 1",
        date: "Januari 2024",
        cover: "https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=300&h=200&fit=crop",
        description: "Penanganan terkini untuk penyakit infeksi pada anak dan imunisasi.",
        isFeatured: false,
        isHero: false,
        accreditation: "AKREDITASI B",
        readCount: 567
    },
    {
        id: 5,
        title: "Bedah & Perawatan Kritis",
        category: "klinis",
        categoryName: "Klinis & Bedah",
        volume: "Vol. 10 Issue 4",
        date: "Desember 2023",
        cover: "https://images.unsplash.com/photo-1516549655169-df83a0774514?w=300&h=200&fit=crop",
        description: "Manajemen pasien kritis dan protokol terbaru di ruang ICU.",
        isFeatured: false,
        isHero: false,
        accreditation: "AKREDITASI A",
        readCount: 678
    },
    {
        id: 6,
        title: "Wellness & Kesehatan Holistik",
        category: "wellness",
        categoryName: "Wellness & Kesehatan",
        volume: "Vol. 7 Issue 3",
        date: "November 2023",
        cover: "https://images.unsplash.com/photo-1504813184591-01572f98c85f?w=300&h=200&fit=crop",
        description: "Pendekatan holistik dalam perawatan pasien dan kesehatan mental perawat.",
        isFeatured: false,
        isHero: false,
        accreditation: "TERAKREDITASI",
        readCount: 445
    },
    {
        id: 7,
        title: "Riset Keperawatan Kontemporer",
        category: "riset",
        categoryName: "Riset Keperawatan",
        volume: "Vol. 9 Issue 2",
        date: "Oktober 2023",
        cover: "https://images.unsplash.com/photo-1532619187608-e5375cab36aa?w=300&h=200&fit=crop",
        description: "Evidence-based practice dan penelitian terbaru dalam keperawatan.",
        isFeatured: false,
        isHero: false,
        accreditation: "AKREDITASI A",
        readCount: 623
    },
    {
        id: 8,
        title: "Leadership In Nursing",
        category: "leadership",
        categoryName: "Leadership",
        volume: "Vol. 5 Issue 4",
        date: "September 2023",
        cover: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=300&h=200&fit=crop",
        description: "Pengembangan karir dan kepemimpinan dalam profesi keperawatan.",
        isFeatured: false,
        isHero: false,
        accreditation: "AKREDITASI B",
        readCount: 534
    },
    {
        id: 9,
        title: "Teknologi Kesehatan Masa Depan",
        category: "teknologi",
        categoryName: "Teknologi Kesehatan",
        volume: "Vol. 3 Issue 1",
        date: "Agustus 2023",
        cover: "https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=300&h=200&fit=crop",
        description: "AI, IoT, dan digitalisasi dalam layanan keperawatan modern.",
        isFeatured: false,
        isHero: false,
        accreditation: "TERAKREDITASI",
        readCount: 789
    }
];

// Render functions
let currentPage = 1;
const itemsPerPage = 6;
let currentCategory = 'all';
let searchQuery = '';

function renderHeroMagazine() {
    const heroMag = magazinesData.find(m => m.isHero === true);
    const container = document.getElementById('heroMagazine');
    if (heroMag) {
        container.innerHTML = `
            <div class="grid md:grid-cols-2 gap-0">
                <div class="p-6 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="accreditation-badge">⭐ ${heroMag.accreditation}</span>
                        <span class="text-xs text-gray-400">📅 ${heroMag.date}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-indigo-200 mb-2">${heroMag.title}</h2>
                    <p class="text-gray-400 text-sm mb-3">${heroMag.description.substring(0, 120)}...</p>
                    <div class="flex items-center gap-3">
                        <button class="btn-primary" onclick="readMagazine(${heroMag.id})">
                            📖 Baca Sekarang
                        </button>
                        <button class="btn-outline" onclick="saveMagazine(${heroMag.id})">
                            💾 Simpan
                        </button>
                    </div>
                </div>
                <div class="h-64 md:h-auto relative">
                    <img src="${heroMag.cover}" alt="${heroMag.title}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent to-indigo-900/50"></div>
                </div>
            </div>
        `;
    }
}

function renderRecommendations() {
    const recommendations = magazinesData.filter(m => m.isFeatured === true && m.isHero !== true).slice(0, 2);
    const container = document.getElementById('recommendationsGrid');
    container.innerHTML = '';
    
    recommendations.forEach(mag => {
        const card = document.createElement('div');
        card.className = 'magazine-card';
        card.innerHTML = `
            <div class="magazine-cover" style="background-image: url('${mag.cover}');">
                <span class="featured-badge">⭐ Rekomendasi</span>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-indigo-300">${mag.categoryName}</span>
                    <span class="text-xs text-gray-500">📅 ${mag.date}</span>
                </div>
                <h3 class="font-semibold text-indigo-200 mb-1">${mag.title}</h3>
                <p class="text-xs text-gray-400 mb-3">${mag.description.substring(0, 80)}...</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">👁️ ${mag.readCount} pembaca</span>
                    <button class="btn-link text-xs" onclick="readMagazine(${mag.id})">Baca →</button>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

function renderMagazines() {
    let filteredData = [...magazinesData];
    
    // Filter by search
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.description.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.categoryName.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    
    // Filter by category
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item => item.category === currentCategory);
    }
    
    // Exclude hero magazine from grid
    filteredData = filteredData.filter(m => m.isHero !== true);
    
    // Pagination
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = filteredData.slice(startIndex, endIndex);
    
    // Generate magazine grid
    const grid = document.getElementById('magazinesGrid');
    grid.innerHTML = '';
    
    if (currentData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-3 text-center py-12">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-400">Tidak ada majalah yang ditemukan</p>
            </div>
        `;
    } else {
        currentData.forEach(mag => {
            const card = document.createElement('div');
            card.className = 'magazine-card fade-up';
            card.innerHTML = `
                <div class="magazine-cover" style="background-image: url('${mag.cover}');"></div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-indigo-300">${mag.categoryName}</span>
                        <span class="text-xs text-gray-500">📅 ${mag.date}</span>
                    </div>
                    <h3 class="font-semibold text-indigo-200 mb-1 text-sm">${mag.title}</h3>
                    <p class="text-xs text-gray-400 mb-3">${mag.description.substring(0, 70)}...</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">📄 ${mag.volume}</span>
                        <button class="btn-link text-xs" onclick="readMagazine(${mag.id})">Baca →</button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }
    
    renderPagination(totalPages);
    
    // Add fade-up class
    setTimeout(() => {
        document.querySelectorAll('.magazine-card').forEach(el => {
            el.classList.add('show');
        });
    }, 50);
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
    let filteredData = [...magazinesData];
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.description.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item => item.category === currentCategory);
    }
    filteredData = filteredData.filter(m => m.isHero !== true);
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderMagazines();
        window.scrollTo({ top: 600, behavior: 'smooth' });
    }
}

function readMagazine(id) {
    const mag = magazinesData.find(m => m.id === id);
    if (mag) {
        showNotification(`📖 Membuka: ${mag.title} - ${mag.volume}`, 'info');
    }
}

function saveMagazine(id) {
    const mag = magazinesData.find(m => m.id === id);
    if (mag) {
        showNotification(`💾 "${mag.title}" telah disimpan ke koleksi Anda.`, 'success');
    }
}

function showAllRecommendations() {
    showNotification('✨ Menampilkan semua rekomendasi majalah terbaru...', 'info');
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
        
        renderMagazines();
    });
});

// Archive category click
document.querySelectorAll('.category-item').forEach(item => {
    item.addEventListener('click', (e) => {
        const archive = e.currentTarget.getAttribute('data-archive');
        if (archive === 'pediatrik') currentCategory = 'pediatrik';
        else if (archive === 'kritis') currentCategory = 'klinis';
        else if (archive === 'wellness') currentCategory = 'wellness';
        else if (archive === 'riset') currentCategory = 'riset';
        else if (archive === 'leadership') currentCategory = 'leadership';
        currentPage = 1;
        renderMagazines();
        showNotification(`📂 Menampilkan majalah kategori ${archive}`, 'info');
    });
});

// Search event
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderMagazines();
});

// Make functions global
window.readMagazine = readMagazine;
window.saveMagazine = saveMagazine;
window.showAllRecommendations = showAllRecommendations;
window.changePage = changePage;

// Initialize
renderHeroMagazine();
renderRecommendations();
renderMagazines();

console.log('Halaman Koleksi Majalah siap dengan 9 majalah dan fitur filter!');
</script>
@endpush