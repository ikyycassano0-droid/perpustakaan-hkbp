@extends('guest.component.master')

@section('title', 'Kerjasama - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KERJASAMA
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

    /* Slider Infinite */
    .slider {
        perspective: 1200px;
        overflow: hidden;
        position: relative;
        width: 100%;
    }

    .slide-track {
        display: flex;
        gap: 40px;
        width: max-content;
        animation: scrollLoop 25s linear infinite;
    }

    @keyframes scrollLoop {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .slider:hover .slide-track {
        animation-play-state: paused;
    }

    /* Logo Card */
    .logo-card {
        width: 220px;
        height: 140px;
        border-radius: 24px;
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.3);
        transform: rotateY(-8deg) scale(0.95);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .logo-card img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 20px;
        filter: brightness(0.95) contrast(1.1);
        transition: filter 0.3s ease;
    }

    .logo-card::before {
        content: "";
        position: absolute;
        inset: -20px;
        background: radial-gradient(circle, rgba(99,102,241,0.5), transparent 70%);
        filter: blur(40px);
        opacity: 0;
        transition: 0.4s;
        z-index: -1;
    }

    .logo-card:hover {
        transform: rotateY(0deg) scale(1.1) translateY(-10px);
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.4);
    }

    .logo-card:hover::before {
        opacity: 1;
    }

    .logo-card:hover img {
        filter: brightness(1.1) contrast(1.2);
    }

    /* Partner Card */
    .partner-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.5rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .partner-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 25px 40px -12px rgba(99, 102, 241, 0.35);
    }

    .partner-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .partner-card:hover .partner-icon {
        transform: scale(1.1);
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.2));
    }

    .partner-card h4 {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .partner-card p {
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.5;
    }

    /* Info Card */
    .info-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.75rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        height: 100%;
        text-align: center;
    }

    .info-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 25px 40px -12px rgba(99, 102, 241, 0.35);
    }

    .info-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .info-card:hover .info-icon {
        transform: scale(1.1);
    }

    .info-card h4 {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .info-card p {
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.5;
    }

    /* Glow Button */
    .glow-btn {
        box-shadow: 0 0 20px rgba(99,102,241,0.5);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        cursor: pointer;
        color: white;
        font-weight: 600;
    }

    .glow-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 35px rgba(99,102,241,0.8);
    }

    /* Tambahkan di style Visi Misi */
    .depth-2 { transform: translateZ(24px); }

    /* CTA Card */
    .cta-card {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05));
        border: 1px solid rgba(99, 102, 241, 0.4);
    }

    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
</style>
@endpush


@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-12 text-center px-5">
        <div class="inline-block glass-card px-5 py-1.5 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">KOLABORASI STRATEGIS</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Kerja<span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">sama</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Perpustakaan AKPER HKBP Balige menjalin kemitraan dengan berbagai institusi terkemuka
        </p>
    </section>

    <!-- DESKRIPSI -->
    <section class="max-w-6xl mx-auto px-5 mb-16">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent mb-3">
                            Jaringan Mitra Strategis
                        </h2>

                        {{-- AMBIL DARI DATABASE --}}
                        @php
                            $desc = $kerjasama->first();
                        @endphp

                        <p class="text-gray-300 leading-relaxed">
                            {{ $desc->description ?? 'Belum ada deskripsi kerjasama' }}
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MITRA STRATEGIS -->
    <section class="max-w-6xl mx-auto px-5 mt-12 mb-16">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
                <span class="text-indigo-400 text-sm">🏛️</span>
                <span class="text-indigo-300 text-sm font-medium">Mitra Utama</span>
            </div>
            <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Mitra Strategis
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- LOOP DATA ADMIN --}}
            @foreach($kerjasama as $item)
            <div class="partner-card fade-up tilt-card">
                <div class="partner-icon">🏢</div>

                <h4>{{ $item->title }}</h4>

                <p>{{ $item->description }}</p>
            </div>
            @endforeach

        </div>
    </section>

    <!-- LOGO SLIDER -->
    <section class="mt-12 mb-16 px-5">
        <div class="text-center mb-10">
            <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Rekan Kolaborasi
            </h3>
        </div>

        <div class="slider fade-up">
            <div class="slide-track">

                {{-- LOOP GAMBAR --}}
                @foreach($kerjasama as $item)
                    @if($item->image)
                        <div class="logo-card">
                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                        </div>
                    @endif
                @endforeach

                {{-- DUPLIKASI UNTUK INFINITE --}}
                @foreach($kerjasama as $item)
                    @if($item->image)
                        <div class="logo-card">
                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </section>

    <!-- BENTUK KERJASAMA -->
    <section class="max-w-6xl mx-auto px-5 mt-20 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($kerjasama as $item)
                @if($item->sequence >= 1 && $item->sequence <= 3)
                <div class="info-card fade-up tilt-card">
                    <div class="info-icon">📌</div>
                    <h4>{{ $item->title }}</h4>
                    <p>{{ $item->description }}</p>
                </div>
                @endif
            @endforeach

        </div>
    </section>

    <!-- CTA -->
    <section class="mb-32 px-5">
        <div class="glass-card p-8 md:p-12 rounded-3xl max-w-3xl mx-auto text-center cta-card fade-up">
            <div class="text-5xl mb-4">🤝</div>
            <h3 class="text-2xl md:text-3xl font-bold mb-3 bg-gradient-to-r from-indigo-200 to-purple-200 bg-clip-text text-transparent">
                Ajukan Kerjasama
            </h3>

            <button class="glow-btn px-8 py-3 rounded-full">
                Hubungi Kami →
            </button>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN KERJASAMA
// Hanya JS yang BELUM ADA di master blade
// ============================================

document.addEventListener('DOMContentLoaded', function() {

    // 1. Tilt 3D effect untuk cards
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

    // 2. Handle image error untuk logo cards
    const allImages = document.querySelectorAll('.logo-card img');
    allImages.forEach(img => {
        img.addEventListener('error', function() {
            const text = this.alt || 'Mitra';
            const firstLetter = text.charAt(0);
            this.style.objectFit = 'cover';
            this.style.padding = '0';
            this.style.backgroundColor = '#1e293b';
            if (this.parentElement) {
                const fallbackDiv = document.createElement('div');
                fallbackDiv.className = 'w-full h-full flex items-center justify-center text-indigo-300 font-bold text-xl bg-slate-800';
                fallbackDiv.innerText = firstLetter || '?';
                this.style.display = 'none';
                this.parentElement.appendChild(fallbackDiv);
            }
        });
    });

    // 3. Stagger animation untuk cards
    const partnerCards = document.querySelectorAll('.partner-card');
    partnerCards.forEach((card, idx) => {
        card.style.transitionDelay = `${idx * 0.1}s`;
    });

    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach((card, idx) => {
        card.style.transitionDelay = `${idx * 0.1}s`;
    });
});

console.log('Halaman Kerjasama siap dengan infinite slider dan efek tilt 3D!');
</script>
@endpush
