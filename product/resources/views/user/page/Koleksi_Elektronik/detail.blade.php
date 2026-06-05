@extends('user.component.master')

@section('title', $item->title . ' - Detail Koleksi Elektronik')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN DETAIL (GAYA KLASIK HIJAU)
       Hanya aturan yang TIDAK ada di master
    ============================================ */

    .main-wrapper {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 60px;
    }

    /* --- BUKU 3D --- */
    .book-wrap {
        perspective: 1500px;
        position: sticky;
        top: 120px;
    }

    .book {
        width: 320px;
        height: 480px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-25deg);
        transition: transform 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
    }

    .book:hover {
        transform: rotateY(-5deg) translateX(50px);
    }

    .cover {
        position: absolute;
        width: 100%;
        height: 100%;
        background: var(--primary-color);
        border-radius: 3px 12px 12px 3px;
        z-index: 10;
        transform-origin: left;
        transition: transform 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
        box-shadow: 10px 10px 25px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .page {
        position: absolute;
        width: 98%;
        height: 96%;
        top: 2%;
        left: 1%;
        background: #fffcf0;
        padding: 40px 30px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 5;
        transform: translateZ(-1px);
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .page h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--primary-color);
        border-bottom: 2px solid var(--accent-yellow);
        display: inline-block;
        padding-bottom: 5px;
    }

    .page p {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: 0.95rem;
        line-height: 1.7;
        color: #444;
    }

    .spine {
        position: absolute;
        width: 45px;
        height: 100%;
        background: var(--deep-green);
        left: 0;
        transform: rotateY(-90deg);
        transform-origin: left;
        z-index: 8;
    }

    .book:hover .cover {
        transform: rotateY(-155deg);
    }

    /* --- TOMBOL AKSI EBOOK --- */
    .ebook-actions {
        margin-top: 40px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-ebook {
        width: 100%;
        padding: 18px;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.4s;
        font-size: 0.95rem;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-read {
        background: var(--primary-color);
        color: white;
    }

    .btn-read:hover {
        background: var(--accent-green);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(26, 107, 71, 0.2);
        color: white;
    }

    .btn-download {
        background: #e0f0e8;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-download:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
    }

    /* --- DETAIL BOX --- */
    .detail-box {
        background: white;
        border-radius: 25px;
        padding: 45px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
    }

    .title-area h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        color: var(--primary-color);
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .author-text {
        color: var(--text-muted);
        margin-bottom: 35px;
        font-size: 1rem;
    }

    .section-header {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header span {
        color: var(--text-muted);
        font-weight: 400;
    }

    .availability-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
    }

    .avail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .avail-table th {
        background: #f0f7f3;
        color: var(--primary-color);
        font-weight: 700;
        text-align: left;
        padding: 16px 24px;
        font-size: 0.9rem;
        border-bottom: 2px solid var(--border-color);
    }

    .avail-table td {
        padding: 20px 24px;
        color: var(--text-dark);
        font-size: 0.95rem;
        border-bottom: 1px solid var(--border-color);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--accent-green);
        font-weight: 700;
        font-size: 0.9rem;
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
        0% { transform: scale(0.33); opacity: 0.8; }
        80%, 100% { transform: scale(2.5); opacity: 0; }
    }

    .info-heading {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 45px 0 25px;
        display: flex;
        align-items: center;
        border-left: 5px solid var(--accent-yellow);
        padding-left: 15px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 280px 1fr;
        padding: 15px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .label {
        color: var(--text-muted);
        font-size: 0.95rem;
        font-weight: 600;
    }

    .value {
        color: var(--text-dark);
        font-weight: 400;
        font-size: 0.95rem;
    }

    @media (max-width: 1024px) {
        .main-wrapper {
            grid-template-columns: 1fr;
        }
        .book-wrap {
            position: relative;
            top: 0;
            margin: 0 auto 50px;
            width: 320px;
        }
    }
</style>
@endpush

@section('content')
<div class="main-wrapper">
    {{-- SISI KIRI: BUKU 3D & TOMBOL AKSI --}}
    <div class="book-wrap" data-aos="zoom-in-right">
        <div class="book">
            <div class="spine"></div>
            <div class="cover">
                @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}">
                @else
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=500&q=80" alt="Cover Default">
                @endif
            </div>
            <div class="page">
                <h2>Abstrak</h2>
                <p>{{ $item->abstract ?? 'Tidak ada abstrak tersedia.' }}</p>
                <div style="font-size: 0.75rem; color: #888; margin-top: auto;">
                    @php
                        $ext = $item->file_url ? strtoupper(pathinfo($item->file_url, PATHINFO_EXTENSION)) : 'PDF';
                    @endphp
                    <i class="fas fa-file-pdf"></i> Format: {{ $ext }}<br>
                    <i class="fas fa-hdd"></i> Size: -
                </div>
            </div>
        </div>

        <div class="ebook-actions">
            @if($item->file_url)
                @php
                    $fileUrl = asset('storage/' . $item->file_url);
                    $ext = strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION));
                    $isWord = in_array($ext, ['doc', 'docx']);
                    $bacaUrl = $isWord ? 'https://docs.google.com/viewer?url=' . urlencode($fileUrl) : $fileUrl;
                @endphp
                <a href="{{ $bacaUrl }}" target="_blank" class="btn-ebook btn-read">
                    <i class="fas fa-book-reader"></i> BACA SEKARANG (ONLINE)
                </a>
                <a href="{{ $fileUrl }}" download class="btn-ebook btn-download">
                    <i class="fas fa-file-download"></i> UNDUH (OFFLINE)
                </a>
            @else
                <button class="btn-ebook btn-read" disabled>
                    <i class="fas fa-book-reader"></i> TIDAK TERSEDIA
                </button>
            @endif
        </div>
    </div>

    {{-- SISI KANAN: DETAIL LENGKAP --}}
    <div class="detail-box" data-aos="fade-left">

        <div class="title-area">
            <span style="color: var(--accent-green); font-weight: 800; font-size: 0.75rem; text-transform: uppercase;">
                KOLEKSI ELEKTRONIK ({{ strtoupper($item->category->name ?? 'E-BOOK') }})
            </span>
            <h1>{{ $item->title }}</h1>
            <p class="author-text">Oleh <strong>{{ $item->student_name ?? $item->user->name ?? 'Administrator' }}</strong></p>
        </div>

        <h2 class="section-header">Status Akses Digital <span>— Repositori AKPER</span></h2>
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
                        <td><strong>Full Text</strong></td>
                        <td>Digital-Cloud-HKBP-01</td>
                        <td>
                            @if($item->status === 'Approved')
                                <div class="status-badge"><div class="pulse-dot"></div> Tersedia (Open Access)</div>
                            @else
                                <div class="status-badge" style="color: #e67e22;"><i class="fas fa-clock"></i> {{ $item->status }}</div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-heading">Informasi Detail</div>
        <div class="info-list">
            <div class="info-row">
                <div class="label">Jenis Koleksi</div>
                <div class="value">{{ $item->category->name ?? 'Umum' }}</div>
            </div>
            @if($item->isbn)
            <div class="info-row">
                <div class="label">ISBN</div>
                <div class="value">{{ $item->isbn }}</div>
            </div>
            @endif
            @if($item->year)
            <div class="info-row">
                <div class="label">Tahun</div>
                <div class="value">{{ $item->year }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="label">Bahasa</div>
                <div class="value">Indonesia</div>
            </div>
            <div class="info-row">
                <div class="label">Subjek</div>
                <div class="value">{{ is_array($item->keywords) ? implode(', ', $item->keywords) : ($item->keywords ?? '-') }}</div>
            </div>
            <div class="info-row">
                <div class="label">Klasifikasi</div>
                <div class="value">{{ $item->classifications->pluck('name')->implode(', ') ?: '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Kategori Koleksi</div>
                <div class="value">{{ $item->categoriesMany->pluck('name')->implode(', ') ?: '-' }}</div>
            </div>
        </div>
        <div style="margin-top: 30px; text-align: center;">
           @php
                $categorySlug = $item->category->slug ?? 'ebook';
                // Hapus dash agar cocok dengan nama route (earticle, cd, video, ebook)
                $routeSlug = str_replace('-', '', $categorySlug);
                // Fallback jika route tidak ditemukan
                $backRoute = 'guest.koleksi_elektronik.' . $routeSlug;
                if (!Route::has($backRoute)) {
                    $backRoute = 'guest.koleksi_elektronik.ebook'; // default
                }
            @endphp
            <a href="{{ route($backRoute) }}" class="btn-ebook btn-download" style="display: inline-flex; width: auto; padding: 12px 32px; border-radius: 50px; margin: 0 auto;">
                <i class="fas fa-arrow-left"></i> Kembali ke Koleksi {{ ucfirst($item->category->name ?? 'E-Book') }}
            </a>
        </div>
    </div> {{-- penutup detail-box --}}
    </div>
</div>
@endsection
