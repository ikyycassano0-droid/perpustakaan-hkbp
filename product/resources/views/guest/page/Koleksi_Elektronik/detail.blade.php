{{-- resources/views/guest/page/Koleksi_Elektronik/detail.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
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

        /* Action Buttons */
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
            background: #1a6b47;
            color: white;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
        }

        .btn-read:hover {
            background: #0f4a31;
            transform: translateY(-3px);
            color: white;
        }

        /* LOGIN ALERT */
        .login-alert {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #fff9e6, #fff3cd);
            border: 2px solid #ffc107;
            border-radius: 16px;
            text-align: center;
            margin-top: 5px;
        }

        .login-alert i {
            font-size: 1.5rem;
            color: #f59e0b;
            margin-bottom: 8px;
            display: block;
        }

        .login-alert strong {
            color: #92400e;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 5px;
        }

        .login-alert p {
            color: #78350f;
            font-size: 0.8rem;
            margin: 0 0 12px 0;
        }

        .btn-login-now {
            display: inline-block;
            background: #1a6b47;
            color: white;
            padding: 8px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-login-now:hover {
            background: #0f4a31;
            transform: translateY(-2px);
            color: white;
        }

        /* ========== DETAIL BOX (CSS DARI HTML REFERENSI BARU) ========== */
        .detail-box {
            background: white;
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid #d4e5d9;
            border-top: 4px solid #f1c40f;
        }

        .title-area h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            color: #1a6b47;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .author-text {
            color: #5a7060;
            margin-bottom: 35px;
            font-size: 1rem;
        }

        .author-text a {
            color: #1a6b47;
            font-weight: 600;
        }

        .section-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0d2137;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-header span {
            color: #5a7060;
            font-weight: 400;
        }

        .availability-card {
            background: #fff;
            border: 1px solid #d4e5d9;
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
            color: #1a6b47;
            font-weight: 700;
            text-align: left;
            padding: 16px 24px;
            font-size: 0.9rem;
            border-bottom: 2px solid #d4e5d9;
        }

        .avail-table td {
            padding: 20px 24px;
            color: #0d2137;
            font-size: 0.95rem;
            border-bottom: 1px solid #d4e5d9;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #2daa6e;
            font-weight: 700;
            font-size: 0.9rem;
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

        .info-heading {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0d2137;
            margin: 45px 0 25px;
            display: flex;
            align-items: center;
            border-left: 5px solid #f1c40f;
            padding-left: 15px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 280px 1fr;
            padding: 15px 0;
            border-bottom: 1px solid #d4e5d9;
        }

        .label {
            color: #5a7060;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .value {
            color: #0d2137;
            font-weight: 400;
            font-size: 0.95rem;
        }

        .keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 5px;
        }

        .keyword-tag {
            background: #eef4f0;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            color: #1a6b47;
        }

        .category-badge {
            display: inline-block;
            background: #1a6b47;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            margin: 2px;
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
        }

        .btn-back:hover {
            background: #0f4a31;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
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
            .info-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .real-book {
                width: 250px;
                height: 370px;
            }

            .detail-box {
                padding: 20px;
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

            <!-- TOMBOL AKSI UNTUK GUEST -->
            <div class="ebook-actions">
                {{-- Tombol Baca Online --}}
                @if($item->file_url)
                    @php
                        $fullFileUrl = asset('storage/' . $item->file_url);
                        $ext = strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION));
                        $isWord = in_array($ext, ['doc', 'docx']);
                        $bacaUrl = $isWord
                            ? 'https://docs.google.com/viewer?url=' . urlencode($fullFileUrl)
                            : $fullFileUrl;
                    @endphp
                    <a href="{{ $bacaUrl }}" target="_blank" class="btn-ebook btn-read">
                        <i class="fas fa-book-reader"></i> BACA ONLINE
                    </a>
                @else
                    <button class="btn-ebook btn-read" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-book-reader"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif

                {{-- ALERT LOGIN UNTUK DOWNLOAD --}}
                <div class="login-alert">
                    <i class="fas fa-lock"></i>
                    <strong>Fitur Download Terbatas</strong>
                    <p>Untuk mengunduh file ini, silakan login terlebih dahulu.</p>
                    <a href="{{ route('login') }}" class="btn-login-now">
                        <i class="fas fa-sign-in-alt"></i> Login Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- DETAIL CARD -->
        <div class="detail-box">
            <div class="title-area">
                <span class="top-tag">
                    <i class="fas {{ $item->category->slug == 'ebook' ? 'fa-book-open' : ($item->category->slug == 'video' ? 'fa-video' : 'fa-file-alt') }}"></i>
                    {{ strtoupper($item->category->name ?? 'KOLEKSI ELEKTRONIK') }}
                </span>
                <h1>{{ $item->title }}</h1>
                <p class="author-text">
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
            </div>

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

            <div class="info-heading">
                <i class="fas fa-info-circle"></i> Informasi Detail
            </div>

            <div class="info-list">
                @if($item->isbn)
                    <div class="info-row">
                        <div class="label">ISBN/ISSN</div>
                        <div class="value">{{ $item->isbn }}</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Penerbit</div>
                    <div class="value">{{ $item->publisher ?? 'Akper HKBP Press' }}</div>
                </div>

                @if($item->year)
                    <div class="info-row">
                        <div class="label">Tahun Terbit</div>
                        <div class="value">{{ $item->year }}</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Bahasa</div>
                    <div class="value">{{ $item->language ?? 'Indonesia' }}</div>
                </div>

                @if($item->edition)
                    <div class="info-row">
                        <div class="label">Edisi</div>
                        <div class="value">{{ $item->edition }}</div>
                    </div>
                @endif

                @if($item->classifications && $item->classifications->count())
                    <div class="info-row">
                        <div class="label">Klasifikasi</div>
                        <div class="value">
                            @foreach($item->classifications as $classification)
                                <span class="category-badge">{{ $classification->code ?? $classification->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($item->categoriesMany && $item->categoriesMany->count())
                    <div class="info-row">
                        <div class="label">Kategori</div>
                        <div class="value">
                            @foreach($item->categoriesMany as $category)
                                <span class="category-badge">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="label">Tipe Isi / Media</div>
                    <div class="value">
                        Text (Digital) /
                        @if($item->file_url)
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

                @if($item->created_at)
                    <div class="info-row">
                        <div class="label">Tanggal Unggah</div>
                        <div class="value">{{ $item->created_at->format('d F Y') }}</div>
                    </div>
                @endif
            </div>

            @if($item->abstract)
                <div class="info-heading" style="margin-top: 25px;">
                    <i class="fas fa-align-left"></i> Abstrak
                </div>
                <div class="abstract-content" style="margin-top: 10px; line-height: 1.8; text-align: justify;">
                    {{ $item->abstract }}
                </div>
            @endif

            {{-- Tombol Kembali --}}
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