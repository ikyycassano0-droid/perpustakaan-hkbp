@extends('guest.component.master')

@section('title', 'Berita & Pengumuman - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN BERITA
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
    
    /* Category Badge */
    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .category-akademik { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.4); }
    .category-pengumuman { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
    .category-kegiatan { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
    .category-riset { background: rgba(139, 92, 246, 0.2); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.4); }
    .category-fasilitas { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.4); }
    .category-sosial { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); }
    
    /* News Card */
    .news-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        margin-bottom: 1.5rem;
    }
    
    .news-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }
    
    .news-image {
        height: 200px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .news-card:hover .news-image {
        transform: scale(1.05);
    }
    
    .img-wrapper {
        overflow: hidden;
        position: relative;
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 20px;
        border-radius: 40px;
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
        padding: 6px 16px;
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
    
    /* Filter button */
    .filter-btn {
        padding: 6px 18px;
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
        .news-image {
            height: 180px;
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
            Arsip Berita & Pengumuman
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Temukan pembaruan terkini mengenai kegiatan kampus, penelitian medis terbaru, dan pengumuman resmi dari Akademi Keperawatan HKBP Balige.
        </p>
    </section>

    <!-- SEARCH & FILTER SECTION -->
    <section class="section max-w-5xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <!-- Search Bar -->
                <div class="mb-6">
                    <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari berita atau pengumuman...">
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="akademik">Akademik</button>
                    <button class="filter-btn" data-filter="pengumuman">Pengumuman</button>
                    <button class="filter-btn" data-filter="kegiatan">Kegiatan</button>
                    <button class="filter-btn" data-filter="riset">Riset</button>
                    <button class="filter-btn" data-filter="fasilitas">Fasilitas</button>
                    <button class="filter-btn" data-filter="sosial">Sosial</button>
                </div>

                <!-- Featured News Card -->
                <div class="mb-8" id="featuredNews">
                    <!-- Featured news will be inserted by JavaScript -->
                </div>

                <!-- News Grid -->
                <div class="grid grid-cols-1 gap-6" id="newsGrid">
                    <!-- News cards will be inserted by JavaScript -->
                </div>

                <!-- Pagination -->
                <div class="flex justify-center gap-2 mt-8" id="paginationButtons">
                    <!-- Pagination will be inserted by JavaScript -->
                </div>

            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN BERITA
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA BERITA
let newsData = [
    {
        id: 1,
        title: "Implementasi Kurikulum Berbasis Simulasi Klinis Terpadu",
        category: "akademik",
        categoryName: "AKADEMIK",
        date: "12 Oktober 2024",
        image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500&h=250&fit=crop",
        excerpt: "Akper HKBP Balige menginisiasi modul simulasi baru guna memperkuat kompetensi praktis mahasiswa dalam menangani situasi gawat darurat dan kegawatdaruratan medis.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: true,
        buttonText: "Baca Selengkapnya",
        buttonAction: "baca"
    },
    {
        id: 2,
        title: "Jadwal Yudisium Semester Ganjil TA 2024/2025",
        category: "pengumuman",
        categoryName: "PENGUMUMAN",
        date: "08 Oktober 2024",
        image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&h=250&fit=crop",
        excerpt: "Pemberitahuan resmi mengenai jadwal dan persyaratan administrasi yudisium bagi calon wisudawan angkatan XXXII.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Lihat Detail",
        buttonAction: "detail"
    },
    {
        id: 3,
        title: "Seminar Internasional Keperawatan Komunitas di Era Digital",
        category: "kegiatan",
        categoryName: "KEGIATAN",
        date: "05 Oktober 2024",
        image: "https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500&h=250&fit=crop",
        excerpt: "Mengundang pakar dari mancanegara untuk membahas peran teknologi dalam meningkatkan efektivitas layanan kesehatan komunitas.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Daftar Sekarang",
        buttonAction: "daftar"
    },
    {
        id: 4,
        title: "Prestasi Dosen: Publikasi Jurnal Internasional Terindeks Scopus",
        category: "riset",
        categoryName: "RISET",
        date: "01 Oktober 2024",
        image: "https://images.unsplash.com/photo-1532619187608-e5375cab36aa?w=500&h=250&fit=crop",
        excerpt: "Tim peneliti Akper HKBP Balige berhasil mempublikasikan temuan mengenai efektivitas perawatan luka diabetik modern di jurnal internasional terindeks Scopus.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Baca Jurnal",
        buttonAction: "jurnal"
    },
    {
        id: 5,
        title: "Peresmian Laboratorium Keperawatan Medikal Bedah",
        category: "fasilitas",
        categoryName: "FASILITAS",
        date: "28 September 2024",
        image: "https://images.unsplash.com/photo-1516549655169-df83a0774514?w=500&h=250&fit=crop",
        excerpt: "Fasilitas penunjang praktik klinik dilengkapi dengan alat batu pernapasan terbaru dan sistem monitoring pasien digital untuk meningkatkan kualitas pembelajaran.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Tur Virtual",
        buttonAction: "tur"
    },
    {
        id: 6,
        title: "Program Pengabdian Masyarakat: Pemeriksaan Kesehatan Gratis",
        category: "sosial",
        categoryName: "SOSIAL",
        date: "25 September 2024",
        image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500&h=250&fit=crop",
        excerpt: "Mahasiswa dan dosen terjun langsung memberikan edukasi gaya hidup sehat dan skrining kesehatan bagi warga sekitar Balige secara gratis.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Dokumentasi",
        buttonAction: "dokumentasi"
    },
    {
        id: 7,
        title: "Workshop Penelitian Kuantitatif untuk Mahasiswa Akhir",
        category: "akademik",
        categoryName: "AKADEMIK",
        date: "20 September 2024",
        image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500&h=250&fit=crop",
        excerpt: "Pelatihan metodologi penelitian kuantitatif menggunakan software SPSS bagi mahasiswa yang sedang menyusun skripsi.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Daftar Sekarang",
        buttonAction: "daftar"
    },
    {
        id: 8,
        title: "Kerjasama Internasional dengan Rumah Sakit di Taiwan",
        category: "akademik",
        categoryName: "AKADEMIK",
        date: "15 September 2024",
        image: "https://images.unsplash.com/photo-1521791136064-7986c2920216?w=500&h=250&fit=crop",
        excerpt: "Akper HKBP Balige menjalin kerjasama dengan rumah sakit terkemuka di Taiwan untuk program pertukaran mahasiswa.",
        content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
        isFeatured: false,
        buttonText: "Baca Selengkapnya",
        buttonAction: "baca"
    }
];

// Render functions
let currentPage = 1;
const itemsPerPage = 5;
let currentCategory = 'all';
let searchQuery = '';

function getCategoryClass(category) {
    const classes = {
        'akademik': 'category-akademik',
        'pengumuman': 'category-pengumuman',
        'kegiatan': 'category-kegiatan',
        'riset': 'category-riset',
        'fasilitas': 'category-fasilitas',
        'sosial': 'category-sosial'
    };
    return classes[category] || 'category-akademik';
}

function renderFeaturedNews() {
    const featured = newsData.find(n => n.isFeatured === true);
    const container = document.getElementById('featuredNews');
    if (featured) {
        container.innerHTML = `
            <div class="glass-card overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="img-wrapper h-64 md:h-auto">
                        <img src="${featured.image}" alt="${featured.title}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="category-badge ${getCategoryClass(featured.category)}">${featured.categoryName}</span>
                            <span class="text-xs text-gray-500">📅 ${featured.date}</span>
                        </div>
                        <h2 class="text-2xl font-bold text-indigo-200 mb-3">${featured.title}</h2>
                        <p class="text-gray-400 text-sm mb-4">${featured.excerpt}</p>
                        <button class="btn-primary w-fit" onclick="handleAction('${featured.buttonAction}', ${featured.id})">
                            ${featured.buttonText} →
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}

function renderNews() {
    let filteredData = [...newsData];
    
    // Filter by search
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.excerpt.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    
    // Filter by category
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item => item.category === currentCategory);
    }
    
    // Exclude featured news from grid
    filteredData = filteredData.filter(item => item.isFeatured !== true);
    
    // Pagination
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = filteredData.slice(startIndex, endIndex);
    
    // Generate news grid
    const grid = document.getElementById('newsGrid');
    grid.innerHTML = '';
    
    if (currentData.length === 0) {
        grid.innerHTML = `
            <div class="text-center py-12">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-400">Tidak ada berita yang ditemukan</p>
            </div>
        `;
    } else {
        currentData.forEach(news => {
            const card = document.createElement('div');
            card.className = 'news-card fade-up';
            card.innerHTML = `
                <div class="grid md:grid-cols-4 gap-0">
                    <div class="img-wrapper md:col-span-1 h-48 md:h-auto">
                        <img src="${news.image}" alt="${news.title}" class="news-image">
                    </div>
                    <div class="md:col-span-3 p-5">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <span class="category-badge ${getCategoryClass(news.category)}">${news.categoryName}</span>
                            <span class="text-xs text-gray-500">📅 ${news.date}</span>
                        </div>
                        <h3 class="font-bold text-indigo-200 text-lg mb-2">${news.title}</h3>
                        <p class="text-gray-400 text-sm mb-4">${news.excerpt}</p>
                        <button class="btn-outline text-sm" onclick="handleAction('${news.buttonAction}', ${news.id})">
                            ${news.buttonText} →
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }
    
    renderPagination(totalPages);
    
    // Add fade-up class
    setTimeout(() => {
        document.querySelectorAll('.news-card').forEach(el => {
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
    let filteredData = [...newsData];
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.excerpt.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item => item.category === currentCategory);
    }
    filteredData = filteredData.filter(item => item.isFeatured !== true);
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderNews();
        window.scrollTo({ top: 500, behavior: 'smooth' });
    }
}

function handleAction(action, id) {
    const news = newsData.find(n => n.id === id);
    if (news) {
        let message = '';
        switch(action) {
            case 'baca':
                message = `📖 Membaca: ${news.title}`;
                break;
            case 'detail':
                message = `📋 Lihat detail: ${news.title}`;
                break;
            case 'daftar':
                message = `📝 Pendaftaran untuk "${news.title}" dibuka.`;
                break;
            case 'jurnal':
                message = `📄 Membuka jurnal: ${news.title}`;
                break;
            case 'tur':
                message = `🎬 Tur virtual fasilitas laboratorium akan dimulai.`;
                break;
            case 'dokumentasi':
                message = `📸 Membuka dokumentasi kegiatan.`;
                break;
            default:
                message = `Membuka: ${news.title}`;
        }
        showNotification(message, 'info');
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
        
        renderNews();
    });
});

// Search event
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderNews();
});

// Make functions global
window.handleAction = handleAction;
window.changePage = changePage;

// Initialize
renderFeaturedNews();
renderNews();

console.log('Halaman Berita & Pengumuman siap dengan 8 berita dan fitur filter!');
</script>
@endpush