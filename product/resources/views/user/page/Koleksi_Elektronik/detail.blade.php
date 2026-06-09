@extends('user.component.master')

@section('title', $item->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
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
        --success: #2daa6e;
    }

    /* --- HEADER --- */
    header {
        background-color: #ffffff;
        color: var(--text-dark);
        padding: 0.6rem 3%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 12px rgba(15, 74, 49, 0.10);
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 2px solid #e6f0ea;
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .logo-img i {
        font-size: 1.5rem;
        color: white;
    }

    .logo-text h1 {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        line-height: 1.2;
        color: var(--text-dark);
    }

    .logo-text span {
        font-size: 0.7rem;
        color: var(--text-muted);
        display: block;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 4px;
    }

    nav ul li {
        position: relative;
    }

    nav ul li a {
        padding: 8px 10px;
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        transition: 0.3s;
        color: var(--text-dark);
    }

    nav ul li a:hover {
        color: var(--primary-color);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #ffffff;
        min-width: 200px;
        box-shadow: 0 8px 20px rgba(15, 74, 49, 0.12);
        border-radius: 8px;
        display: none;
        z-index: 100;
        border-top: 3px solid var(--accent-green);
    }

    .dropdown-menu li a {
        padding: 8px 12px;
        font-size: 0.75rem;
    }

    nav ul li:hover > .dropdown-menu {
        display: block;
    }

    /* --- MAIN LAYOUT --- */
    .main-wrapper {
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 30px;
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 50px;
        align-items: start;
    }

    /* ========== 3D BOOK SECTION ========== */
    .book-wrap {
        perspective: 1600px;
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .real-book {
        width: 300px;
        height: 420px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-12deg) rotateX(2deg);
        transition: transform 0.5s ease;
        cursor: pointer;
        margin-bottom: 30px;
        will-change: transform;
    }

    .real-book:hover {
        transform: rotateY(-5deg) rotateX(1deg) translateX(50px);
    }

    /* Cover belakang */
    .book-back {
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(145deg, #e0d4bc, #cdc0a4);
        border-radius: 4px 12px 12px 4px;
        box-shadow: -5px 5px 15px rgba(0, 0, 0, 0.2);
        z-index: 1;
        backface-visibility: hidden;
    }

    /* Halaman dalam buku (isi) */
    .book-pages {
        position: absolute;
        width: 96%;
        height: 96%;
        top: 2%;
        left: 2%;
        background: #f1f1ee;
        border-radius: 2px 8px 8px 2px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05), 2px 3px 10px rgba(0, 0, 0, 0.1);
        z-index: 5;
        padding: 30px 16px;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        font-family: 'Playfair Display', serif;
        backface-visibility: hidden;
    }

    .book-pages h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-color);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 12px;
        margin-bottom: 12px;
        font-family: 'DM Sans', sans-serif;
    }

    .book-pages p {
        font-size: 0.72rem;
        line-height: 1.55;
        color: #2c3e2f;
        margin-bottom: 10px;
        text-align: justify;
    }

    .book-preview {
        background: #f9f5e8;
        padding: 8px 10px;
        border-radius: 8px;
        margin: 8px 0;
        font-style: italic;
        font-size: 0.7rem;
        border-left: 3px solid var(--accent-green);
    }

    .pages-meta {
        margin-top: auto;
        font-size: 0.62rem;
        color: #a0814b;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #ece3cf;
        padding-top: 10px;
        font-family: 'DM Sans', sans-serif;
    }

    /* Cover depan */
    .book-cover {
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1a6b47, #0f4a31);
        border-radius: 4px 12px 12px 4px;
        transform-origin: left center;
        transition: transform 0.7s cubic-bezier(0.4, 0.2, 0.2, 1);
        z-index: 20;
        box-shadow: -8px 6px 20px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Saat hover: cover terbuka */
    .real-book:hover .book-cover {
        transform: rotateY(-180deg);
    }

    /* Punggung buku */
    .book-spine {
        position: absolute;
        width: 24px;
        height: 100%;
        background: linear-gradient(110deg, #0a3a25, #1b6845, #0f4a31);
        left: -8px;
        top: 0;
        transform: rotateY(-90deg);
        transform-origin: right center;
        border-radius: 3px 2px 2px 3px;
        box-shadow: -3px 0 10px rgba(0, 0, 0, 0.3);
        z-index: 25;
        backface-visibility: hidden;
    }

    /* Efek samping halaman */
    .book-edges {
        position: absolute;
        width: 97%;
        height: 95%;
        top: 2.5%;
        left: 1.5%;
        background: repeating-linear-gradient(180deg, #faf3e0 0px, #faf3e0 2px, #f2e8d0 2px, #f2e8d0 6px);
        z-index: 2;
        transform: translateZ(-5px);
        border-radius: 2px 5px 5px 2px;
        pointer-events: none;
        backface-visibility: hidden;
    }

    .book-pages::-webkit-scrollbar {
        width: 3px;
    }

    .book-pages::-webkit-scrollbar-track {
        background: #ece3cf;
        border-radius: 10px;
    }

    .book-pages::-webkit-scrollbar-thumb {
        background: var(--accent-green);
        border-radius: 10px;
    }

    /* --- ACTION BUTTONS --- */
    .ebook-actions {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 12px;
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
    }

    .btn-read {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
    }

    .btn-read:hover {
        background: var(--accent-green);
        transform: translateY(-3px);
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

    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* --- DETAIL BOX --- */
    .detail-box {
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

    .author-text {
        color: var(--text-muted);
        margin-bottom: 26px;
        font-size: 0.95rem;
        border-bottom: 1px dashed var(--border-color);
        padding-bottom: 14px;
    }

    .section-header {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
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

    .status-badge {
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
        80%, 100% {
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

    .label {
        color: var(--text-muted);
        font-weight: 600;
    }

    .value {
        color: var(--text-dark);
        font-weight: 500;
    }

    .tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 5px;
    }

    .tag {
        background: #e0f2e9;
        color: var(--primary-color);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* --- READER OVERLAY --- */
    #reader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--reader-bg);
        z-index: 2000;
        display: none;
        flex-direction: column;
    }

    .reader-active {
        display: flex !important;
    }

    .reader-nav-top {
        background: #222;
        color: white;
        padding: 12px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #444;
    }

    .search-box-reader {
        display: none;
        align-items: center;
        background: #333;
        border-radius: 20px;
        padding: 4px 12px;
    }

    #reader-search-input {
        background: transparent;
        border: none;
        color: white;
        outline: none;
        font-size: 0.8rem;
        width: 140px;
    }

    .reader-main {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 30px 20px;
        overflow-y: auto;
        background: #2c2c2c;
    }

    .reader-page {
        width: 100%;
        max-width: 800px;
        background: white;
        min-height: 1000px;
        padding: 60px 80px;
        border-radius: 4px;
        font-family: 'Georgia', serif;
        font-size: 1rem;
        line-height: 1.8;
        color: #1a1a1a;
    }

    .reader-dark-mode .reader-page {
        background: #1e1e1e;
        color: #d1d1d1;
    }

    .reader-footer {
        background: #222;
        color: white;
        padding: 10px;
        display: flex;
        justify-content: center;
        gap: 30px;
    }

    .btn-nav-reader {
        background: var(--primary-color);
        border: none;
        padding: 6px 20px;
        border-radius: 30px;
        cursor: pointer;
        color: white;
    }

    /* --- FOOTER --- */
    footer {
        background-color: var(--deep-green);
        color: rgba(200, 235, 218, 0.85);
        padding: 2.5rem 5% 1.5rem;
        margin-top: 40px;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 2rem;
    }

    .footer-col h4 {
        color: white;
        margin-bottom: 1rem;
        border-left: 3px solid var(--accent-green);
        padding-left: 8px;
        font-size: 0.9rem;
    }

    .footer-col p,
    .footer-col ul li a {
        font-size: 0.8rem;
    }

    .footer-col ul {
        list-style: none;
    }

    .footer-col ul li a {
        color: rgba(200, 235, 218, 0.85);
        transition: 0.3s;
    }

    .footer-col ul li a:hover {
        color: white;
    }

    .copyright {
        margin-top: 2rem;
        padding-top: 1rem;
        text-align: center;
        font-size: 0.7rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 1024px) {
        .main-wrapper {
            grid-template-columns: 1fr;
            margin: 30px 20px;
            gap: 35px;
        }

        .book-wrap {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 640px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 6px;
        }

        .reader-page {
            padding: 30px 25px;
        }

        .real-book {
            width: 250px;
            height: 370px;
        }
    }
</style>
@endpush

@section('content')
<div class="main-wrapper">
    <!-- BUKU 3D -->
    <div class="book-wrap" data-aos="zoom-in-right">
        <div class="real-book">
            <div class="book-spine"></div>
            <div class="book-edges"></div>
            <div class="book-back"></div>

            <div class="book-pages">
                <h3><i class="fas fa-feather-alt"></i> Abstrak</h3>
                <p>{{ Str::limit($item->abstract ?? 'Tidak ada abstrak yang tersedia untuk publikasi ini.', 250) }}</p>
                @if($item->keywords)
                <div class="book-preview">
                    <i class="fas fa-tags"></i> <strong>Kata Kunci:</strong> {{ is_array($item->keywords) ? implode(', ', $item->keywords) : $item->keywords }}
                </div>
                @endif
                <div class="pages-meta">
                    <span><i class="fas fa-lock-open"></i> Open Access</span>
                    <span><i class="fas fa-file-pdf"></i>
                        @if($item->file_size)
                            {{ number_format($item->file_size / 1024, 1) }} KB
                        @else
                            PDF Digital
                        @endif
                    </span>
                </div>
            </div>

            <!-- Cover depan dengan gambar -->
            <div class="book-cover">
                @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="Cover {{ $item->title }}">
                @else
                    <img src="{{ asset('assets/img/default-cover.jpg') }}" alt="Default Cover">
                @endif
            </div>
        </div>

        <div class="ebook-actions">
            @if($item->file_url && file_exists(public_path('storage/' . $item->file_url)))
                <button class="btn-ebook btn-read" onclick="openReader('{{ asset('storage/' . $item->file_url) }}')">
                    <i class="fas fa-book-reader"></i> BACA SEKARANG (ONLINE)
                </button>
                <a href="{{ route('login') }}" class="btn-ebook btn-download">
                    <i class="fas fa-file-download"></i> UNDUH PDF (Login Required)
                </a>
            @else
                <button class="btn-ebook btn-read btn-disabled" disabled>
                    <i class="fas fa-ban"></i> FILE TIDAK TERSEDIA
                </button>
                <button class="btn-ebook btn-download btn-disabled" disabled>
                    <i class="fas fa-download"></i> UNDUH (Tidak Tersedia)
                </button>
            @endif
        </div>
    </div>

    <!-- DETAIL CARD -->
    <div class="detail-box" data-aos="fade-left">
        <div class="title-area">
            <span class="top-tag"><i class="fas fa-book-open"></i>
                @if($item->category)
                    {{ $item->category->name }}
                @else
                    KOLEKSI ELEKTRONIK
                @endif
            </span>
            <h1>{{ $item->title }}</h1>
            <p class="author-text">
                Oleh
                @if($item->student_name)
                    <a href="#">{{ $item->student_name }}</a>
                @elseif($item->user)
                    <a href="#">{{ $item->user->name }}</a>
                @else
                    <a href="#">Penulis Tidak Diketahui</a>
                @endif
                @if($item->npm)
                    | NPM: {{ $item->npm }}
                @endif
            </p>
        </div>

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
                        <td><strong>Full Text PDF</strong></td>
                        <td>Digital-Cloud-HKBP-01</td>
                        <td>
                            <div class="status-badge">
                                <div class="pulse-dot"></div>
                                @if($item->file_url && file_exists(public_path('storage/' . $item->file_url)))
                                    Tersedia (Open Access)
                                @else
                                    Tidak Tersedia
                                @endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-heading">
            <i class="fas fa-info-circle"></i> Informasi Detail
        </div>

        <div class="info-list">
            <div class="info-row">
                <div class="label">Series Title</div>
                <div class="value">{{ $item->series_title ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Penerbit</div>
                <div class="value">{{ $item->publisher ?? 'Akper HKBP Press' }}</div>
            </div>
            <div class="info-row">
                <div class="label">ISBN</div>
                <div class="value">{{ $item->isbn ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Bahasa</div>
                <div class="value">{{ $item->language ?? 'Indonesia' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Edisi</div>
                <div class="value">{{ $item->edition ?? 'Edisi Digital Pertama' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Tahun Terbit</div>
                <div class="value">{{ $item->publication_year ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Program Studi</div>
                <div class="value">{{ $item->study_program ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Subjek</div>
                <div class="value">{{ $item->subject ?? $item->category->name ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Pembimbing 1</div>
                <div class="value">{{ $item->first_supervisor->name ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Pembimbing 2</div>
                <div class="value">{{ $item->second_supervisor->name ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Tipe Isi / Media</div>
                <div class="value">Text (Digital) / Computer File</div>
            </div>
            <div class="info-row">
                <div class="label">Lokasi</div>
                <div class="value">E-Library Server - Koleksi Elektronik</div>
            </div>
        </div>

        @if($item->keywords)
        <div class="info-heading" style="margin-top: 20px;">
            <i class="fas fa-tags"></i> Kata Kunci
        </div>
        <div class="tags">
            @foreach(is_array($item->keywords) ? $item->keywords : explode(',', $item->keywords) as $keyword)
                <span class="tag">{{ trim($keyword) }}</span>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- READER OVERLAY -->
<div id="reader-overlay">
    <div class="reader-nav-top">
        <div>
            <i class="fas fa-book-open" style="color: var(--accent-yellow);"></i>
            <span style="margin-left: 10px;">E-READER: {{ $item->title }}</span>
        </div>
        <div>
            <div class="search-box-reader" id="search-container">
                <input type="text" id="reader-search-input" placeholder="Cari kata..." onkeyup="doSearch(event)">
            </div>
            <i class="fas fa-search" onclick="toggleSearch()" style="cursor: pointer;"></i>
            <i class="fas fa-moon" id="darkmode-btn" onclick="toggleDarkMode()" style="cursor: pointer; margin-left: 20px;"></i>
            <i class="fas fa-times-circle" onclick="closeReader()" style="cursor: pointer; margin-left: 20px; color: #e74c3c;"></i>
        </div>
    </div>
    <div class="reader-main">
        <div class="reader-page" id="reader-text-content">
            <div id="pdf-viewer-container" style="width:100%;">
                <iframe id="pdf-frame" src="" style="width:100%; height:800px; border:none;"></iframe>
            </div>
            <div id="preview-content" style="display:none;">
                <h2 style="color: var(--primary-color);">Pratinjau Konten</h2>
                <p>{{ Str::limit($item->abstract ?? 'Konten lengkap dapat diakses melalui tombol baca online atau unduh PDF.', 500) }}</p>
            </div>
        </div>
    </div>
    <div class="reader-footer">
        <button class="btn-nav-reader" onclick="closeReader()">Tutup</button>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="footer-col">
            <h4>Sekolah Keperawatan HKBP</h4>
            <p><i class="fas fa-hospital"></i> Sumatera Utara</p>
            <p><i class="fas fa-envelope"></i> library@akperhkbp.ac.id</p>
        </div>
        <div class="footer-col">
            <h4>Sumber Daya</h4>
            <ul>
                <li><a href="#">Jurnal Keperawatan</a></li>
                <li><a href="#">Panduan Sitasi APA</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Akses Cepat</h4>
            <ul>
                <li><a href="panduan.html">Pendaftaran Anggota</a></li>
                <li><a href="upload-ta.html">Bebas Pustaka</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">&copy; 2024 Perpustakaan Sekolah Keperawatan HKBP.</div>
</footer>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true });

    let currentPdfUrl = '';

    function openReader(pdfUrl) {
        currentPdfUrl = pdfUrl;
        const readerOverlay = document.getElementById('reader-overlay');
        const pdfFrame = document.getElementById('pdf-frame');
        const pdfContainer = document.getElementById('pdf-viewer-container');
        const previewContent = document.getElementById('preview-content');

        if (pdfUrl) {
            pdfFrame.src = pdfUrl;
            pdfContainer.style.display = 'block';
            previewContent.style.display = 'none';
        } else {
            pdfContainer.style.display = 'none';
            previewContent.style.display = 'block';
        }

        readerOverlay.classList.add('reader-active');
        document.body.style.overflow = 'hidden';
    }

    function closeReader() {
        const readerOverlay = document.getElementById('reader-overlay');
        const pdfFrame = document.getElementById('pdf-frame');
        readerOverlay.classList.remove('reader-active');
        document.body.style.overflow = 'auto';
        if (pdfFrame) pdfFrame.src = '';
        resetSearch();
    }

    function toggleDarkMode() {
        const overlay = document.getElementById('reader-overlay');
        const btn = document.getElementById('darkmode-btn');
        overlay.classList.toggle('reader-dark-mode');
        if (overlay.classList.contains('reader-dark-mode')) {
            btn.classList.replace('fa-moon', 'fa-sun');
        } else {
            btn.classList.replace('fa-sun', 'fa-moon');
        }
    }

    function toggleSearch() {
        const box = document.getElementById('search-container');
        if (box.style.display === 'flex') {
            box.style.display = 'none';
            resetSearch();
        } else {
            box.style.display = 'flex';
            document.getElementById('reader-search-input').focus();
        }
    }

    function doSearch(e) {
        const keyword = e.target.value.toLowerCase();
        const content = document.getElementById('preview-content');
        if (!content) return;

        if (!content.dataset.original) content.dataset.original = content.innerHTML;
        if (keyword.length < 3) {
            content.innerHTML = content.dataset.original;
            return;
        }
        const regex = new RegExp(`(${keyword})`, 'gi');
        content.innerHTML = content.dataset.original.replace(regex, '<mark>$1</mark>');
    }

    function resetSearch() {
        const content = document.getElementById('preview-content');
        if (content && content.dataset.original) content.innerHTML = content.dataset.original;
        const searchInput = document.getElementById('reader-search-input');
        if (searchInput) searchInput.value = "";
    }

    function logout() {
        if (confirm("Yakin ingin keluar?")) window.location.href = "{{ route('login') }}";
    }
</script>
@endpush