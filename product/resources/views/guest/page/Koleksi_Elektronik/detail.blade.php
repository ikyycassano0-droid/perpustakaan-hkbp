{{-- resources/views/guest/page/Koleksi_Elektronik/detail.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        .main-wrapper {
            max-width: 1220px;
            margin: 40px auto;
            padding: 0 15px;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 50px;
            align-items: start;
            justify-items: start;
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

        .book-pages {
            position: absolute;
            width: 96%;
            height: 96%;
            top: 2%;
            left: 2%;
            background: #fffdfd;
            border-radius: 2px 8px 8px 2px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05), 2px 3px 10px rgba(0, 0, 0, 0.1);
            z-index: 5;
            padding: 30px 16px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            font-family: 'Playfair Display', serif;
        }

        .book-pages h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a6b47;
            border-left: 4px solid #f1c40f;
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
            border-left: 3px solid #1a6b47;
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

        .real-book:hover .book-cover {
            transform: rotateY(-180deg);
        }

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
        }

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
        }

        .book-pages::-webkit-scrollbar {
            width: 3px;
        }

        .book-pages::-webkit-scrollbar-track {
            background: #ece3cf;
            border-radius: 10px;
        }

        .book-pages::-webkit-scrollbar-thumb {
            background: #1a6b47;
            border-radius: 10px;
        }

        /* ========== ACTION BUTTONS ========== */
        .ebook-actions {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-ebook {
            width: 100%;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 0.9rem;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .btn-read-online {
            background: #1a6b47;
            color: white;
            box-shadow: 0 4px 12px rgba(26, 107, 71, 0.3);
        }

        .btn-read-online:hover {
            background: #0f4a31;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(26, 107, 71, 0.4);
            color: white;
        }

        .btn-read-online i {
            font-size: 1.1rem;
        }

        .btn-read-online .badge-label {
            font-size: 0.7rem;
            font-weight: 400;
            opacity: 0.8;
            background: rgba(255,255,255,0.15);
            padding: 2px 10px;
            border-radius: 12px;
        }

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

        .btn-download-locked {
            background: #f5f5f0;
            color: #999;
            border: 2px solid #ddd;
            cursor: not-allowed;
            opacity: 0.7;
            position: relative;
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

        /* ========== DETAIL BOX - DIPERBAIKI ========== */
        .detail-box {
            background: white;
            border-radius: 20px;
            padding: 40px 45px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #d4e5d9;
            border-top: 4px solid #f1c40f;
        }

        .category-tag {
            display: inline-block;
            color: #1a6b47;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .detail-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: #1a6b47;
            margin-bottom: 8px;
            line-height: 1.2;
            font-weight: 700;
        }

        .detail-author {
            color: #5a7060;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .detail-author a {
            color: #1a6b47;
            font-weight: 600;
            text-decoration: none;
        }

        /* ===== STATUS TABLE ===== */
        .section-header {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0d2137;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header span {
            color: #5a7060;
            font-weight: 400;
        }

        .availability-card {
            background: #fff;
            border: 1px solid #d4e5d9;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 35px;
        }

        .avail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .avail-table th {
            background: #f0f7f3;
            color: #1a6b47;
            font-weight: 700;
            text-align: left;
            padding: 12px 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #d4e5d9;
        }

        .avail-table td {
            padding: 14px 20px;
            color: #0d2137;
            font-size: 0.9rem;
            border-bottom: 1px solid #f0f2f0;
        }

        .avail-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #2daa6e;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #2daa6e;
            border-radius: 50%;
            position: relative;
        }

        .pulse-dot::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: #2daa6e;
            border-radius: 50%;
            animation: pulse-ring 1.5s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.33);
                opacity: 0.8;
            }
            80%, 100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* ===== INFO DETAIL ===== */
        .info-heading {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0d2137;
            margin: 35px 0 20px;
            display: flex;
            align-items: center;
            border-left: 4px solid #f1c40f;
            padding-left: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #f0f2f0;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 10px 0;
            font-size: 0.9rem;
            vertical-align: top;
        }

        .info-table .label-col {
            width: 160px;
            color: #5a7060;
            font-weight: 600;
            padding-right: 20px;
            white-space: nowrap;
        }

        .info-table .value-col {
            color: #0d2137;
            font-weight: 400;
        }

        .info-table .value-col .category-badge {
            display: inline-block;
            background: #1a6b47;
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
            background: #1a6b47;
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
            background: #0f4a31;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 3px;
        }

        .keyword-tag {
            background: #eef4f0;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            color: #1a6b47;
        }

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
            .detail-box {
                padding: 20px;
            }

            .real-book {
                width: 250px;
                height: 370px;
            }

            .btn-ebook {
                font-size: 0.8rem;
                padding: 12px 16px;
            }

            .btn-ebook .badge-label {
                font-size: 0.6rem;
                padding: 1px 8px;
            }

            .detail-title {
                font-size: 1.6rem;
            }

            .info-table .label-col {
                width: 100px;
                font-size: 0.8rem;
            }

            .info-table td {
                font-size: 0.8rem;
                padding: 8px 0;
            }

            .avail-table th,
            .avail-table td {
                padding: 10px 14px;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-wrapper">
        <!-- 3D BOOK SECTION -->
        <div class="book-wrap">
            <div class="real-book">
                <div class="book-spine"></div>
                <div class="book-edges"></div>
                <div class="book-back"></div>

                <div class="book-pages">
                    <h3><i class="fas fa-feather-alt"></i> Abstrak</h3>
                    <p>{{ Str::limit($item->abstract ?? 'Tidak ada abstrak untuk koleksi ini.', 350) }}</p>

                    @if($item->keywords)
                        <div class="book-preview">
                            <i class="fas fa-tags"></i> <strong>Kata Kunci:</strong><br>
                            <div class="keywords" style="margin-top: 5px;">
                                @php
                                    $keywords = is_array($item->keywords) ? $item->keywords : json_decode($item->keywords, true);
                                @endphp
                                @if($keywords)
                                    @foreach($keywords as $keyword)
                                        <span class="keyword-tag">#{{ $keyword }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="pages-meta">
                        <span><i class="fas fa-lock-open"></i> Open Access</span>
                    </div>
                </div>

                <!-- Cover depan -->
                <div class="book-cover">
                    @if($item->cover_image && Storage::disk('public')->exists($item->cover_image))
                        <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}">
                    @else
                        <img src="{{ asset('assets/default-cover.jpg') }}" alt="Default Cover">
                    @endif
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="ebook-actions">
                @if($item->file_url)
                    @php
                        $fullFileUrl = asset('storage/' . $item->file_url);
                        $ext = strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION));
                        $isWord = in_array($ext, ['doc', 'docx']);
                        $bacaUrl = $isWord
                            ? 'https://docs.google.com/viewer?url=' . urlencode($fullFileUrl)
                            : $fullFileUrl;
                    @endphp
                    <a href="{{ $bacaUrl }}" target="_blank" class="btn-ebook btn-read-online">
                        <i class="fas fa-book-open"></i> BACA SEKARANG
                        <span class="badge-label">ONLINE</span>
                    </a>
                @else
                    <button class="btn-ebook btn-read-online" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-book-open"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif

                @if($item->file_url)
                    <button class="btn-ebook btn-download btn-download-locked" disabled>
                        <i class="fas fa-lock lock-icon"></i> UNDUH PDF
                        <span class="badge-label">OFFLINE</span>
                    </button>
                    <div class="login-hint">
                        <i class="fas fa-info-circle" style="color: #ccc;"></i>
                        Login untuk mengunduh file &nbsp;
                        <a href="{{ route('login') }}">Login Sekarang →</a>
                    </div>
                @else
                    <button class="btn-ebook btn-download" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-file-pdf"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif
            </div>
        </div>

        <!-- DETAIL CARD - DIPERBAIKI DENGAN TABEL -->
        <div class="detail-box">
            <!-- Title Area -->
            <div class="category-tag">
                <i class="fas {{ $item->category->slug == 'ebook' ? 'fa-book-open' : ($item->category->slug == 'video' ? 'fa-video' : 'fa-file-alt') }}"></i>
                {{ strtoupper($item->category->name ?? 'KOLEKSI ELEKTRONIK') }}
            </div>
            <h1 class="detail-title">{{ $item->title }}</h1>
            <p class="detail-author">
                @if($item->student_name)
                    Oleh <a href="#">{{ $item->student_name }}</a>
                @elseif($item->user)
                    Oleh <a href="#">{{ $item->user->name ?? 'Admin Perpustakaan' }}</a>
                @else
                    Oleh <a href="#">Admin Perpustakaan</a>
                @endif
                @if($item->year)
                    | Tahun {{ $item->year }}
                @endif
            </p>

            <!-- Status Table -->
            <div class="section-header">
                <i class="fas fa-cloud-upload-alt" style="color: #0f4a31;"></i>
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
                            <td><strong>Full Text {{ strtoupper($item->category->slug ?? 'PDF') }}</strong></td>
                            <td>Digital-Cloud-HKBP-01</td>
                            <td>
                                <div class="status-badge">
                                    <div class="pulse-dot"></div>
                                    @if($item->status == 'Approved')
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

            <!-- Info Detail - Menggunakan Tabel -->
            <div class="info-heading">
                <i class="fas fa-info-circle"></i> Informasi Detail
            </div>

            <table class="info-table">
                @if($item->isbn)
                    <tr>
                        <td class="label-col">ISBN/ISSN</td>
                        <td class="value-col">{{ $item->isbn }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="label-col">Penerbit</td>
                    <td class="value-col">{{ $item->publisher ?? 'Akper HKBP Press' }}</td>
                </tr>

                @if($item->year)
                    <tr>
                        <td class="label-col">Tahun Terbit</td>
                        <td class="value-col">{{ $item->year }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="label-col">Bahasa</td>
                    <td class="value-col">{{ $item->language ?? 'Indonesia' }}</td>
                </tr>

                @if($item->edition)
                    <tr>
                        <td class="label-col">Edisi</td>
                        <td class="value-col">{{ $item->edition }}</td>
                    </tr>
                @endif

                @if($item->classifications && $item->classifications->count())
                    <tr>
                        <td class="label-col">Klasifikasi</td>
                        <td class="value-col">
                            @foreach($item->classifications as $classification)
                                <span class="category-badge">{{ $classification->code ?? $classification->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endif

                @if($item->categoriesMany && $item->categoriesMany->count())
                    <tr>
                        <td class="label-col">Kategori</td>
                        <td class="value-col">
                            @foreach($item->categoriesMany as $category)
                                <span class="category-badge">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endif

                <tr>
                    <td class="label-col">Tipe Isi / Media</td>
                    <td class="value-col">
                        Text (Digital) /
                        @if($item->file_url)
                            @php
                                $extension = pathinfo($item->file_url, PATHINFO_EXTENSION);
                            @endphp
                            {{ strtoupper($extension) }} File
                        @else
                            Computer File
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Lokasi</td>
                    <td class="value-col">E-Library Server - Koleksi Elektronik</td>
                </tr>

                @if($item->created_at)
                    <tr>
                        <td class="label-col">Tanggal Unggah</td>
                        <td class="value-col">{{ $item->created_at->format('d F Y') }}</td>
                    </tr>
                @endif
            </table>

            <!-- Abstract -->
            @if($item->abstract)
                <div class="info-heading" style="margin-top: 30px;">
                    <i class="fas fa-align-left"></i> Abstrak
                </div>
                <div class="abstract-content">
                    {{ $item->abstract }}
                </div>
            @endif

            <!-- Tombol Kembali -->
            <div style="margin-top: 40px; text-align: center;">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('guest.koleksi_elektronik.ebook') }}"
                   class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Koleksi
                </a>
            </div>
        </div>
    </div>
@endsection
