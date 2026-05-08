@extends('user.component.master')

@section('title', 'Visi & Misi - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN VISI MISI
    ============================================ */
    
    .glass-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 25px rgba(99,102,241,0.5);
    }
    
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
    
    .hero-badge {
        background: rgba(99,102,241,0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(99,102,241,0.3);
    }
    
    .fade-up {
        animation: fadeUp 0.6s ease-out forwards;
        opacity: 0;
    }
    
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    
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

    <!-- HERO -->
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

    <!-- ABOUT (TENTANG) -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex items-center gap-3 mb-5">
                    <div class="text-3xl md:text-4xl">📘</div>
                    <h2 class="text-xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent">
                        Tentang AKPER HKBP
                    </h2>
                </div>
                @if($about && $about->description)
                <p class="text-gray-300 text-sm md:text-lg leading-relaxed">
                    {{ $about->description }}
                </p>
                @else
                <p class="text-gray-500 italic">
                    Konten tentang AKPER HKBP belum tersedia. Silakan hubungi administrator.
                </p>
                @endif
            </div>
        </div>
    </section>

    <!-- VISI -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex items-center gap-3 mb-5">
                    <div class="text-3xl md:text-4xl">✨</div>
                    <h2 class="text-xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent">
                        Visi
                    </h2>
                </div>

                @if($visi && $visi->description)
                <p class="text-gray-300 text-sm md:text-lg leading-relaxed italic border-l-4 border-indigo-500 pl-4 md:pl-5">
                    "{{ $visi->description }}"
                </p>
                @else
                <p class="text-gray-500 italic border-l-4 border-indigo-500 pl-4 md:pl-5">
                    Visi belum tersedia. Silakan hubungi administrator.
                </p>
                @endif
            </div>
        </div>
    </section>

    <!-- MISI -->
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
            @forelse($misi as $index => $item)
            <div class="misi-card-clean fade-up" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="misi-img-wrapper">
                    <img 
                        src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/600x450/1e293b/6366f1?text=Misi' }}"
                        class="misi-img"
                        alt="{{ $item->title }}"
                        loading="lazy"
                        onerror="this.src='https://placehold.co/600x450/1e293b/6366f1?text=Image+Not+Found'">
                </div>
                <div class="misi-text-area">
                    <h3>{{ $item->title ?? 'Misi ' . ($index + 1) }}</h3>
                    <p>{{ $item->description ?? 'Deskripsi misi belum tersedia' }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400">
                    <i class="fas fa-info-circle text-4xl mb-3"></i>
                    <p>Data misi belum tersedia. Silakan hubungi administrator.</p>
                </div>
            </div>
            @endforelse
        </div>
    </section>

    <!-- FOOTER QUOTE -->
    <section class="pb-16 md:pb-20 text-center px-5">
        <div class="inline-block px-5 md:px-8 py-4 md:py-5 rounded-full max-w-2xl mx-auto fade-up" 
             style="background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.1)); border-left: 3px solid #6366f1;">
            <p class="text-indigo-200 text-xs md:text-base">
                📌 "Melayani dengan Kasih, Mendidik dengan Presisi Klinis"
            </p>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
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
});

console.log('Halaman Visi Misi siap dengan efek khusus!');
</script>
@endpush