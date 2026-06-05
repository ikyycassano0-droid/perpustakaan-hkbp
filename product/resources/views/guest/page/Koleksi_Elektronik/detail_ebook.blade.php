{{-- resources/views/guest/page/koleksi_elektronik/detail.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA DETAIL KOLEKSI ELEKTRONIK (KLASIK HIJAU)
    ============================================ */
    .detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 40px;
    }

    /* SAMPUL & TOMBOL */
    .cover-section {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        position: sticky;
        top: 100px;
    }
    .cover-img {
        width: 100%;
        max-width: 280px;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        margin-bottom: 25px;
    }
    .ebook-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }
    .btn-ebook {
        padding: 12px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-read {
        background: var(--primary-color);
        color: white;
    }
    .btn-read:hover {
        background: var(--accent-green);
        transform: translateY(-2px);
    }
    .btn-download {
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
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

    /* DETAIL INFORMASI */
    .info-section {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
    }
    .info-section h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 10px;
        font-weight: 800;
    }
    .info-meta {
        color: var(--text-muted);
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }
    .info-meta .author {
        font-weight: 600;
        color: var(--primary-color);
    }
    .info-grid {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 12px 20px;
        margin: 20px 0;
    }
    .info-label {
        font-weight: 700;
        color: var(--text-dark);
    }
    .info-value {
        color: var(--text-muted);
    }
    .abstract {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }
    .abstract h3 {
        font-size: 1.2rem;
        color: var(--primary-color);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .abstract p {
        line-height: 1.7;
        color: var(--text-dark);
    }

    /* STATUS BADGE */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #e0f0e8;
        color: var(--success);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        background: var(--success);
        border-radius: 50%;
        position: relative;
    }
    .pulse-dot::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: var(--success);
        border-radius: 50%;
        animation: pulse-ring 1.5s infinite;
    }
    @keyframes pulse-ring {
        0% { transform: scale(0.33); opacity: 0.8; }
        80%, 100% { transform: scale(2.5); opacity: 0; }
    }

    /* READER OVERLAY (SEDERHANA, TIDAK PAKAI 3D) */
    #reader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #1a1a1a;
        z-index: 2000;
        display: none;
        flex-direction: column;
    }
    .reader-active { display: flex !important; }
    .reader-nav-top {
        background: #222;
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .reader-main {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: #2c2c2c;
    }
    .reader-page {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 8px;
        font-family: 'Georgia', serif;
        line-height: 1.8;
    }
    .reader-dark-mode { background: #121212 !important; }
    .reader-dark-mode .reader-main { background: #121212 !important; }
    .reader-dark-mode .reader-page { background: #1e1e1e; color: #ddd; }
    .reader-dark-mode .reader-page h2 { color: #f1c40f; }
    mark { background: #f1c40f; color: #000; }
    .reader-footer {
        background: #222;
        color: white;
        padding: 15px;
        display: flex;
        justify-content: center;
        gap: 40px;
    }
    .btn-nav-reader {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 25px;
        border-radius: 20px;
        cursor: pointer;
    }

    @media (max-width: 1024px) {
        .detail-container {
            grid-template-columns: 1fr;
        }
        .cover-section {
            position: static;
            max-width: 380px;
            margin: 0 auto;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <!-- KOLOM KIRI: COVER & AKSI -->
    <div class="cover-section">
        @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
            <img src="{{ asset('storage/' . $item->cover_image) }}" class="cover-img" alt="Cover {{ $item->title }}">
        @else
            <img src="{{ asset('assets/img/default-cover.jpg') }}" class="cover-img" alt="Default Cover">
        @endif

        <div class="ebook-actions">
            @if($item->file_url)
                <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-ebook btn-read">
                    <i class="fas fa-book-open"></i> Baca Online
                </a>
                    <a href="{{ route('login') }}" class="btn-ebook btn-download"><i class="fas fa-download"></i> Download (Login Required)</a>
            @else
                <button class="btn-ebook btn-read btn-disabled" disabled>
                    <i class="fas fa-ban"></i> File Tidak Tersedia
                </button>
            @endif
        </div>

        <div class="status-badge" style="margin-top: 20px; justify-content: center;">
            <div class="pulse-dot"></div> Tersedia (Open Access)
        </div>
    </div>

    <!-- KOLOM KANAN: INFORMASI DETAIL -->
    <div class="info-section">
        <h1>{{ $item->title }}</h1>
        <div class="info-meta">
            <i class="fas fa-user-graduate"></i>
            <span class="author">{{ $item->student_name ?? ($item->user->name ?? 'Penulis tidak diketahui') }}</span>
            @if($item->npm) | NPM: {{ $item->npm }} @endif
        </div>

        <div class="info-grid">
            @if($item->category)
                <div class="info-label">Kategori</div>
                <div class="info-value">{{ $item->category->name ?? '-' }}</div>
            @endif
            @if($item->study_program)
                <div class="info-label">Program Studi</div>
                <div class="info-value">{{ $item->study_program }}</div>
            @endif
            @if($item->first_supervisor)
                <div class="info-label">Pembimbing 1</div>
                <div class="info-value">{{ $item->first_supervisor->name }}</div>
            @endif
            @if($item->second_supervisor)
                <div class="info-label">Pembimbing 2</div>
                <div class="info-value">{{ $item->second_supervisor->name }}</div>
            @endif
            @if($item->isbn)
                <div class="info-label">ISBN</div>
                <div class="info-value">{{ $item->isbn }}</div>
            @endif
            @if($item->publisher)
                <div class="info-label">Penerbit</div>
                <div class="info-value">{{ $item->publisher }}</div>
            @endif
            @if($item->publication_year)
                <div class="info-label">Tahun Terbit</div>
                <div class="info-value">{{ $item->publication_year }}</div>
            @endif
            @if($item->edition)
                <div class="info-label">Edisi</div>
                <div class="info-value">{{ $item->edition }}</div>
            @endif
            @if($item->language)
                <div class="info-label">Bahasa</div>
                <div class="info-value">{{ $item->language }}</div>
            @endif
            <div class="info-label">Status Akses</div>
            <div class="info-value">Open Access (dapat diakses publik)</div>
        </div>

        @if($item->abstract)
        <div class="abstract">
            <h3><i class="fas fa-align-left"></i> Abstrak</h3>
            <p>{{ $item->abstract }}</p>
        </div>
        @endif

        @if($item->keywords)
        <div class="abstract" style="margin-top: 10px;">
            <h3><i class="fas fa-tags"></i> Kata Kunci</h3>
            <div class="tags" style="display: flex; gap: 8px; flex-wrap: wrap;">
                @foreach(is_array($item->keywords) ? $item->keywords : explode(',', $item->keywords) as $keyword)
                    <span class="tag">{{ trim($keyword) }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- READER OVERLAY (opsional, untuk preview konten) -->
<div id="reader-overlay">
    <div class="reader-nav-top">
        <div>
            <i class="fas fa-book-open" style="color: #f1c40f;"></i>
            <span style="margin-left: 10px;">E-READER: {{ $item->title }}</span>
        </div>
        <div>
            <i class="fas fa-search" onclick="toggleSearch()" style="cursor: pointer;"></i>
            <i class="fas fa-moon" id="darkmode-btn" onclick="toggleDarkMode()" style="cursor: pointer; margin-left: 20px;"></i>
            <i class="fas fa-times-circle" onclick="closeReader()" style="cursor: pointer; margin-left: 20px; color: #e74c3c;"></i>
        </div>
    </div>
    <div class="reader-main">
        <div class="reader-page" id="reader-text-content">
            <h2>Pratinjau Konten</h2>
            <p>Untuk membaca atau mengunduh dokumen lengkap, silakan gunakan tombol "Baca Online" atau "Unduh PDF" di halaman ini. File akan dibuka di tab baru atau diunduh ke perangkat Anda.</p>
            <p>Fitur pembaca interaktif masih dalam pengembangan. Terima kasih.</p>
        </div>
    </div>
    <div class="reader-footer">
        <button class="btn-nav-reader" onclick="closeReader()">Tutup</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // FUNGSI READER OVERLAY
    function openReader() {
        document.getElementById('reader-overlay').classList.add('reader-active');
        document.body.style.overflow = 'hidden';
    }

    function closeReader() {
        document.getElementById('reader-overlay').classList.remove('reader-active');
        document.body.style.overflow = 'auto';
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
        alert('Fitur pencarian teks akan tersedia pada update berikutnya.');
    }

    // BUKA READER SAAT TOMBOL BACA ONLINE DIKLIK (OVERRIDE)
    document.querySelectorAll('.btn-read').forEach(btn => {
        if (btn.getAttribute('onclick')) {
            btn.removeAttribute('onclick');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url && url !== '#') {
                    window.open(url, '_blank');
                } else {
                    openReader();
                }
            });
        }
    });
</script>
@endpush
