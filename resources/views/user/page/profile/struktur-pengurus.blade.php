@extends('user.component.master')

@section('title', 'Struktur Pengurus - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN STRUKTUR
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Glass card untuk struktur */
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
/* ===== RESET & BASE ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ===== PARTICLE CANVAS ===== */
#particleCanvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
}

/* ===== BLOB ORNAMENT ===== */
.blob {
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #6366f1, transparent);
    filter: blur(120px);
    opacity: 0.4;
    z-index: -1;
}

.blob-1 { top: -200px; left: -150px; }
.blob-2 { bottom: -250px; right: -200px; background: radial-gradient(circle, #6366f1, transparent); }

/* ===== CURSOR GLOW ORGANIK ===== */
.cursor-glow {
    position: fixed;
    width: 100px;
    height: 100px;
    pointer-events: none;
    transform: translate(-50%, -50%);
    z-index: 9999;
    border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;
    background: radial-gradient(circle at 30% 30%, rgba(99, 107, 185, 0.5), transparent 60%),
                radial-gradient(circle at 70% 70%, rgba(99,102,241,0.4), transparent 70%),
                radial-gradient(circle at 50% 50%, rgba(59,130,246,0.3), transparent 80%);
    filter: blur(55px);
    transition: opacity 0.2s;
    animation: blobMove 8s ease-in-out infinite, pulseGlow 4s ease-in-out infinite;
}

@keyframes blobMove {
    0% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
    25% { border-radius: 50% 60% 40% 60% / 60% 40% 60% 40%; }
    50% { border-radius: 70% 30% 60% 40% / 40% 70% 30% 60%; }
    75% { border-radius: 40% 60% 50% 50% / 60% 30% 70% 40%; }
    100% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
}

@keyframes pulseGlow {
    0%, 100% { filter: blur(55px) brightness(1); }
    50% { filter: blur(70px) brightness(1.15); }
}

/* ===== MAIN CONTENT ===== */
.main-content {
    position: relative;
    z-index: 10;
}

/* ===== GLASS CARD MODERN ===== */
.glass-card {
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 1.5rem;
    transition: all 0.3s ease;
}

/* ===== TITLE ===== */
.title-main {
    font-weight: 800;
    background: linear-gradient(135deg, #ffffff);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    text-shadow: 0 0 30px rgba(99, 102, 241, 0.3);
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

/* ===== 3D TILT EFFECT ===== */
.tilt-card {
    transform-style: preserve-3d;
    perspective: 1200px;
    transition: transform 0.15s ease-out;
}

/* ===== LINE CONNECTOR ===== */
.line {
    width: 2px;
    height: 50px;
    background: linear-gradient(to bottom, #6366f1, rgba(99,102,241,0.15));
    margin: 0 auto;
}

/* ===== STATISTIK CARD ===== */
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

/* ===== TIMELINE STYLE ===== */
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

/* ===== PROFILE CARD ===== */
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

/* ===== FLOATING ELEMENTS ===== */
.float {
    animation: floatAnim 6s ease-in-out infinite;
}

@keyframes floatAnim {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
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

/* ===== DELAY UTILITY ===== */
.delay-1 { transition-delay: 0.1s; }
.delay-2 { transition-delay: 0.2s; }
.delay-3 { transition-delay: 0.3s; }
</style>
@endpush

@section('content')
<!-- Particle Canvas -->
<canvas id="particleCanvas"></canvas>

<!-- Background Blobs -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<!-- Cursor Glow Organik -->
<div class="cursor-glow" id="cursorGlow"></div>

<!-- Floating Decorative Elements -->
<div class="fixed top-40 left-10 text-indigo-400 float opacity-30 pointer-events-none z-0 text-2xl">✦</div>
<div class="fixed top-60 right-20 text-indigo-300 float opacity-30 pointer-events-none z-0 text-2xl">✧</div>
<div class="fixed bottom-40 left-20 text-indigo-500 float opacity-30 pointer-events-none z-0 text-2xl">✦</div>

<div class="main-content">

```
<!-- HERO SECTION -->
<section class="pt-28 pb-12 text-center px-5">
    <div class="inline-block glass-card px-5 py-1.5 rounded-full mb-5 fade-up">
        <span class="text-indigo-300 text-sm font-medium tracking-wide">👥 STRUKTUR ORGANISASI</span>
    </div>
    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Kepemimpinan <br>
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">& Dedikasi</span>
</h1>
    <h2 class="text-2xl md:text-3xl text-indigo-400 font-bold mt-3 fade-up">
        Akademik
    </h2>
    <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
        Membangun ekosistem literasi berkualitas yang unggul melalui tata kelola perpustakaan profesional.
    </p>
</section>
    <!-- ================= FILTER DATA ================= -->
    @php
        // Filter Direktur (jabatan mengandung kata "direktur")
        $direktur = $struktur->filter(function($item) {
            return str_contains(strtolower($item->jabatan ?? ''), 'direktur');
        })->first();

        // Filter Kepala Perpustakaan
        $kepala = $struktur->filter(function($item) {
            return str_contains(strtolower($item->jabatan ?? ''), 'kepala perpustakaan');
        })->first();

        // Staff lainnya (tanpa gambar)
        $staff = $struktur->filter(function($item) use ($direktur, $kepala) {
            if($direktur && $item->id == $direktur->id) return false;
            if($kepala && $item->id == $kepala->id) return false;
            return true;
        });
    @endphp

    <!-- STATISTIK SECTION -->
    <section class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-5 px-5 max-w-5xl mx-auto fade-up">
        <div class="stat-card p-5 rounded-xl text-center hover-card">
            <div class="stat-number">{{ $staff->count() }}</div>
            <p class="text-gray-400 text-sm mt-1">Staff Perpustakaan</p>
        </div>
        <div class="stat-card p-5 rounded-xl text-center hover-card">
            <div class="stat-number">45K+</div>
            <p class="text-gray-400 text-sm mt-1">Koleksi Digital</p>
        </div>
        <div class="stat-card p-5 rounded-xl text-center hover-card">
            <div class="stat-number">A</div>
            <p class="text-gray-400 text-sm mt-1">Akreditasi</p>
        </div>
        <div class="stat-card p-5 rounded-xl text-center hover-card">
            <div class="stat-number">{{ $struktur->count() }}</div>
            <p class="text-gray-400 text-sm mt-1">Total Pengurus</p>
        </div>
    </section>

    <!-- ================= DIREKTUR (GAMBAR BESAR) ================= -->
    @if($direktur)
    <section class="mt-20 text-center px-5 fade-up">
        <div class="profile-card inline-block w-[320px] mx-auto tilt-card">
            <div class="p-6">
                @if($direktur->image)
                    <img src="{{ asset('storage/' . $direktur->image) }}" class="w-28 h-28 rounded-xl mx-auto mb-4 shadow-lg object-cover">
                @else
                    <div class="w-28 h-28 rounded-xl mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-4xl shadow-lg">
                        👩‍⚕️
                    </div>
                @endif
                <h3 class="font-bold text-xl text-white">{{ $direktur->title }}</h3>
                <p class="text-indigo-300 text-sm mt-1">{{ $direktur->jabatan }}</p>
                @if($direktur->description)
                    <div class="mt-3 text-xs text-gray-400">{{ $direktur->description }}</div>
                @endif
            </div>
        </div>
        <div class="line mt-6"></div>
    </section>
    @endif

    <!-- ================= KEPALA PERPUSTAKAAN (GAMBAR BESAR) ================= -->
    @if($kepala)
    <section class="mt-8 text-center px-5 fade-up">
        <div class="profile-card inline-block w-[320px] mx-auto tilt-card">
            <div class="p-6">
                @if($kepala->image)
                    <img src="{{ asset('storage/' . $kepala->image) }}" class="w-24 h-24 rounded-lg mx-auto mb-4 shadow-lg object-cover">
                @else
                    <div class="w-24 h-24 rounded-lg mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-3xl shadow-lg">
                        📚
                    </div>
                @endif
                <h3 class="font-semibold text-xl text-white">{{ $kepala->title }}</h3>
                <p class="text-indigo-300 text-sm mt-1">{{ $kepala->jabatan }}</p>
                @if($kepala->description)
                    <div class="mt-3 text-xs text-gray-400">{{ $kepala->description }}</div>
                @endif
            </div>
        </div>
        <div class="line mt-6"></div>
    </section>
    @endif

    <!-- ================= STAFF GRID (TANPA GAMBAR - HANYA NAMA & JABATAN) ================= -->
    @if($staff->count() > 0)
    <section class="mt-12 px-5 fade-up">
        <div class="grid md:grid-cols-3 gap-5 max-w-4xl mx-auto">
            @foreach($staff as $item)
            <div class="profile-card p-4 rounded-xl flex items-center gap-4 tilt-card">
                <!-- Icon kecil sebagai pengganti gambar -->
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500/50 to-purple-500/50 flex items-center justify-center text-white text-sm font-bold shadow-md">
                    👤
                </div>
                <div>
                    <h4 class="font-semibold text-white">{{ $item->title }}</h4>
                    <p class="text-gray-400 text-sm">{{ $item->jabatan }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- TIMELINE STRUKTUR -->
    <section class="mt-28 px-5">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
                <span class="text-indigo-400 text-sm">📋</span>
                <span class="text-indigo-300 text-sm font-medium">Hierarki Organisasi</span>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Struktur Kepemimpinan
            </h3>
        </div>

        <div class="max-w-4xl mx-auto relative">
            <!-- GARIS TENGAH VERTIKAL -->
            <div class="absolute left-1/2 top-0 bottom-0 w-[2px] bg-gradient-to-b from-indigo-500/40 via-indigo-400/20 to-transparent hidden md:block"></div>

            <!-- ITEM 1 - DIREKTUR (kiri) -->
            <div class="mb-16 flex flex-col md:flex-row items-center justify-start fade-up">
                <div class="md:w-1/2 md:pr-10 text-center md:text-right mb-4 md:mb-0">
                    <div class="profile-card p-4 rounded-xl inline-block tilt-card">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">👑</div>
                            <div>
                                <h4 class="text-indigo-400 font-bold">Direktur</h4>
                                <p class="text-gray-400 text-sm">{{ $direktur->title ?? 'Belum tersedia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="timeline-dot relative z-10 mx-4">👑</div>
                <div class="md:w-1/2"></div>
            </div>

            <!-- ITEM 2 - KEPALA PERPUSTAKAAN (kanan) -->
            <div class="mb-16 flex flex-col md:flex-row items-center justify-end fade-up">
                <div class="md:w-1/2"></div>
                <div class="timeline-dot relative z-10 mx-4">📚</div>
                <div class="md:w-1/2 md:pl-10 text-center md:text-left mt-4 md:mt-0">
                    <div class="profile-card p-4 rounded-xl inline-block tilt-card">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">📚</div>
                            <div>
                                <h4 class="text-indigo-400 font-bold">Kepala Perpustakaan</h4>
                                <p class="text-gray-400 text-sm">{{ $kepala->title ?? 'Belum tersedia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ITEM 3 - TIM PERPUSTAKAAN (kiri) -->
            <div class="mb-16 flex flex-col md:flex-row items-center justify-start fade-up">
                <div class="md:w-1/2 md:pr-10 text-center md:text-right mb-4 md:mb-0">
                    <div class="profile-card p-4 rounded-xl inline-block tilt-card">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">👥</div>
                            <div>
                                <h4 class="text-indigo-400 font-bold">Tim Perpustakaan</h4>
                                <p class="text-gray-400 text-sm">{{ $staff->count() }} Staff</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="timeline-dot relative z-10 mx-4">👥</div>
                <div class="md:w-1/2"></div>
            </div>
        </div>
    </section>

    <!-- TIM PERPUSTAKAAN GRID (TANPA GAMBAR) -->
    @if($staff->count() > 0)
    <section class="mt-20 mb-24 px-5">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
                <span class="text-indigo-400 text-sm">👥</span>
                <span class="text-indigo-300 text-sm font-medium">Pengurus Harian</span>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Tim Perpustakaan
            </h3>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @foreach($staff as $index => $item)
            <div class="profile-card p-5 rounded-xl text-center tilt-card fade-up delay-{{ ($index % 3) + 1 }}">
                <!-- Icon bulat sebagai pengganti gambar -->
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-br from-indigo-500/60 to-purple-500/60 flex items-center justify-center text-2xl text-white shadow-lg">
                    👤
                </div>
                <h4 class="font-semibold text-white">{{ $item->title }}</h4>
                <p class="text-indigo-300 text-sm">{{ $item->jabatan }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

@push('scripts')
<script>
// ==========================
// 1. PARTICLE ENGINE
// ==========================
const canvas = document.getElementById('particleCanvas');
let ctx = canvas.getContext('2d');
let particles = [];
let animationId = null;

document.addEventListener('DOMContentLoaded'), function() {

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
}

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

function initParticles() {
    const particleCount = 80;
    particles = [];
    for (let i = 0; i < particleCount; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            dx: (Math.random() - 0.5) * 0.6,
            dy: (Math.random() - 0.5) * 0.6,
            r: Math.random() * 2.5 + 1,
            opacity: Math.random() * 0.5 + 0.2
        });
    }
}

function drawParticles() {
    if (!ctx) return;
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach(p => {
        p.x += p.dx;
        p.y += p.dy;

        if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.dy *= -1;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(99, 102, 241, ${p.opacity * 0.8})`;
        ctx.fill();
    });

    animationId = requestAnimationFrame(drawParticles);
}

function startParticles() {
    if (animationId) cancelAnimationFrame(animationId);
    resizeCanvas();
    initParticles();
    drawParticles();
}

window.addEventListener('resize', () => {
    resizeCanvas();
    initParticles();
});

startParticles();

// ==========================
// 2. CURSOR GLOW ORGANIK
// ==========================
const cursorGlow = document.getElementById('cursorGlow');
if (cursorGlow) {
    document.addEventListener('mousemove', (e) => {
        cursorGlow.style.left = e.clientX + 'px';
        cursorGlow.style.top = e.clientY + 'px';
    });
    document.addEventListener('mouseleave', () => {
        cursorGlow.style.opacity = '0';
    });
    document.addEventListener('mouseenter', () => {
        cursorGlow.style.opacity = '1';
    });
}

// ==========================
// 3. FADE-UP INTERSECTION OBSERVER
// ==========================
const fadeElements = document.querySelectorAll('.fade-up');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });
fadeElements.forEach(el => observer.observe(el));

// ==========================
// 4. 3D TILT EFFECT
// ==========================
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
        card.style.transform = `perspective(1200px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = `perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1)`;
    });
});

// ==========================
// 5. PARALLAX MINOR
// ==========================
window.addEventListener('scroll', () => {
    const heroTitle = document.querySelector('.title-main');
    if (heroTitle) {
        const scrollY = window.scrollY;
        heroTitle.style.transform = `translateY(${scrollY * 0.03}px)`;
    }
});

console.log('Struktur Pengurus Page siap!');
</script>
@endpush
