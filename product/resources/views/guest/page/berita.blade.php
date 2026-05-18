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
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }

    /* Glow text */
    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }

    /* Tambahkan di style Visi Misi */
    .depth-2 { transform: translateZ(24px); }

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

     /* Glass card untuk halaman visi misi */
     .library-footer {
        position: relative;
        overflow: hidden;

        padding: 3.5rem 3rem 2rem;

        border-radius: 32px;

        background:
            linear-gradient(
                145deg,
                rgba(15, 23, 42, 0.92),
                rgba(17, 24, 39, 0.96)
            );

        border: 1px solid rgba(255, 255, 255, 0.06);

        backdrop-filter: blur(18px);

        box-shadow:
            0 10px 40px rgba(0, 0, 0, 0.35);
    }

    /* soft glow */
    .library-footer::before {
        content: "";

        position: absolute;

        width: 320px;
        height: 320px;

        top: -140px;
        right: -100px;

        border-radius: 999px;

        background: rgba(99, 102, 241, 0.08);

        filter: blur(80px);
    }

    /* grid */
    .footer-grid {
        position: relative;
        z-index: 2;

        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr;
        gap: 3rem;
    }

    /* logo */
    .footer-logo {
        width: 58px;
        height: 58px;

        border-radius: 18px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 1.5rem;

        background:
            linear-gradient(
                135deg,
                rgba(99, 102, 241, 0.25),
                rgba(139, 92, 246, 0.15)
            );

        border: 1px solid rgba(99, 102, 241, 0.2);
    }

    /* description */
    .footer-desc {
        margin-top: 1rem;

        color: #94a3b8;

        line-height: 1.9;

        font-size: 0.95rem;

        max-width: 340px;
    }

    /* section title */
    .footer-title {
        color: white;

        font-size: 1rem;
        font-weight: 600;

        margin-bottom: 1.3rem;
    }

    /* links */
    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .footer-links a {
        color: #94a3b8;

        font-size: 0.92rem;

        transition: all .25s ease;
    }

    .footer-links a:hover {
        color: #c7d2fe;

        transform: translateX(4px);
    }

    .footer-social {
        width: 44px;
        height: 44px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: rgba(255, 255, 255, 0.04);

        border: 1px solid rgba(255, 255, 255, 0.06);

        color: #cbd5e1;

        backdrop-filter: blur(10px);

        transition: all .3s ease;
    }

    .footer-social:hover {
        transform: translateY(-4px);

        background:
            linear-gradient(
                135deg,
                rgba(99, 102, 241, 0.18),
                rgba(139, 92, 246, 0.12)
            );

        border-color: rgba(99, 102, 241, 0.28);

        color: white;

        box-shadow:
            0 10px 24px rgba(99, 102, 241, 0.18);
    }

    /* contact */
    .footer-contact {
        display: flex;
        gap: 12px;

        color: #94a3b8;

        line-height: 1.7;
    }

    /* divider */
    .footer-divider {
        height: 1px;

        margin: 2.5rem 0 1.5rem;

        background:
            linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
    }

    /* bottom */
    .footer-bottom {
        position: relative;
        z-index: 2;

        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 1rem;

        color: #64748b;

        font-size: 0.85rem;
    }

    .footer-bottom-links {
        display: flex;
        gap: 1.5rem;
    }

    .footer-bottom-links a {
        transition: .25s ease;
    }

    .footer-bottom-links a:hover {
        color: #c7d2fe;
    }

    /* responsive */
    @media (max-width: 992px) {

        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }

    }

    @media (max-width: 640px) {

        .library-footer {
            padding: 2rem;
            border-radius: 24px;
        }

        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }

        .footer-bottom {
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-bottom-links {
            flex-wrap: wrap;
            gap: 1rem;
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

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
            Arsip Berita <br>
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">& Pengumuman</span>
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Temukan pembaruan terkini mengenai kegiatan kampus, penelitian, dan pengumuman resmi.
        </p>
    </section>


    <!-- CONTENT -->
    <section class="section max-w-5xl mx-auto px-5">

        <div class="neon-border fade-up">
            <div class="neon-inner">

                {{-- ================= SEARCH ================= --}}
                <form method="GET" class="mb-6">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="search-input"
                           placeholder="🔍 Cari berita...">
                </form>


                {{-- ================= CATEGORY FILTER ================= --}}
                <div class="flex flex-wrap gap-3 mb-8">

                    @php
                        $categories = ['all','akademik','pengumuman','kegiatan','riset','fasilitas','sosial'];
                    @endphp

                    @foreach($categories as $cat)
                        <a href="?category={{ $cat }}"
                           class="filter-btn {{ request('category','all') == $cat ? 'active' : '' }}">
                            {{ ucfirst($cat) }}
                        </a>
                    @endforeach

                </div>


                {{-- ================= FEATURED NEWS ================= --}}
                @if($featured)
                <div class="mb-10">

                    <div class="glass-card overflow-hidden">
                        <div class="grid md:grid-cols-2 gap-0">

                            <div class="img-wrapper h-64 md:h-auto">
                                <img src="{{ asset('storage/'.$featured->image) }}"
                                     class="w-full h-full object-cover">
                            </div>

                            <div class="p-6 flex flex-col justify-center">

                                <div class="flex items-center gap-3 mb-3">
                                    <span class="category-badge category-{{ $featured->category }}">
                                        {{ strtoupper($featured->category) }}
                                    </span>

                                    <span class="text-xs text-gray-500">
                                        📅 {{ $featured->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                <h2 class="text-2xl font-bold text-indigo-200 mb-3">
                                    {{ $featured->title }}
                                </h2>

                                <p class="text-gray-400 text-sm mb-5">
                                    {{ $featured->excerpt }}
                                </p>

                                <a href="{{ route('guest.berita.show', $featured->slug) }}"
                                    class="btn-primary w-fit">
                                        Baca Selengkapnya →
                                </a>

                            </div>

                        </div>
                    </div>

                </div>
                @endif


                {{-- ================= NEWS LIST ================= --}}
                <div class="grid grid-cols-1 gap-6">

                    @forelse($berita as $item)

                        <div class="news-card fade-up">

                            <div class="grid md:grid-cols-4 gap-0">

                                {{-- IMAGE --}}
                                <div class="img-wrapper md:col-span-1 h-48">
                                    <img src="{{ asset('storage/'.$item->image) }}"
                                         class="news-image">
                                </div>

                                {{-- CONTENT --}}
                                <div class="md:col-span-3 p-5">

                                    <div class="flex items-center gap-3 mb-2 flex-wrap">

                                        <span class="category-badge category-{{ $item->category }}">
                                            {{ strtoupper($item->category) }}
                                        </span>

                                        <span class="text-xs text-gray-500">
                                            📅 {{ $item->created_at->format('d M Y') }}
                                        </span>

                                    </div>

                                    <h3 class="font-bold text-indigo-200 text-lg mb-2">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="text-gray-400 text-sm mb-4">
                                        {{ $item->excerpt }}
                                    </p>

                                    <a href="{{ route('guest.berita.show', $item->id) }}"
                                       class="btn-outline text-sm">
                                        Baca Selengkapnya →
                                    </a>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-12 text-gray-400">
                            📭 Tidak ada berita ditemukan
                        </div>

                    @endforelse

                </div>


                {{-- ================= PAGINATION ================= --}}
                <div class="mt-10 flex justify-center">
                    {{ $berita->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="px-10 pb-12 pt-6">

        <div class="max-w-9xl mx-auto">

            <div class="library-footer fade-up">

                <div class="footer-grid">

                    <!-- BRAND -->
                    <div>

                        <div class="flex items-center gap-4">

                            <div class="footer-logo">
                                📚
                            </div>

                            <div>

                                <h3 class="text-white font-semibold text-lg">
                                    Perpustakaan Digital
                                </h3>

                                <p class="text-indigo-300 text-sm">
                                    AKPER HKBP Balige
                                </p>

                            </div>

                        </div>

                        <p class="footer-desc">
                            Menyediakan akses e-book, jurnal,
                            repository ilmiah, dan literatur digital
                            modern untuk mendukung pembelajaran mahasiswa.
                        </p>

                        <!-- SOCIAL MEDIA -->
                        <div class="flex items-center gap-3 mt-6">

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="Website"
                            >
                                <i class="fas fa-globe"></i>
                            </a>

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="Facebook"
                            >
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="YouTube"
                            >
                                <i class="fab fa-youtube"></i>
                            </a>

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="Instagram"
                            >
                                <i class="fab fa-instagram"></i>
                            </a>

                        </div>

                    </div>

                    <!-- NAVIGATION -->
                    <div>

                        <h4 class="footer-title">
                            Navigasi
                        </h4>

                        <ul class="footer-links">

                            <li>
                                <a href="{{ route('home') }}">
                                    Beranda
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('guest.profile.tugas-fungsi') }}">
                                    E-Book
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    E-Journal
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Repository
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Katalog
                                </a>
                            </li>

                        </ul>

                    </div>

                    <!-- SERVICES -->
                    <div>

                        <h4 class="footer-title">
                            Layanan
                        </h4>

                        <ul class="footer-links">

                            <li>
                                <a href="{{ route('user.pinjam') }}">
                                    Peminjaman
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('final_project.upload.kti') }}">
                                    Upload KTI
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('panduan') }}">
                                    Literasi Digital
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('user.profile.struktur') }}">
                                    Keanggotaan
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Bantuan
                                </a>
                            </li>

                        </ul>

                    </div>

                    <!-- CONTACT -->
                    <div>

                        <h4 class="footer-title">
                            Kontak
                        </h4>

                        <div class="space-y-4 text-sm">

                            <div class="footer-contact">

                                <span>
                                    📍
                                </span>

                                <p>
                                    AKPER HKBP Balige,
                                    Sumatera Utara
                                </p>

                            </div>

                            <div class="footer-contact">

                                <span>
                                    📧
                                </span>

                                <p>
                                    library@akperhkbp.ac.id
                                </p>

                            </div>

                            <div class="footer-contact">

                                <span>
                                    📞
                                </span>

                                <p>
                                    +62 812 xxxx xxxx
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- divider -->
                <div class="footer-divider"></div>

                <!-- bottom -->
                <div class="footer-bottom">

                    <p>
                        © 2026 Perpustakaan Digital AKPER HKBP Balige.
                    </p>

                    <div class="footer-bottom-links">

                        <a href="#">
                            Privacy
                        </a>

                        <a href="#">
                            Terms
                        </a>

                        <a href="#">
                            Support
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </footer>
</div>
@endsection
@push('scripts')
<script>
// ==============================
// DATA DARI LARAVEL (REAL DB)
// ==============================
let newsData = @json($berita->items());
let featuredNews = @json($featured);

// ==============================
// NORMALISASI DATA
// ==============================
newsData = newsData.map(item => ({
    id: item.id,
    title: item.title,
    category: item.category ?? 'akademik',
    categoryName: (item.category ?? 'akademik').toUpperCase(),
    date: item.created_at
        ? new Date(item.created_at).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        })
        : '',
    image: item.image ? `/storage/${item.image}` : 'https://via.placeholder.com/500x250',
    excerpt: item.excerpt ?? '',
    content: item.content ?? '',
    isFeatured: item.is_featured ?? false,
    buttonText: 'Baca Selengkapnya',
    buttonAction: 'baca'
}));

if (featuredNews) {
    featuredNews = {
        id: featuredNews.id,
        title: featuredNews.title,
        category: featuredNews.category ?? 'akademik',
        categoryName: (featuredNews.category ?? 'akademik').toUpperCase(),
        date: featuredNews.created_at
            ? new Date(featuredNews.created_at).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            })
            : '',
        image: featuredNews.image ? `/storage/${featuredNews.image}` : 'https://via.placeholder.com/500x250',
        excerpt: featuredNews.excerpt ?? '',
        content: featuredNews.content ?? '',
        isFeatured: true,
        buttonText: 'Baca Selengkapnya',
        buttonAction: 'baca'
    };
}

// ==============================
// STATE
// ==============================
let currentPage = 1;
const itemsPerPage = 5;
let currentCategory = 'all';
let searchQuery = '';

// ==============================
// CATEGORY STYLE
// ==============================
function getCategoryClass(category) {
    const classes = {
        akademik: 'category-akademik',
        pengumuman: 'category-pengumuman',
        kegiatan: 'category-kegiatan',
        riset: 'category-riset',
        fasilitas: 'category-fasilitas',
        sosial: 'category-sosial'
    };
    return classes[category] || 'category-akademik';
}

// ==============================
// FEATURED NEWS
// ==============================
function renderFeaturedNews() {
    const container = document.getElementById('featuredNews');

    if (!featuredNews) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = `
        <div class="glass-card overflow-hidden">
            <div class="grid md:grid-cols-2 gap-0">
                <div class="img-wrapper h-64 md:h-auto">
                    <img src="${featuredNews.image}" class="w-full h-full object-cover">
                </div>

                <div class="p-6 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="category-badge ${getCategoryClass(featuredNews.category)}">
                            ${featuredNews.categoryName}
                        </span>
                        <span class="text-xs text-gray-500">📅 ${featuredNews.date}</span>
                    </div>

                    <h2 class="text-2xl font-bold text-indigo-200 mb-3">
                        ${featuredNews.title}
                    </h2>

                    <p class="text-gray-400 text-sm mb-4">
                        ${featuredNews.excerpt}
                    </p>

                    <button class="btn-primary w-fit" onclick="handleAction('baca', ${featuredNews.id})">
                        Baca Selengkapnya →
                    </button>
                </div>
            </div>
        </div>
    `;
}

// ==============================
// RENDER NEWS LIST
// ==============================
function renderNews() {

    let filtered = [...newsData];

    // search
    if (searchQuery) {
        filtered = filtered.filter(item =>
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.excerpt.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }

    // category
    if (currentCategory !== 'all') {
        filtered = filtered.filter(item => item.category === currentCategory);
    }

    // exclude featured
    if (featuredNews) {
        filtered = filtered.filter(item => item.id !== featuredNews.id);
    }

    // pagination
    const totalPages = Math.ceil(filtered.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const data = filtered.slice(start, start + itemsPerPage);

    const grid = document.getElementById('newsGrid');
    grid.innerHTML = '';

    if (data.length === 0) {
        grid.innerHTML = `
            <div class="text-center py-12 text-gray-400">
                📭 Tidak ada berita ditemukan
            </div>
        `;
        return;
    }

    data.forEach(news => {
        grid.innerHTML += `
            <div class="news-card fade-up">
                <div class="grid md:grid-cols-4 gap-0">

                    <div class="img-wrapper md:col-span-1 h-48">
                        <img src="${news.image}" class="news-image">
                    </div>

                    <div class="md:col-span-3 p-5">

                        <div class="flex gap-3 mb-2 flex-wrap">
                            <span class="category-badge ${getCategoryClass(news.category)}">
                                ${news.categoryName}
                            </span>
                            <span class="text-xs text-gray-500">
                                📅 ${news.date}
                            </span>
                        </div>

                        <h3 class="font-bold text-indigo-200 text-lg mb-2">
                            ${news.title}
                        </h3>

                        <p class="text-gray-400 text-sm mb-4">
                            ${news.excerpt}
                        </p>

                        <button class="btn-outline text-sm"
                            onclick="handleAction('${news.buttonAction}', ${news.id})">
                            Baca Selengkapnya →
                        </button>

                    </div>
                </div>
            </div>
        `;
    });

    renderPagination(totalPages);
}

// ==============================
// PAGINATION
// ==============================
function renderPagination(totalPages) {
    const el = document.getElementById('paginationButtons');

    if (totalPages <= 1) {
        el.innerHTML = '';
        return;
    }

    let html = '<div class="flex gap-2">';

    html += `
        <button class="pagination-btn"
            onclick="changePage(${currentPage - 1})"
            ${currentPage === 1 ? 'disabled' : ''}>
            ◀
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button class="pagination-btn"
            onclick="changePage(${currentPage + 1})"
            ${currentPage === totalPages ? 'disabled' : ''}>
            ▶
        </button>
    `;

    html += '</div>';

    el.innerHTML = html;
}

// ==============================
// CHANGE PAGE
// ==============================
function changePage(page) {
    currentPage = page;
    renderNews();
    window.scrollTo({ top: 500, behavior: 'smooth' });
}

// ==============================
// ACTION BUTTON
// ==============================
function handleAction(action, id) {
    const news = newsData.find(n => n.id === id) || featuredNews;

    let msg = '';

    switch(action) {
        case 'baca':
            msg = `📖 Membaca: ${news.title}`;
            break;
        default:
            msg = `Membuka: ${news.title}`;
    }

    alert(msg);
}

// ==============================
// FILTER EVENTS
// ==============================
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {

        document.querySelectorAll('.filter-btn')
            .forEach(b => b.classList.remove('active'));

        e.target.classList.add('active');

        currentCategory = e.target.dataset.filter;
        currentPage = 1;

        renderNews();
    });
});

// ==============================
// SEARCH
// ==============================
document.getElementById('searchInput')
.addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderNews();
});

// ==============================
// INIT
// ==============================
renderFeaturedNews();
renderNews();

</script>
@endpush
