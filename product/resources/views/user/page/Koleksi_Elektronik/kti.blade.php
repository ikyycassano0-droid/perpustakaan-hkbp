@extends('user.component.master')

@section('title', 'Karya Tulis Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }
    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }
    .depth-2 { transform: translateZ(24px); }
    .kti-card {
        background: rgba(15, 23, 42, 0.8);
        border-radius: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    .kti-card:hover {
        transform: translateY(-3px);
        border-color: #6366f1;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    .status-approved {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .status-rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .sidebar-menu {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
    }
    .sidebar-item {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        color: #cbd5e1;
        font-size: 0.85rem;
    }
    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.15);
        color: white;
        padding-left: 24px;
    }
    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        color: #a5b4fc;
        border-left: 3px solid #6366f1;
    }
    .sidebar-title {
        font-weight: 700;
        color: #c7d2fe;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    .btn-upload {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }
    .btn-upload:hover {
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }
    .search-input {
        width: 100%;
        padding: 10px 16px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 40px;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .search-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }
    .neon-border {
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        padding: 2px;
    }
    .neon-inner {
        background: rgba(15, 23, 42, 0.7);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .fade-up {
        opacity: 0;
        transform: translateY(40px);
        transition: 0.9s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }
    .section {
        margin-top: 40px;
    }
    .library-footer {
        position: relative;
        overflow: hidden;
        padding: 3.5rem 3rem 2rem;
        border-radius: 32px;
        background: linear-gradient(145deg, rgba(15, 23, 42, 0.92), rgba(17, 24, 39, 0.96));
        border: 1px solid rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(18px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35);
    }
    .library-footer::before {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        top: -140px;
        right: -100px;
        border-radius: 999px;
        background: rgba(99, 102, 241, 0.08);
        filter: blur(80px);
    }
    .footer-grid {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr;
        gap: 3rem;
    }
    .footer-logo {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(139, 92, 246, 0.15));
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    .footer-desc {
        margin-top: 1rem;
        color: #94a3b8;
        line-height: 1.9;
        font-size: 0.95rem;
        max-width: 340px;
    }
    .footer-title {
        color: white;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1.3rem;
    }
    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }
    .footer-links a {
        color: #94a3b8;
        font-size: 0.92rem;
        transition: all .25s ease;
    }
    .footer-links a:hover {
        color: #c7d2fe;
        transform: translateX(4px);
    }
    .footer-social {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: #cbd5e1;
        backdrop-filter: blur(10px);
        transition: all .3s ease;
    }
    .footer-social:hover {
        transform: translateY(-4px);
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.18), rgba(139, 92, 246, 0.12));
        border-color: rgba(99, 102, 241, 0.28);
        color: white;
        box-shadow: 0 10px 24px rgba(99, 102, 241, 0.18);
    }
    .footer-contact {
        display: flex;
        gap: 12px;
        color: #94a3b8;
        line-height: 1.7;
    }
    .footer-divider {
        height: 1px;
        margin: 2.5rem 0 1.5rem;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
    }
    .footer-bottom {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        color: #64748b;
        font-size: 0.85rem;
    }
    .footer-bottom-links {
        display: flex;
        gap: 1.5rem;
    }
    .footer-bottom-links a {
        transition: .25s ease;
    }
    .footer-bottom-links a:hover {
        color: #c7d2fe;
    }
    @media (max-width: 992px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    @media (max-width: 640px) {
        .library-footer {
            padding: 2rem;
            border-radius: 24px;
        }
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
        .footer-bottom {
            flex-direction: column;
            align-items: flex-start;
        }
        .footer-bottom-links {
            flex-wrap: wrap;
            gap: 1rem;
        }
    }
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #a5b4fc;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        padding: 10px 14px;
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 12px;
        color: white;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }
    .upload-area {
        border: 2px dashed rgba(99, 102, 241, 0.4);
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-area:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.05);
    }
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 500;
        color: #c7d2fe;
        border: 1px solid rgba(99, 102, 241, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-secondary:hover {
        background: rgba(99, 102, 241, 0.2);
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
            Karya Tulis Ilmiah <br>
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Mahasiswa</span>
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses digital koleksi tugas akhir, skripsi, dan penelitian keperawatan.
        </p>
    </section>

    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR MENU -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Menu KTI</div>
                            <div class="sidebar-item active" data-menu="all">🌐 Semua KTI (Disetujui)</div>
                            <div class="sidebar-title mt-2">📁 KTI Saya</div>
                            <div class="sidebar-item" data-menu="my-approved">✅ Disetujui</div>
                            <div class="sidebar-item" data-menu="my-pending">⏳ Menunggu Persetujuan</div>
                            <div class="sidebar-item" data-menu="my-rejected">❌ Ditolak</div>
                        </div>
                    </div>

                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH -->
                        <div class="mb-6">
                            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul KTI...">
                        </div>

                        <!-- KTI LIST -->
                        <div id="ktiList" class="min-h-[300px]">
                            <div class="text-center py-12">
                                <div class="text-5xl mb-3">⏳</div>
                                <p class="text-gray-400">Memuat data...</p>
                            </div>
                        </div>

                        <!-- PAGINATION -->
                        <div id="paginationButtons" class="flex justify-center gap-2 mt-6"></div>

                        <!-- TOMBOL UPLOAD -->
                        <div class="text-center mt-8">
                            <button onclick="toggleFormUpload()" type="button" class="btn-upload inline-flex items-center gap-2">
                                <span>📤</span> Upload KTI Baru
                            </button>
                        </div>

                        <!-- FORM UPLOAD (SEMBUNYI) -->
                        <div id="formUploadKTI" style="display:none;" class="mt-6">
                            <section class="section max-w-5xl mx-auto px-5">
                                <div class="neon-border fade-up">
                                    <div class="neon-inner">
                                        <form action="{{ route('final_project.kti.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                            @csrf
                                            <input type="hidden" name="from" value="layanan">
                                            
                                            <div>
                                                <label class="form-label">📖 Judul Lengkap Tugas Akhir</label>
                                                <input type="text" name="title" class="form-input" placeholder="Masukkan judul lengkap sesuai dokumen..." required>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="form-label">🆔 NPM</label>
                                                    <input type="text" name="npm" class="form-input" placeholder="Masukkan NPM" required>
                                                </div>
                                                <div>
                                                    <label class="form-label">🎓 Program Studi</label>
                                                    <input type="text" name="study_program" class="form-input" placeholder="Contoh: D3 Keperawatan" required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="form-label">👨‍🏫 Pembimbing 1</label>
                                                    <select name="first_supervisor_id" class="form-input" required>
                                                        <option value="">Pilih Pembimbing</option>
                                                        @foreach($supervisors as $dosen)
                                                            <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="form-label">👨‍🏫 Pembimbing 2 (Opsional)</label>
                                                    <select name="second_supervisor_id" class="form-input">
                                                        <option value="">Pilih Pembimbing</option>
                                                        @foreach($supervisors as $dosen)
                                                            <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="form-label">📝 Abstrak (Bahasa Indonesia)</label>
                                                <textarea name="abstract" rows="4" class="form-input" placeholder="Tuliskan ringkasan penelitian Anda di sini..."></textarea>
                                            </div>

                                            <div>
                                                <label class="form-label">📎 Unggah File (Format PDF/DOCX)</label>
                                                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                                                    <div class="text-3xl mb-2">📄</div>
                                                    <p class="text-gray-400 mb-1">Klik atau drag & drop file di sini</p>
                                                    <p class="text-xs text-gray-500">Maksimal 10 MB</p>
                                                    <input type="file" name="file_url" id="fileInput" accept=".pdf,.docx" class="hidden" required>
                                                </div>
                                                <div id="fileNameDisplay" class="text-sm text-indigo-300 mt-2 hidden"></div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="glass-card p-5 rounded-xl">
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <span class="text-2xl">🏆</span>
                                                        <h3 class="font-semibold text-indigo-200">Status Akreditasi</h3>
                                                    </div>
                                                    <p class="text-sm text-gray-400 mb-3">Setiap karya yang diunggah akan melalui proses verifikasi oleh tim pustakawan dalam 2×24 jam kerja.</p>
                                                    <div class="status-badge">TERAKREDITASI A</div>
                                                </div>
                                                <div class="glass-card p-5 rounded-xl">
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <span class="text-2xl">📚</span>
                                                        <h3 class="font-semibold text-indigo-200">Panduan Penulisan</h3>
                                                    </div>
                                                    <ul class="text-sm text-gray-400 space-y-1 list-disc list-inside">
                                                        <li>Pastikan file PDF/DOCX tidak dikunci (no password)</li>
                                                        <li>Urutan halaman: Cover, Pengesahan, Abstrak, Isi</li>
                                                        <li>Cantumkan tanda tangan asli pada lembar pengesahan</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex justify-end gap-4 pt-4">
                                                <button type="button" onclick="toggleFormUpload()" class="btn-secondary">Batal</button>
                                                <button type="submit" class="btn-primary">📤 Upload KTI</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="px-10 pb-12 pt-6">
        <div class="max-w-9xl mx-auto">
            <div class="library-footer fade-up">
                <div class="footer-grid">
                    <div>
                        <div class="flex items-center gap-4">
                            <div class="footer-logo">📚</div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Perpustakaan Digital</h3>
                                <p class="text-indigo-300 text-sm">AKPER HKBP Balige</p>
                            </div>
                        </div>
                        <p class="footer-desc">Menyediakan akses e-book, jurnal, repository ilmiah, dan literatur digital modern untuk mendukung pembelajaran mahasiswa.</p>
                        <div class="flex items-center gap-3 mt-6">
                            <a href="#" class="footer-social"><i class="fas fa-globe"></i></a>
                            <a href="#" class="footer-social"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="footer-social"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="footer-social"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div>
                        <h4 class="footer-title">Navigasi</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('home') }}">Beranda</a></li>
                            <li><a href="{{ route('guest.profile.tugas-fungsi') }}">E-Book</a></li>
                            <li><a href="#">E-Journal</a></li>
                            <li><a href="#">Repository</a></li>
                            <li><a href="#">Katalog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="footer-title">Layanan</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('user.pinjam') }}">Peminjaman</a></li>
                            <li><a href="{{ route('final_project.upload.kti') }}">Upload KTI</a></li>
                            <li><a href="{{ route('panduan') }}">Literasi Digital</a></li>
                            <li><a href="{{ route('user.profile.struktur') }}">Keanggotaan</a></li>
                            <li><a href="#">Bantuan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="footer-title">Kontak</h4>
                        <div class="space-y-4 text-sm">
                            <div class="footer-contact"><span>📍</span><p>AKPER HKBP Balige, Sumatera Utara</p></div>
                            <div class="footer-contact"><span>📧</span><p>library@akperhkbp.ac.id</p></div>
                            <div class="footer-contact"><span>📞</span><p>+62 812 xxxx xxxx</p></div>
                        </div>
                    </div>
                </div>
                <div class="footer-divider"></div>
                <div class="footer-bottom">
                    <p>© 2026 Perpustakaan Digital AKPER HKBP Balige.</p>
                    <div class="footer-bottom-links">
                        <a href="#">Privacy</a>
                        <a href="#">Terms</a>
                        <a href="#">Support</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
// ================= TOGGLE FORM UPLOAD =================
function toggleFormUpload() {
    var form = document.getElementById('formUploadKTI');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", function() {

    // Disable opsi pembimbing yang sudah dipilih
var select1 = document.querySelector('select[name="first_supervisor_id"]');
var select2 = document.querySelector('select[name="second_supervisor_id"]');

if (select1 && select2) {
    select1.addEventListener('change', function() {
        var val = this.value;
        for (var i = 0; i < select2.options.length; i++) {
            select2.options[i].disabled = (select2.options[i].value === val && val !== '');
        }
    });
    
    select2.addEventListener('change', function() {
        var val = this.value;
        for (var i = 0; i < select1.options.length; i++) {
            select1.options[i].disabled = (select1.options[i].value === val && val !== '');
        }
    });
}
    // Data dari server
    var allApprovedKtis = @json($allApprovedKtis ?? []);
    var myKtis = @json($myKtis ?? []);
    var currentUserId = {{ user_id() ?? 0 }};

    var currentMenu = 'all';
    var currentPage = 1;
    var itemsPerPage = 5;
    var searchQuery = '';

    function getStatusBadge(status) {
        if (status === 'Approved') return '<span class="status-badge status-approved">✅ Disetujui</span>';
        else if (status === 'Pending') return '<span class="status-badge status-pending">⏳ Menunggu Persetujuan</span>';
        else if (status === 'Rejected') return '<span class="status-badge status-rejected">❌ Ditolak</span>';
        return '';
    }

    function getFilteredData() {
        var filtered = [];
        if (currentMenu === 'all') filtered = [...allApprovedKtis];
        else if (currentMenu === 'my-approved') filtered = myKtis.filter(function(item) { return item.status === 'Approved'; });
        else if (currentMenu === 'my-pending') filtered = myKtis.filter(function(item) { return item.status === 'Pending'; });
        else if (currentMenu === 'my-rejected') filtered = myKtis.filter(function(item) { return item.status === 'Rejected'; });

        if (searchQuery) {
            filtered = filtered.filter(function(item) {
                return (item.title && item.title.toLowerCase().includes(searchQuery.toLowerCase())) ||
                       (item.abstract && item.abstract.toLowerCase().includes(searchQuery.toLowerCase())) ||
                       (item.student_name && item.student_name.toLowerCase().includes(searchQuery.toLowerCase()));
            });
        }
        return filtered;
    }

    function renderPagination(totalPages) {
        var container = document.getElementById('paginationButtons');
        if (!container || totalPages <= 1) { if(container) container.innerHTML = ''; return; }
        var html = '<div class="flex gap-2">';
        html += '<button class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 cursor-pointer" onclick="changePage(' + (currentPage - 1) + ')">◀</button>';
        for (var i = 1; i <= totalPages; i++) {
            html += '<button class="px-3 py-1 rounded ' + (i === currentPage ? 'bg-indigo-600' : 'bg-gray-700 hover:bg-gray-600 cursor-pointer') + '" onclick="changePage(' + i + ')">' + i + '</button>';
        }
        html += '<button class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 cursor-pointer" onclick="changePage(' + (currentPage + 1) + ')">▶</button></div>';
        container.innerHTML = html;
    }

    window.changePage = function(page) {
        var filtered = getFilteredData();
        var totalPages = Math.ceil(filtered.length / itemsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            renderKTI();
            window.scrollTo({ top: 400, behavior: 'smooth' });
        }
    };

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m;
        });
    }

    function renderKTI() {
        var container = document.getElementById('ktiList');
        if (!container) return;
        var filteredData = getFilteredData();
        var startIndex = (currentPage - 1) * itemsPerPage;
        var currentData = filteredData.slice(startIndex, startIndex + itemsPerPage);
        container.innerHTML = '';
        if (currentData.length === 0) {
            var msg = currentMenu === 'all' ? 'Belum ada KTI yang disetujui' : (currentMenu === 'my-approved' ? 'Belum ada KTI Anda yang disetujui' : (currentMenu === 'my-pending' ? 'Tidak ada KTI yang menunggu persetujuan' : 'Tidak ada KTI yang ditolak'));
            container.innerHTML = '<div class="text-center py-12"><div class="text-5xl mb-3">📭</div><p class="text-gray-400">' + msg + '</p></div>';
            return;
        }
        for (var i = 0; i < currentData.length; i++) {
            var kti = currentData[i];
            var card = document.createElement('div');
            card.className = 'kti-card p-5';
            var downloadUrl = "{{ url('storage') }}/" + (kti.file_url || '');
            var createdDate = kti.created_at ? new Date(kti.created_at).toLocaleDateString('id-ID') : '-';
            var abstractText = (kti.abstract && kti.abstract.length > 150) ? kti.abstract.substring(0, 150) + '...' : (kti.abstract || 'Tidak ada abstrak');
            var authorInfo = currentMenu === 'all' ? '<p class="text-xs text-indigo-300 mt-1">👤 Penulis: ' + escapeHtml(kti.student_name || '-') + ' | NPM: ' + escapeHtml(kti.npm || '-') + '</p>' : '';
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2 flex-wrap"><span class="text-xs text-indigo-300">KTI #${kti.id}</span>${getStatusBadge(kti.status)}</div>
                    <span class="text-xs text-gray-500">📅 ${createdDate}</span>
                </div>
                <h3 class="font-bold text-white text-lg mb-2">${escapeHtml(kti.title || 'Tanpa Judul')}</h3>
                <p class="text-gray-400 text-sm mb-3">${escapeHtml(abstractText)}</p>${authorInfo}
                <div class="flex justify-between items-center mt-3 pt-3 border-t border-white/10">
                    <div><p class="text-sm text-gray-300">✍️ ${escapeHtml(kti.student_name || '-')}</p>
                    <p class="text-xs text-gray-500">NPM: ${escapeHtml(kti.npm || '-')} | ${escapeHtml(kti.study_program || '-')}</p>
                    <p class="text-xs text-gray-500">👨‍🏫 Pembimbing: ${escapeHtml(kti.first_supervisor ? kti.first_supervisor.name : '-')}${kti.second_supervisor ? ' & ' + escapeHtml(kti.second_supervisor.name) : ''}</p></div>
                    ${kti.file_url && kti.status === 'Approved' ? '<a href="' + downloadUrl + '" target="_blank" class="text-indigo-400 hover:text-indigo-300 text-sm">📥 Download</a>' : ''}
                </div>`;
            container.appendChild(card);
        }
        renderPagination(Math.ceil(filteredData.length / itemsPerPage));
    }

    // Menu click
    document.querySelectorAll('.sidebar-item').forEach(function(item) {
        item.addEventListener('click', function() {
            var menu = this.dataset.menu;
            if (menu) {
                currentMenu = menu; currentPage = 1;
                document.querySelectorAll('.sidebar-item').forEach(function(i) { i.classList.remove('active'); });
                this.classList.add('active');
                renderKTI();
            }
        });
    });

    // Search
    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            searchQuery = e.target.value; currentPage = 1; renderKTI();
        });
    }

    // File input display
    var fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            var fileName = this.files[0]?.name || '';
            var display = document.getElementById('fileNameDisplay');
            if (display) {
                if (fileName) { display.textContent = '📎 ' + fileName; display.classList.remove('hidden'); }
                else { display.classList.add('hidden'); }
            }
        });
    }

    // Init
    renderKTI();

    // Fade animation
    document.querySelectorAll('.fade-up').forEach(function(el, i) {
        setTimeout(function() { el.classList.add('show'); }, 100 * i);
    });
});


</script>
@endpush