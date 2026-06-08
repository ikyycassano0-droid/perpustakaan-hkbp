{{-- resources/views/user/page/koleksi_elektronik/detail_kti.blade.php --}}
@extends('user.component.master')

@section('title', $item->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
    <style>
        /* ============================================
           GAYA DETAIL KTI (KLASIK HIJAU)
        ============================================ */
        .main-wrapper {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 50px;
            font-family: 'Poppins', sans-serif;
        }

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
            background: linear-gradient(135deg, var(--deep-green) 0%, var(--primary-color) 100%);
            border-radius: 3px 12px 12px 3px;
            z-index: 10;
            transform-origin: left;
            transition: transform 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
            box-shadow: 10px 10px 25px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 25px;
            text-align: center;
        }

        .cover-border {
            border: 2px solid var(--accent-yellow);
            height: 100%;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cover .logo-kti {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 900;
            margin-bottom: 20px;
        }

        .cover h3 {
            color: white;
            font-size: 0.7rem;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        .cover .title-kti {
            color: var(--accent-yellow);
            font-size: 0.85rem;
            font-weight: 700;
            line-height: 1.6;
            text-transform: uppercase;
        }

        .cover .author-kti {
            color: white;
            margin-top: auto;
            font-size: 0.9rem;
            font-weight: 600;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
            width: 100%;
        }

        .page {
            position: absolute;
            width: 98%;
            height: 96%;
            top: 2%;
            left: 1%;
            background: var(--paper);
            padding: 40px 30px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 5;
            transform: translateZ(-1px);
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

        .kti-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-kti {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.9rem;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
            background: #fafdfb;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-download:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-cite {
            background: #f8fbf9;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .btn-cite:hover {
            background: var(--border-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .detail-box {
            background: var(--card-bg);
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
        }

        .kti-badge {
            background: #e0f0e8;
            color: var(--primary-color);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 15px;
        }

        .title-area h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--primary-color);
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .author-box {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8fbf9;
            border-radius: 15px;
            border: 1px solid var(--border-color);
        }

        .author-img {
            width: 55px;
            height: 55px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .author-info h4 {
            font-size: 1.1rem;
            color: var(--text-dark);
        }

        .author-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 35px;
        }

        .info-card {
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            text-align: center;
            background: white;
        }

        .info-card i {
            color: var(--accent-yellow);
            font-size: 1.2rem;
            margin-bottom: 8px;
            display: block;
        }

        .info-card span {
            font-size: 0.65rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 800;
            display: block;
        }

        .info-card p {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 30px 0 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--accent-yellow);
            padding-left: 12px;
        }

        .data-row {
            display: grid;
            grid-template-columns: 220px 1fr;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .label {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .value {
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .citation-box {
            background: #fafdfb;
            border: 1px dashed var(--accent-yellow);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .citation-box p {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        #download-toast {
            position: fixed;
            top: 100px;
            right: -400px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 3000;
            transition: 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-left: 5px solid var(--accent-green);
        }

        #download-toast.show {
            right: 30px;
        }

        .toast-icon {
            width: 40px;
            height: 40px;
            background: #e0f0e8;
            color: var(--accent-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

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

        .reader-nav {
            background: #222;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reader-nav i {
            cursor: pointer;
            font-size: 1.5rem;
        }

        @media (max-width: 1024px) {
            .main-wrapper {
                grid-template-columns: 1fr;
            }

            .book-wrap {
                position: relative;
                top: 0;
                margin: 0 auto 40px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-wrapper">
        <!-- LEFT: VISUAL KTI -->
        <div class="book-wrap" data-aos="zoom-in">
            <div class="book">
                <div class="spine"></div>
                <div class="cover">
                    <div class="cover-border">
                        <div class="logo-kti"><i class="fas fa-plus-square"></i></div>
                        <h3>KARYA TULIS ILMIAH</h3>
                        <div class="title-kti">{{ Str::limit($item->title, 45) }}</div>
                        <div class="author-kti">{{ $item->student_name ?? $item->user->name ?? 'Penulis' }}<br><small>NIM: {{ $item->npm ?? '-' }}</small></div>
                    </div>
                </div>
                <div class="page">
                    <h2 style="font-family:'Playfair Display'; color:var(--primary-color);">Abstrak</h2>
                    <p style="font-size: 0.8rem; line-height: 1.6;">{{ Str::limit($item->abstract ?? 'Tidak ada abstrak.', 200) }}</p>
                </div>
            </div>

            <div class="kti-actions">
                @if($item->file_url)
                    <button class="btn-kti btn-read" onclick="openReader()">
                        <i class="fas fa-book-open"></i> BACA ABSTRAK & BAB 1
                    </button>
                    <button class="btn-kti btn-download" onclick="handleDownload('{{ $item->file_url }}')">
                        <i class="fas fa-file-pdf"></i> UNDUH FULLTEXT (PDF)
                    </button>
                @else
                    <button class="btn-kti btn-read" disabled style="opacity:0.6; cursor:not-allowed;">
                        <i class="fas fa-ban"></i> FILE TIDAK TERSEDIA
                    </button>
                @endif
                <button class="btn-kti btn-cite" onclick="copyCitation()">
                    <i class="fas fa-quote-right"></i> KUTIP KARYA INI
                </button>
            </div>
        </div>

        <!-- RIGHT: DETAIL KTI -->
        <div class="detail-box" data-aos="fade-left">
            <span class="kti-badge">Karya Tulis Ilmiah ({{ $item->study_program ?? 'D3 Keperawatan' }})</span>
            <div class="title-area">
                <h1>{{ $item->title }}</h1>
            </div>

            <div class="author-box">
                <div class="author-img"><i class="fas fa-user-graduate"></i></div>
                <div class="author-info">
                    <h4>{{ $item->student_name ?? $item->user->name ?? 'Penulis tidak diketahui' }}</h4>
                    <p>{{ $item->study_program ?? 'Program Studi Keperawatan' }} • Angkatan {{ $item->created_at ? $item->created_at->format('Y') : '-' }}</p>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-card"><span>Tahun Lulus</span><p>{{ $item->publication_year ?? $item->created_at->format('Y') ?? '2024' }}</p></div>
                <div class="info-card"><span>Halaman</span><p>{{ $item->pages ?? '-' }} Hal.</p></div>
                <div class="info-card"><span>Bahasa</span><p>{{ $item->language ?? 'Indonesia' }}</p></div>
            </div>

            <div class="section-title">Informasi Akademik</div>
            <div class="data-list">
                <div class="data-row"><div class="label">NPM (Nomor Induk)</div><div class="value">{{ $item->npm ?? '-' }}</div></div>
                <div class="data-row"><div class="label">Dosen Pembimbing I</div><div class="value">{{ $item->firstSupervisor->name ?? '-' }}</div></div>
                <div class="data-row"><div class="label">Dosen Pembimbing II</div><div class="value">{{ $item->secondSupervisor->name ?? '-' }}</div></div>
                <div class="data-row"><div class="label">Metode Penelitian</div><div class="value">{{ $item->research_method ?? 'Deskriptif Korelatif (Kuantitatif)' }}</div></div>
                <div class="data-row"><div class="label">Lokasi Penelitian</div><div class="value">{{ $item->research_location ?? 'Wilayah Kerja Puskesmas Balige' }}</div></div>
            </div>

            <div class="section-title">Metadata & Subjek</div>
            <div class="data-list">
                <div class="data-row"><div class="label">Kata Kunci</div><div class="value">{{ is_array($item->keywords) ? implode(', ', $item->keywords) : ($item->keywords ?? '-') }}</div></div>
                <div class="data-row"><div class="label">Klasifikasi</div><div class="value">{{ $item->classification ?? '610.736 (Nursing Care)' }}</div></div>
                <div class="data-row"><div class="label">Jenis Dokumen</div><div class="value">Karya Tulis Ilmiah (KTI) Digital</div></div>
                <div class="data-row"><div class="label">Penerbit Digital</div><div class="value">Repositori AKPER HKBP Tarutung</div></div>
            </div>

            <div class="section-title">Cara Mengutip (APA Style)</div>
            <div class="citation-box">
                <p id="citation-text">
                    {{ $item->student_name ?? 'Penulis' }}. ({{ $item->publication_year ?? $item->created_at->format('Y') ?? '2024' }}).
                    {{ $item->title }} [Karya Tulis Ilmiah, Sekolah Keperawatan HKBP].
                    Repositori Digital AKPER HKBP.
                </p>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI UNDUH -->
    <div id="download-toast">
        <div class="toast-icon"><i class="fas fa-check-circle"></i></div>
        <div class="toast-text">
            <h5>Berhasil!</h5>
            <p>File KTI sedang diunduh ke perangkat Anda.</p>
        </div>
    </div>

    <!-- READER OVERLAY (PREVIEW) -->
    <div id="reader-overlay">
        <div class="reader-nav">
            <span>PREVIEW: {{ Str::slug($item->title, '_') }}.pdf</span>
            <i class="fas fa-times" onclick="closeReader()"></i>
        </div>
        <div style="flex:1; display:flex; justify-content:center; padding: 40px; overflow-y: auto;">
            <div style="width:100%; max-width:800px; background:white; padding:60px; color:#333; font-family:'serif';">
                <h2 style="text-align:center;">ABSTRAK</h2><br>
                <p>{{ $item->abstract ?? 'Tidak ada abstrak.' }}</p>
                @if($item->abstract)
                    <hr style="margin:20px 0;">
                    <p style="font-size:0.8rem;"><strong>Catatan:</strong> Preview hanya menampilkan abstrak. Untuk membaca full teks, silakan unduh file PDF.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        AOS.init({ duration: 1000, once: true });

        function handleDownload(fileUrl) {
            if (fileUrl) {
                const toast = document.getElementById('download-toast');
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 4000);
                window.location.href = "{{ asset('storage/') }}/" + fileUrl;
            } else {
                alert("File tidak tersedia untuk diunduh.");
            }
        }

        function openReader() {
            document.getElementById('reader-overlay').classList.add('reader-active');
            document.body.style.overflow = 'hidden';
        }

        function closeReader() {
            document.getElementById('reader-overlay').classList.remove('reader-active');
            document.body.style.overflow = 'auto';
        }

        function copyCitation() {
            const text = document.getElementById('citation-text').innerText;
            navigator.clipboard.writeText(text);
            alert("Sitasi berhasil disalin ke clipboard!");
        }
    </script>
@endpush
