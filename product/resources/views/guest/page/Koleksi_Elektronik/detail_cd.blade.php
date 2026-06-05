{{-- resources/views/guest/page/koleksi_elektronik/detail_cd.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA DETAIL CD (KLASIK HIJAU)
    ============================================ */
    .detail-container {
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
        border-top: 4px solid #f1c40f;
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

    .cd-disc-effect {
        position: absolute;
        top: 5px;
        right: -40px;
        width: 210px;
        height: 210px;
        background: repeating-conic-gradient(from 0deg, #2d3e2d 0deg 20deg, #1a2b1a 20deg 40deg);
        border-radius: 50%;
        z-index: 1;
        border: 2px solid #1a2b1a;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
        animation: rotateDisc 10s linear infinite;
    }

    @keyframes rotateDisc {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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
    .status-borrowed {
        background: #fee2e2;
        color: var(--danger);
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
    }

    .btn-play {
        background: var(--primary-color);
        color: white;
    }
    .btn-play:hover {
        background: var(--accent-green);
        transform: translateY(-2px);
    }
    .btn-borrow {
        background: #fff;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }
    .btn-borrow:hover {
        background: #f0f7f3;
        transform: translateY(-2px);
    }

    .cd-info-content {
        background: var(--card-bg);
        padding: 45px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
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
        border-left: 4px solid #f1c40f;
        padding-left: 12px;
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

    /* Media Player Overlay */
    #media-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 2000;
        display: none;
        justify-content: center;
        align-items: center;
    }
    .player-container {
        width: 90%;
        max-width: 900px;
        background: #000;
        border-radius: 15px;
        overflow: hidden;
    }
    .player-header {
        padding: 15px 25px;
        background: #111;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .video-placeholder {
        width: 100%;
        aspect-ratio: 16/9;
        background: #111;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #444;
    }
    .video-placeholder i { font-size: 5rem; margin-bottom: 20px; color: var(--primary-color); }
    .player-controls { padding: 20px; background: #111; }
    .progress-bar { width: 100%; height: 5px; background: #333; border-radius: 10px; margin-bottom: 15px; }
    .progress-fill { width: 35%; height: 100%; background: #f1c40f; border-radius: 10px; }

    @media (max-width: 1024px) {
        .detail-container { grid-template-columns: 1fr; }
        .cd-visual-card { position: static; }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <!-- SIDEBAR KIRI -->
    <aside class="cd-visual-card">
        <div class="cd-cover-wrapper">
            @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
                <img src="{{ asset('storage/' . $item->cover_image) }}" class="cd-image" alt="Cover CD">
            @else
                <img src="https://via.placeholder.com/220x220?text=CD+Cover" class="cd-image" alt="Cover">
            @endif
            <div class="cd-disc-effect"></div>
        </div>

        <div class="status-badge {{ ($item->available_stock ?? 0) > 0 ? 'status-available' : 'status-borrowed' }}">
            <i class="fas {{ ($item->available_stock ?? 0) > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
            {{ ($item->available_stock ?? 0) > 0 ? 'TERSEDIA DI RAK' : 'SEDANG DIPINJAM' }}
        </div>

        @if($item->file_url)
            <button class="btn-action btn-play" onclick="togglePlayer()">
                <i class="fas fa-play-circle"></i> PUTAR PRATINJAU
            </button>
        @endif
        <button class="btn-action btn-borrow" onclick="borrowAlert()">
            <i class="fas fa-bookmark"></i> PINJAM MEDIA INI
        </button>
        <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 10px;">*Peminjaman fisik memerlukan kartu anggota</p>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="cd-info-content">
        <span class="category-tag">{{ $item->category->name ?? 'Multimedia Keperawatan' }}</span>
        <h1 class="cd-title">{{ $item->title }}</h1>

        <div class="cd-meta-top">
            <span><i class="far fa-calendar-alt"></i> Terbit: {{ $item->publication_year ?? date('Y') }}</span>
            <span><i class="far fa-clock"></i> Durasi: {{ $item->duration ?? '45 Menit' }}</span>
            <span><i class="fas fa-star" style="color: #f1c40f;"></i> {{ $item->rating ?? '4.8' }}/5.0</span>
        </div>

        <div class="description-box">
            <div class="section-label">DESKRIPSI KOLEKSI</div>
            <p class="description-text">{{ $item->description ?? $item->abstract ?? 'Tidak ada deskripsi tersedia.' }}</p>
        </div>

        <div class="section-label">INFORMASI TEKNIS</div>
        <div class="specs-grid">
            <div class="spec-item">
                <span class="spec-label">Produksi / Penerbit</span>
                <span class="spec-value">{{ $item->publisher ?? 'Pusdiknakes RI' }}</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Format Media</span>
                <span class="spec-value">{{ $item->format ?? 'DVD-Video / ISO' }}</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Bahasa</span>
                <span class="spec-value">{{ $item->language ?? 'Bahasa Indonesia' }}</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Kualitas Video</span>
                <span class="spec-value">HD 1080p</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Kode Lokasi</span>
                <span class="spec-value">{{ $item->location_code ?? 'RAK-CD-0042' }}</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Kelengkapan</span>
                <span class="spec-value">Box + Panduan Cetak</span>
            </div>
        </div>

        <div class="info-note">
            <h4><i class="fas fa-info-circle"></i> Cara Memutar</h4>
            <p>Anda dapat memutar langsung di laboratorium komputer perpustakaan atau meminjam fisik untuk diputar menggunakan DVD-Player/Laptop.</p>
        </div>
    </main>
</div>

<!-- MEDIA PLAYER OVERLAY (Preview) -->
<div id="media-overlay">
    <div class="player-container">
        <div class="player-header">
            <span id="player-title">Preview: {{ $item->title }}</span>
            <i class="fas fa-times" onclick="togglePlayer()" style="cursor:pointer"></i>
        </div>
        <div class="video-placeholder">
            <i class="fas fa-play-circle"></i>
            <p style="color: #666;">Menyiapkan Aliran Media...</p>
        </div>
        <div class="player-controls">
            <div class="progress-bar"><div class="progress-fill"></div></div>
            <div style="display:flex; justify-content: space-between; color:white; font-size:0.8rem;">
                <div><i class="fas fa-play"></i> &nbsp; <i class="fas fa-volume-up"></i></div>
                <div>02:15 / 05:00</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePlayer() {
        const overlay = document.getElementById('media-overlay');
        if (overlay.style.display === 'flex') {
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        } else {
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function borrowAlert() {
        alert("Permintaan peminjaman telah dikirim ke Pustakawan. Silakan ambil fisik CD di rak yang ditentukan dengan menunjukkan KTM Anda.");
    }
</script>
@endpush
