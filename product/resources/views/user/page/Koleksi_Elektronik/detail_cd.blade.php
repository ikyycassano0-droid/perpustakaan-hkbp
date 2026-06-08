@extends('user.component.master')

@section('title', $item->title . ' - Detail CD Koleksi')

@push('styles')
    <style>
        /* ============================================
           CSS KHUSUS DETAIL CD (GAYA KLASIK HIJAU)
           ============================================ */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 40px;
        }

        .cd-visual-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
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
            color: var(--accent-green);
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .btn-play {
            background: var(--primary-color);
            color: white;
        }

        .btn-play:hover {
            background: var(--accent-green);
            transform: translateY(-2px);
            color: white;
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
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .cd-info-content {
            background: var(--card-bg);
            padding: 45px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
        }

        .category-tag {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cd-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--text-dark);
            margin: 10px 0;
            font-weight: 800;
            line-height: 1.2;
        }

        .cd-meta-top {
            display: flex;
            gap: 20px;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .description-box {
            margin-bottom: 35px;
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
            border: 1px solid var(--border-color);
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

        .info-note {
            margin-top: 30px;
            padding: 20px;
            border-radius: 12px;
            border: 1px dashed var(--primary-color);
            background: #fafdfb;
        }

        .info-note h4 {
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .info-note p {
            font-size: 0.85rem;
            color: var(--text-muted);
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
                <!-- Elemen gambar CD di belakang telah dihapus sesuai permintaan -->
            </div>

            <div class="status-badge status-available">
                <i class="fas fa-check-circle"></i> {{ $item->status == 'Approved' ? 'TERSEDIA' : strtoupper($item->status) }}
            </div>

            @if($item->file_url)
                <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-action btn-play">
                    <i class="fas fa-play-circle"></i> DENGARKAN / AKSES
                </a>
            @else
                <button class="btn-action btn-play" disabled>
                    <i class="fas fa-play-circle"></i> TIDAK TERSEDIA
                </button>
            @endif
            <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 10px;">*Klik untuk mengakses file media</p>
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
                <p>Anda dapat mengakses file media melalui tombol "Dengarkan" di samping, atau mengunduh file untuk diputar di perangkat Anda.</p>
            </div>

            {{-- Tombol Kembali --}}
            <div style="margin-top: 30px; text-align: center;">
                @php
                    $categorySlug = $item->category->slug ?? 'cd';
                    $routeSlug = str_replace('-', '', $categorySlug);
                    $backRoute = Route::has('guest.koleksi_elektronik.' . $routeSlug) ? 'guest.koleksi_elektronik.' . $routeSlug : 'guest.koleksi_elektronik.cd';
                @endphp
                <a href="{{ route($backRoute) }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Koleksi {{ ucfirst($item->category->name ?? 'CD') }}
                </a>
            </div>
        </main>
    </div>
@endsection
