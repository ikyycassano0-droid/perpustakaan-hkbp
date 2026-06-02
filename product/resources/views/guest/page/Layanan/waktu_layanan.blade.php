@extends('guest.component.master')

@section('title', 'Waktu Layanan & Operasional - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN WAKTU LAYANAN
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Glass card untuk layanan */
    .glass {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.25s ease;
    }

    .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }

    /* Glow text */
    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }

    /* Schedule row hover effect */
    .schedule-row {
        transition: all 0.2s;
    }
    .schedule-row:hover {
        background: rgba(99, 102, 241, 0.25);
        border-color: #818cf8;
        transform: scale(1.01);
    }

    /* Badge utility */
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.2rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Info icon */
    .info-icon {
        background: rgba(99, 102, 241, 0.2);
        padding: 0.5rem;
        border-radius: 1rem;
    }

    /* Depth layers tambahan */
    .depth-1 { transform: translateZ(12px); }
    .depth-2 { transform: translateZ(24px); }

    /* Card 3D effect */
    .card3d {
        transition: transform 0.15s ease-out, box-shadow 0.2s;
        will-change: transform;
    }

    /* Tilt container */
    .tilt {
        transform-style: preserve-3d;
        perspective: 1200px;
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
<!-- MAIN CONTENT -->
<section class="relative max-w-7xl mx-auto px-5 md:px-10 py-16 mt-8 md:mt-20 z-10">

    <!-- ========== HEADER SECTION ========== -->
    <div class="text-center mb-16 fade-up">
        <div class="inline-block glass px-5 py-1.5 rounded-full mb-4 depth-1">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📘 STATUS AKADEMIK</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2">
            Waktu Layanan <br>
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">& Operasional</span>
        </h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto mt-5 leading-relaxed">
            Akses sumber daya pengetahuan medis tersedia sepanjang minggu. <br>
            Perhatikan jadwal layanan fisik, sirkulasi, dan ruang baca.
        </p>
    </div>

    <!-- ========== 2-COLUMN LAYOUT ========== -->
    <div class="grid lg:grid-cols-3 gap-8 xl:gap-10">

        <!-- KOLOM KIRI : JADWAL MINGGUAN LENGKAP -->
        <div class="lg:col-span-2 fade-up">
            <div class="glass p-6 md:p-8 rounded-3xl shadow-2xl border border-white/10">

                <!-- Header jadwal dengan status operasional -->
                <div class="flex flex-wrap justify-between items-center mb-8 border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl">📅</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-wide">Jadwal Mingguan</h2>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-500/20 px-4 py-1.5 rounded-full">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-emerald-300 text-sm font-semibold">Sedang Beroperasi</span>
                    </div>
                </div>

                <!-- Daftar jadwal dari DATABASE -->
                <div class="space-y-4" id="jadwalContainer">
                    @forelse($schedules as $schedule)
                    <div class="schedule-row glass-card p-4 rounded-xl flex flex-wrap sm:flex-nowrap justify-between items-center transition-all duration-200 border border-white/5">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="bg-indigo-500/30 w-12 h-12 rounded-xl flex items-center justify-center font-bold text-indigo-200 text-xl backdrop-blur-sm">
                                {{ $schedule->day_short }}
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-lg">{{ $schedule->day_name }}</h3>
                                <div class="flex flex-wrap items-center gap-1 text-xs text-indigo-200/80">
                                    <span>{{ $schedule->note ?? 'Layanan Reguler' }}</span>
                                    @if(in_array($schedule->day_name, ['Senin', 'Selasa', 'Rabu', 'Kamis']))
                                    <span class="ml-2 text-[11px] bg-indigo-600/40 px-2 py-0.5 rounded-full text-indigo-200">📖 diperpanjang hingga 20:00 (Ujian)</span>
                                    @elseif($schedule->day_name == 'Jumat')
                                    <span class="ml-2 text-[11px] bg-amber-600/30 px-2 py-0.5 rounded-full">🕌 Jeda ibadah</span>
                                    @elseif($schedule->day_name == 'Sabtu')
                                    <span class="ml-2 text-[11px] bg-orange-600/30 px-2 py-0.5 rounded-full">📚 Baca saja</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-3 sm:mt-0">
                            <p class="text-white font-mono text-base font-medium">{{ $schedule->service_hours }}</p>
                            <p class="text-sm font-semibold tracking-wide flex items-center justify-end gap-1" style="color: {{ $schedule->status_color }}">
                                <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $schedule->status_color }}"></span>
                                {{ $schedule->status }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-calendar-day text-4xl mb-3 block"></i>
                        <p>Belum ada data jadwal layanan</p>
                    </div>
                    @endforelse
                </div>

                <!-- Catatan tambahan -->
                <div class="mt-8 pt-4 border-t border-white/20 text-sm text-indigo-200/70 flex flex-wrap justify-between items-center">
                    <div class="flex gap-3 items-center">
                        <span class="text-indigo-300 text-lg">⏱️</span>
                        <span>Layanan sirkulasi aktif: <strong class="text-white">08:00 — 16:30</strong></span>
                    </div>
                    <div class="bg-indigo-900/40 px-3 py-1 rounded-full text-xs">
                        📖 Buka diperpanjang hingga <strong class="text-amber-300">20:00</strong> selama UTS & UAS
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN : INFORMASI TAMBAHAN -->
        <div class="space-y-7 fade-up">

            <!-- Card Ringkasan Layanan Hari Ini - Mengambil data dari database -->
            <div class="glass p-6 rounded-3xl tilt card3d border-l-4 border-indigo-500">
                <div class="flex items-start gap-3">
                    <div class="text-3xl">🕘</div>
                    <div>
                        <h3 class="text-xl font-bold flex items-center gap-2">Sedang Beroperasi <span class="badge bg-green-500/30 text-green-300">Aktif</span></h3>
                        <div class="mt-3 space-y-2 text-gray-200">
                            @php
                                $weekdays = $schedules->where('is_active', true);
                                $seninKamis = $weekdays->whereIn('day_name', ['Senin', 'Selasa', 'Rabu', 'Kamis'])->first();
                                $jumat = $weekdays->where('day_name', 'Jumat')->first();
                                $sabtu = $weekdays->where('day_name', 'Sabtu')->first();
                                $minggu = $weekdays->where('day_name', 'Minggu')->first();
                            @endphp
                            @if($seninKamis)
                            <p class="flex justify-between"><span>📆 Senin - Kamis :</span><span class="font-mono">{{ $seninKamis->service_hours }}</span></p>
                            @endif
                            @if($jumat)
                            <p class="flex justify-between"><span>📆 Jumat :</span><span class="font-mono">{{ $jumat->service_hours }}</span></p>
                            @endif
                            @if($sabtu)
                            <p class="flex justify-between"><span>📆 Sabtu :</span><span class="font-mono">{{ $sabtu->service_hours }}</span></p>
                            @endif
                            @if($minggu)
                            <p class="flex justify-between"><span>📆 Minggu :</span><span class="font-mono {{ $minggu->status_color == '#f43f5e' ? 'text-rose-300' : '' }}">{{ $minggu->service_hours }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-xs text-indigo-200/60 bg-white/5 p-2 rounded-xl">
                    💡 *Layanan sirkulasi & peminjaman aktif sesuai jadwal. Ruang baca Sabtu terbatas.
                </div>
            </div>

            <!-- Kontak & Informasi (Data bisa diambil dari database service_infos) -->
            <div class="glass p-6 rounded-3xl tilt card3d">
                <h3 class="text-xl font-semibold flex items-center gap-2 mb-5"><span>📞</span> Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 glass-card p-3 rounded-xl">
                        <div class="bg-indigo-500/20 p-2 rounded-full">📞</div>
                        <div><p class="text-gray-300 text-sm">Telepon Kantor</p><p class="font-bold text-white">(0632) 12345</p></div>
                    </div>
                    <div class="flex items-center gap-3 glass-card p-3 rounded-xl">
                        <div class="bg-indigo-500/20 p-2 rounded-full">✉️</div>
                        <div><p class="text-gray-300 text-sm">Surel Akademik</p><p class="font-mono text-sm text-indigo-200">lib@akperhkpbpalige.ac.id</p></div>
                    </div>
                    <div class="flex items-center gap-3 glass-card p-3 rounded-xl">
                        <div class="bg-indigo-500/20 p-2 rounded-full">📍</div>
                        <div><p class="text-gray-300 text-sm">Layanan Fisik</p><p class="text-white">Gedung Utama Lantai 2, Ruang Sirkulasi</p></div>
                    </div>
                </div>
                <div class="mt-5 pt-3 text-center text-indigo-200/80 text-xs italic border-t border-white/10">
                    "Melayani dengan Kasih, Mendidik dengan Presisi Klinis."
                </div>
            </div>

            <!-- Info operasional tambahan (Data bisa diambil dari database announcements) -->
            <div class="glass p-5 rounded-3xl tilt card3d bg-gradient-to-br from-slate-800/40 to-indigo-900/20">
                <div class="flex gap-3 items-start">
                    <span class="text-2xl">📢</span>
                    <div>
                        <h4 class="font-semibold">Pengumuman Akademik</h4>
                        <ul class="text-sm text-gray-300 space-y-1 mt-2 list-disc list-inside">
                            <li>Istirahat ibadah Jumat : 12:00 - 13:30 (layanan ditutup sementara)</li>
                            <li>Sabtu: hanya ruang baca (tanpa peminjaman/sirkulasi)</li>
                            <li>Minggu: perpustakaan tutup total, akses e-resources tetap tersedia</li>
                        </ul>
                    </div>
                </div>
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
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN WAKTU LAYANAN
// ============================================

document.addEventListener('DOMContentLoaded', function() {

    // ==========================
    // TILT 3D EFFECT (card3d)
    // ==========================
    const cards3d = document.querySelectorAll('.card3d');
    cards3d.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 18;
            const rotateY = (x - centerX) / 18;
            card.style.transform = `perspective(1200px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = `perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1)`;
        });
    });

    // Stagger animation untuk jadwal rows
    const scheduleRows = document.querySelectorAll('.schedule-row');
    scheduleRows.forEach((row, idx) => {
        row.style.transitionDelay = `${idx * 0.05}s`;
    });

    // Fade up animation observer
    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(el => observer.observe(el));
});

console.log('Halaman Waktu Layanan & Operasional siap dengan data dari database!');
</script>
@endpush




