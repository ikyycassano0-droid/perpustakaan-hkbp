{{-- resources/views/guest/page/Koleksi_Elektronik/detail_cd.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Detail CD Koleksi')

@push('styles')
    <style>
        /* ============================================================
               RESET & VARIABEL
            ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f7f5;
            color: #0d2137;
            line-height: 1.5;
            font-family: 'DM Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        :root {
            --primary-color: #1a6b47;
            --deep-green: #0f4a31;
            --accent-green: #2daa6e;
            --accent-yellow: #f1c40f;
            --text-dark: #0d2137;
            --text-muted: #5a7060;
            --light-bg: #f4f7f5;
            --card-bg: #ffffff;
            --border-color: #d4e5d9;
            --danger: #e74c3c;
            --paper: #fffcf0;
            --reader-bg: #1a1a1a;
        }

        /* ============================================================
               MAIN LAYOUT
            ============================================================ */
        .main-wrapper {
            max-width: 1430px;
            margin: 100px 0 40px auto;
            padding: 0 30px;
            display: flex;
            gap: 50px;
            align-items: flex-start;
            justify-content: flex-end;
            overflow: visible;
            min-height: 100vh;
        }

        /* ============================================================
               CD VISUAL CARD (Sisi Kiri)
            ============================================================ */
        .cd-visual-card {
            perspective: 1600px;
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: visible;
            flex: 0 0 350px;
            height: fit-content;
            align-self: flex-start;
            background: white;
            border-radius: 28px;
            padding: 32px 25px;
            box-shadow: 0 12px 28px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 5px solid var(--accent-yellow);
            text-align: center;
        }

        .cd-cover-wrapper {
            position: relative;
            width: 220px;
            height: 220px;
            margin: 0 auto 25px;
        }

        .cd-cover-wrapper .cd-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease;
        }

        .cd-cover-wrapper .cd-image:hover {
            transform: scale(1.02);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: #e0f0e8;
            color: #0f4a31;
        }

        .status-badge i {
            color: var(--accent-green);
        }

        /* ============================================================
               ACTION BUTTONS
            ============================================================ */
        .cd-actions {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 5px;
        }

        .btn-ebook {
            width: 100%;
            padding: 12px 18px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 0.85rem;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
        }

        .btn-play {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
        }

        .btn-play:hover {
            background: var(--accent-green);
            transform: translateY(-3px);
            color: white;
        }

        .btn-play .badge-label {
            font-size: 0.65rem;
            font-weight: 400;
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 12px;
            border-radius: 20px;
        }

        .btn-download {
            background: #eef4f0;
            color: var(--primary-color);
            border: 1.8px solid var(--primary-color);
        }

        .btn-download:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-download .badge-label {
            font-size: 0.65rem;
            font-weight: 400;
            opacity: 0.7;
            background: rgba(26, 107, 71, 0.1);
            padding: 2px 12px;
            border-radius: 20px;
        }

        .btn-download:hover .badge-label {
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }

        .btn-download-locked {
            background: #f5f5f0;
            color: #999;
            border: 1.8px solid #ddd;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .btn-download-locked:hover {
            transform: none !important;
            box-shadow: none !important;
            background: #f5f5f0;
            color: #999;
        }

        .btn-download-locked .lock-icon {
            color: var(--accent-yellow);
        }

        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed !important;
            background: #e2e8f0 !important;
            color: #a0aec0 !important;
        }

        .login-hint {
            text-align: center;
            padding: 4px 0 2px 0;
            font-size: 0.75rem;
            color: #999;
        }

        .login-hint a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed var(--primary-color);
        }

        .login-hint a:hover {
            color: var(--deep-green);
            border-bottom: 1px solid var(--deep-green);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--primary-color);
            color: white;
            padding: 10px 24px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            background: var(--deep-green);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            color: white;
        }

        /* ============================================================
               DETAIL BOX (Sisi Kanan)
            ============================================================ */
        .detail-box {
            flex: 1;
            max-width: 820px;
            margin-left: 0;
            background: white;
            border-radius: 28px;
            padding: 32px 36px;
            box-shadow: 0 12px 28px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 5px solid var(--accent-yellow);
        }

        .title-area h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .title-area span.top-tag {
            color: var(--accent-green);
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 8px;
            background: #e0f2e9;
            padding: 3px 12px;
            border-radius: 30px;
        }

        .title-area span.top-tag i {
            margin-right: 6px;
        }

        .author-text {
            color: var(--text-muted);
            margin-bottom: 26px;
            font-size: 0.95rem;
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 14px;
        }

        .author-text a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        .section-header {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header span {
            color: var(--text-muted);
            font-weight: 400;
        }

        .availability-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .avail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .avail-table th {
            background: #f0f7f3;
            color: var(--primary-color);
            text-align: left;
            padding: 12px 20px;
            font-size: 0.85rem;
        }

        .avail-table td {
            padding: 12px 20px;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-color);
        }

        .avail-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge-table {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent-green);
            font-weight: 700;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-green);
            border-radius: 50%;
            position: relative;
        }

        .pulse-dot::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: var(--accent-green);
            border-radius: 50%;
            animation: pulse-ring 1.5s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.33);
                opacity: 0.6;
            }
            80%,
            100% {
                transform: scale(2.2);
                opacity: 0;
            }
        }

        .info-heading {
            font-size: 1.1rem;
            font-weight: 800;
            margin: 20px 0 16px;
            border-left: 5px solid var(--accent-yellow);
            padding-left: 14px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            color: var(--text-muted);
            font-weight: 600;
        }

        .value {
            color: var(--text-dark);
            font-weight: 500;
        }

        .value .category-badge {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            margin: 2px 3px 2px 0;
        }

        .abstract-content {
            margin-top: 10px;
            line-height: 1.8;
            text-align: justify;
            color: #2d3748;
            font-size: 0.95rem;
        }

        /* ============================================================
               RESPONSIVE
            ============================================================ */
        @media (max-width: 1024px) {
            .main-wrapper {
                flex-direction: column;
                margin: 100px 20px 30px 20px;
                gap: 35px;
                align-items: center;
            }

            .cd-visual-card {
                position: relative;
                top: 0;
                flex: none;
                width: 100%;
                max-width: 400px;
            }

            .detail-box {
                max-width: 100%;
                margin-left: 0;
            }
        }

        @media (max-width: 640px) {
            .detail-box {
                padding: 20px;
            }

            .cd-cover-wrapper {
                width: 180px;
                height: 180px;
            }

            .cd-cover-wrapper .cd-image {
                border-radius: 12px;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }

            .title-area h1 {
                font-size: 1.5rem;
            }

            .btn-ebook {
                font-size: 0.8rem;
                padding: 10px 14px;
            }

            .avail-table th,
            .avail-table td {
                padding: 10px 14px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .main-wrapper {
                margin: 90px 10px 15px 10px;
                padding: 0;
            }

            .cd-cover-wrapper {
                width: 150px;
                height: 150px;
            }

            .detail-box {
                padding: 16px;
                border-radius: 16px;
            }

            .cd-visual-card {
                padding: 20px 15px;
                border-radius: 16px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-wrapper">
        <!-- ===== CD VISUAL CARD (Sisi Kiri) ===== -->
        <aside class="cd-visual-card" data-aos="zoom-in-right">
            <div class="cd-cover-wrapper">
                @if ($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
                    <img src="{{ asset('storage/' . $item->cover_image) }}" class="cd-image" alt="Cover CD">
                @else
                    <img src="https://via.placeholder.com/220x220?text=CD+Cover" class="cd-image" alt="Cover">
                @endif
            </div>

            <div class="status-badge">
                <i class="fas fa-check-circle"></i>
                {{ $item->status == 'Approved' ? 'TERSEDIA' : strtoupper($item->status) }}
            </div>

            <!-- ===== TOMBOL AKSI ===== -->
            <div class="cd-actions">
                @if ($item->file_url)
                    <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-ebook btn-play">
                        <i class="fas fa-play-circle"></i> PUTAR / AKSES
                        <span class="badge-label">ONLINE</span>
                    </a>
                @else
                    <button class="btn-ebook btn-play btn-disabled" disabled>
                        <i class="fas fa-play-circle"></i> TIDAK TERSEDIA
                    </button>
                @endif

                @if ($item->file_url)
                    <button class="btn-ebook btn-download btn-download-locked" disabled>
                        <i class="fas fa-lock lock-icon"></i> UNDUH FILE
                        <span class="badge-label">OFFLINE</span>
                    </button>
                    <div class="login-hint">
                        <i class="fas fa-info-circle" style="color: #ccc;"></i>
                        Login untuk mengunduh file &nbsp;
                        <a href="{{ route('login') }}">Login Sekarang →</a>
                    </div>
                @else
                    <button class="btn-ebook btn-download" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-file"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif
            </div>
        </aside>

        <!-- ===== DETAIL CARD (Sisi Kanan) ===== -->
        <div class="detail-box" data-aos="fade-left">
            <div class="title-area">
                <span class="top-tag">
                    <i class="fas fa-compact-disc"></i>
                    {{ strtoupper($item->category->name ?? 'MULTIMEDIA') }} (CD)
                </span>
                <h1>{{ $item->title }}</h1>
                <p class="author-text">
                    Oleh
                    @if ($item->student_name)
                        <a href="#">{{ $item->student_name }}</a>
                    @elseif ($item->user)
                        <a href="#">{{ $item->user->name ?? 'Admin Perpustakaan' }}</a>
                    @else
                        <a href="#">Admin Perpustakaan</a>
                    @endif
                    @if ($item->year)
                        | Tahun {{ $item->year }}
                    @endif
                </p>
            </div>

            <!-- ===== STATUS TABLE ===== -->
            <div class="section-header">
                <i class="fas fa-cloud-upload-alt" style="color: var(--accent-green);"></i>
                Status Akses Digital <span>— Repositori AKPER</span>
            </div>

            <div class="availability-card">
                <table class="avail-table">
                    <thead>
                        <tr>
                            <th># Tipe Akses</th>
                            <th>Server Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Full Text {{ strtoupper(pathinfo($item->file_url, PATHINFO_EXTENSION) ?? 'CD') }}</strong></td>
                            <td>Digital-Cloud-HKBP-01</td>
                            <td>
                                <div class="status-badge-table">
                                    <div class="pulse-dot"></div>
                                    @if ($item->status == 'Approved')
                                        Tersedia (Open Access)
                                    @else
                                        {{ $item->status ?? 'Pending' }}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ===== INFO DETAIL ===== -->
            <div class="info-heading">
                <i class="fas fa-info-circle"></i> Informasi Detail
            </div>

            <div class="info-list">
                @if ($item->series)
                    <div class="info-row">
                        <div class="label">Series Title</div>
                        <div class="value">{{ $item->series }}</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Penerbit</div>
                    <div class="value">{{ $item->publisher ?? 'Akper HKBP Press : Tarutung, 2023' }}</div>
                </div>

                @if ($item->isbn)
                    <div class="info-row">
                        <div class="label">ISBN</div>
                        <div class="value">{{ $item->isbn }} (Digital)</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Bahasa</div>
                    <div class="value">{{ $item->language ?? 'Indonesia' }}</div>
                </div>

                @if ($item->edition)
                    <div class="info-row">
                        <div class="label">Edisi</div>
                        <div class="value">{{ $item->edition }}</div>
                    </div>
                @endif

                @if ($item->subjects)
                    <div class="info-row">
                        <div class="label">Subjek</div>
                        <div class="value">{{ $item->subjects }}</div>
                    </div>
                @endif

                @if ($item->classifications && $item->classifications->count())
                    <div class="info-row">
                        <div class="label">Klasifikasi</div>
                        <div class="value">
                            @foreach ($item->classifications as $classification)
                                <span class="category-badge">{{ $classification->code ?? $classification->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($item->categoriesMany && $item->categoriesMany->count())
                    <div class="info-row">
                        <div class="label">Kategori</div>
                        <div class="value">
                            @foreach ($item->categoriesMany as $category)
                                <span class="category-badge">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Tipe Isi / Media</div>
                    <div class="value">
                        Audio/Video (Digital) /
                        @if ($item->file_url)
                            @php
                                $extension = pathinfo($item->file_url, PATHINFO_EXTENSION);
                            @endphp
                            {{ strtoupper($extension) }} File
                        @else
                            Computer File
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="label">Lokasi</div>
                    <div class="value">E-Library Server - Koleksi Elektronik</div>
                </div>

                @if ($item->created_at)
                    <div class="info-row">
                        <div class="label">Tanggal Unggah</div>
                        <div class="value">{{ $item->created_at->translatedFormat('d F Y') }}</div>
                    </div>
                @endif
            </div>

            <!-- ===== ABSTRACT ===== -->
            @if ($item->abstract)
                <div class="info-heading" style="margin-top: 30px;">
                    <i class="fas fa-align-left"></i> Abstrak / Deskripsi
                </div>
                <div class="abstract-content">
                    {{ $item->abstract }}
                </div>
            @endif

            <!-- ===== TOMBOL KEMBALI ===== -->
            <div style="margin-top: 40px; text-align: center;">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('guest.koleksi_elektronik.cd') }}"
                    class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Koleksi
                </a>
            </div>
        </div>
    </div>
@endsection
