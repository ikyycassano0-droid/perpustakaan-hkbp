{{-- detail.blade.php untuk Ebook, E-article, dan jenis lainnya --}}
@extends('user.component.master')

@section('title', $item->title . ' - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* Additional styles specific to ebook detail page */
        .main-wrapper {
            max-width: 1300px;
            margin: 40px auto 40px 13%;
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
            background: var(--accent-green);
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
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
        }

        .btn-read:hover {
            background: var(--accent-green);
            transform: translateY(-3px);
            color: white;
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

        /* Detail Box */
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

        .author-text a {
            color: var(--primary-color);
            font-weight: 600;
        }

        .author-text a:hover {
            text-decoration: underline;
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

        .label {
            color: var(--text-muted);
            font-weight: 600;
        }

        .value {
            color: var(--text-dark);
            font-weight: 500;
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
            color: var(--primary-color);
        }

        .category-badge {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            margin: 2px;
        }

        /* Reader Overlay */
        #reader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--reader-bg, #1a1a1a);
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

        .btn-nav-reader:hover {
            background: var(--accent-green);
        }

        /* Tombol Kembali */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--primary-color, #1a6b47);
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
            background: var(--accent-green, #0f4a31);
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

            .reader-page {
                padding: 30px 25px;
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
        <div class="book-wrap" data-aos="zoom-in-right">
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
                                @foreach(is_array($item->keywords) ? $item->keywords : json_decode($item->keywords, true) ?? [] as $keyword)
                                    <span class="keyword-tag">#{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="pages-meta">
                        <span><i class="fas fa-lock-open"></i> Open Access</span>
                    </div>
                </div>

                <!-- Cover depan dengan gambar -->
                <div class="book-cover">
                    @if($item->cover_image && Storage::disk('public')->exists($item->cover_image))
                        <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}">
                    @else
                        <img src="{{ asset('assets/default-cover.jpg') }}" alt="Default Cover">
                    @endif
                </div>
            </div>

            <div class="ebook-actions">
                {{-- Tombol Baca Online --}}
                @if($item->file_url)
                    @php
                        $fileUrl  = Storage::url($item->file_url);
                        $fullFileUrl = asset('storage/' . $item->file_url);
                        $ext      = strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION));
                        $isWord   = in_array($ext, ['doc', 'docx']);
                        $bacaUrl  = $isWord
                            ? 'https://docs.google.com/viewer?url=' . urlencode($fullFileUrl)
                            : $fullFileUrl;
                    @endphp
                    <a href="{{ $bacaUrl }}" target="_blank" class="btn-ebook btn-read">
                        <i class="fas fa-book-reader"></i> BACA SEKARANG (ONLINE)
                    </a>
                    {{-- Tombol Download Langsung (Tanpa Login) --}}
                    <a href="{{ $fullFileUrl }}" download class="btn-ebook btn-download">
                        <i class="fas fa-file-download"></i> UNDUH {{ strtoupper($ext) }} (OFFLINE)
                    </a>
                @else
                    <button class="btn-ebook btn-read" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-book-reader"></i> FILE TIDAK TERSEDIA
                    </button>
                    <button class="btn-ebook btn-download" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-file-download"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif
            </div>
        </div>

        <!-- DETAIL CARD -->
        <div class="detail-box" data-aos="fade-left">
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

            {{-- Tombol Kembali ke Koleksi (dalam card detail, ditengah) --}}
            <div style="margin-top: 40px; text-align: center;">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('guest.koleksi_elektronik.index') }}"
                   class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Koleksi {{ ucfirst($item->category->name ?? 'Elektronik') }}
                </a>
            </div>
        </div>
    </div>

    <!-- READER OVERLAY (Optional - bisa dihapus jika tidak diperlukan) -->
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
                    @if($item->file_url)
                        @php
                            $fileUrl  = asset('storage/' . $item->file_url);
                            $ext      = strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION));
                            $isWord   = in_array($ext, ['doc', 'docx']);
                            $viewUrl  = $isWord
                                ? 'https://docs.google.com/viewer?url=' . urlencode($fileUrl)
                                : $fileUrl;
                        @endphp
                        <iframe id="pdf-frame" src="{{ $viewUrl }}" style="width:100%; height:800px; border:none;"></iframe>
                    @else
                        <div class="text-center" style="padding: 50px;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #e74c3c;"></i>
                            <p style="margin-top: 20px;">File tidak tersedia untuk dibaca online.</p>
                            <p>Silakan unduh file untuk membaca.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="reader-footer">
            <button class="btn-nav-reader" onclick="closeReader()">Tutup</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        AOS.init({ duration: 700, once: true });

        function openReader() {
            const overlay = document.getElementById('reader-overlay');
            overlay.classList.add('reader-active');
            document.body.style.overflow = 'hidden';
        }

        function closeReader() {
            document.getElementById('reader-overlay').classList.remove('reader-active');
            document.body.style.overflow = 'auto';
            resetSearch();
        }

        function toggleDarkMode() {
            const overlay = document.getElementById('reader-overlay');
            const btn = document.getElementById('darkmode-btn');
            overlay.classList.toggle('reader-dark-mode');
            if (overlay.classList.contains('reader-dark-mode')) {
                btn.classList.remove('fa-moon');
                btn.classList.add('fa-sun');
            } else {
                btn.classList.remove('fa-sun');
                btn.classList.add('fa-moon');
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
            const content = document.getElementById('reader-text-content');

            if (!content.dataset.original && content.innerHTML) {
                content.dataset.original = content.innerHTML;
            }

            if (keyword.length < 3) {
                if (content.dataset.original) {
                    content.innerHTML = content.dataset.original;
                }
                return;
            }

            const regex = new RegExp(`(${keyword})`, 'gi');
            if (content.dataset.original) {
                content.innerHTML = content.dataset.original.replace(regex, '<mark style="background: #f1c40f; color: #000; padding: 2px 4px; border-radius: 3px;">$1</mark>');
            }
        }

        function resetSearch() {
            const content = document.getElementById('reader-text-content');
            if (content.dataset.original) {
                content.innerHTML = content.dataset.original;
            }
            const searchInput = document.getElementById('reader-search-input');
            if (searchInput) searchInput.value = "";
        }

        // Keyboard navigation for reader
        document.addEventListener('keydown', function(e) {
            const reader = document.getElementById('reader-overlay');
            if (reader.classList.contains('reader-active')) {
                if (e.key === 'Escape') {
                    closeReader();
                }
            }
        });
    </script>
@endpush