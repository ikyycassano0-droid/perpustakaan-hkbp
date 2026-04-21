@extends('guest.component.master')

@section('title', 'Kerjasama - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KERJASAMA
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
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
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight title-main fade-up">
            Kerjasama
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Perpustakaan AKPER HKBP Balige menjalin kemitraan dengan berbagai institusi terkemuka
        </p>
    </section>

    <!-- DESKRIPSI KERJASAMA -->
    <section class="max-w-6xl mx-auto px-5 mb-16">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text text-transparent mb-3">
                            Jaringan Mitra Strategis
                        </h2>
                        <p class="text-gray-300 leading-relaxed">
                            Melalui kerjasama yang berkelanjutan, Perpustakaan AKPER HKBP Balige berkomitmen untuk meningkatkan 
                            akses informasi, sumber daya digital, dan program pengembangan koleksi bersama institusi pendidikan 
                            tinggi, asosiasi profesi, dan lembaga kesehatan nasional maupun internasional.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MITRA STRATEGIS (CARD GRID) -->
    <section class="max-w-6xl mx-auto px-5 mt-12 mb-16">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
                <span class="text-indigo-400 text-sm">🏛️</span>
                <span class="text-indigo-300 text-sm font-medium">Mitra Utama</span>
            </div>
            <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Mitra Strategis
            </h3>
            <p class="text-indigo-200/70 mt-2 fade-up">Berkolaborasi dengan institusi terpercaya di Indonesia</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="partner-card fade-up tilt-card">
                <div class="partner-icon">🏥</div>
                <h4>Rumah Sakit Umum</h4>
                <p>Kerjasama dengan berbagai RS di Sumatera Utara untuk akses jurnal dan penelitian klinis</p>
            </div>
            <div class="partner-card fade-up tilt-card">
                <div class="partner-icon">🎓</div>
                <h4>Perguruan Tinggi</h4>
                <p>Kemitraan dengan universitas ternama untuk pertukaran koleksi dan sumber daya digital</p>
            </div>
            <div class="partner-card fade-up tilt-card">
                <div class="partner-icon">📚</div>
                <h4>Asosiasi Profesi</h4>
                <p>Kolaborasi dengan PPNI dan organisasi profesi keperawatan lainnya</p>
            </div>
            <div class="partner-card fade-up tilt-card">
                <div class="partner-icon">🌐</div>
                <h4>Mitra Internasional</h4>
                <p>Jaringan global dengan perpustakaan kesehatan di Asia dan Eropa</p>
            </div>
        </div>
    </section>

    <!-- LOGO SLIDER INFINITE -->
    <section class="mt-12 mb-16 px-5">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
                <span class="text-indigo-400 text-sm">🏛️</span>
                <span class="text-indigo-300 text-sm font-medium">Mitra Kami</span>
            </div>
            <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Rekan Kolaborasi
            </h3>
            <p class="text-indigo-200/70 mt-2 fade-up">Berkolaborasi dengan institusi terpercaya di Indonesia</p>
        </div>

        <div class="slider fade-up">
            <div class="slide-track">
                <!-- LOGO - Baris 1 -->
                <div class="logo-card"><img src="assets/ui.png" alt="UI" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=Universitas+Indonesia'"></div>
                <div class="logo-card"><img src="assets/ugm.png" alt="UGM" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=UGM'"></div>
                <div class="logo-card"><img src="assets/unair.png" alt="UNAIR" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=Unair'"></div>
                <div class="logo-card"><img src="assets/itb.png" alt="ITB" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=ITB'"></div>
                <div class="logo-card"><img src="assets/ipb.png" alt="IPB" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=IPB'"></div>
                
                <!-- DUPLIKASI UNTUK SMOOTH INFINITE -->
                <div class="logo-card"><img src="assets/ui.png" alt="UI" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=Universitas+Indonesia'"></div>
                <div class="logo-card"><img src="assets/ugm.png" alt="UGM" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=UGM'"></div>
                <div class="logo-card"><img src="assets/unair.png" alt="UNAIR" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=Unair'"></div>
                <div class="logo-card"><img src="assets/itb.png" alt="ITB" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=ITB'"></div>
                <div class="logo-card"><img src="assets/ipb.png" alt="IPB" onerror="this.src='https://placehold.co/220x140/1e293b/6366f1?text=IPB'"></div>
            </div>
        </div>
    </section>

    <!-- BENTUK KERJASAMA (Grid Info) -->
    <section class="max-w-6xl mx-auto px-5 mt-20 mb-16">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3 fade-up">
                <span class="text-indigo-400 text-sm">📋</span>
                <span class="text-indigo-300 text-sm font-medium">Ruang Lingkup</span>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent fade-up">
                Bentuk Kerjasama
            </h3>
            <p class="text-indigo-200/70 mt-2 fade-up">Beragam program kolaborasi untuk kemajuan bersama</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="info-card fade-up tilt-card">
                <div class="info-icon">📚</div>
                <h4>Pertukaran Koleksi</h4>
                <p>Kerjasama peminjaman antar perpustakaan (inter-library loan) dan berbagi sumber daya koleksi digital.</p>
            </div>
            <div class="info-card fade-up tilt-card">
                <div class="info-icon">🔬</div>
                <h4>Penelitian Bersama</h4>
                <p>Kolaborasi riset keperawatan dan publikasi ilmiah terindeks nasional maupun internasional.</p>
            </div>
            <div class="info-card fade-up tilt-card">
                <div class="info-icon">🎓</div>
                <h4>Pengembangan SDM</h4>
                <p>Pelatihan pustakawan, workshop literasi informasi, dan program magang mahasiswa.</p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="mb-32 px-5">
        <div class="glass-card p-8 md:p-12 rounded-3xl max-w-3xl mx-auto text-center cta-card fade-up">
            <div class="text-5xl mb-4">🤝</div>
            <h3 class="text-2xl md:text-3xl font-bold mb-3 bg-gradient-to-r from-indigo-200 to-purple-200 bg-clip-text text-transparent">
                Ajukan Kerjasama
            </h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">
                Kami terbuka untuk menjalin kemitraan dengan berbagai institusi dalam rangka pengembangan layanan perpustakaan dan pendidikan keperawatan.
            </p>
            <button class="glow-btn px-8 py-3 rounded-full transition font-semibold" onclick="showNotif('Terima kasih! Silakan hubungi kami di email: kerjasama@akperhkpb.ac.id', 'info')">
                Hubungi Kami →
            </button>
            <div class="mt-6 text-xs text-indigo-300/50">
                📞 (0632) 12345 | ✉️ kerjasama@akperhkpbpalige.ac.id
            </div>
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