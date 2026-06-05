{{-- resources/views/guest/page/koleksi_elektronik/detail_earticle.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA DETAIL E-ARTICLE (KLASIK HIJAU)
    ============================================ */
    .detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 30px;
    }

    /* Sidebar Image Area */
    .article-visual {
        background: var(--card-bg);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .article-visual img {
        width: 100%;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .btn-action {
        display: block;
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-main {
        background: var(--primary-color);
        color: white;
    }
    .btn-main:hover {
        background: var(--accent-green);
        transform: translateY(-2px);
    }
    .btn-outline {
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }
    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    /* Content Area */
    .article-content {
        background: var(--card-bg);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 15px;
        color: white;
    }

    .title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--text-dark);
        line-height: 1.3;
        margin-bottom: 10px;
    }

    .author {
        font-size: 1rem;
        color: var(--text-muted);
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 20px 0 10px;
    }

    .abstract-text {
        color: var(--text-muted);
        text-align: justify;
        font-size: 0.95rem;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .meta-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        background: #f8fbf9;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
    }

    .meta-value {
        font-size: 0.9rem;
        color: var(--text-dark);
        font-weight: 600;
    }

    /* PDF Reader Overlay */
    #pdf-reader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 74, 49, 0.95);
        z-index: 2000;
        display: none;
        flex-direction: column;
    }

    .reader-toolbar {
        background: #0f4a31;
        color: white;
        padding: 10px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .search-container input {
        padding: 6px 35px 6px 12px;
        border-radius: 20px;
        border: none;
        outline: none;
        font-size: 0.85rem;
        width: 200px;
    }

    .search-container i {
        position: absolute;
        right: 12px;
        color: #666;
        cursor: pointer;
    }

    .nav-btn {
        background: #2daa6e;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 0.8rem;
        transition: 0.3s;
    }
    .nav-btn:hover {
        background: var(--accent-yellow);
        color: var(--primary-color);
    }

    .reader-view {
        flex: 1;
        overflow-y: auto;
        padding: 40px 20px;
        display: flex;
        justify-content: center;
    }

    .paper-page {
        background: white;
        width: 100%;
        max-width: 850px;
        min-height: 1000px;
        padding: 70px 90px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        border-radius: 8px;
        color: #1a1a1a;
    }

    mark {
        background-color: #f1c40f;
        color: black;
    }

    @media (max-width: 900px) {
        .detail-container {
            grid-template-columns: 1fr;
        }
        .article-visual {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <!-- SIDEBAR KIRI -->
    <aside class="article-visual">
        @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
            <img src="{{ asset('storage/' . $item->cover_image) }}" alt="Cover">
        @else
            <img src="https://via.placeholder.com/400x300?text=No+Cover" alt="Cover">
        @endif

        @if($item->file_url)
            <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-action btn-main">
                <i class="fas fa-external-link-alt"></i> BUKA PORTAL JURNAL
            </a>
                <a href="{{ route('final_project.download', $book->id) }}" class="btn-outline-read">
                    ⬇️ Download
                </a>
        @else
            <button class="btn-action btn-main" disabled style="opacity:0.6; cursor:not-allowed;">
                <i class="fas fa-ban"></i> FILE TIDAK TERSEDIA
            </button>
        @endif
        <button class="btn-action btn-outline" onclick="openReader()">
            <i class="fas fa-book-open"></i> BACA ONLINE (PREVIEW)
        </button>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="article-content">
        @php
            $badgeColor = '#3498db'; // default internasional
            $badgeText = 'Internasional';
            if (str_contains(strtolower($item->category->name ?? ''), 'nasional')) {
                $badgeColor = '#2daa6e';
                $badgeText = 'Nasional';
            } elseif (str_contains(strtolower($item->category->name ?? ''), 'internal')) {
                $badgeColor = '#e74c3c';
                $badgeText = 'Internal';
            }
        @endphp
        <span class="badge" style="background: {{ $badgeColor }}">{{ $badgeText }}</span>
        <h1 class="title">{{ $item->title }}</h1>
        <p class="author">
            <i class="far fa-user"></i> Penulis:
            <span>{{ $item->student_name ?? ($item->user->name ?? 'Tidak diketahui') }}</span>
        </p>

        <div class="section-title">ABSTRAK</div>
        <p class="abstract-text">
            {{ $item->abstract ?? 'Tidak ada abstrak yang tersedia untuk artikel ini.' }}
        </p>

        <div class="meta-info">
            <div>
                <div class="meta-label">Kategori</div>
                <div class="meta-value">{{ $item->category->name ?? 'E-Article' }}</div>
            </div>
            <div>
                <div class="meta-label">Sumber Database</div>
                <div class="meta-value">{{ $item->journal ?? 'Repository AKPER HKBP' }}</div>
            </div>
            <div>
                <div class="meta-label">Bahasa</div>
                <div class="meta-value">{{ $item->language ?? 'Indonesia/Inggris' }}</div>
            </div>
            <div>
                <div class="meta-label">DOI / ISSN</div>
                <div class="meta-value">{{ $item->doi ?? '10.1234/example' }}</div>
            </div>
        </div>
    </main>
</div>

<!-- PDF READER OVERLAY (PREVIEW KONTEN DARI ABSTRAK) -->
<div id="pdf-reader">
    <div class="reader-toolbar">
        <div class="toolbar-left">
            <span><i class="fas fa-file-alt"></i> {{ $item->title ?? 'Artikel' }}</span>
        </div>
        <div class="toolbar-center">
            <button class="nav-btn" onclick="prevPage()"><i class="fas fa-chevron-left"></i> SEBELUM</button>
            <div class="page-indicator">Halaman <span id="current-page">1</span> dari <span id="total-pages">1</span></div>
            <button class="nav-btn" onclick="nextPage()">LANJUT <i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="toolbar-right">
            <div class="search-container" style="position: relative;">
                <input type="text" id="pdf-search-input" placeholder="Cari kata kunci..." onkeyup="handleSearch(event)">
                <i class="fas fa-search" onclick="performSearch()" style="position: absolute; right: 10px; top: 8px;"></i>
            </div>
            <button onclick="closeReader()" style="background:#e74c3c; border:none; color:white; padding:8px 15px; border-radius:20px; cursor:pointer; font-weight:bold;">
                <i class="fas fa-times"></i> TUTUP
            </button>
        </div>
    </div>
    <div class="reader-view">
        <div class="paper-page" id="printable-area">
            <div class="paper-header">
                <h3>{{ $item->title ?? 'E-Article' }}</h3>
                <p>Penulis: {{ $item->student_name ?? ($item->user->name ?? 'Tidak diketahui') }}</p>
            </div>
            <div class="paper-content" id="page-content-area">
                <h2>Abstrak</h2>
                <p>{{ $item->abstract ?? 'Tidak ada abstrak.' }}</p>
                @if($item->keywords)
                    <p><strong>Kata Kunci:</strong> {{ is_array($item->keywords) ? implode(', ', $item->keywords) : $item->keywords }}</p>
                @endif
                <hr>
                <p style="font-size:0.8rem; color:#666;">*Preview ini hanya menampilkan abstrak dan metadata. Untuk membaca full teks, silakan unduh file PDF.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentPageIndex = 0;
    const totalPages = 1; // hanya 1 halaman preview

    function renderPage() {
        const container = document.getElementById('page-content-area');
        // Tetap gunakan konten yang sudah ada (tidak diubah)
        document.getElementById('current-page').innerText = currentPageIndex + 1;
        document.getElementById('total-pages').innerText = totalPages;
    }

    function nextPage() {
        if (currentPageIndex < totalPages - 1) {
            currentPageIndex++;
            renderPage();
            document.querySelector('.reader-view').scrollTop = 0;
        } else {
            alert('Halaman terakhir.');
        }
    }

    function prevPage() {
        if (currentPageIndex > 0) {
            currentPageIndex--;
            renderPage();
            document.querySelector('.reader-view').scrollTop = 0;
        } else {
            alert('Halaman pertama.');
        }
    }

    function handleSearch(event) {
        if (event.key === "Enter") {
            performSearch();
        }
    }

    function performSearch() {
        const keyword = document.getElementById('pdf-search-input').value.toLowerCase();
        if (!keyword) {
            renderPage();
            return;
        }
        const contentArea = document.getElementById('page-content-area');
        const originalHTML = contentArea.innerHTML;
        const regex = new RegExp(`(${keyword})`, 'gi');
        const newHTML = originalHTML.replace(regex, '<mark>$1</mark>');
        contentArea.innerHTML = newHTML;
        if (!newHTML.includes('<mark>')) {
            alert('Kata tidak ditemukan.');
        }
    }

    function openReader() {
        document.getElementById('pdf-reader').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        renderPage();
    }

    function closeReader() {
        document.getElementById('pdf-reader').style.display = 'none';
        document.body.style.overflow = 'auto';
        // Reset highlight
        const contentArea = document.getElementById('page-content-area');
        if (contentArea.dataset.original) {
            contentArea.innerHTML = contentArea.dataset.original;
        } else {
            contentArea.dataset.original = contentArea.innerHTML;
        }
        document.getElementById('pdf-search-input').value = '';
    }

    // Simpan original konten
    window.addEventListener('load', function() {
        const area = document.getElementById('page-content-area');
        if (area) area.dataset.original = area.innerHTML;
    });
</script>
@endpush
