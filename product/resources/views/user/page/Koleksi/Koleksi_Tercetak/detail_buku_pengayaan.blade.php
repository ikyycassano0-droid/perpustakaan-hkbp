{{-- resources/views/user/page/Koleksi/Koleksi_Tercetak/detail_buku_pengayaan.blade.php --}}
@extends('user.component.master')

@section('title', $collection->title . ' - Perpustakaan AKPER HKBP')

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
            justify-content: flex-end;
            align-items: flex-start;
            overflow: visible;
            min-height: 100vh;
        }

        /* ============================================================
               3D BOOK SECTION
            ============================================================ */
        .book-wrap {
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
            overflow: visible;
        }

        .real-book:hover {
            transform: rotateY(-5deg) rotateX(1deg) translateX(30px);
        }

        .real-book:hover .book-cover {
            transform: rotateY(-180deg);
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
            -webkit-backface-visibility: hidden;
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
            -webkit-backface-visibility: hidden;
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
            -webkit-backface-visibility: hidden;
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

        /* ============================================================
               ACTION BUTTONS
            ============================================================ */
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
            text-decoration: none;
        }

        .btn-read {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
        }

        .btn-read:hover {
            background: var(--accent-green);
            transform: translateY(-3px);
            color: white;
        }

        .btn-read:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-back-action {
            background: #eef4f0;
            color: var(--primary-color);
            border: 1.8px solid var(--primary-color);
        }

        .btn-back-action:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* ============================================================
               DETAIL BOX
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

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent-green);
            font-weight: 700;
        }

        .status-badge-danger {
            color: var(--danger);
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
            width: 100%;
            justify-content: center;
        }

        .btn-back:hover {
            background: var(--deep-green);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .btn-back i {
            font-size: 0.9rem;
        }

        /* ============================================================
               MODAL
            ============================================================ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 74, 49, 0.4);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s;
        }

        .modal-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        .modal-container {
            background: white;
            border-radius: 28px;
            width: 100%;
            max-width: 480px;
            margin: 1rem;
            box-shadow: 0 25px 50px rgba(15, 74, 49, 0.25);
            border: 1px solid var(--border-color);
            border-top: 5px solid var(--accent-yellow);
            transform: scale(0.9);
            transition: transform 0.3s;
            padding: 32px 36px;
        }

        .modal-overlay.active .modal-container {
            transform: scale(1);
        }

        .modal-container h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-family: 'Playfair Display', serif;
        }

        .modal-container h2 i {
            color: var(--accent-yellow);
        }

        .modal-container label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            display: block;
            margin-bottom: 0.4rem;
        }

        .modal-container input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            background: #f9fbf9;
            transition: 0.2s;
        }

        .modal-container input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(26, 107, 71, 0.1);
            outline: none;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 1rem;
        }

        .btn-modal {
            flex: 1;
            padding: 12px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .btn-batal {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-batal:hover {
            background: #e2e8f0;
        }

        .btn-submit {
            background: var(--primary-color);
            color: white;
        }

        .btn-submit:hover {
            background: var(--deep-green);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .modal-text-center {
            text-align: center;
        }

        .modal-text-center .icon-large {
            font-size: 2.5rem;
            color: var(--accent-yellow);
            margin-bottom: 15px;
        }

        .modal-text-center h3 {
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 700;
        }

        .modal-text-center p {
            color: #666;
            font-size: 0.9rem;
            margin: 10px 0 30px;
        }

        .modal-actions-center {
            display: flex;
            gap: 15px;
            justify-content: center;
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

            .book-wrap {
                position: relative;
                top: 0;
                flex: none;
                width: 100%;
                max-width: 350px;
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

            .real-book {
                width: 250px;
                height: 370px;
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

            .modal-container {
                padding: 24px 20px;
                border-radius: 20px;
            }

            .modal-actions {
                flex-direction: column;
            }

            .modal-actions-center {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .main-wrapper {
                margin: 90px 10px 15px 10px;
                padding: 0;
            }

            .real-book {
                width: 200px;
                height: 300px;
            }

            .detail-box {
                padding: 16px;
                border-radius: 16px;
            }

            .book-pages {
                padding: 16px 12px;
            }

            .book-pages h3 {
                font-size: 0.8rem;
            }

            .book-pages p {
                font-size: 0.6rem;
            }

            .pages-meta {
                font-size: 0.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-wrapper">
        <!-- ===== 3D BOOK SECTION ===== -->
        <div class="book-wrap" data-aos="zoom-in-right">
            <div class="real-book">
                <div class="book-spine"></div>
                <div class="book-edges"></div>
                <div class="book-back"></div>

                <div class="book-pages">
                    <h3><i class="fas fa-feather-alt"></i> Sinopsis</h3>
                    <p>{{ Str::limit($collection->description ?? 'Tidak ada sinopsis untuk buku ini.', 350) }}</p>

                    @if ($collection->publisher || $collection->publication_year)
                        <div class="book-preview">
                            <i class="fas fa-info-circle"></i> <strong>Informasi Terbitan:</strong><br>
                            {{ $collection->publisher ?? 'AKPER HKBP Press' }}, {{ $collection->publication_year ?? '-' }}
                        </div>
                    @endif

                    <div class="pages-meta">
                        <span><i class="fas fa-hashtag"></i> Koleksi Cetak</span>
                        <span><i class="fas fa-book"></i> Buku Pengayaan</span>
                    </div>
                </div>

                <!-- Cover depan -->
                <div class="book-cover">
                    @if ($collection->cover_image && Storage::disk('public')->exists($collection->cover_image))
                        <img src="{{ Storage::url($collection->cover_image) }}" alt="{{ $collection->title }}">
                    @else
                        <img src="https://via.placeholder.com/400x600?text=Buku+Cover" alt="Default Cover">
                    @endif
                </div>
            </div>

            <!-- ===== TOMBOL AKSI ===== -->
            <div class="ebook-actions">
                @if (session()->has('user'))
                    @if ($borrowStatus)
                        @if ($borrowStatus['status'] == 'PENDING')
                            <button class="btn-ebook btn-read" disabled>
                                <i class="fas fa-clock"></i> Menunggu Konfirmasi
                            </button>
                        @elseif ($borrowStatus['status'] == 'APPROVED')
                            <button class="btn-ebook btn-read" disabled>
                                <i class="fas fa-book"></i> Sedang Dipinjam
                            </button>
                        @elseif ($borrowStatus['status'] == 'REJECTED')
                            <button class="btn-ebook btn-read" id="btnPinjamKiri">
                                <i class="fas fa-book-reader"></i> PINJAM SEKARANG
                            </button>
                        @endif
                    @elseif ($collection->available_stock > 0)
                        <button class="btn-ebook btn-read" id="btnPinjamKiri">
                            <i class="fas fa-book-reader"></i> PINJAM SEKARANG
                        </button>
                    @else
                        <button class="btn-ebook btn-read" disabled>
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </button>
                    @endif
                @else
                    <button class="btn-ebook btn-read" id="btnPinjamKiri">
                        <i class="fas fa-book-reader"></i> PINJAM SEKARANG
                    </button>
                @endif

                <a href="{{ route('user.koleksi.buku_pengayaan') }}" class="btn-ebook btn-back-action" style="text-decoration:none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Menu Buku Pengayaan
                </a>
            </div>
        </div>

        <!-- ===== DETAIL BOX ===== -->
        <div class="detail-box" data-aos="fade-left">
            <div class="title-area">
                <span class="top-tag">
                    <i class="fas fa-book-open"></i> KOLEKSI BUKU PENGAYAAN
                </span>
                <h1>{{ $collection->title }}</h1>
                <p class="author-text">
                    @php
                        $authors = is_array($collection->author) ? $collection->author : json_decode($collection->author, true) ?? [];
                        $authorStr = !empty($authors) ? implode(', ', $authors) : 'Tim Penulis';
                    @endphp
                    <a href="#">{{ $authorStr }}</a>
                    @if ($collection->edition)
                        — Edisi {{ $collection->edition }}
                    @endif
                    @if ($collection->publication_year)
                        | {{ $collection->publication_year }}
                    @endif
                </p>
            </div>

            <!-- ===== STATUS KETERSEDIAAN ===== -->
            <div class="section-header">
                <i class="fas fa-boxes" style="color: var(--accent-green);"></i>
                Status Ketersediaan Fisik <span>— Rak Koleksi</span>
            </div>

            <div class="availability-card">
                <table class="avail-table">
                    <thead>
                        <tr>
                            <th># Tipe Ketersediaan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Stok Tersedia</strong></td>
                            <td>
                                @if (($collection->available_stock ?? 0) > 0)
                                    <div class="status-badge">
                                        <div class="pulse-dot"></div>
                                        Tersedia ({{ $collection->available_stock }} eksemplar)
                                    </div>
                                @else
                                    <div class="status-badge status-badge-danger">
                                        <i class="fas fa-times-circle"></i>
                                        Tidak Tersedia
                                    </div>
                                @endif
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
                <div class="info-row">
                    <div class="label">ISBN/ISSN</div>
                    <div class="value">{{ $collection->isbn ?? '-' }}</div>
                </div>

                <div class="info-row">
                    <div class="label">Penerbit</div>
                    <div class="value">{{ $collection->publisher ?? 'AKPER HKBP Press' }}</div>
                </div>

                @if ($collection->publication_year)
                    <div class="info-row">
                        <div class="label">Tahun Terbit</div>
                        <div class="value">{{ $collection->publication_year }}</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Bahasa</div>
                    <div class="value">{{ $collection->language ?? 'Indonesia' }}</div>
                </div>

                <div class="info-row">
                    <div class="label">Format</div>
                    <div class="value">{{ $collection->format ?? 'Cetak' }}</div>
                </div>

                @if ($collection->edition)
                    <div class="info-row">
                        <div class="label">Edisi</div>
                        <div class="value">{{ $collection->edition }}</div>
                    </div>
                @endif

                @if ($collection->classifications && $collection->classifications->count())
                    <div class="info-row">
                        <div class="label">Klasifikasi</div>
                        <div class="value">
                            @foreach ($collection->classifications as $classification)
                                <span class="category-badge">{{ $classification->code ?? $classification->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($collection->categories && $collection->categories->count())
                    <div class="info-row">
                        <div class="label">Kategori</div>
                        <div class="value">
                            @foreach ($collection->categories as $category)
                                <span class="category-badge">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($collection->location)
                    <div class="info-row">
                        <div class="label">Lokasi Rak</div>
                        <div class="value">{{ $collection->location->name }}</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Jenis Koleksi</div>
                    <div class="value">Buku Pengayaan (Dapat dipinjam)</div>
                </div>
            </div>

            <!-- ===== SINOPSIS ===== -->
            @if ($collection->description)
                <div class="info-heading" style="margin-top: 25px;">
                    <i class="fas fa-align-left"></i> Sinopsis / Deskripsi
                </div>
                <div class="abstract-content">
                    {{ $collection->description }}
                </div>
            @endif

            <!-- ===== TOMBOL PINJAM BAWAH ===== -->
            <div style="margin-top: 30px;">
                @if (session()->has('user'))
                    @if ($borrowStatus)
                        @if ($borrowStatus['status'] == 'PENDING')
                            <button class="btn-ebook btn-read" disabled style="width:100%;">
                                <i class="fas fa-clock"></i> Menunggu Konfirmasi
                            </button>
                        @elseif ($borrowStatus['status'] == 'APPROVED')
                            <button class="btn-ebook btn-read" disabled style="width:100%;">
                                <i class="fas fa-book"></i> Sedang Dipinjam
                            </button>
                        @elseif ($borrowStatus['status'] == 'REJECTED')
                            <button class="btn-ebook btn-read" id="btnPinjamBawah" style="width:100%;">
                                <i class="fas fa-book-reader"></i> PINJAM SEKARANG
                            </button>
                        @endif
                    @elseif ($collection->available_stock > 0)
                        <button class="btn-ebook btn-read" id="btnPinjamBawah" style="width:100%;">
                            <i class="fas fa-book-reader"></i> PINJAM SEKARANG
                        </button>
                    @else
                        <button class="btn-ebook btn-read" disabled style="width:100%;">
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </button>
                    @endif
                @else
                    <button class="btn-ebook btn-read" id="btnPinjamBawah" style="width:100%;">
                        <i class="fas fa-book-reader"></i> PINJAM SEKARANG
                    </button>
                @endif

            </div>
        </div>
    </div>

    <!-- ===== MODAL PEMINJAMAN ===== -->
    <div id="pinjamModal" class="modal-overlay">
        <div class="modal-container">
            <h2><i class="fas fa-calendar-check"></i> Form Peminjaman Buku</h2>
            <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="collection_id" value="{{ $collection->id }}">

                <div>
                    <label>Judul Buku</label>
                    <input type="text" value="{{ $collection->title }}" readonly>
                </div>
                <div>
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="borrow_date" required>
                </div>
                <div>
                    <label>Tanggal Kembali (maks. 3 hari)</label>
                    <input type="date" name="return_date" id="return_date" required>
                </div>
                <div class="modal-actions">
                    <button type="button" onclick="closeModal()" class="btn-modal btn-batal">Batal</button>
                    <button type="submit" id="submitPinjamBtn" class="btn-modal btn-submit">Pinjam</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL LOGIN ===== -->
    <div id="loginModal" class="modal-overlay">
        <div class="modal-container modal-text-center">
            <div class="icon-large"><i class="fas fa-user-lock"></i></div>
            <h3>Akses Terbatas</h3>
            <p>Silakan login terlebih dahulu untuk meminjam koleksi ini.</p>
            <div class="modal-actions-center">
                <button onclick="document.getElementById('loginModal').classList.remove('active')" class="btn-modal btn-batal" style="flex:1;">Kembali</button>
                <button onclick="window.location.href='{{ route('login') }}'" class="btn-modal btn-submit" style="flex:1;">Login</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        AOS.init({
            duration: 700,
            once: true
        });

        var pinjamModal = document.getElementById('pinjamModal');
        var loginModal = document.getElementById('loginModal');

        function handlePinjam() {
            @if (session()->has('user'))
                pinjamModal.classList.add('active');
            @else
                loginModal.classList.add('active');
            @endif
        }

        document.getElementById('btnPinjamKiri')?.addEventListener('click', handlePinjam);
        document.getElementById('btnPinjamBawah')?.addEventListener('click', handlePinjam);

        window.closeModal = function() {
            pinjamModal.classList.remove('active');
            document.getElementById('pinjamForm').reset();
            var btn = document.getElementById('submitPinjamBtn');
            if (btn) {
                btn.disabled = false;
                btn.innerText = 'Pinjam';
            }
        };

        document.getElementById('loginModal')?.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });

        // Date picker logic
        var today = new Date();
        var borrowInput = document.getElementById('borrow_date');
        var returnInput = document.getElementById('return_date');

        if (borrowInput && returnInput) {
            borrowInput.min = formatDate(today);
            borrowInput.value = formatDate(today);

            var minReturn = new Date(today);
            minReturn.setDate(minReturn.getDate() + 1);
            var maxReturn = new Date(today);
            maxReturn.setDate(maxReturn.getDate() + 3);

            returnInput.min = formatDate(minReturn);
            returnInput.max = formatDate(maxReturn);
            returnInput.value = formatDate(minReturn);

            borrowInput.addEventListener('change', function() {
                var borrow = new Date(this.value);
                borrow.setHours(0, 0, 0, 0);
                var minRet = new Date(borrow);
                minRet.setDate(minRet.getDate() + 1);
                var maxRet = new Date(borrow);
                maxRet.setDate(maxRet.getDate() + 3);
                returnInput.min = formatDate(minRet);
                returnInput.max = formatDate(maxRet);
                var cur = new Date(returnInput.value);
                if (cur < minRet || cur > maxRet) returnInput.value = formatDate(minRet);
            });
        }

        function formatDate(date) {
            var y = date.getFullYear();
            var m = String(date.getMonth() + 1).padStart(2, '0');
            var d = String(date.getDate()).padStart(2, '0');
            return y + '-' + m + '-' + d;
        }

        document.getElementById('pinjamForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            var borrow = new Date(borrowInput.value);
            var ret = new Date(returnInput.value);
            borrow.setHours(0, 0, 0, 0);
            ret.setHours(0, 0, 0, 0);
            var diff = (ret - borrow) / (1000 * 60 * 60 * 24);
            if (diff < 1) {
                alert('Minimal peminjaman 1 hari');
                return;
            }
            if (diff > 3) {
                alert('Maksimal peminjaman hanya 3 hari');
                return;
            }
            var btn = document.getElementById('submitPinjamBtn');
            btn.innerText = 'Memproses...';
            btn.disabled = true;
            this.submit();
        });
    </script>
@endpush
