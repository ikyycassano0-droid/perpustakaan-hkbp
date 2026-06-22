{{-- resources/views/user/page/kti.blade.php --}}
@extends('user.component.master')

@section('title', 'Repositori KTI - AKPER HKBP')

@push('styles')
    <style>
        /* ============================================================
               RESET & VARIABEL
            ============================================================ */
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
            --success: #2daa6e;
            --danger: #e74c3c;
        }

        /* ============================================================
               MAIN LAYOUT
            ============================================================ */
        .main-container {
            display: flex;
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
            gap: 30px;
            align-items: flex-start;
        }

        /* ============================================================
               SIDEBAR
            ============================================================ */
        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            position: sticky;
            top: 100px;
            z-index: 10;
        }

        .sidebar-title {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .side-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            border-radius: 10px;
            transition: 0.3s;
            margin-bottom: 5px;
            text-decoration: none;
        }

        .side-menu li a:hover,
        .side-menu li a.active {
            background-color: #f0f7f3;
            color: var(--primary-color);
        }

        .side-menu li a.active {
            background-color: #e0f0e8;
            border-left: 4px solid var(--primary-color);
        }

        /* ============================================================
               CONTENT SECTION
            ============================================================ */
        .content-section {
            flex-grow: 1;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header span {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            background: #e0f0e8;
            padding: 4px 12px;
            border-radius: 50px;
            display: inline-block;
        }

        .page-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--text-dark);
            margin-top: 10px;
            font-weight: 800;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* ============================================================
               FILTER ROW
            ============================================================ */
        .filter-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .filter-item {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            transition: 0.3s;
        }

        .filter-item:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
        }

        .filter-item i {
            color: var(--text-muted);
            margin-right: 10px;
            font-size: 0.9rem;
        }

        .filter-item input,
        .filter-item select {
            border: none;
            outline: none;
            padding: 12px 0;
            width: 100%;
            font-size: 0.9rem;
            color: var(--text-dark);
            background: transparent;
        }

        /* ============================================================
               STATS BANNER
            ============================================================ */
        .stats-banner {
            background: #e0f0e8;
            border-radius: 20px;
            padding: 30px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 30px 0;
            border: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 20px;
        }

        .stat-item {
            text-align: center;
            flex: 1;
            min-width: 100px;
            border-right: 1px solid var(--border-color);
            padding: 0 20px;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-item h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .stat-item p {
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-unggah {
            background: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            flex-shrink: 0;
        }

        .btn-unggah:hover {
            background: var(--accent-green);
            transform: translateY(-2px);
            color: white;
        }

        /* ============================================================
               KTI CARD
            ============================================================ */
        .kti-card {
            background: var(--card-bg);
            border-radius: 16px;
            margin-bottom: 16px;
            padding: 20px 24px;
            box-shadow: 0 4px 12px rgba(15, 74, 49, 0.06);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
            transition: 0.3s;
        }

        .kti-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(15, 74, 49, 0.1);
            border-color: var(--accent-green);
        }

        .kti-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .kti-id {
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--text-muted);
            background: #f0f5f2;
            padding: 4px 12px;
            border-radius: 30px;
        }

        .kti-status {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 30px;
        }

        .kti-status-approved {
            background: rgba(45, 170, 110, 0.12);
            color: var(--accent-green);
        }

        .kti-status-pending {
            background: rgba(241, 196, 15, 0.15);
            color: #b8860b;
        }

        .kti-status-rejected {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
        }

        .kti-judul {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 14px;
            line-height: 1.4;
        }

        .kti-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
            margin-bottom: 16px;
            font-size: 0.85rem;
        }

        .detail-item {
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
        }

        .detail-label {
            font-weight: 700;
            color: var(--text-dark);
            min-width: 95px;
        }

        .detail-label i {
            color: var(--primary-color);
            width: 18px;
            margin-right: 6px;
        }

        .detail-value {
            color: var(--text-muted);
        }

        .kti-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
            font-size: 0.75rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        .kti-tanggal {
            color: var(--text-muted);
        }

        .kti-aksi {
            display: flex;
            gap: 16px;
        }

        .kti-aksi a {
            color: var(--primary-color);
            font-weight: 700;
            transition: 0.2s;
            text-decoration: none;
        }

        .kti-aksi a:hover {
            color: var(--accent-green);
        }

        /* ============================================================
               PAGINATION
            ============================================================ */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .page-box {
            width: 35px;
            height: 35px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .page-box.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-box:hover:not(.active) {
            background: #f0f7f3;
            border-color: var(--accent-green);
            color: var(--primary-color);
        }

        .page-box.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ============================================================
               MODAL UPLOAD
            ============================================================ */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 3000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--card-bg);
            max-width: 700px;
            width: 90%;
            border-radius: 28px;
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: fadeSlideUp 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border-top: 5px solid var(--accent-yellow);
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 24px 32px 16px;
            background: white;
            border-bottom: 2px solid rgba(26, 107, 71, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-header h3 i {
            color: var(--accent-yellow);
            font-size: 1.6rem;
        }

        .close-modal {
            font-size: 2rem;
            cursor: pointer;
            color: #a0aba5;
            transition: 0.2s;
            line-height: 1;
        }

        .close-modal:hover {
            color: var(--danger);
        }

        .modal-body {
            padding: 32px 32px 24px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #e8ecea;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: var(--accent-green);
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-group label i {
            color: var(--primary-color);
            width: 20px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.9rem;
            outline: none;
            transition: 0.2s;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(26, 107, 71, 0.1);
        }

        .upload-area {
            border: 2px dashed var(--primary-color);
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            background: rgba(26, 107, 71, 0.02);
        }

        .upload-area:hover {
            border-color: var(--accent-green);
            background: rgba(45, 170, 110, 0.05);
        }

        .upload-area i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            display: block;
        }

        .upload-area p {
            color: var(--text-muted);
        }

        .glass-card-form {
            background: linear-gradient(135deg, rgba(26, 107, 71, 0.05), rgba(45, 170, 110, 0.02));
            border-radius: 16px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid rgba(26, 107, 71, 0.15);
        }

        .glass-card-form h4 {
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .glass-card-form ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .glass-card-form ul li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            color: var(--text-muted);
            padding: 4px 0;
        }

        .glass-card-form ul li i {
            color: var(--accent-green);
        }

        .modal-footer {
            padding: 16px 32px 32px;
            background: white;
            display: flex;
            justify-content: flex-end;
            gap: 18px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-secondary {
            background: #f1f3f5;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            color: #2c3e35;
        }

        .btn-secondary:hover {
            background: #e3e8e5;
        }

        .btn-submit {
            background: var(--primary-color);
            border: none;
            padding: 12px 34px;
            border-radius: 40px;
            font-weight: 800;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 6px 14px rgba(26, 107, 71, 0.3);
        }

        .btn-submit:hover {
            background: var(--accent-green);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(10, 58, 40, 0.3);
            color: white;
        }

        .info-hint {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* ============================================================
               RESPONSIVE
            ============================================================ */
        @media (max-width: 1024px) {
            .sidebar {
                display: none;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-banner {
                flex-direction: column;
                text-align: center;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                padding: 10px 0;
                width: 100%;
            }

            .stat-item:last-child {
                border-bottom: none;
            }

            .kti-detail {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .kti-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-content {
                width: 95%;
                border-radius: 20px;
            }

            .modal-header {
                padding: 20px;
            }

            .modal-body {
                padding: 20px;
            }

            .modal-footer {
                padding: 16px 20px 20px;
                flex-direction: column;
            }

            .modal-footer .btn-secondary,
            .modal-footer .btn-submit {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .page-header h2 {
                font-size: 1.5rem;
            }

            .kti-card {
                padding: 16px;
            }

            .kti-judul {
                font-size: 1rem;
            }

            .kti-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-container">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <h3 class="sidebar-title">Katalog Digital</h3>
            <ul class="side-menu">
                <li>
                    <a href="{{ route('final_project.koleksi', 'ebook') }}" {{ request()->route('category') == 'ebook' ? 'class=active' : '' }}>
                        <i class="fas fa-book"></i> E-book
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.koleksi', 'e-article') }}" {{ request()->route('category') == 'e-article' ? 'class=active' : '' }}>
                        <i class="fas fa-file-alt"></i> E-Article
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.koleksi', 'cd') }}" {{ request()->route('category') == 'cd' ? 'class=active' : '' }}>
                        <i class="fas fa-compact-disc"></i> CD
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.koleksi', 'video') }}" {{ request()->route('category') == 'video' ? 'class=active' : '' }}>
                        <i class="fas fa-video"></i> Video
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.kti') }}" {{ request()->route('category') == 'kti' ? 'class=active' : '' }}>
                        <i class="fas fa-chart-line"></i> KTI
                    </a>
                </li>
            </ul>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="content-section">
            <div class="page-header">
                <span>Repositori Digital</span>
                <h2>Karya Tulis Ilmiah (KTI)</h2>
                <p>Akses koleksi hasil penelitian mahasiswa keperawatan sebagai referensi tugas akhir Anda.</p>
            </div>

            <!-- ===== FILTER ROW ===== -->
            <div class="filter-row">
                <div class="filter-item">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari judul KTI...">
                </div>
                <div class="filter-item">
                    <select id="filterProgram">
                        <option value="">Semua Program Studi</option>
                        <option value="D3 Keperawatan">D3 Keperawatan</option>
                        <option value="Profesi Ners">Profesi Ners</option>
                    </select>
                </div>
                <div class="filter-item">
                    <select id="filterTahun">
                        <option value="">Tahun Terbaru</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>
                </div>
                <div class="filter-item">
                    <select id="filterTampilkan">
                        <option value="all">Semua KTI</option>
                        <option value="my">KTI Saya</option>
                    </select>
                </div>
            </div>

            <!-- ===== KTI LIST ===== -->
            <div id="ktiList"></div>
            <div id="paginationButtons" class="pagination"></div>

            <!-- ===== STATS BANNER ===== -->
            <div class="stats-banner">
                <div class="stat-item">
                    <h2 id="totalKti">0</h2>
                    <p>Total KTI</p>
                </div>
                <div class="stat-item">
                    <h2 id="totalApproved">0</h2>
                    <p>Disetujui</p>
                </div>
                <div class="stat-item">
                    <h2>100%</h2>
                    <p>Akses Terbuka</p>
                </div>
                <button class="btn-unggah" id="openUploadModalBtn">
                    <i class="fas fa-upload"></i> Unggah Karya Mandiri
                </button>
            </div>
        </main>
    </div>

    <!-- ===== MODAL UPLOAD KTI ===== -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-feather-alt"></i> Unggah Karya Tulis Ilmiah</h3>
                <span class="close-modal" id="closeModalBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form id="uploadKtiForm" action="{{ route('final_project.kti.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="from" value="layanan">

                    <div class="form-group">
                        <label><i class="fas fa-book"></i> Judul Lengkap</label>
                        <input type="text" name="title" placeholder="Masukkan judul KTI sesuai dokumen" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> NPM</label>
                        <input type="text" name="npm" placeholder="Nomor Pokok Mahasiswa" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-graduation-cap"></i> Program Studi</label>
                        <input type="text" name="study_program" placeholder="Contoh: D3 Keperawatan" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-chalkboard-user"></i> Pembimbing 1</label>
                        <select name="first_supervisor_id" required>
                            <option value="">Pilih Pembimbing</option>
                            @foreach ($supervisors as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user-friends"></i> Pembimbing 2 (Opsional)</label>
                        <select name="second_supervisor_id">
                            <option value="">Pilih Pembimbing</option>
                            @foreach ($supervisors as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Abstrak (Bahasa Indonesia)</label>
                        <textarea name="abstract" rows="4" placeholder="Tulis ringkasan penelitian Anda (maks 300 kata)"></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-file-pdf"></i> Unggah File (PDF/DOCX)</label>
                        <div class="upload-area" onclick="document.getElementById('fileKti').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="text-gray-600 mb-1">Klik atau drag & drop file di sini</p>
                            <p class="text-xs text-gray-400">Maksimal 10 MB, format PDF/DOCX</p>
                            <input type="file" id="fileKti" name="file_url" accept=".pdf,.docx" style="display: none;" required>
                        </div>
                        <div id="fileNameDisplay" class="info-hint" style="margin-top: 8px; display: none;">
                            <i class="fas fa-file-alt"></i> <span id="fileNameSpan"></span>
                        </div>
                    </div>

                    <div class="glass-card-form">
                        <h4><i class="fas fa-award"></i> Informasi Penting</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Pastikan file tidak dikunci (no password)</li>
                            <li><i class="fas fa-check-circle"></i> Urutan halaman: Cover, Pengesahan, Abstrak, Isi</li>
                            <li><i class="fas fa-check-circle"></i> Setiap unggahan akan diverifikasi dalam 2x24 jam</li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="closeModalBtn">Batal</button>
                <button type="submit" form="uploadKtiForm" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Unggah KTI
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari server
            var allApprovedKtis = @json($allApprovedKtis ?? []);
            var myKtis = @json($myKtis ?? []);

            var currentFilter = 'all';
            var currentPage = 1;
            var itemsPerPage = 5;
            var searchQuery = '';

            function getStatusBadge(status) {
                if (status === 'Approved') {
                    return '<span class="kti-status kti-status-approved">✅ Disetujui</span>';
                } else if (status === 'Pending') {
                    return '<span class="kti-status kti-status-pending">⏳ Menunggu Persetujuan</span>';
                } else if (status === 'Rejected') {
                    return '<span class="kti-status kti-status-rejected">❌ Ditolak</span>';
                }
                return '<span class="kti-status">' + status + '</span>';
            }

            function getFilteredData() {
                var filtered = currentFilter === 'all' ? [...allApprovedKtis] : [...myKtis];

                if (searchQuery) {
                    filtered = filtered.filter(function(item) {
                        var title = item.title || '';
                        var abstract = item.abstract || '';
                        var studentName = item.student_name || '';
                        return title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                            abstract.toLowerCase().includes(searchQuery.toLowerCase()) ||
                            studentName.toLowerCase().includes(searchQuery.toLowerCase());
                    });
                }

                return filtered;
            }

            function renderPagination(totalPages) {
                var container = document.getElementById('paginationButtons');
                if (!container) return;

                if (totalPages <= 1) {
                    container.innerHTML = '';
                    return;
                }

                var html = '';
                html += '<div class="page-box ' + (currentPage === 1 ? 'disabled' : '') + '" onclick="changePage(' + (currentPage - 1) +
                    ')"><i class="fas fa-chevron-left"></i></div>';

                for (var i = 1; i <= totalPages; i++) {
                    html += '<div class="page-box' + (i === currentPage ? ' active' : '') + '" onclick="changePage(' + i +
                        ')">' + i + '</div>';
                }

                html += '<div class="page-box ' + (currentPage === totalPages ? 'disabled' : '') + '" onclick="changePage(' + (
                    currentPage + 1) + ')"><i class="fas fa-chevron-right"></i></div>';

                container.innerHTML = html;
            }

            window.changePage = function(page) {
                var filtered = getFilteredData();
                var totalPages = Math.ceil(filtered.length / itemsPerPage);

                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    renderKTI();
                }
            };

            function escapeHtml(str) {
                if (!str) return '';
                return String(str).replace(/[&<>]/g, function(m) {
                    if (m === '&') return '&amp;';
                    if (m === '<') return '&lt;';
                    if (m === '>') return '&gt;';
                    return m;
                });
            }

            function renderKTI() {
                var container = document.getElementById('ktiList');
                if (!container) return;

                var filteredData = getFilteredData();
                var totalPages = Math.ceil(filteredData.length / itemsPerPage);
                var startIndex = (currentPage - 1) * itemsPerPage;
                var currentData = filteredData.slice(startIndex, startIndex + itemsPerPage);

                // Update stats
                var uniqueIds = new Set();
                allApprovedKtis.forEach(function(item) {
                    uniqueIds.add(item.id);
                });
                myKtis.forEach(function(item) {
                    uniqueIds.add(item.id);
                });
                document.getElementById('totalKti').textContent = uniqueIds.size;
                document.getElementById('totalApproved').textContent = allApprovedKtis.length;

                container.innerHTML = '';

                if (currentData.length === 0) {
                    container.innerHTML = '<div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">📭 Tidak ada KTI ditemukan</div>';
                    renderPagination(0);
                    return;
                }

                for (var i = 0; i < currentData.length; i++) {
                    var kti = currentData[i];
                    var card = document.createElement('div');
                    card.className = 'kti-card';

                    var downloadUrl = "{{ url('storage') }}/" + (kti.file_url || '');
                    var createdDate = kti.created_at ? new Date(kti.created_at).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    }) : '-';

                    var penulisNpm = '';
                    if (currentFilter === 'all') {
                        penulisNpm =
                            '<div class="detail-item"><span class="detail-label"><i class="fas fa-user"></i> Penulis</span><span class="detail-value">' +
                            escapeHtml(kti.student_name || '-') + '</span></div>' +
                            '<div class="detail-item"><span class="detail-label"><i class="fas fa-id-card"></i> NPM</span><span class="detail-value">' +
                            escapeHtml(kti.npm || '-') + '</span></div>';
                    }

                    var firstSupervisor = kti.first_supervisor ? kti.first_supervisor.name : '-';
                    var secondSupervisor = kti.second_supervisor ? ' & ' + kti.second_supervisor.name : '';

                    card.innerHTML = `
                        <div class="kti-header">
                            <span class="kti-id">#KTI-${kti.id}</span>
                            ${getStatusBadge(kti.status)}
                        </div>
                        <div class="kti-judul">${escapeHtml(kti.title || 'Tanpa Judul')}</div>
                        <div class="kti-detail">
                            ${penulisNpm}
                            <div class="detail-item"><span class="detail-label"><i class="fas fa-graduation-cap"></i> Prodi</span><span class="detail-value">${escapeHtml(kti.study_program || '-')}</span></div>
                            <div class="detail-item"><span class="detail-label"><i class="fas fa-chalkboard-user"></i> Pembimbing</span><span class="detail-value">${escapeHtml(firstSupervisor)}${secondSupervisor}</span></div>
                        </div>
                        <div class="kti-footer">
                            <span class="kti-tanggal"><i class="far fa-calendar-alt"></i> ${createdDate}</span>
                            <div class="kti-aksi">
                                ${kti.file_url && kti.status === 'Approved' ? '<a href="' + downloadUrl + '" target="_blank"><i class="fas fa-download"></i> Download</a>' : ''}
                            </div>
                        </div>
                    `;

                    container.appendChild(card);
                }

                renderPagination(totalPages);
            }

            // Event listeners
            document.getElementById('filterTampilkan').addEventListener('change', function() {
                currentFilter = this.value;
                currentPage = 1;
                renderKTI();
            });

            document.getElementById('searchInput').addEventListener('input', function() {
                searchQuery = this.value;
                currentPage = 1;
                renderKTI();
            });

            document.getElementById('filterProgram').addEventListener('change', function() {
                currentPage = 1;
                renderKTI();
            });

            document.getElementById('filterTahun').addEventListener('change', function() {
                currentPage = 1;
                renderKTI();
            });

            // Modal
            var modal = document.getElementById('uploadModal');
            var openBtn = document.getElementById('openUploadModalBtn');
            var closeBtn = document.getElementById('closeModalBtn');

            if (openBtn) {
                openBtn.onclick = function() {
                    modal.style.display = 'flex';
                };
            }

            if (closeBtn) {
                closeBtn.onclick = function() {
                    modal.style.display = 'none';
                };
            }

            // Close modal when clicking outside
            window.onclick = function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            };

            // File display
            document.getElementById('fileKti').addEventListener('change', function() {
                var name = this.files[0]?.name || '';
                document.getElementById('fileNameSpan').textContent = name;
                document.getElementById('fileNameDisplay').style.display = name ? 'flex' : 'none';
            });

            // Initial render
            renderKTI();
        });
    </script>
@endpush
