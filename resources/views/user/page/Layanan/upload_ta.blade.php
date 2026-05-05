@extends('user.component.master')

@section('title', 'Upload Karya Tulis Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN UPLOAD TA
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card untuk upload */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.3s ease;
    }
    
    /* Title utama */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }
    
    /* Neon border */
    .neon-border {
        position: relative;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        transition: all 0.3s ease;
    }
    
    .neon-border:hover {
        box-shadow: 0 0 30px rgba(99,102,241,0.3);
    }
    
    .neon-inner {
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }
    
    /* Form Input Styles */
    .form-input {
        width: 100%;
        padding: 12px 16px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 12px;
        color: white;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }
    
    .form-input::placeholder {
        color: #64748b;
    }
    
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 6px;
        color: #c7d2fe;
    }
    
    /* Upload Area */
    .upload-area {
        border: 2px dashed rgba(99, 102, 241, 0.4);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(15, 23, 42, 0.4);
    }
    
    .upload-area:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
    }
    
    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 25px rgba(99, 102, 241, 0.5);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
        color: white;
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.02);
    }
    
    /* Notification custom */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.5);
        border-radius: 12px;
        color: white;
        z-index: 1000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    /* Section spacing */
    .section {
        margin-top: 40px;
    }
    
    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📄 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Upload Karya Tulis Ilmiah
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Silakan unggah dokumen akhir Skripsi atau KTI Anda sesuai dengan standar akademik yang telah ditentukan oleh Perpustakaan Akper HKBP Balige.
        </p>
    </section>

    <!-- FORM UPLOAD SECTION -->
    <section class="section max-w-5xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <form id="uploadForm" class="space-y-6">
                    
                    <!-- Judul Lengkap -->
                    <div>
                        <label class="form-label">📖 Judul Lengkap Tugas Akhir</label>
                        <input type="text" id="judul" class="form-input" placeholder="Masukkan judul lengkap sesuai dokumen..." required>
                    </div>

                    <!-- 2 Kolom: Jenis Karya & Tahun Lulus -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">📂 Jenis Karya</label>
                            <select id="jenisKarya" class="form-input">
                                <option value="KTI">Karya Tulis Ilmiah (KTI)</option>
                                <option value="Skripsi">Skripsi</option>
                                <option value="Tesis">Tesis</option>
                                <option value="Laporan Penelitian">Laporan Penelitian</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">📅 Tahun Lulus</label>
                            <select id="tahunLulus" class="form-input">
                                <option>2024</option>
                                <option>2023</option>
                                <option>2022</option>
                                <option>2021</option>
                                <option>2020</option>
                            </select>
                        </div>
                    </div>

                    <!-- Abstrak -->
                    <div>
                        <label class="form-label">📝 Abstrak (Bahasa Indonesia)</label>
                        <textarea id="abstrak" rows="4" class="form-input" placeholder="Tuliskan ringkasan penelitian Anda di sini..."></textarea>
                    </div>

                    <!-- Upload File -->
                    <div>
                        <label class="form-label">📎 Unggah File (Format PDF)</label>
                        <div id="uploadArea" class="upload-area">
                            <div class="text-3xl mb-2">📄</div>
                            <p class="text-gray-400 mb-1">Klik atau drag & drop file PDF di sini</p>
                            <p class="text-xs text-gray-500">Maksimal 10 MB</p>
                            <input type="file" id="fileInput" accept=".pdf" class="hidden">
                        </div>
                        <div id="fileNameDisplay" class="text-sm text-indigo-300 mt-2 hidden"></div>
                    </div>

                    <!-- Status & Panduan dalam 2 Kolom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status Akreditasi -->
                        <div class="glass-card p-5 rounded-xl">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-2xl">🏆</span>
                                <h3 class="font-semibold text-indigo-200">Status Akreditasi</h3>
                            </div>
                            <p class="text-sm text-gray-400 mb-3">Setiap karya yang diunggah akan melalui proses verifikasi oleh tim pustakawan dalam 2×24 jam kerja.</p>
                            <div class="status-badge">TERAKREDITASI A</div>
                        </div>

                        <!-- Panduan Penulisan -->
                        <div class="glass-card p-5 rounded-xl">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-2xl">📚</span>
                                <h3 class="font-semibold text-indigo-200">Panduan Penulisan</h3>
                            </div>
                            <ul class="text-sm text-gray-400 space-y-1 list-disc list-inside">
                                <li>Pastikan file PDF tidak dikunci (no password)</li>
                                <li>Urutan halaman: Cover, Pengesahan, Abstrak, Isi</li>
                                <li>Cantumkan tanda tangan asli pada lembar pengesahan</li>
                            </ul>
                            <button type="button" id="downloadTemplateBtn" class="mt-3 text-indigo-400 text-sm hover:text-indigo-300 transition flex items-center gap-1">
                                📥 Unduh Template KTI
                            </button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-4 pt-4">
                        <button type="button" id="cancelBtn" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">Simpan Data</button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- BANTUAN SECTION -->
    <section class="section max-w-5xl mx-auto px-5 mb-16">
        <div class="glass-card p-6 rounded-2xl fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">💬</span>
                    <div>
                        <h3 class="font-semibold text-indigo-200">Butuh Bantuan?</h3>
                        <p class="text-sm text-gray-400">Hubungi pusat bantuan perpustakaan jika mengalami kendala teknis.</p>
                    </div>
                </div>
                <button id="liveChatBtn" class="btn-primary px-6 py-2 text-sm">
                    Buka Live Chat →
                </button>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN UPLOAD TA
// Hanya JS yang BELUM ADA di master blade
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================
    // UPLOAD FILE HANDLER
    // ==========================
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#6366f1';
        uploadArea.style.background = 'rgba(99, 102, 241, 0.15)';
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.borderColor = 'rgba(99, 102, 241, 0.4)';
        uploadArea.style.background = 'rgba(15, 23, 42, 0.4)';
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = 'rgba(99, 102, 241, 0.4)';
        uploadArea.style.background = 'rgba(15, 23, 42, 0.4)';
        const file = e.dataTransfer.files[0];
        if (file && file.type === 'application/pdf') {
            handleFile(file);
        } else {
            showNotification('Harap unggah file PDF!', 'error');
        }
    });

    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) handleFile(file);
    });

    function handleFile(file) {
        if (file.size > 10 * 1024 * 1024) {
            showNotification('Ukuran file maksimal 10 MB!', 'error');
            return;
        }
        fileNameDisplay.textContent = `📄 ${file.name}`;
        fileNameDisplay.classList.remove('hidden');
        showNotification('File berhasil dipilih', 'success');
    }

    // ==========================
    // FORM SUBMIT
    // ==========================
    const form = document.getElementById('uploadForm');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const judul = document.getElementById('judul').value;
        if (!judul) {
            showNotification('Harap isi judul lengkap!', 'error');
            return;
        }
        showNotification('Data berhasil disimpan! Karya akan segera diverifikasi.', 'success');
        form.reset();
        fileNameDisplay.classList.add('hidden');
    });

    // ==========================
    // CANCEL BUTTON
    // ==========================
    document.getElementById('cancelBtn').addEventListener('click', () => {
        form.reset();
        fileNameDisplay.classList.add('hidden');
        showNotification('Formulir dibersihkan', 'info');
    });

    // ==========================
    // DOWNLOAD TEMPLATE
    // ==========================
    document.getElementById('downloadTemplateBtn').addEventListener('click', () => {
        showNotification('Template KTI akan segera diunduh...', 'success');
    });

    // ==========================
    // LIVE CHAT BUTTON
    // ==========================
    document.getElementById('liveChatBtn').addEventListener('click', () => {
        showNotification('Menghubungkan ke Live Chat...', 'info');
    });

    // ==========================
    // NOTIFICATION SYSTEM (custom untuk halaman ini)
    // ==========================
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Stagger animation untuk form elements
    const formElements = document.querySelectorAll('.form-input, .upload-area, .glass-card');
    formElements.forEach((el, idx) => {
        el.style.transitionDelay = `${idx * 0.05}s`;
    });
});

console.log('Halaman Upload Karya Tulis Ilmiah siap dengan drag & drop file!');
</script>
@endpush