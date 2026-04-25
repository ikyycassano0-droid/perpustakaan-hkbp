{{-- resources/views/struktur.blade.php --}}
@extends('guest.component.master')

@section('title', 'Struktur Pengurus - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN STRUKTUR
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card untuk struktur */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
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
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.3);
    }
    
    /* Neon border efek */
    .neon-border {
        position: relative;
        border-radius: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .neon-border::before {
        content: "";
        position: absolute;
        inset: -1px;
        border-radius: 1.5rem;
        background: linear-gradient(130deg, #6366f1, #8b5cf6, #3b82f6);
        opacity: 0;
        transition: 0.3s ease;
        z-index: -1;
    }
    
    .neon-border:hover::before {
        opacity: 0.35;
    }
    
    .neon-border:hover {
        transform: translateY(-3px);
    }
    
    /* Hover card effect */
    .hover-card {
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.5);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.25);
    }
    
    /* Line connector */
    .line {
        width: 2px;
        height: 50px;
        background: linear-gradient(to bottom, #6366f1, rgba(99,102,241,0.15));
        margin: 0 auto;
    }
    
    /* Statistik card */
    .stat-card {
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 10px 25px -10px rgba(99, 102, 241, 0.2);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }
    
    /* Timeline dot */
    .timeline-dot {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
        z-index: 10;
    }
    
    /* Profile card */
    .profile-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        border: 1px solid rgba(99, 102, 241, 0.25);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.5);
        box-shadow: 0 20px 30px -12px rgba(99, 102, 241, 0.2);
    }
    
    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    
    /* Avatar placeholder */
    .avatar-placeholder {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    
    /* Responsive timeline */
    @media (max-width: 768px) {
        .timeline-dot {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">

```
<!-- HERO SECTION -->
<section class="pt-28 pb-12 text-center px-5">
    <div class="inline-block glass-card px-5 py-1.5 rounded-full mb-5 fade-up">
        <span class="text-indigo-300 text-sm font-medium tracking-wide">👥 STRUKTUR ORGANISASI</span>
    </div>
    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight title-main fade-up">
        Kepemimpinan & Dedikasi
    </h1>
    <h2 class="text-2xl md:text-3xl text-indigo-400 font-bold mt-3 fade-up">
        Akademik
    </h2>
    <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
        Membangun ekosistem literasi berkualitas yang unggul melalui tata kelola perpustakaan profesional.
    </p>
</section>

<!-- ================= DATA FILTER ================= -->
@php
    $direktur = $struktur->where('jabatan', 'Direktur')->first();
    $kepala   = $struktur->where('jabatan', 'Kepala Perpustakaan')->first();
    $staff    = $struktur->whereNotIn('jabatan', ['Direktur','Kepala Perpustakaan']);
@endphp

<!-- DIREKTUR -->
<section class="mt-20 text-center px-5">
    @if($direktur)
    <div class="profile-card inline-block w-[320px] mx-auto fade-up">
        <div class="p-6">

            <div class="w-28 h-28 rounded-xl mx-auto mb-4 overflow-hidden shadow-lg">
                @if($direktur->image)
                    <img src="{{ asset('storage/'.$direktur->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="avatar-placeholder w-full h-full text-4xl">
                        {{ strtoupper(substr($direktur->title,0,1)) }}
                    </div>
                @endif
            </div>

            <h3 class="font-bold text-xl text-white">{{ $direktur->title }}</h3>
            <p class="text-indigo-300 text-sm mt-1">{{ $direktur->jabatan }}</p>

        </div>
    </div>
    @endif
    <div class="line mt-6"></div>
</section>

<!-- KEPALA -->
<section class="mt-8 text-center px-5">
    @if($kepala)
    <div class="profile-card inline-block w-[320px] mx-auto fade-up">
        <div class="p-6">

            <div class="w-24 h-24 rounded-lg mx-auto mb-4 overflow-hidden shadow-lg">
                @if($kepala->image)
                    <img src="{{ asset('storage/'.$kepala->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="avatar-placeholder w-full h-full text-3xl">
                        {{ strtoupper(substr($kepala->title,0,1)) }}
                    </div>
                @endif
            </div>

            <h3 class="font-semibold text-xl text-white">{{ $kepala->title }}</h3>
            <p class="text-indigo-300 text-sm mt-1">{{ $kepala->jabatan }}</p>

        </div>
    </div>
    @endif
    <div class="line mt-6"></div>
</section>

<!-- STAFF GRID -->
<section class="mt-12 px-5">
    <div class="grid md:grid-cols-3 gap-5 max-w-4xl mx-auto">

        @foreach($staff as $item)
        <div class="profile-card p-4 rounded-xl flex items-center gap-4 fade-up">

            <div class="w-12 h-12 rounded-lg overflow-hidden shadow-md">
                @if($item->image)
                    <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="avatar-placeholder w-full h-full">
                        {{ strtoupper(substr($item->title,0,2)) }}
                    </div>
                @endif
            </div>

            <div>
                <h4 class="font-semibold text-white">{{ $item->title }}</h4>
                <p class="text-gray-400 text-sm">{{ $item->jabatan }}</p>
            </div>

        </div>
        @endforeach

    </div>
</section>

<!-- TIM GRID -->
<section class="mt-20 mb-24 px-5">
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3">
            <span class="text-indigo-400 text-sm">👥</span>
            <span class="text-indigo-300 text-sm font-medium">Pengurus Harian</span>
        </div>
        <h3 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">
            Tim Perpustakaan
        </h3>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">

        @foreach($staff as $item)
        <div class="profile-card p-5 rounded-xl text-center fade-up">

            <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden shadow-lg">
                @if($item->image)
                    <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="avatar-placeholder w-full h-full">
                        {{ strtoupper(substr($item->title,0,2)) }}
                    </div>
                @endif
            </div>

            <h4 class="font-semibold text-white">{{ $item->title }}</h4>
            <p class="text-indigo-300 text-sm">{{ $item->jabatan }}</p>

        </div>
        @endforeach

    </div>
</section>


</div>
@endsection


@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN STRUKTUR
// Hanya JS yang BELUM ADA di master blade
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Tilt 3D effect untuk profile cards
    const tiltCards = document.querySelectorAll('.profile-card');
    tiltCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 25;
            const rotateY = (x - centerX) / 25;
            card.style.transform = `perspective(1200px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = `perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1)`;
        });
    });
    
    // 2. Parallax efek untuk hero title
    const heroTitle = document.querySelector('.title-main');
    if (heroTitle) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            if (scrollY < 400) {
                heroTitle.style.transform = `translateY(${scrollY * 0.03}px)`;
            }
        });
    }
    
    // 3. Counter animasi untuk statistik (opsional)
    const statNumbers = document.querySelectorAll('.stat-number');
    const hasAnimated = new Map();
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !hasAnimated.get(entry.target)) {
                hasAnimated.set(entry.target, true);
                const element = entry.target;
                const targetText = element.innerText;
                
                if (targetText.includes('K+')) {
                    const number = parseInt(targetText);
                    animateNumber(element, number, 0, 2000, 'K+');
                } else if (!isNaN(parseInt(targetText))) {
                    const number = parseInt(targetText);
                    animateNumber(element, number, 0, 2000, '');
                }
            }
        });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(el => counterObserver.observe(el));
    
    function animateNumber(element, target, current, duration, suffix) {
        const increment = target / (duration / 16);
        let start = current;
        
        function updateNumber() {
            start += increment;
            if (start < target) {
                element.innerText = Math.floor(start) + suffix;
                requestAnimationFrame(updateNumber);
            } else {
                element.innerText = target + suffix;
            }
        }
        
        updateNumber();
    }
    
    // 4. Staggered animation untuk timeline items
    const timelineItems = document.querySelectorAll('.timeline-container > div');
    timelineItems.forEach((item, idx) => {
        item.style.transitionDelay = `${idx * 0.15}s`;
    });
});

console.log('Halaman Struktur Organisasi siap dengan efek tilt 3D dan counter animasi!');
</script>
@endpush