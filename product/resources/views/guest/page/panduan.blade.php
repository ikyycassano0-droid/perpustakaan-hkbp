@extends('guest.component.master')

@section('title', 'Panduan & Informasi - AKPER HKBP Balige')

@push('styles')
<style>
/* ===== RESET & BASE ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ===== MAIN CONTENT ===== */
.main-content {
    position: relative;
    z-index: 10;
}

/* ===== SECTION ===== */
.section {
    margin-top: 40px;
}

/* ===== GLASS CARD ===== */
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

/* ===== TITLE ===== */
.title-main {
    font-weight: 800;
    background: linear-gradient(135deg, #ffffff);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
}

/* ===== NEON BORDER ===== */
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

/* ===== SEARCH BAR ===== */
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

/* ===== FILTER BUTTON ===== */
.filter-btn {
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 0.85rem;
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

/* ===== GUIDE CARD ===== */
.guide-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(12px);
    border-radius: 1.5rem;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    border: 1px solid rgba(99, 102, 241, 0.3);
}

.guide-card:hover {
    transform: translateY(-5px);
    border-color: rgba(99, 102, 241, 0.7);
    box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
}

.guide-icon {
    width: 50px;
    height: 50px;
    background: rgba(99, 102, 241, 0.15);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.guide-title {
    font-weight: 700;
    font-size: 1rem;
    color: #c7d2fe;
    margin-bottom: 0.25rem;
}

.guide-meta {
    font-size: 0.7rem;
    color: #94a3b8;
}

.btn-download {
    background: transparent;
    border: 1px solid rgba(99, 102, 241, 0.5);
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 500;
    color: #a5b4fc;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-download:hover {
    background: rgba(99, 102, 241, 0.2);
    border-color: #6366f1;
    color: white;
    transform: scale(1.05);
}

.btn-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    padding: 10px 24px;
    border-radius: 40px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    color: white;
    font-size: 0.85rem;
}

.btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
}

/* ===== FADE UP ANIMATION ===== */
.fade-up {
    opacity: 0;
    transform: translateY(40px);
    transition: 0.9s cubic-bezier(0.2, 0.9, 0.4, 1.1);
}

.fade-up.show {
    opacity: 1;
    transform: translateY(0);
}

/* ===== NOTIFICATION ===== */
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

/* ===== LINE CLAMP ===== */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ===== CUSTOM SCROLLBAR ===== */
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-track {
    background: #0f172a;
}
::-webkit-scrollbar-thumb {
    background: #6366f1;
    border-radius: 8px;
}

/* ===== FLOATING ANIMATION ===== */
@keyframes floatAnim {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
}

.float {
    animation: floatAnim 6s ease-in-out infinite;
}
</style>
@endpush

@section('content')
<!-- Particle Canvas -->
<canvas id="particleCanvas" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 0;"></canvas>

<!-- Background Blobs -->
<div class="blob blob-1" style="position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, #6366f1, transparent); filter: blur(120px); opacity: 0.6; z-index: -1; top: -200px; left: -150px;"></div>
<div class="blob blob-2" style="position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, #6366f1, transparent); filter: blur(120px); opacity: 0.6; z-index: -1; bottom: -250px; right: -200px;"></div>

<!-- Cursor Glow -->
<div class="cursor-glow" id="cursorGlow" style="position: fixed; width: 150px; height: 180px; pointer-events: none; transform: translate(-50%, -50%); z-index: 9999; border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; background: radial-gradient(circle at 30% 30%, rgba(99, 107, 185, 0.6), transparent 60%), radial-gradient(circle at 70% 70%, rgba(99,102,241,0.5), transparent 70%), radial-gradient(circle at 50% 50%, rgba(59,130,246,0.4), transparent 80%); filter: blur(40px); transition: opacity 0.2s; animation: blobMove 8s ease-in-out infinite, pulseGlow 4s ease-in-out infinite;"></div>

<style>
@keyframes blobMove {
    0% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
    25% { border-radius: 50% 60% 40% 60% / 60% 40% 60% 40%; }
    50% { border-radius: 70% 30% 60% 40% / 40% 70% 30% 60%; }
    75% { border-radius: 40% 60% 50% 50% / 60% 30% 70% 40%; }
    100% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
}

@keyframes pulseGlow {
    0%, 100% { filter: blur(40px) brightness(1); }
    50% { filter: blur(55px) brightness(1.3); }
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

<!-- Floating Decorative Elements -->
<div class="fixed top-40 left-10 text-indigo-400 float opacity-30 pointer-events-none z-0 text-2xl">✦</div>
<div class="fixed top-60 right-20 text-indigo-300 float opacity-30 pointer-events-none z-0 text-2xl">✧</div>
<div class="fixed bottom-40 left-20 text-indigo-500 float opacity-30 pointer-events-none z-0 text-2xl">✦</div>

<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
        Panduan & <br>
        <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Informasi Akademik</span>
    </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses berbagai dokumen panduan resmi, tata tertib, dan prosedur operasional standar Akademi Keperawatan HKBP Balige untuk mendukung kelancaran studi Anda.
        </p>
    </section>

    <!-- SEARCH & FILTER SECTION -->
    <section class="section max-w-5xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari panduan...">
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-3 mb-8" id="filterContainer">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    @php
                        $uniqueCategories = $data->pluck('category')->unique();
                    @endphp
                    @foreach($uniqueCategories as $category)
                    <button class="filter-btn" data-filter="{{ strtolower($category) }}">
                        @if($category == 'Petunjuk Penggunaan') 📖
                        @elseif($category == 'Kebijakan') ⚖️
                        @elseif($category == 'Syarat & Ketentuan') 📜
                        @elseif($category == 'FAQ') ❓
                        @else 📌
                        @endif
                        {{ $category }}
                    </button>
                    @endforeach
                </div>

                <!-- Guides Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="guidesGrid">
                    <div class="col-span-2 text-center py-12">
                        <div class="text-2xl mb-3">⏳</div>
                        <p class="text-gray-400">Memuat data...</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- HELP SECTION -->
    <section class="section max-w-5xl mx-auto px-5 mb-16">
        <div class="glass-card p-6 rounded-2xl fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">💬</span>
                    <div>
                        <h3 class="font-semibold text-indigo-200">Butuh Bantuan Lainnya?</h3>
                        <p class="text-sm text-gray-400">Jika Anda tidak menemukan panduan yang dicari, silakan hubungi pusat informasi akademik kami di Balige.</p>
                    </div>
                </div>
                <button id="helpBtn" class="btn-primary px-6 py-2 text-sm">
                    Hubungi Kami →
                </button>
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
// ============================================
// DATA DARI BACKEND (Laravel)
// ============================================

@php
$guides = $data->map(function($item){
    // Mapping icon berdasarkan kategori
    $iconMap = [
        'Petunjuk Penggunaan' => '📖',
        'Kebijakan' => '⚖️',
        'Syarat & Ketentuan' => '📜',
        'FAQ' => '❓',
        'Lainnya' => '📌'
    ];

    $icon = $iconMap[$item->category] ?? '📄';

    // Pastikan files diproses dengan benar
    $files = [];
    if(isset($item->activeFiles) && $item->activeFiles->count() > 0) {
        $files = $item->activeFiles->map(function($file){
            return [
                'url' => asset('storage/' . $file->file_url),
                'name' => $file->file_name ?? 'File',
                'size' => $file->file_size ?? 0,
                'original_name' => $file->original_name ?? $file->file_name ?? 'download'
            ];
        })->values()->toArray();
    }

    return [
        'id' => $item->id,
        'title' => $item->title ?? 'Tanpa Judul',
        'category' => $item->category ?? 'Umum',
        'category_filter' => strtolower(trim($item->category ?? 'umum')),
        'icon' => $icon,
        'date' => $item->updated_at ? $item->updated_at->format('d M Y') : date('d M Y'),
        'description' => $item->description ?? '',
        'files' => $files,
        'file_size' => $files && count($files) > 0 ? formatBytes($files[0]['size']) : ''
    ];
})->values();

function formatBytes($bytes, $precision = 2) {
    if ($bytes == 0) return '0 Bytes';
    $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), $precision) . ' ' . $units[$i];
}
@endphp

let guidesData = {!! json_encode($guides) !!};

// ============================================
// DEBUG: Cek data di console
// ============================================
console.log('🔍 Total Data dari Backend:', guidesData.length);
console.log('📦 Detail Data:', guidesData);

// ============================================
// VARIABLES
// ============================================
let currentFilter = 'all';
let searchQuery = '';

// ============================================
// NOTIFICATION SYSTEM
// ============================================
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

// ============================================
// DOWNLOAD FUNCTION (UNTUK FILE DARI CRUD)
// ============================================
function downloadAllFiles(files) {
    if (!files || files.length === 0) {
        showNotification('❌ Tidak ada file untuk diunduh', 'error');
        return;
    }

    files.forEach((file, index) => {
        setTimeout(() => {
            const link = document.createElement('a');
            link.href = file.url;
            link.download = file.original_name || file.name || 'download';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }, index * 500); // delay biar tidak bentrok
    });

    showNotification(`📦 Mengunduh ${files.length} file...`, 'success');
}

// ============================================
// ESCAPE HTML
// ============================================
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ============================================
// RENDER FUNCTION
// ============================================
function renderGuides() {
    console.log('🔄 Rendering guides...');
    console.log('Current Filter:', currentFilter);
    console.log('Search Query:', searchQuery);

    let filteredData = [...guidesData];

    // APPLY SEARCH
    if (searchQuery && searchQuery.trim() !== '') {
        filteredData = filteredData.filter(item => {
            const titleMatch = item.title && item.title.toLowerCase().includes(searchQuery.toLowerCase());
            const descMatch = item.description && item.description.toLowerCase().includes(searchQuery.toLowerCase());
            return titleMatch || descMatch;
        });
    }

    // APPLY FILTER
    if (currentFilter !== 'all') {
        filteredData = filteredData.filter(item => {
            return item.category_filter === currentFilter.trim();
        });
    }

    console.log('📊 Filtered Data Count:', filteredData.length);

    const grid = document.getElementById('guidesGrid');
    if (!grid) {
        console.error('❌ Element #guidesGrid tidak ditemukan!');
        return;
    }

    // Clear grid
    grid.innerHTML = '';

    // Show empty state if no data
    if (filteredData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-2 text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-400 text-lg">Tidak ada panduan yang ditemukan</p>
                <p class="text-gray-500 text-sm mt-2">Coba gunakan kata kunci lain atau pilih kategori berbeda</p>
            </div>
        `;
        return;
    }

    // Render each guide card
    filteredData.forEach((guide, index) => {
        // Determine file button
        let fileButton = '';
        if (guide.files && guide.files.length > 0 && guide.files[0].url) {
            const file = guide.files[0];
            const fileName = file.original_name || file.name || 'download';
            const fileSize = file.size ? (file.size < 1024 ? file.size + ' B' : (file.size < 1048576 ? (file.size/1024).toFixed(1) + ' KB' : (file.size/1048576).toFixed(1) + ' MB')) : '';

            fileButton = `
                <button
                    onclick='downloadAllFiles(${JSON.stringify(guide.files)})', '${fileName.replace(/'/g, "\\'")}', '${fileSize}')"
                    class="btn-download">
                    📥 Unduh ${fileSize ? `(${fileSize})` : ''}
                </button>
            `;
        } else {
            fileButton = `<span class="btn-download" style="opacity:0.5; cursor:not-allowed;">📄 Tidak ada file</span>`;
        }

        // Create card
        const card = document.createElement('div');
        card.className = 'guide-card fade-up';
        card.style.animationDelay = `${index * 0.05}s`;

        card.innerHTML = `
            <div class="p-5 flex items-start justify-between gap-4">
                <div class="flex items-start gap-4 flex-1">
                    <div class="guide-icon">${guide.icon}</div>
                    <div class="flex-1">
                        <h3 class="guide-title">${escapeHtml(guide.title)}</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">${escapeHtml(guide.description.substring(0, 100))}${guide.description.length > 100 ? '...' : ''}</p>
                        <div class="guide-meta mt-3">
                            <span>🕒 Update: ${guide.date}</span>
                            ${guide.file_size ? `<span class="mx-2">•</span><span>📄 PDF (${guide.file_size})</span>` : ''}
                        </div>
                    </div>
                </div>
                ${fileButton}
            </div>
        `;

        grid.appendChild(card);
    });

    // Trigger fade-up animation for new cards
    setTimeout(() => {
        document.querySelectorAll('.guide-card.fade-up').forEach(el => {
            el.classList.add('show');
        });
    }, 100);
}


// ============================================
// PARALLAX EFFECT
// ============================================
window.addEventListener('scroll', () => {
    const heroTitle = document.querySelector('.title-main');
    if (heroTitle) {
        const scrollY = window.scrollY;
        heroTitle.style.transform = `translateY(${scrollY * 0.03}px)`;
    }
});

// ============================================
// EVENT LISTENERS
// ============================================

// Filter buttons
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const filterValue = e.currentTarget.getAttribute('data-filter');
        console.log('🔘 Filter clicked:', filterValue);

        currentFilter = filterValue;

        // Update active class
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active');
        });
        e.currentTarget.classList.add('active');

        // Re-render
        renderGuides();
    });
});

// Search input
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value;
        console.log('🔍 Search query:', searchQuery);
        renderGuides();
    });
}

// Help button
const helpBtn = document.getElementById('helpBtn');
if (helpBtn) {
    helpBtn.addEventListener('click', () => {
        showNotification('💬 Menghubungkan ke layanan bantuan akademik...', 'info');
        setTimeout(() => {
            showNotification('📞 Silakan hubungi (0632) 12345 atau email info@akperhkbp.ac.id', 'info');
        }, 1500);
    });
}

// ============================================
// INITIAL RENDER
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 DOM Loaded, initializing...');
    renderGuides();
});
</script>
@endpush




