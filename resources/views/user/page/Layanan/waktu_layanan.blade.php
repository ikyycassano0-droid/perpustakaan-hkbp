@extends('user.component.master')

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

                <!-- Daftar jadwal -->
                <div class="space-y-4" id="jadwalContainer">
                    <!-- JavaScript akan merender jadwal -->
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

            <!-- Card Ringkasan Layanan Hari Ini -->
            <div class="glass p-6 rounded-3xl tilt card3d border-l-4 border-indigo-500">
                <div class="flex items-start gap-3">
                    <div class="text-3xl">🕘</div>
                    <div>
                        <h3 class="text-xl font-bold flex items-center gap-2">Sedang Beroperasi <span class="badge bg-green-500/30 text-green-300">Aktif</span></h3>
                        <div class="mt-3 space-y-2 text-gray-200">
                            <p class="flex justify-between"><span>📆 Senin - Kamis :</span><span class="font-mono">08:00 – 16:30</span></p>
                            <p class="flex justify-between"><span>📆 Jumat :</span><span class="font-mono">08:00 – 12:00 & 13:30 – 16:30</span></p>
                            <p class="flex justify-between"><span>📆 Sabtu :</span><span class="font-mono">09:00 – 13:00 (Ruang Baca)</span></p>
                            <p class="flex justify-between"><span>📆 Minggu :</span><span class="font-mono text-rose-300">Tutup</span></p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-xs text-indigo-200/60 bg-white/5 p-2 rounded-xl">
                    💡 *Layanan sirkulasi & peminjaman aktif sesuai jadwal. Ruang baca Sabtu terbatas.
                </div>
            </div>

            <!-- Kontak & Informasi -->
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

            <!-- Info operasional tambahan -->
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

    <!-- ========== BAGIAN BAWAH ========== -->
    <div class="mt-16 text-center fade-up">
        <div class="glass inline-block px-8 py-4 rounded-full backdrop-blur-lg border border-white/20">
            <p class="text-indigo-200 text-sm md:text-base">📌 Akses 24/7 ke sumber daya digital tersedia untuk mahasiswa & tenaga pendidik. Jadwal dapat berubah sesuai kebijakan institusi.</p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN WAKTU LAYANAN
// Hanya JS yang BELUM ADA di master blade
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================
    // RENDER JADWAL LENGKAP
    // ==========================
    const weeklySchedule = [
        { dayShort: "Sn", dayName: "Senin", serviceHours: "08:00 — 16:30", status: "Layanan Penuh", statusColor: "emerald", note: "Sirkulasi Aktif" },
        { dayShort: "Sl", dayName: "Selasa", serviceHours: "08:00 — 16:30", status: "Layanan Penuh", statusColor: "emerald", note: "Sirkulasi Aktif" },
        { dayShort: "Rb", dayName: "Rabu", serviceHours: "08:00 — 16:30", status: "Layanan Penuh", statusColor: "emerald", note: "Sirkulasi Aktif" },
        { dayShort: "Km", dayName: "Kamis", serviceHours: "08:00 — 16:30", status: "Layanan Penuh", statusColor: "emerald", note: "Sirkulasi Aktif" },
        { dayShort: "Jm", dayName: "Jumat", serviceHours: "08:00 - 12:00 & 13:30 - 16:30", status: "Istirahat Ibadah (12:00-13:30)", statusColor: "amber", note: "Layanan terbatas" },
        { dayShort: "Sb", dayName: "Sabtu", serviceHours: "09:00 — 13:00", status: "Hanya Ruang Baca", statusColor: "orange", note: "Tidak ada sirkulasi" },
        { dayShort: "Mg", dayName: "Minggu", serviceHours: "TUTUP", status: "Perpustakaan Tutup", statusColor: "rose", note: "Libur Mingguan" }
    ];

    const container = document.getElementById('jadwalContainer');
    if (container) {
        container.innerHTML = '';
        
        weeklySchedule.forEach((item) => {
            let extraBadge = '';
            if (item.dayName === 'Senin' || item.dayName === 'Selasa' || item.dayName === 'Rabu' || item.dayName === 'Kamis') {
                extraBadge = `<span class="ml-2 text-[11px] bg-indigo-600/40 px-2 py-0.5 rounded-full text-indigo-200">📖 diperpanjang hingga 20:00 (Ujian)</span>`;
            } else if (item.dayName === 'Jumat') {
                extraBadge = `<span class="ml-2 text-[11px] bg-amber-600/30 px-2 py-0.5 rounded-full">🕌 Jeda ibadah</span>`;
            } else if (item.dayName === 'Sabtu') {
                extraBadge = `<span class="ml-2 text-[11px] bg-orange-600/30 px-2 py-0.5 rounded-full">📚 Baca saja</span>`;
            }
            
            const statusColorMap = {
                emerald: 'text-emerald-400',
                amber: 'text-amber-300',
                orange: 'text-orange-300',
                rose: 'text-rose-400'
            };
            const statusClass = statusColorMap[item.statusColor] || 'text-gray-300';
            
            const row = document.createElement('div');
            row.className = 'schedule-row glass-card p-4 rounded-xl flex flex-wrap sm:flex-nowrap justify-between items-center transition-all duration-200 border border-white/5';
            row.innerHTML = `
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <div class="bg-indigo-500/30 w-12 h-12 rounded-xl flex items-center justify-center font-bold text-indigo-200 text-xl backdrop-blur-sm">${item.dayShort}</div>
                    <div>
                        <h3 class="font-bold text-white text-lg">${item.dayName}</h3>
                        <div class="flex flex-wrap items-center gap-1 text-xs text-indigo-200/80">
                            <span>${item.note}</span>
                            ${extraBadge}
                        </div>
                    </div>
                </div>
                <div class="text-right mt-3 sm:mt-0">
                    <p class="text-white font-mono text-base font-medium">${item.serviceHours}</p>
                    <p class="${statusClass} text-sm font-semibold tracking-wide flex items-center justify-end gap-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-${item.statusColor === 'emerald' ? 'emerald' : item.statusColor === 'amber' ? 'amber' : item.statusColor === 'orange' ? 'orange' : 'rose'}-400"></span>
                        ${item.status}
                    </p>
                </div>
            `;
            container.appendChild(row);
        });
        
        // Info tambahan
        const infoRow = document.createElement('div');
        infoRow.className = 'mt-5 bg-indigo-950/30 rounded-xl p-3 flex flex-wrap justify-between items-center text-sm';
        infoRow.innerHTML = `
            <div class="flex gap-4 items-center">
                <span class="font-mono text-indigo-300">🕒 Sirkulasi Aktif:</span>
                <span class="text-white">08:00 — 16:30 (Sen-Kam & Jumat siang setelah istirahat)</span>
            </div>
            <div class="text-indigo-300 text-xs flex items-center gap-1"><span>⏳</span> Sabtu: 09:00-13:00 (Ruang Baca)</div>
        `;
        container.appendChild(infoRow);
    }
    
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
});

console.log('Halaman Waktu Layanan & Operasional siap dengan jadwal lengkap dan efek tilt 3D!');
</script>
@endpush