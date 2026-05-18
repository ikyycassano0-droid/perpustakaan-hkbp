@extends('guest.component.master')

@section('title', 'Tugas & Fungsi - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN TUGAS & FUNGSI
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Glass card untuk halaman visi misi */
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

    /* Line decoration */
    .line {
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        margin: 16px auto 32px;
        border-radius: 10px;
    }

    /* Card Rectangle untuk Tugas Pokok */
    .card-rectangle {
        display: flex;
        align-items: center;
        gap: 20px;
        width: 100%;
        min-height: 130px;
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        padding: 24px;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .card-rectangle::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, #6366f1, #8b5cf6);
        border-radius: 4px;
    }

    .card-rectangle::after {
        content: "";
        position: absolute;
        top: -40px;
        left: -40px;
        right: -40px;
        bottom: -40px;
        background: radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(99,102,241,0.3), transparent 70%);
        filter: blur(50px);
        opacity: 0;
        transition: 0.3s;
        z-index: -1;
        pointer-events: none;
    }

    .card-rectangle:hover {
        transform: translateY(-6px);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 20px 40px -12px rgba(99, 102, 241, 0.3);
    }

    .card-rectangle:hover::after {
        opacity: 1;
    }

    .card-rectangle .icon {
        width: 55px;
        height: 55px;
        font-size: 26px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        border: 1px solid rgba(99,102,241,0.3);
    }

    .card-rectangle:hover .icon {
        transform: rotate(5deg) scale(1.1);
        background: linear-gradient(135deg, rgba(99,102,241,0.5), rgba(139,92,246,0.4));
    }

    /* Misi Card untuk Fungsi Strategis */
    .misi-card-new {
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        position: relative;
        overflow: hidden;
    }

    .misi-card-new::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 1.5rem;
        background: linear-gradient(130deg, #6366f1, #8b5cf6, #3b82f6);
        opacity: 0;
        transition: 0.4s;
        z-index: -1;
    }

    .misi-card-new:hover::before {
        opacity: 0.15;
    }

    .misi-card-new:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
    }

    .misi-card-new .icon {
        width: 50px;
        height: 50px;
        margin: 0 auto;
        background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.15));
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: 0.3s;
    }

    .misi-card-new:hover .icon {
        transform: scale(1.1);
        background: linear-gradient(135deg, rgba(99,102,241,0.4), rgba(139,92,246,0.3));
    }

    /* Button custom */
    .btn {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 12px 28px;
        border-radius: 999px;
        transition: all 0.3s ease;
        display: inline-block;
        font-weight: 500;
        box-shadow: 0 0 20px rgba(99,102,241,0.3);
        cursor: pointer;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 30px rgba(99,102,241,0.5);
    }

    /* Image hover effect */
    .img-hover {
        overflow: hidden;
        border-radius: 1.5rem;
    }

    .img-hover img {
        transition: transform 0.5s ease;
    }

    .img-hover:hover img {
        transform: scale(1.08);
    }

    /* Soft shadow */
    .soft-shadow {
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.4);
    }

    /* Number badge */
    .number-badge {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        min-width: 48px;
    }

    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }

    /* Tilt card effect class */
    .tilt-card {
        transform-style: preserve-3d;
        perspective: 1200px;
        transition: transform 0.15s ease-out;
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


<!-- ================= HERO - TUGAS ================= -->
<section class="pt-28 pb-12 px-5">
    <div class="text-center">
        <div class="inline-block glass-card px-5 py-1.5 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📋 TUGAS & FUNGSI</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Tugas
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Pokok</span>
</h1>
        <div class="line"></div>
    </div>

    <div class="max-w-4xl mx-auto mt-12 space-y-5">

        @forelse($tugas as $item)
        <div class="card-rectangle fade-up">
            <div class="icon">
                {!! $item->icon ?? '📚' !!}
            </div>
            <div>
                <h3 class="font-semibold mb-1 text-lg text-white">
                    {{ $item->title }}
                </h3>
                <p class="text-gray-400 text-sm">
                    {{ $item->description }}
                </p>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-400">Belum ada data tugas.</p>
        @endforelse

    </div>
</section>

<!-- ================= FUNGSI ================= -->
<section class="py-20 px-5">
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
            <span class="text-indigo-400 text-sm">🎯</span>
            <span class="text-indigo-300 text-sm font-medium">Peran Strategis</span>
        </div>
        <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
            Fungsi Strategis
        </h2>
        <div class="line"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">

        @forelse($fungsi as $item)
        <div class="misi-card-new fade-up">
            <div class="icon mx-auto">
                {!! $item->icon ?? '🎓' !!}
            </div>
            <h3 class="font-semibold mt-3 text-white">
                {{ $item->title }}
            </h3>
            <p class="text-gray-400 text-xs mt-2">
                {{ $item->description }}
            </p>
        </div>
        @empty
        <p class="text-center text-gray-400 col-span-4">Belum ada data fungsi.</p>
        @endforelse

    </div>
</section>

<!-- ================= TUJUAN ================= -->
<section class="py-20 px-5">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            <!-- IMAGE -->
            <div class="glass-card p-3 rounded-2xl img-hover soft-shadow fade-up">
                @php
                    // Cari gambar dari data tujuan yang memiliki image
                    $tujuanImage = $tujuan->firstWhere('image', '!=', null);
                @endphp

                @if($tujuanImage && $tujuanImage->image)
                    <img src="{{ asset('storage/'.$tujuanImage->image) }}"
                         class="rounded-xl w-full"
                         alt="{{ $tujuanImage->title ?? 'Tujuan Kami' }}">
                @else
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&h=450&fit=crop"
                         class="rounded-xl w-full"
                         alt="Default Image">
                @endif
            </div>

            <!-- TEXT -->
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-4">
                    <span class="text-indigo-400 text-sm">🏆</span>
                    <span class="text-indigo-300 text-sm font-medium">Target Kami</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent mb-6">
                    Tujuan Kami
                </h2>

                <div class="space-y-6">
                    @forelse($tujuan as $index => $item)
                    <div class="flex gap-4 items-start">
                        <span class="number-badge">
                            {{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div>
                            <h3 class="font-semibold text-white mb-1">
                                {{ $item->title ?? 'Tujuan ' . ($index+1) }}
                            </h3>
                            <p class="text-gray-400 text-sm">
                                {{ $item->description ?? 'Deskripsi belum tersedia' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400">Belum ada data tujuan.</p>
                    @endforelse
                </div>

                <button class="btn mt-8" onclick="showNotif('Jelajahi koleksi kami di perpustakaan digital!', 'success')">
                    Jelajahi Lebih Lanjut →
                </button>
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
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN TUGAS & FUNGSI
// Hanya JS yang BELUM ADA di master blade
// ============================================

document.addEventListener('DOMContentLoaded', function() {

    // 1. Tilt 3D effect untuk cards dengan class tilt-card
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (x - centerX) / 20;
            card.style.transform = `perspective(1200px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = `perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1)`;
        });
    });

    // 2. Card Rectangle glow follow cursor
    const rectCards = document.querySelectorAll('.card-rectangle');
    rectCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--x', x + 'px');
            card.style.setProperty('--y', y + 'px');
        });
    });

    // 3. Parallax effect untuk hero title
    const heroTitle = document.querySelector('.title-main');
    if (heroTitle) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            if (scrollY < 400) {
                heroTitle.style.transform = `translateY(${scrollY * 0.03}px)`;
            }
        });
    }

    // 4. Staggered animation untuk card rectangle
    const rectCardsAnimate = document.querySelectorAll('.card-rectangle');
    rectCardsAnimate.forEach((card, idx) => {
        card.style.transitionDelay = `${idx * 0.1}s`;
    });

    // 5. Misi card staggered animation
    const misiCards = document.querySelectorAll('.misi-card-new');
    misiCards.forEach((card, idx) => {
        card.style.transitionDelay = `${idx * 0.08}s`;
    });
});

console.log('Halaman Tugas & Fungsi siap dengan efek card rectangle glow follow cursor dan tilt 3D!');
</script>
@endpush
