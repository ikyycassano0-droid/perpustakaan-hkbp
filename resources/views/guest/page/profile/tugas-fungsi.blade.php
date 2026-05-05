@extends('guest.component.master')

@section('title', 'Tugas & Fungsi - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN TUGAS & FUNGSI
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card untuk tugas fungsi */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 1.5rem;
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
</style>
@endpush

@section('content')

<div class="main-content">

```
<!-- ================= HERO - TUGAS ================= -->
<section class="pt-28 pb-12 px-5">
    <div class="text-center">
        <div class="inline-block glass-card px-5 py-1.5 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📋 TUGAS & FUNGSI</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight title-main fade-up">
            Tugas Pokok
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
                    $img = $tujuan->firstWhere('image', '!=', null);
                @endphp

                @if($img && $img->image)
                    <img src="{{ asset('storage/'.$img->image) }}" class="rounded-xl w-full">
                @else
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&h=450&fit=crop" 
                         class="rounded-xl w-full">
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
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-400 text-sm">
                                {{ $item->description }}
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

<!-- QUOTE -->
<section class="pb-24 text-center px-5">
    <div class="glass-card inline-block px-8 py-5 rounded-full max-w-2xl mx-auto fade-up">
        <p class="text-indigo-200 text-sm md:text-base">
            📌 "{{ $tujuan->last()->description ?? 'Melayani dengan Kasih, Mendidik dengan Presisi Klinis' }}"
        </p>
    </div>
</section>
```

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