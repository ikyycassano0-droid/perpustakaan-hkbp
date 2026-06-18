{{-- resources/views/guest/page/Koleksi_Elektronik/detail_cd.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Detail CD Koleksi')

@push('styles')
    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 40px;
        }

        .cd-visual-card {
            background: #fff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid #f1c40f;
            height: fit-content;
            position: sticky;
            top: 100px;
            text-align: center;
        }

        .cd-cover-wrapper {
            position: relative;
            width: 220px;
            height: 220px;
            margin: 0 auto 25px;
        }

        .cd-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .status-available {
            background: #e0f0e8;
            color: #0f4a31;
        }

        /* ========== ACTION BUTTONS - STYLE SEPERTI DETAIL REGULER ========== */
        .cd-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 5px;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 0.9rem;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        /* Tombol Play/Akses - Hijau solid */
        .btn-play {
            background: #1a6b47;
            color: white;
            box-shadow: 0 4px 12px rgba(26, 107, 71, 0.3);
        }

        .btn-play:hover {
            background: #0f4a31;
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
            background: rgba(255,255,255,0.15);
            padding: 2px 10px;
            border-radius: 12px;
        }

        /* Tombol Download - Outline Hijau (guest = disabled/locked) */
        .btn-download {
            background: transparent;
            color: #1a6b47;
            border: 2px solid #1a6b47;
            box-shadow: 0 2px 8px rgba(26, 107, 71, 0.08);
        }

        .btn-download:hover {
            background: #1a6b47;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(26, 107, 71, 0.25);
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
            background: rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
        }

        /* Tombol Download dalam keadaan terkunci (guest) */
        .btn-download-locked {
            background: #f5f5f0;
            color: #999;
            border: 2px solid #ddd;
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
            color: #f1c40f;
        }

        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed !important;
            pointer-events: none;
            background: #e2e8f0 !important;
            color: #a0aec0 !important;
        }

        /* Login hint kecil di bawah tombol download */
        .login-hint {
            text-align: center;
            padding: 6px 0 2px 0;
            font-size: 0.75rem;
            color: #999;
        }

        .login-hint a {
            color: #1a6b47;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed #1a6b47;
        }

        .login-hint a:hover {
            color: #0f4a31;
            border-bottom: 1px solid #0f4a31;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: auto;
            padding: 12px 25px;
            margin-top: 15px;
            border-radius: 50px;
            font-weight: 700;
            border: 2px solid #1a6b47;
            color: #1a6b47;
            background: transparent;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            background: #1a6b47;
            color: white;
            transform: translateY(-2px);
        }

        .cd-info-content {
            background: #fff;
            padding: 45px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid #f1c40f;
        }

        .category-tag {
            color: #1a6b47;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cd-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: #2d3748;
            margin: 10px 0;
            font-weight: 800;
            line-height: 1.2;
        }

        .cd-meta-top {
            display: flex;
            gap: 20px;
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .description-box {
            margin-bottom: 35px;
        }

        .section-label {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #f1c40f;
            padding-left: 12px;
        }

        .description-text {
            color: #718096;
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
            color: #718096;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .spec-value {
            font-size: 0.95rem;
            color: #2d3748;
            font-weight: 600;
        }

        .info-note {
            margin-top: 30px;
            padding: 20px;
            border-radius: 12px;
            border: 1px dashed #1a6b47;
            background: #fafdfb;
        }

        .info-note h4 {
            color: #1a6b47;
            margin-bottom: 5px;
        }

        .info-note p {
            font-size: 0.85rem;
            color: #718096;
        }

        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
            }

            .cd-visual-card {
                position: relative;
                top: 0;
            }
        }

        @media (max-width: 640px) {
            .cd-info-content {
                padding: 20px;
            }

            .specs-grid {
                grid-template-columns: 1fr;
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

            .cd-title {
                font-size: 1.6rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- SIDEBAR VISUAL -->
        <aside class="cd-visual-card">
            <div class="cd-cover-wrapper">
                @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
                    <img src="{{ asset('storage/' . $item->cover_image) }}" class="cd-image" alt="Cover CD">
                @else
                    <img src="https://via.placeholder.com/220x220?text=CD+Cover" class="cd-image" alt="Cover">
                @endif
            </div>

            <div class="status-badge status-available">
                <i class="fas fa-check-circle"></i> {{ $item->status == 'Approved' ? 'TERSEDIA' : strtoupper($item->status) }}
            </div>

            <!-- TOMBOL AKSI - STYLE SEPERTI DETAIL REGULER -->
            <div class="cd-actions">
                {{-- Tombol Play/Akses (setara dengan BACA ONLINE) --}}
                @if($item->file_url)
                    <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-action btn-play">
                        <i class="fas fa-play-circle"></i> PUTAR / AKSES
                        <span class="badge-label">ONLINE</span>
                    </a>
                @else
                    <button class="btn-action btn-disabled" disabled>
                        <i class="fas fa-play-circle"></i> TIDAK TERSEDIA
                    </button>
                @endif

                {{-- Tombol Download - untuk guest tetap terkunci (setara dengan UNDUH PDF) --}}
                @if($item->file_url)
                    <button class="btn-action btn-download btn-download-locked" disabled>
                        <i class="fas fa-lock lock-icon"></i> UNDUH FILE
                        <span class="badge-label">OFFLINE</span>
                    </button>
                    <div class="login-hint">
                        <i class="fas fa-info-circle" style="color: #ccc;"></i>
                        Login untuk mengunduh file &nbsp;
                        <a href="{{ route('login') }}">Login Sekarang →</a>
                    </div>
                @else
                    <button class="btn-action btn-download" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-file"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif
            </div>

            <p style="font-size: 0.7rem; color: #718096; margin-top: 15px;">*Klik untuk mengakses file media</p>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="cd-info-content">
            <span class="category-tag">{{ $item->category->name ?? 'Multimedia Keperawatan' }}</span>
            <h1 class="cd-title">{{ $item->title }}</h1>

            <div class="cd-meta-top">
                <span><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('Y') }}</span>
                <span><i class="fas fa-user"></i> {{ $item->student_name ?? $item->user->name ?? 'Administrator' }}</span>
            </div>

            <div class="description-box">
                <div class="section-label">DESKRIPSI KOLEKSI</div>
                <p class="description-text">
                    {{ $item->abstract ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            <div class="section-label">INFORMASI TEKNIS</div>
            <div class="specs-grid">
                <div class="spec-item">
                    <span class="spec-label">ISBN</span>
                    <span class="spec-value">{{ $item->isbn ?? '-' }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Format File</span>
                    <span class="spec-value">{{ $item->file_url ? strtoupper(pathinfo($item->file_url, PATHINFO_EXTENSION)) : '-' }}</span>
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

            <div class="info-note">
                <h4><i class="fas fa-info-circle"></i> Cara Memutar</h4>
                <p>Anda dapat mengakses file media melalui tombol "Putar / Akses" di samping. Untuk mengunduh file, silakan login terlebih dahulu.</p>
            </div>

            {{-- Tombol Kembali --}}
            <div style="margin-top: 30px; text-align: center;">
                <a href="{{ route('guest.koleksi_elektronik.cd') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Koleksi CD
                </a>
            </div>
        </main>
    </div>
@endsection
