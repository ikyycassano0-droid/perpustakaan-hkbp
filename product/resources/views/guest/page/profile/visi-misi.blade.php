@extends('guest.component.master')

@section('title', 'Visi & Misi - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN VISI MISI
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

    /* Title gradient untuk halaman visi misi */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 25px rgba(99,102,241,0.5);
    }

    /* Neon border effect - khusus visi misi */
    .neon-border {
        position: relative;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.25), rgba(99,102,241,0.1));
        transition: 0.3s;
    }

    .neon-border:hover {
        box-shadow: 0 0 30px rgba(99,102,241,0.4);
    }

    .neon-inner {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* Misi Card - khusus halaman visi misi */
    .misi-card-clean {
        background: rgba(255,255,255,0.05);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(99,102,241,0.2);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .misi-card-clean:hover {
        transform: translateY(-8px) scale(1.03);
        border-color: rgba(99,102,241,0.7);
        box-shadow: 0 0 30px rgba(99,102,241,0.4);
    }

    .misi-img-wrapper {
        overflow: hidden;
        height: 200px;
    }

    .misi-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .misi-card-clean:hover .misi-img {
        transform: scale(1.08);
    }

    .misi-text-area {
        padding: 1.2rem;
    }

    .misi-text-area h3 {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #c7d2fe, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .misi-text-area p {
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.5;
    }

    /* Tambahkan di style Visi Misi */
    .depth-2 { transform: translateZ(24px); }

    /* Hero badge khusus */
    .hero-badge {
        background: rgba(99,102,241,0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(99,102,241,0.3);
    }

    /* Delay animasi untuk card */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }

    /* Section margin untuk visi misi */
    .section {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    @media (min-width: 768px) {
        .section {
            margin-top: 3rem;
            margin-bottom: 3rem;
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
    <section class="pt-28 pb-10 text-center px-5 md:pt-32">
        <div class="inline-block hero-badge px-5 py-1.5 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">✨ AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Visi
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">& Misi</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-xl mx-auto fade-up text-sm md:text-base">
            Perpustakaan Digital yang Mendukung Pendidikan Keperawatan Unggul
        </p>
    </section>

    <!-- ABOUT (STATIC - TIDAK DIUBAH) -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex items-center gap-3 mb-5">
                    <div class="text-3xl md:text-4xl">📘</div>
                    <h2 class="text-xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent">
                        Tentang AKPER HKBP
                    </h2>
                </div>
                @if($about)
                <p class="text-gray-300 text-sm md:text-lg leading-relaxed">
                    {{ $about->description }}
                </p>
                @else
                <p class="text-gray-500 italic">
                    Konten belum tersedia
                </p>
                @endif
            </div>
        </div>
    </section>

    <!-- VISI (DINAMIS) -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex items-center gap-3 mb-5">
                    <div class="text-3xl md:text-4xl">✨</div>
                    <h2 class="text-xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent">
                        Visi
                    </h2>
                </div>

                <p class="text-gray-300 text-sm md:text-lg leading-relaxed italic border-l-4 border-indigo-500 pl-4 md:pl-5">
                    "{{ $visi->description ?? 'Visi belum tersedia' }}"
                </p>
            </div>
        </div>
    </section>

    <!-- MISI (DINAMIS LOOP) -->
    <section class="section max-w-6xl mx-auto px-5 mt-8 mb-16">
        <div class="text-center mb-10 md:mb-12">
            <div class="inline-flex items-center gap-2 hero-badge px-4 py-2 rounded-full mb-4 fade-up">
                <span class="text-indigo-400 text-sm">🎯</span>
                <span class="text-indigo-300 text-sm font-medium">Komitmen Kami</span>
            </div>
            <h2 class="text-2xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Misi Kami
            </h2>
            <p class="text-indigo-200/70 mt-3 fade-up max-w-lg mx-auto text-sm md:text-base">
                Langkah nyata menuju perpustakaan masa depan yang inspiratif
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">

            @forelse($misi as $item)
            <div class="misi-card-clean fade-up">

                <div class="misi-img-wrapper">
                    <img
                        src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/600x450/1e293b/6366f1?text=Misi' }}"
                        class="misi-img"
                        loading="lazy">
                </div>

                <div class="misi-text-area">
                    <h3>{{ $item->title }}</h3>
                    <p>{{ $item->description }}</p>
                </div>

            </div>
            @empty
                <p class="text-center text-gray-400 col-span-4">
                    Data misi belum tersedia
                </p>
            @endforelse

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
// JAVASCRIPT KHUSUS UNTUK HALAMAN VISI MISI
// Hanya JS yang BELUM ADA di master blade
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Efek parallax ringan untuk hero section
    const heroSection = document.querySelector('.main-content > section:first-child');

    if (heroSection) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            if (scrolled < 500) {
                heroSection.style.transform = `translateY(${scrolled * 0.3}px)`;
                heroSection.style.opacity = 1 - (scrolled * 0.002);
            }
        });
    }

    // Efek glow dinamis pada card misi saat hover
    const misiCards = document.querySelectorAll('.misi-card-clean');
    misiCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            const glowIntensity = 0.3 + (index * 0.05);
            const glowColor = `rgba(99, 102, 241, ${glowIntensity})`;
            this.style.boxShadow = `0 0 35px ${glowColor}`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '';
        });
    });

    // Animasi fade-up dengan delay bertingkat untuk misi cards
    const fadeElements = document.querySelectorAll('.misi-card-clean');
    fadeElements.forEach((el, idx) => {
        el.style.transitionDelay = `${idx * 0.1}s`;
    });
});

console.log('Halaman Visi Misi siap dengan efek khusus!');
</script>
@endpush




