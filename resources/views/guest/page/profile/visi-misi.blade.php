{{-- resources/views/visi-misi.blade.php --}}
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
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    /* Title gradient untuk halaman visi misi */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
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
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION VISI MISI -->
    <section class="pt-28 pb-10 text-center px-5 md:pt-32">
        <div class="inline-block hero-badge px-5 py-1.5 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">✨ AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight title-main fade-up">
            Visi & Misi
        </h1>
        <p class="text-gray-400 mt-5 max-w-xl mx-auto fade-up text-sm md:text-base">
            Perpustakaan Digital yang Mendukung Pendidikan Keperawatan Unggul
        </p>
    </section>

    <!-- ABOUT SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex items-center gap-3 mb-5">
                    <div class="text-3xl md:text-4xl">📘</div>
                    <h2 class="text-xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent">
                        Tentang AKPER HKBP
                    </h2>
                </div>
                <p class="text-gray-300 text-sm md:text-lg leading-relaxed">
                    Akademi Keperawatan HKBP Balige merupakan institusi pendidikan yang berkomitmen dalam mencetak tenaga kesehatan profesional 
                    yang unggul, beretika, dan siap menghadapi tantangan global. Perpustakaan menjadi pusat informasi dan pembelajaran yang 
                    mendukung kegiatan akademik secara optimal, dengan mengintegrasikan teknologi modern dan koleksi pengetahuan terkini.
                </p>
            </div>
        </div>
    </section>

    <!-- VISI SECTION -->
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
                    "Menjadi perpustakaan akademi keperawatan yang unggul, modern, berbasis teknologi serta mampu mendukung pendidikan, 
                    penelitian dan pengabdian masyarakat secara berkelanjutan."
                </p>
            </div>
        </div>
    </section>

    <!-- MISI SECTION -->
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
            
            <!-- MISI CARD 1 -->
            <div class="misi-card-clean fade-up">
                <div class="misi-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&h=450&fit=crop" 
                        alt="Koleksi Buku" 
                        class="misi-img"
                        loading="lazy">
                </div>
                <div class="misi-text-area">
                    <h3>📚 Koleksi Berkualitas</h3>
                    <p>Menyediakan sumber belajar terbaik, jurnal ilmiah, dan referensi keperawatan mutakhir yang mendukung kurikulum berbasis riset dan evidence-based practice.</p>
                </div>
            </div>

            <!-- MISI CARD 2 -->
            <div class="misi-card-clean fade-up">
                <div class="misi-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=600&h=450&fit=crop" 
                        alt="Teknologi Digital" 
                        class="misi-img"
                        loading="lazy">
                </div>
                <div class="misi-text-area">
                    <h3>💻 Teknologi Modern</h3>
                    <p>Mengintegrasikan akses digital cepat, e-library, basis data terintegrasi, dan layanan online 24/7 untuk mahasiswa, dosen, dan tenaga kependidikan.</p>
                </div>
            </div>

            <!-- MISI CARD 3 -->
            <div class="misi-card-clean fade-up">
                <div class="misi-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=600&h=450&fit=crop" 
                        alt="Literatur Keperawatan" 
                        class="misi-img"
                        loading="lazy">
                </div>
                <div class="misi-text-area">
                    <h3>📖 Pengayaan Koleksi</h3>
                    <p>Memperkaya koleksi cetak dan digital, termasuk jurnal internasional, database keperawatan, serta akses evidence-based nursing resources.</p>
                </div>
            </div>

            <!-- MISI CARD 4 -->
            <div class="misi-card-clean fade-up">
                <div class="misi-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=600&h=450&fit=crop" 
                        alt="Inovasi Digital" 
                        class="misi-img"
                        loading="lazy">
                </div>
                <div class="misi-text-area">
                    <h3>🚀 Inovasi Berkelanjutan</h3>
                    <p>Mengembangkan layanan mandiri, sistem rekomendasi bacaan berbasis AI, dan kolaborasi dengan institusi kesehatan nasional & internasional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER QUOTE -->
    <section class="pb-16 md:pb-20 text-center px-5">
        <div class="inline-block px-5 md:px-8 py-4 md:py-5 rounded-full max-w-2xl mx-auto fade-up" 
             style="background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.1)); border-left: 3px solid #6366f1;">
            <p class="text-indigo-200 text-xs md:text-base">
                📌 "Melayani dengan Kasih, Mendidik dengan Presisi Klinis" — AKPER HKBP Balige
            </p>
        </div>
    </section>

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