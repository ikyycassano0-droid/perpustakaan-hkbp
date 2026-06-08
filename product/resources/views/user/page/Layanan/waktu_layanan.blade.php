{{-- resources/views/guest/page/layanan/waktu-layanan.blade.php --}}
@extends('user.component.master')

@section('title', 'Waktu Layanan - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* ============================================
           STYLE KHUSUS HALAMAN WAKTU LAYANAN
           (mempertahankan desain asli: border kuning, tabel hijau)
        ============================================ */

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                        url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            padding: 70px 5% 80px;
            color: white;
            text-align: center;
        }

        .hero-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 900;
        }

        .hero-banner p {
            font-size: 1.05rem;
            opacity: 0.92;
        }

        /* Container (kartu putih dengan border atas kuning) */
        .schedule-container {
            max-width: 900px;
            margin: -40px auto 50px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border-top: 4px solid #f1c40f;
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        /* Info Card */
        .info-card {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            background: #f8fbf9;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #f1c40f;
            align-items: center;
        }

        .num-circle {
            background: var(--primary-color);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-card h3 {
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        /* Tabel Waktu */
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .schedule-table th {
            background-color: #f0f7f3;
            color: var(--primary-color);
            padding: 15px;
            text-align: left;
            font-weight: 700;
            border-bottom: 2px solid var(--primary-color);
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .schedule-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        .schedule-table tr:hover {
            background-color: #fafdfb;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-block;
        }

        .status-open {
            background: #e0f0e8;
            color: #2daa6e;
        }

        .status-closed {
            background: #fee8e8;
            color: #e74c3c;
        }

        .footer-note {
            margin-top: 25px;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-style: italic;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .schedule-container {
                margin: 20px 20px 50px;
                padding: 25px;
            }

            .schedule-table th,
            .schedule-table td {
                padding: 10px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Banner -->
    <div class="hero-banner" data-aos="fade-up">
        <h2>Waktu Layanan</h2>
        <p>Jam Operasional Perpustakaan AKPER HKBP Balige</p>
    </div>

    <!-- Main Container -->
    <div class="schedule-container" data-aos="fade-up" data-aos-delay="100">
        <div class="info-card">
            <div class="num-circle"><i class="fas fa-clock"></i></div>
            <div>
                <h3>Jadwal Kehadiran</h3>
                <p>Kami siap melayani kebutuhan literasi dan riset Anda pada waktu berikut.</p>
            </div>
        </div>

        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam Operasional</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules ?? [] as $schedule)
                    <tr>
                        <td><strong>{{ $schedule->day_name }}</strong></td>
                        <td>{{ $schedule->service_hours }}</td>
                        <td>
                            <span class="status-badge" style="background-color: {{ $schedule->status_color }}20; color: {{ $schedule->status_color }};">
                                {{ $schedule->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <!-- Data statis (fallback) -->
                    <tr>
                        <td><strong>Senin</strong></td>
                        <td>08.30 - 20.00 WIB</td>
                        <td><span class="status-badge status-open">BUKA</span></td>
                    </tr>
                    <tr>
                        <td><strong>Selasa - Kamis</strong></td>
                        <td>08.00 - 20.00 WIB</td>
                        <td><span class="status-badge status-open">BUKA</span></td>
                    </tr>
                    <tr>
                        <td><strong>Jumat</strong></td>
                        <td>08.00 - 16.30 WIB</td>
                        <td><span class="status-badge status-open">BUKA</span></td>
                    </tr>
                    <tr>
                        <td><strong>Sabtu - Minggu</strong></td>
                        <td>Tutup</td>
                        <td><span class="status-badge status-closed">LIBUR</span></td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-note">
            * Jam layanan dapat berubah sewaktu-waktu pada hari libur nasional atau kebijakan institusi.
        </div>
    </div>
@endsection
