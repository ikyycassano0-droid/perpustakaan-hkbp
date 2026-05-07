@extends('user.component.master')

@section('title', 'Upload Karya Tulis Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN UPLOAD KTI
    ============================================ */
    
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.3s ease;
    }
    
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }
    
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
    
    .upload-area {
        border: 2px dashed rgba(99, 102, 241, 0.4);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(15, 23, 42, 0.4);
    }
    
    .upload-area.has-error {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }
    
    .upload-area:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 5px;
        display: none;
    }
    
    .error-message.show {
        display: block;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
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
    
    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
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
    
    .section {
        margin-top: 40px;
    }
    
    .kti-card {
        background: rgba(15, 23, 42, 0.8);
        border-radius: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        padding: 1.25rem;
    }
    
    .kti-card:hover {
        transform: translateY(-3px);
        border-color: #6366f1;
    }
    
    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
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
        color: #10b981;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .status-rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
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
                
                <!-- Tampilkan error dari server -->
                @if($errors->any())
                    <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                        <ul class="text-red-300 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Tampilkan success message -->
                @if(session('success'))
                    <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
                        <p class="text-green-300">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" id="uploadForm" action="{{ route('final_project.kti.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">👤 Nama Lengkap</label>
                            <input type="text" name="student_name" value="{{ auth()->user()->name ?? old('student_name') }}" 
                                   class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">📋 NPM</label>
                            <input type="text" name="npm" value="{{ auth()->user()->npm ?? old('npm') }}" 
                                   class="form-input" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">🎓 Program Studi</label>
                            <input type="text" name="study_program" value="{{ auth()->user()->study_program ?? old('study_program') }}" 
                                   class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">📖 Judul Lengkap KTI</label>
                            <input type="text" name="title" value="{{ old('title') }}" 
                                   class="form-input" placeholder="Masukkan judul lengkap sesuai dokumen..." required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">📝 Abstrak (Bahasa Indonesia)</label>
                        <textarea name="abstract" rows="4" class="form-input" placeholder="Tuliskan ringkasan penelitian Anda di sini..." required>{{ old('abstract') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">👨‍🏫 Dosen Pembimbing 1</label>
                            <select name="first_supervisor_id" id="firstSupervisor" class="form-input" required>
                                <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                @isset($supervisors)
                                    @foreach($supervisors as $sup)
                                        <option value="{{ $sup->id }}" {{ old('first_supervisor_id') == $sup->id ? 'selected' : '' }}>
                                            {{ $sup->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div>
                            <label class="form-label">👨‍🏫 Dosen Pembimbing 2 (Opsional)</label>
                            <select name="second_supervisor_id" id="secondSupervisor" class="form-input">
                                <option value="">-- Pilih Dosen Pembimbing 2 --</option>
                                @isset($supervisors)
                                    @foreach($supervisors as $sup)
                                        <option value="{{ $sup->id }}" {{ old('second_supervisor_id') == $sup->id ? 'selected' : '' }}>
                                            {{ $sup->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">📎 Unggah File (PDF/DOCX) <span class="text-red-400">*</span></label>
                        <div id="uploadArea" class="upload-area">
                            <div class="text-3xl mb-2">📄</div>
                            <p class="text-gray-400 mb-1">Klik atau drag & drop file di sini</p>
                            <p class="text-xs text-gray-500">Maksimal 10 MB, format PDF atau DOCX</p>
                            <!-- HAPUS required dari sini -->
                            <input type="file" name="file_url" id="fileInput" accept=".pdf,.docx" class="hidden">
                        </div>
                        <div id="fileError" class="error-message">❌ File wajib diunggah</div>
                        <div id="fileNameDisplay" class="text-sm text-indigo-300 mt-2 hidden"></div>
                    </div>

                    <!-- Status & Panduan -->
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
                                <li>Maksimal ukuran file 10MB</li>
                            </ul>
                            <button type="button" id="downloadTemplateBtn" class="mt-3 text-indigo-400 text-sm hover:text-indigo-300 transition flex items-center gap-1">
                                📥 Unduh Template KTI
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <button type="button" id="cancelBtn" class="btn-secondary">Batal</button>
                        <button type="submit" id="submitBtn" class="btn-primary">Upload KTI</button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- DAFTAR RIWAYAT KTI YANG SUDAH DIUPLOAD -->
    <section class="section max-w-7xl mx-auto px-5 mb-16">
        <div class="glass-card p-6">
            <h2 class="text-2xl font-bold text-indigo-200 mb-6">📋 Riwayat KTI Anda</h2>
            <div id="ktiList" class="min-h-[200px]">
                <div class="text-center py-8">
                    <div class="text-4xl mb-3">⏳</div>
                    <p class="text-gray-400">Memuat data...</p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================
    // UPLOAD FILE HANDLER (Drag & Drop)
    // ==========================
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileError = document.getElementById('fileError');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('uploadForm');

    // Hilangkan error styling awal
    if (uploadArea) uploadArea.classList.remove('has-error');
    if (fileError) fileError.classList.remove('show');

    if (uploadArea && fileInput) {
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
            if (file && (file.type === 'application/pdf' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
                handleFile(file);
                // Set file ke input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                // Hapus error jika ada
                if (fileError) fileError.classList.remove('show');
                if (uploadArea) uploadArea.classList.remove('has-error');
            } else {
                showNotification('Harap unggah file PDF atau DOCX!', 'error');
            }
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                handleFile(file);
                // Hapus error jika ada
                if (fileError) fileError.classList.remove('show');
                if (uploadArea) uploadArea.classList.remove('has-error');
            }
        });
    }

    function handleFile(file) {
        if (file.size > 10 * 1024 * 1024) {
            showNotification('Ukuran file maksimal 10 MB!', 'error');
            fileInput.value = '';
            if (fileNameDisplay) fileNameDisplay.classList.add('hidden');
            return;
        }
        if (fileNameDisplay) {
            fileNameDisplay.textContent = `📄 ${file.name}`;
            fileNameDisplay.classList.remove('hidden');
        }
        showNotification('File berhasil dipilih', 'success');
    }

    // ==========================
    // VALIDATE FORM SEBELUM SUBMIT
    // ==========================
    function validateForm() {
        let isValid = true;
        
        // Validasi file
        if (!fileInput.files || fileInput.files.length === 0) {
            if (fileError) fileError.classList.add('show');
            if (uploadArea) uploadArea.classList.add('has-error');
            showNotification('Harap pilih file KTI terlebih dahulu!', 'error');
            isValid = false;
        } else {
            if (fileError) fileError.classList.remove('show');
            if (uploadArea) uploadArea.classList.remove('has-error');
        }
        
        // Validasi judul
        const title = document.querySelector('[name="title"]');
        if (title && !title.value.trim()) {
            showNotification('Harap isi judul lengkap!', 'error');
            title.focus();
            isValid = false;
        }
        
        // Validasi pembimbing 1
        const firstSupervisor = document.getElementById('firstSupervisor');
        if (firstSupervisor && !firstSupervisor.value) {
            showNotification('Harap pilih Dosen Pembimbing 1!', 'error');
            firstSupervisor.focus();
            isValid = false;
        }
        
        return isValid;
    }

    // ==========================
    // FORM SUBMIT WITH VALIDATION
    // ==========================
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Cegah submit default
            
            if (validateForm()) {
                // Jika valid, submit form
                showNotification('Mengupload data...', 'info');
                this.submit();
            }
        });
    }

    // ==========================
    // VALIDATE SUPERVISOR (Tidak boleh sama)
    // ==========================
    const firstSupervisor = document.getElementById('firstSupervisor');
    const secondSupervisor = document.getElementById('secondSupervisor');

    function validateSupervisor() {
        if (firstSupervisor && secondSupervisor && 
            firstSupervisor.value && secondSupervisor.value && 
            firstSupervisor.value === secondSupervisor.value) {
            showNotification('Pembimbing 1 dan Pembimbing 2 tidak boleh sama!', 'error');
            secondSupervisor.value = '';
        }
    }

    firstSupervisor?.addEventListener('change', validateSupervisor);
    secondSupervisor?.addEventListener('change', validateSupervisor);

    // ==========================
    // CANCEL BUTTON
    // ==========================
    const cancelBtn = document.getElementById('cancelBtn');
    
    if (cancelBtn && form) {
        cancelBtn.addEventListener('click', () => {
            form.reset();
            if (fileNameDisplay) fileNameDisplay.classList.add('hidden');
            if (fileInput) fileInput.value = '';
            if (fileError) fileError.classList.remove('show');
            if (uploadArea) uploadArea.classList.remove('has-error');
            showNotification('Formulir dibersihkan', 'info');
        });
    }

    // ==========================
    // DOWNLOAD TEMPLATE
    // ==========================
    const downloadBtn = document.getElementById('downloadTemplateBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', () => {
            showNotification('Template KTI akan segera diunduh...', 'success');
        });
    }

    // ==========================
    // NOTIFICATION SYSTEM
    // ==========================
    function showNotification(message, type = 'success') {
        const existingNotif = document.querySelector('.notification');
        if (existingNotif) existingNotif.remove();
        
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

    // ==========================
    // TAMPILKAN RIWAYAT KTI USER
    // ==========================
    let ktiData = @json($ktis ?? []);
    let currentUserId = {{ auth()->id() ?? 0 }};

    function getStatusBadge(status) {
        if (status === 'Approved') {
            return '<span class="status-approved">✅ Disetujui</span>';
        } else if (status === 'Pending') {
            return '<span class="status-pending">⏳ Menunggu Persetujuan</span>';
        } else if (status === 'Rejected') {
            return '<span class="status-rejected">❌ Ditolak</span>';
        }
        return '';
    }

    function renderKTIList() {
        const container = document.getElementById('ktiList');
        if (!container) return;

        const myKtis = ktiData.filter(item => parseInt(item.user_id) === currentUserId);
        
        if (myKtis.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <div class="text-4xl mb-3">📭</div>
                    <p class="text-gray-400">Belum ada KTI yang diupload</p>
                    <p class="text-sm text-gray-500 mt-2">Silakan upload KTI Anda melalui form di atas</p>
                </div>
            `;
            return;
        }

        container.innerHTML = "";
        myKtis.forEach(kti => {
            const card = document.createElement('div');
            card.className = 'kti-card';
            
            let downloadUrl = "{{ url('storage') }}/" + kti.file_url;
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <span class="text-xs text-indigo-300">KTI #${kti.id}</span>
                        ${getStatusBadge(kti.status)}
                    </div>
                    <span class="text-xs text-gray-500">${kti.created_at ? new Date(kti.created_at).toLocaleDateString('id-ID') : '-'}</span>
                </div>
                
                <h3 class="font-bold text-white text-lg mb-2">${kti.title || 'Tanpa Judul'}</h3>
                
                <p class="text-gray-400 text-sm mb-3">${(kti.abstract && kti.abstract.length > 150) ? kti.abstract.substring(0, 150) + '...' : (kti.abstract || 'Tidak ada abstrak')}</p>
                
                <div class="flex justify-between items-center mt-3 pt-3 border-t border-white/10">
                    <div>
                        <p class="text-sm text-gray-300">✍️ ${kti.student_name || '-'}</p>
                        <p class="text-xs text-gray-500">NPM: ${kti.npm || '-'} | ${kti.study_program || '-'}</p>
                        ${kti.first_supervisor ? `<p class="text-xs text-gray-500 mt-1">Pembimbing: ${kti.first_supervisor.name}${kti.second_supervisor ? ` & ${kti.second_supervisor.name}` : ''}</p>` : ''}
                    </div>
                    ${kti.file_url ? `<a href="${downloadUrl}" target="_blank" class="text-indigo-400 hover:text-indigo-300 text-sm">📥 Download</a>` : ''}
                </div>
            `;
            
            container.appendChild(card);
        });
    }

    renderKTIList();

    // Stagger animation
    const formElements = document.querySelectorAll('.form-input, .upload-area, .glass-card');
    formElements.forEach((el, idx) => {
        el.style.transitionDelay = `${idx * 0.05}s`;
    });
});

console.log('Halaman Upload KTI siap dengan validasi file required!');
</script>
@endpush