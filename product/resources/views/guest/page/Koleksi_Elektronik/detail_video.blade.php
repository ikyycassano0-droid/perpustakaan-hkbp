{{-- resources/views/guest/page/Koleksi_Elektronik/detail_video.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Detail Video')

@push('styles')
    <style>
        /* ============================================
           CSS KHUSUS DETAIL VIDEO GUEST
        ============================================ */

        .container {
            max-width: 1400px;
            margin: 30px auto 50px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
        }

        .video-player-wrapper {
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.12);
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

        .video-info-card {
            margin-top: 25px;
            background: #fff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid #f1c40f;
        }

        .video-tag {
            background: #e0f0e8;
            color: #1a6b47;
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
            color: #2d3748;
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
            color: #718096;
            font-size: 0.85rem;
        }

        .video-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .description-card {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            margin-top: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid #f1c40f;
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

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
            padding: 12px 25px;
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

        .sidebar-info {
            background: #fff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2e8f0;
            border-top: 4px solid #f1c40f;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .sidebar-info h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #2d3748;
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

        .info-item .ilabel {
            font-size: 0.8rem;
            color: #718096;
            font-weight: 600;
        }

        .info-item .ivalue {
            font-size: 0.85rem;
            color: #2d3748;
            font-weight: 600;
            text-align: right;
        }

        .sidebar-actions {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-play {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 25px;
            background: #f1c40f;
            color: #1a6b47;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
        }

        .btn-play:hover {
            background: #f5d442;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(241, 196, 15, 0.3);
        }

        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed !important;
            pointer-events: none;
            background: #e2e8f0 !important;
            color: #a0aec0 !important;
        }

        .login-alert {
            padding: 15px;
            background: linear-gradient(135deg, #fff9e6, #fff3cd);
            border: 2px solid #ffc107;
            border-radius: 12px;
            text-align: center;
        }

        .login-alert i {
            color: #f59e0b;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .login-alert p {
            font-size: 0.8rem;
            color: #78350f;
            margin: 8px 0;
        }

        .btn-login {
            display: inline-block;
            padding: 8px 20px;
            background: #1a6b47;
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #0f4a31;
            transform: translateY(-2px);
            color: white;
        }

        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
            }

            .sidebar-info {
                position: relative;
                top: 0;
            }

            .specs-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $fileUrl = $item->file_url ? asset('storage/' . $item->file_url) : null;
        $ext = $fileUrl ? strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION)) : null;
        $videoExts = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv'];
    @endphp

    <div class="container">
        {{-- KONTEN UTAMA --}}
        <main>
            {{-- Video Player --}}
            <div class="video-player-wrapper">
                @if($fileUrl && in_array($ext, $videoExts))
                    <video controls autoplay muted>
                        <source src="{{ $fileUrl }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                @else
                    <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #aaa;">
                        <i class="fas fa-video" style="font-size: 5rem; margin-bottom: 15px; color: #1a6b47;"></i>
                        <p style="font-size: 1rem;">Pratinjau video tidak tersedia</p>
                    </div>
                @endif
            </div>

            {{-- Info Video --}}
            <div class="video-info-card">
                <span class="video-tag">{{ $item->category->name ?? 'Video' }}</span>
                <h1 class="video-title">{{ $item->title }}</h1>

                <div class="video-meta">
                    <span><i class="far fa-user"></i> {{ $item->student_name ?? $item->user->name ?? 'Administrator' }}</span>
                    <span><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}</span>
                    @if($item->year)
                        <span><i class="fas fa-tag"></i> Tahun: {{ $item->year }}</span>
                    @endif
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="description-card">
                <div class="section-label">DESKRIPSI VIDEO</div>
                <p class="description-text">
                    {{ $item->abstract ?? 'Tidak ada deskripsi untuk video ini.' }}
                </p>

                @if($item->keywords)
                    <div style="margin-top: 20px;">
                        <strong>Kata Kunci:</strong>
                        <span style="color: #718096;">
                            {{ is_array($item->keywords) ? implode(', ', $item->keywords) : $item->keywords }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Informasi Teknis --}}
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

            {{-- Tombol Kembali --}}
            <div style="text-align: center;">
                <a href="{{ route('guest.koleksi_elektronik.video') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Koleksi Video
                </a>
            </div>
        </main>

        {{-- SIDEBAR --}}
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
                @if($item->year)
                    <div class="info-item">
                        <span class="ilabel">Tahun</span>
                        <span class="ivalue">{{ $item->year }}</span>
                    </div>
                @endif
                @if($ext)
                    <div class="info-item">
                        <span class="ilabel">Format</span>
                        <span class="ivalue">{{ strtoupper($ext) }}</span>
                    </div>
                @endif
                @if($item->isbn)
                    <div class="info-item">
                        <span class="ilabel">ISBN</span>
                        <span class="ivalue">{{ $item->isbn }}</span>
                    </div>
                @endif
            </div>

            {{-- Tombol: HANYA PUTAR, TANPA DOWNLOAD --}}
            <div class="sidebar-actions">
                @if($fileUrl)
                    @if(in_array($ext, $videoExts))
                        <a href="{{ $fileUrl }}" target="_blank" class="btn-play">
                            <i class="fas fa-play"></i> Putar Video
                        </a>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank" class="btn-play">
                            <i class="fas fa-external-link-alt"></i> Buka File
                        </a>
                    @endif

                    {{-- ALERT LOGIN --}}
                    <div class="login-alert">
                        <i class="fas fa-lock"></i>
                        <p>
                            <strong>Fitur Download Terbatas</strong><br>
                            Login untuk mengunduh video ini.
                        </p>
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                @else
                    <button class="btn-play btn-disabled" disabled>
                        <i class="fas fa-play"></i> Video Tidak Tersedia
                    </button>
                @endif
            </div>
        </aside>
    </div>
@endsection