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

    <!-- STATISTIK SECTION -->
    <section class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-5 px-5 max-w-5xl mx-auto">
        <div class="stat-card p-5 rounded-xl text-center hover-card fade-up">
            <div class="stat-number">12</div>
            <p class="text-gray-400 text-sm mt-1">Staff Ahli</p>
        </div>
        <div class="stat-card p-5 rounded-xl text-center hover-card fade-up">
            <div class="stat-number">45K+</div>
            <p class="text-gray-400 text-sm mt-1">Koleksi Digital</p>
        </div>
        <div class="stat-card p-5 rounded-xl text-center hover-card fade-up">
            <div class="stat-number">A</div>
            <p class="text-gray-400 text-sm mt-1">Akreditasi</p>
        </div>
        <div class="stat-card p-5 rounded-xl text-center hover-card fade-up">
            <div class="stat-number">15</div>
            <p class="text-gray-400 text-sm mt-1">Tahun Pengabdian</p>
        </div>
    </section>

    <!-- DIREKTUR SECTION -->
    <section class="mt-20 text-center px-5">
        <div class="profile-card inline-block w-[320px] mx-auto fade-up">
            <div class="p-6">
                <div class="w-28 h-28 rounded-xl mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-4xl shadow-lg">
                    👩‍⚕️
                </div>
                <h3 class="font-bold text-xl text-white">Ns. Jane Doe, M.Kep</h3>
                <p class="text-indigo-300 text-sm mt-1">Direktur AKPER HKBP Balige</p>
                <div class="mt-3 text-xs text-gray-400">📧 direktur@akperhkpb.ac.id</div>
            </div>
        </div>
        <div class="line mt-6"></div>
    </section>

    <!-- KEPALA PERPUSTAKAAN SECTION -->
    <section class="mt-8 text-center px-5">
        <div class="profile-card inline-block w-[320px] mx-auto fade-up">
            <div class="p-6">
                <div class="w-24 h-24 rounded-lg mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-3xl shadow-lg">
                    📚
                </div>
                <h3 class="font-semibold text-xl text-white">Bpk. Robert Simanjuntak</h3>
                <p class="text-indigo-300 text-sm mt-1">Kepala Perpustakaan</p>
                <div class="mt-3 text-xs text-gray-400">📞 (0632) 12345</div>
            </div>
        </div>
        <div class="line mt-6"></div>
    </section>

    <!-- STAFF GRID (3 kolom) -->
    <section class="mt-12 px-5">
        <div class="grid md:grid-cols-3 gap-5 max-w-4xl mx-auto">
            <div class="profile-card p-4 rounded-xl flex items-center gap-4 fade-up">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white shadow-md">SN</div>
                <div>
                    <h4 class="font-semibold text-white">Sri Nurhaliza</h4>
                    <p class="text-gray-400 text-sm">Pengolahan & Arsip</p>
                </div>
            </div>
            <div class="profile-card p-4 rounded-xl flex items-center gap-4 fade-up">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white shadow-md">BS</div>
                <div>
                    <h4 class="font-semibold text-white">Budi Santoso</h4>
                    <p class="text-gray-400 text-sm">Sirkulasi</p>
                </div>
            </div>
            <div class="profile-card p-4 rounded-xl flex items-center gap-4 fade-up">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white shadow-md">DA</div>
                <div>
                    <h4 class="font-semibold text-white">Dedi Ardiansyah</h4>
                    <p class="text-gray-400 text-sm">IT Perpustakaan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TIMELINE STRUKTUR -->
    <section class="mt-28 px-5">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3">
                <span class="text-indigo-400 text-sm">📋</span>
                <span class="text-indigo-300 text-sm font-medium">Hierarki Organisasi</span>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">
                Struktur Kepemimpinan
            </h3>
        </div>

        <div class="max-w-4xl mx-auto relative">
            <!-- GARIS TENGAH VERTIKAL -->
            <div class="absolute left-1/2 top-0 bottom-0 w-[2px] bg-gradient-to-b from-indigo-500/40 via-indigo-400/20 to-transparent hidden md:block"></div>

            <!-- ITEM 1 - DIREKTUR (kiri) -->
            <div class="mb-16 flex flex-col md:flex-row items-center justify-start fade-up">
                <div class="md:w-1/2 md:pr-10 text-center md:text-right mb-4 md:mb-0">
                    <div class="profile-card p-5 rounded-xl inline-block">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">👑</div>
                            <div>
                                <h4 class="text-indigo-400 font-bold">Direktur</h4>
                                <p class="text-gray-400 text-sm">Memimpin seluruh kebijakan akademik</p>
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
                    <div class="profile-card p-5 rounded-xl inline-block">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">📚</div>
                            <div>
                                <h4 class="text-indigo-400 font-bold">Kepala Perpustakaan</h4>
                                <p class="text-gray-400 text-sm">Mengelola operasional layanan perpustakaan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ITEM 3 - LAYANAN TEKNIS (kiri) -->
            <div class="mb-16 flex flex-col md:flex-row items-center justify-start fade-up">
                <div class="md:w-1/2 md:pr-10 text-center md:text-right mb-4 md:mb-0">
                    <div class="profile-card p-5 rounded-xl inline-block">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">⚙️</div>
                            <div>
                                <h4 class="text-indigo-400 font-bold">Layanan Teknis</h4>
                                <p class="text-gray-400 text-sm">Pengolahan & klasifikasi koleksi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="timeline-dot relative z-10 mx-4">⚙️</div>
                <div class="md:w-1/2"></div>
            </div>
        </div>
    </section>

    <!-- TIM PERPUSTAKAAN GRID 4 KOLOM -->
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
            <!-- Card 1 -->
            <div class="profile-card p-5 rounded-xl text-center fade-up">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-xl font-bold text-white shadow-lg">SN</div>
                <h4 class="font-semibold text-white">Sri Nurlailah</h4>
                <p class="text-indigo-300 text-sm">Pengolahan Koleksi</p>
            </div>

            <!-- Card 2 -->
            <div class="profile-card p-5 rounded-xl text-center fade-up">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-xl font-bold text-white shadow-lg">BS</div>
                <h4 class="font-semibold text-white">Budi Santoso</h4>
                <p class="text-indigo-300 text-sm">Sirkulasi</p>
            </div>

            <!-- Card 3 -->
            <div class="profile-card p-5 rounded-xl text-center fade-up">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-xl font-bold text-white shadow-lg">DA</div>
                <h4 class="font-semibold text-white">Dedi Arisandi</h4>
                <p class="text-indigo-300 text-sm">IT Perpustakaan</p>
            </div>

            <!-- Card 4 -->
            <div class="profile-card p-5 rounded-xl text-center fade-up">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-xl font-bold text-white shadow-lg">HW</div>
                <h4 class="font-semibold text-white">Hendra Wijaya</h4>
                <p class="text-indigo-300 text-sm">Support & Maintenance</p>
            </div>
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