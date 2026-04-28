@extends('user.component.master')

@section('title', 'Karya Tulis Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KTI
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Filter Select */
    .filter-select {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 12px;
        padding: 10px 16px;
        color: white;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .filter-select:focus {
        outline: none;
        border-color: #6366f1;
    }

    /* KTI Card */
    .kti-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        margin-bottom: 1.25rem;
    }

    .kti-card:hover {
        transform: translateY(-3px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .kti-number {
        font-family: monospace;
        font-size: 0.7rem;
        color: #818cf8;
    }

    /* Stat Card */
    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.6);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    /* Sidebar Menu */
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

    /* Glass card */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.3s ease;
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

    /* Title utama */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }

    /* Search input */
    .search-input {
        width: 100%;
        padding: 12px 20px;
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

    .search-input::placeholder {
        color: #64748b;
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }

    .btn-outline {
        background: transparent;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.8rem;
    }

    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    /* Pagination */
    .pagination-btn {
        padding: 8px 14px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 8px;
        color: #c7d2fe;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination-btn:hover:not(:disabled) {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
        .filter-group {
            flex-direction: column;
        }
    }

     .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #a5b4fc;
            margin-bottom: 0.5rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 14px;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 12px;
            color: white;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
        }

        .btn-file {
            position: relative;
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-file input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-form-container {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border-radius: 26px;
            padding: 1.5rem;
            border: 1px solid rgba(99, 102, 241, 0.3);
            margin-bottom: 2rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar-menu {
                margin-bottom: 20px;
            }
            .filter-group {
                flex-direction: column;
            }
        }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📚 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Karya Tulis Ilmiah Mahasiswa
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses digital koleksi tugas akhir, skripsi, dan penelitian keperawatan sivitas akademika Akper HKBP Balige.
        </p>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Informasi</div>
                            <div class="sidebar-item active">
                                📚 Semua KTI (Approved)
                            </div>
                            <div class="sidebar-item">
                                ⏳ Menunggu Persetujuan Admin
                            </div>
                            <div class="sidebar-item">
                                ❌ Ditolak Admin
                            </div>
                        </div>
                    </div>

                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH (OPTIONAL BACKEND NANTI) -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <input type="text" class="search-input"
                                   placeholder="🔍 Pencarian bisa ditambahkan backend nanti..."
                                   disabled>
                        </div>

                        <!-- KTI LIST -->
                        <div id="ktiList">
                            {{-- OPTIONAL: kalau mau fallback saat JS mati --}}
                            @forelse ($ktis as $kti)
                                <div class="kti-card fade-up">
                                    ...
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="text-5xl mb-3">📭</div>
                                    <p class="text-gray-400">
                                        Belum ada KTI yang disetujui admin
                                    </p>
                                </div>
                            @endforelse
                        </div>

<!-- PAGINATION -->
<div id="paginationButtons" class="flex gap-2 mt-4"></div>

                        <!-- UPLOAD SECTION -->
                        <div class="mt-8 glass-card p-5 rounded-xl text-center">
                            <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">📤</span>
                                    <div>
                                        <h3 class="font-semibold text-indigo-200">
                                            Unggah Karya Mandiri
                                        </h3>
                                        <p class="text-sm text-gray-400">
                                            KTI akan diverifikasi admin sebelum dipublikasikan.
                                        </p>
                                    </div>
                                </div>

                                <a href="#" id="toggleUploadBtn"
                                class="btn-primary px-6 py-2 text-sm">
                                    Unggah Karya →
                                </a>
                            </div>
                        </div>
                        <div id="uploadFormContainer" style="display:none;" class="mt-6 glass-card p-6">

    <h3 class="text-xl font-bold text-indigo-200 mb-4">
        📝 Form Upload KTI
    </h3>

    <form method="POST"
          action="{{ route('final_project.kti.store') }}"
          enctype="multipart/form-data"
          class="space-y-5">
        @csrf

        <input type="hidden" name="student_name" value="{{ auth()->user()->name }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Nama</label>
                <input type="text"
                       value="{{ auth()->user()->name }}"
                       class="form-input"
                       disabled>
            </div>

            <div>
                <label class="form-label">NPM</label>
                <input type="text"
                       name="npm"
                       value="{{ auth()->user()->npm }}"
                       class="form-input"
                       required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Program Studi</label>
                <input type="text"
                       name="study_program"
                       value="{{ auth()->user()->study_program }}"
                       class="form-input"
                       required>
            </div>

            <div>
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-input" required>
            </div>
        </div>

        <div>
            <label class="form-label">Abstract</label>
            <textarea name="abstract" class="form-textarea" required></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <select name="first_supervisor_id" class="form-select" required>
                <option value="">-- Supervisor 1 --</option>
                @foreach($supervisors as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                @endforeach
            </select>

            <select name="second_supervisor_id" class="form-select">
                <option value="">-- Supervisor 2 --</option>
                @foreach($supervisors as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <input type="file"
                   name="file_url"
                   accept=".pdf,.docx"
                   required>
        </div>

        <div class="text-right">
            <button type="submit" class="btn-primary">
                Upload
            </button>
        </div>
    </form>
</div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // ================= TOGGLE FORM =================
    const btn = document.getElementById("toggleUploadBtn");
    const form = document.getElementById("uploadFormContainer");

    if (btn && form) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
                form.scrollIntoView({ behavior: "smooth" });
            } else {
                form.style.display = "none";
            }
        });
    }

    // ================= VALIDASI SUPERVISOR =================
    const sup1 = document.querySelector('[name="first_supervisor_id"]');
    const sup2 = document.querySelector('[name="second_supervisor_id"]');

    function validateSupervisor() {
        if (sup1 && sup2 && sup1.value && sup2.value && sup1.value === sup2.value) {
            alert("Supervisor 1 dan Supervisor 2 tidak boleh sama!");
            sup2.value = "";
        }
    }

    sup1?.addEventListener("change", validateSupervisor);
    sup2?.addEventListener("change", validateSupervisor);

});
// ================= DATA =================
let ktiData = @json($ktis);

let currentPage = 1;
const itemsPerPage = 5;
let currentCategory = 'all';
let currentYear = 'all';
let currentProdi = 'all';
let searchQuery = '';

// ================= RENDER =================
function renderKTI() {
    let filteredData = [...ktiData];

    // 🔍 SEARCH
    if (searchQuery) {
        filteredData = filteredData.filter(item =>
            item.title?.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.author?.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.abstract?.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }

    // 📂 CATEGORY
    if (currentCategory !== 'all') {
        filteredData = filteredData.filter(item =>
            item.category?.slug === currentCategory
        );
    }

    // 📅 YEAR
    if (currentYear !== 'all') {
        filteredData = filteredData.filter(item =>
            item.year?.toString() === currentYear
        );
    }

    // 🎓 PRODI
    if (currentProdi !== 'all') {
        filteredData = filteredData.filter(item =>
            item.program === currentProdi
        );
    }
        // ================= PAGINATION =================
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const currentData = filteredData.slice(startIndex, startIndex + itemsPerPage);

    const container = document.getElementById('ktiList');

    // 🔥 WAJIB ADA DI HTML
    if (!container) return;

    container.innerHTML = '';

    if (currentData.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-400">Belum ada KTI yang disetujui</p>
            </div>
        `;
        return;
    }

    currentData.forEach(kti => {
        const card = document.createElement('div');
        card.className = 'kti-card fade-up';

        card.innerHTML = `
            <div class="p-5">

                <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-indigo-300">
                            ${kti.category?.name ?? 'Kategori'}
                        </span>
                        <span class="kti-number">
                            #KTI-${kti.id}
                        </span>
                    </div>

                    <span class="text-xs text-gray-500">
                        🎓 ${kti.year ?? '-'}
                    </span>
                </div>

                <h3 class="font-semibold text-indigo-200 text-lg mb-2">
                    ${kti.title}
                </h3>

                <p class="text-gray-400 text-sm mb-3">
                    ${kti.abstract?.substring(0, 180) ?? ''}...
                </p>
                                <div class="flex flex-wrap items-center justify-between gap-3">

                    <div>
                        <p class="text-sm text-gray-300">
                            ✍️ ${kti.author ?? '-'}
                        </p>
                        <p class="text-xs text-gray-500">
                            👨‍🏫 ${kti.first_supervisor?.name ?? '-'}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500">
                            📄 ${kti.pages ?? '-'} Halaman
                        </span>

                        <a href="/kti/${kti.id}" 
                           class="btn-primary text-xs py-1 px-3">
                            📖 Baca
                        </a>

                        ${kti.file ? `
                            <a href="/storage/${kti.file}" target="_blank"
                               class="btn-outline text-xs py-1 px-2">
                                ⬇️
                            </a>
                        ` : ''}
                    </div>

                </div>

            </div>
        `;

        container.appendChild(card);
    });

    renderPagination(totalPages);
}
// ================= PAGINATION BUTTON =================
function renderPagination(totalPages) {
    const paginationContainer = document.getElementById('paginationButtons');

    if (!paginationContainer) return;

    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    let html = '';

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    paginationContainer.innerHTML = html;
}

function changePage(page) {
    currentPage = page;
    renderKTI();
}

// ================= SEARCH =================
const searchInput = document.getElementById('searchInput');

if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value;
        currentPage = 1;
        renderKTI();
    });
}

// ================= INIT =================
renderKTI();
</script>
@endpush