{{-- resources/views/user/page/Koleksi_Elektronik/detail_video.blade.php --}}
@extends('user.component.master')

@section('title', $item->title . ' - Detail Video')

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
               MAIN LAYOUT - Grid 2 Kolom (seperti tampilan sebelumnya)
            ============================================================ */
        .main-wrapper {
            max-width: 1430px;
            margin: 100px 0 40px auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
            align-items: start;
            overflow: visible;
        }

        /* ============================================================
               LEFT COLUMN - Video Player
            ============================================================ */
        .video-main {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .video-player-wrapper {
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(15, 74, 49, 0.12);
            aspect-ratio: 16 / 9;
            position: relative;
            border: 3px solid #fff;
        }

        .video-player-wrapper video,
        .video-player-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            object-fit: cover;
        }

        .video-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #aaa;
            background: #1a1a1a;
        }

        .video-placeholder i {
            font-size: 5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .video-placeholder p {
            font-size: 1rem;
        }

        /* ============================================================
               VIDEO INFO CARD (seperti tampilan sebelumnya)
            ============================================================ */
        .video-info-card {
            background: #fff;
            padding: 25px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid var(--accent-yellow);
        }

        .video-tag {
            background: #e0f0e8;
            color: var(--primary-color);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
        }

        .video-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 15px 0;
            line-height: 1.4;
            font-family: 'Playfair Display', serif;
        }

        .video-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .video-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* ============================================================
               DESCRIPTION CARD (seperti tampilan sebelumnya)
            ============================================================ */
        .description-card {
            background: #fff;
            padding: 25px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid var(--accent-yellow);
        }

        .section-label {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--accent-yellow);
            padding-left: 12px;
        }

        .description-text {
            color: var(--text-muted);
            line-height: 1.8;
            text-align: justify;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            background: #f8fbf9;
            padding: 25px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }

        .spec-item {
            display: flex;
            flex-direction: column;
        }

        .spec-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .spec-value {
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        /* ============================================================
       TOMBOL KEMBALI - Hijau Solid (sama seperti detail lain)
    ============================================================ */
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 25px;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 700;
            border: none;
            background: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
            cursor: pointer;
        }

        .btn-back:hover {
            background: var(--accent-green);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(26, 107, 71, 0.35);
        }

        .btn-back i {
            font-size: 0.9rem;
        }

        /* ============================================================
               SIDEBAR (seperti tampilan sebelumnya)
            ============================================================ */
        .sidebar-info {
            background: #fff;
            padding: 25px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid var(--accent-yellow);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .sidebar-info h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--text-dark);
            border-left: 4px solid var(--accent-yellow);
            padding-left: 12px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-item .ilabel {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .info-item .ivalue {
            font-size: 0.85rem;
            color: var(--text-dark);
            font-weight: 600;
            text-align: right;
        }

        /* ============================================================
               ACTION BUTTONS (Sidebar) - Sama seperti detail reguler
            ============================================================ */
        .sidebar-actions {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 20px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 0.9rem;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .btn-play {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(26, 107, 71, 0.3);
        }

        .btn-play:hover {
            background: var(--deep-green);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(26, 107, 71, 0.4);
            color: white;
        }

        .btn-play i {
            font-size: 1.1rem;
        }

        .btn-play .badge-label {
            font-size: 0.7rem;
            font-weight: 400;
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 10px;
            border-radius: 12px;
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

        .btn-download i {
            font-size: 1.1rem;
        }

        .btn-download .badge-label {
            font-size: 0.7rem;
            font-weight: 400;
            opacity: 0.7;
            background: rgba(26, 107, 71, 0.1);
            padding: 2px 10px;
            border-radius: 12px;
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

        /* ============================================================
               RESPONSIVE
            ============================================================ */
        @media (max-width: 1024px) {
            .main-wrapper {
                grid-template-columns: 1fr;
                margin: 100px 20px 30px 20px;
                gap: 30px;
            }

            .sidebar-info {
                position: relative;
                top: 0;
            }

            .specs-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .video-info-card {
                padding: 20px;
            }

            .description-card {
                padding: 20px;
            }

            .sidebar-info {
                padding: 20px;
            }

            .specs-grid {
                gap: 12px;
                padding: 15px;
            }

            .btn-action {
                font-size: 0.8rem;
                padding: 12px 16px;
            }

            .btn-action .badge-label {
                font-size: 0.6rem;
                padding: 1px 8px;
            }

            .video-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .main-wrapper {
                margin: 90px 10px 15px 10px;
                padding: 0;
            }

            .video-info-card {
                padding: 16px;
                border-radius: 16px;
            }

            .description-card {
                padding: 16px;
                border-radius: 16px;
            }

            .sidebar-info {
                padding: 16px;
                border-radius: 16px;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $fileUrl = $item->file_url ? asset('storage/' . $item->file_url) : null;
        $ext = $fileUrl ? strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION)) : null;
        $videoExts = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'm4v'];
    @endphp

    <div class="main-wrapper">
        <!-- ===== LEFT COLUMN - Video Player & Info ===== -->
        <div class="video-main">
            <!-- Video Player -->
            <div class="video-player-wrapper">
                @if ($fileUrl && in_array($ext, $videoExts))
                    <video controls autoplay muted>
                        <source src="{{ $fileUrl }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                @else
                    <div class="video-placeholder">
                        <i class="fas fa-video"></i>
                        <p>Pratinjau video tidak tersedia</p>
                    </div>
                @endif
            </div>

            <!-- ===== VIDEO INFO CARD ===== -->
            <div class="video-info-card">
                <span class="video-tag">{{ $item->category->name ?? 'Video' }}</span>
                <h1 class="video-title">{{ $item->title }}</h1>

                <div class="video-meta">
                    <span><i class="far fa-user"></i> {{ $item->student_name ?? $item->user->name ?? 'Administrator' }}</span>
                    <span><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}</span>
                    @if ($item->year)
                        <span><i class="fas fa-tag"></i> Tahun: {{ $item->year }}</span>
                    @endif
                </div>
            </div>

            <!-- ===== DESKRIPSI ===== -->
            <div class="description-card">
                <div class="section-label">DESKRIPSI VIDEO</div>
                <p class="description-text">
                    {{ $item->abstract ?? 'Tidak ada deskripsi untuk video ini.' }}
                </p>

                @if ($item->keywords)
                    <div style="margin-top: 20px;">
                        <strong>Kata Kunci:</strong>
                        <span style="color: var(--text-muted);">
                            {{ is_array($item->keywords) ? implode(', ', $item->keywords) : $item->keywords }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- ===== INFORMASI TEKNIS ===== -->
            <div class="description-card">
                <div class="section-label">INFORMASI TEKNIS</div>
                <div class="specs-grid">
                    <div class="spec-item">
                        <span class="spec-label">ISBN</span>
                        <span class="spec-value">{{ $item->isbn ?? '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Format File</span>
                        <span class="spec-value">{{ $ext ? strtoupper($ext) : '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Klasifikasi</span>
                        <span class="spec-value">{{ $item->classifications->pluck('name')->implode(', ') ?: '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Kategori Koleksi</span>
                        <span class="spec-value">{{ $item->categoriesMany->pluck('name')->implode(', ') ?: '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Tahun</span>
                        <span class="spec-value">{{ $item->year ?? $item->created_at->format('Y') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Status</span>
                        <span class="spec-value">{{ $item->status }}</span>
                    </div>
                </div>
            </div>

            <!-- ===== TOMBOL KEMBALI ===== -->
            <div style="text-align: center;">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('user.koleksi_elektronik.video') }}"
                    class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Koleksi
                </a>
            </div>
        </div>

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar-info">
            <h3>Informasi Video</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="ilabel">Kategori</span>
                    <span class="ivalue">{{ $item->category->name ?? 'Video' }}</span>
                </div>
                <div class="info-item">
                    <span class="ilabel">Status</span>
                    <span class="ivalue" style="color: {{ $item->status == 'Approved' ? '#0f4a31' : '#e67e22' }};">
                        {{ $item->status == 'Approved' ? 'Tersedia' : $item->status }}
                    </span>
                </div>
                @if ($item->year)
                    <div class="info-item">
                        <span class="ilabel">Tahun</span>
                        <span class="ivalue">{{ $item->year }}</span>
                    </div>
                @endif
                @if ($ext)
                    <div class="info-item">
                        <span class="ilabel">Format</span>
                        <span class="ivalue">{{ strtoupper($ext) }}</span>
                    </div>
                @endif
                @if ($item->isbn)
                    <div class="info-item">
                        <span class="ilabel">ISBN</span>
                        <span class="ivalue">{{ $item->isbn }}</span>
                    </div>
                @endif
            </div>

            <!-- ===== TOMBOL AKSI ===== -->
            <div class="sidebar-actions">
                @if ($fileUrl)
                    @if (in_array($ext, $videoExts))
                        <a href="{{ $fileUrl }}" target="_blank" class="btn-action btn-play">
                            <i class="fas fa-play-circle"></i> PUTAR VIDEO
                            <span class="badge-label">ONLINE</span>
                        </a>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank" class="btn-action btn-play">
                            <i class="fas fa-external-link-alt"></i> BUKA FILE
                            <span class="badge-label">ONLINE</span>
                        </a>
                    @endif

                    <button class="btn-action btn-download btn-download-locked" disabled>
                        <i class="fas fa-lock lock-icon"></i> UNDUH VIDEO
                        <span class="badge-label">OFFLINE</span>
                    </button>
                    <div class="login-hint">
                        <i class="fas fa-info-circle" style="color: #ccc;"></i>
                        Login untuk mengunduh file &nbsp;
                        <a href="{{ route('login') }}">Login Sekarang →</a>
                    </div>
                @else
                    <button class="btn-action btn-play btn-disabled" disabled>
                        <i class="fas fa-play"></i> VIDEO TIDAK TERSEDIA
                    </button>
                @endif
            </div>
        </aside>
    </div>
@endsection
