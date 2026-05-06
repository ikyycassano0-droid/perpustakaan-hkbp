@extends('user.component.master')

@section('title', 'Karya Tulis Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    /* Style minimal untuk test */
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
    
    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
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
    
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
    }
    
    .btn-outline {
        background: transparent;
        padding: 6px 16px;
        border-radius: 30px;
        border: 1px solid rgba(99, 102, 241, 0.5);
        color: #c7d2fe;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
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

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white fade-up">
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

                    <!-- SIDEBAR MENU -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title p-3 font-bold text-indigo-200 border-b border-white/10">📂 Menu KTI</div>
                            
                            <div class="sidebar-item" data-menu="all">
                                🌐 Semua KTI (Disetujui)
                            </div>
                            
                            <div class="sidebar-title p-3 font-bold text-indigo-200 border-b border-white/10 mt-2">📁 KTI Saya</div>
                            
                            <div class="sidebar-item" data-menu="my-approved">
                                ✅ Disetujui
                            </div>
                            
                            <div class="sidebar-item active" data-menu="my-pending">
                                ⏳ Menunggu Persetujuan
                            </div>
                            
                            <div class="sidebar-item" data-menu="my-rejected">
                                ❌ Ditolak
                            </div>
                        </div>
                    </div>

                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH -->
                        <div class="flex flex-wrap gap-4 mb-6">
                            <input type="text" id="searchInput" class="search-input w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white"
                                   placeholder="🔍 Cari judul KTI...">
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
                                <a href="#" id="toggleUploadBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm">
                                    Unggah Karya →
                                </a>
                            </div>
                        </div>

                        <!-- UPLOAD FORM -->
                        <div id="uploadFormContainer" style="display:none;" class="mt-6 glass-card p-6">
                            <h3 class="text-xl font-bold text-indigo-200 mb-4">
                                📝 Form Upload KTI
                            </h3>
                            <form method="POST" action="{{ route('final_project.kti.store') }}" enctype="multipart/form-data" class="space-y-5">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-indigo-300 mb-1">Nama</label>
                                        <input type="text" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" disabled>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-indigo-300 mb-1">NPM</label>
                                        <input type="text" name="npm" value="{{ auth()->user()->npm }}" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-indigo-300 mb-1">Program Studi</label>
                                        <input type="text" name="study_program" value="{{ auth()->user()->study_program }}" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-indigo-300 mb-1">Judul</label>
                                        <input type="text" name="title" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-indigo-300 mb-1">Abstract</label>
                                    <textarea name="abstract" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" rows="4" required></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <select name="first_supervisor_id" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" required>
                                        <option value="">-- Supervisor 1 --</option>
                                        @foreach($supervisors as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                        @endforeach
                                    </select>
                                    <select name="second_supervisor_id" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white">
                                        <option value="">-- Supervisor 2 --</option>
                                        @foreach($supervisors as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-indigo-300 mb-1">File (PDF/DOCX)</label>
                                    <input type="file" name="file_url" accept=".pdf,.docx" class="w-full px-4 py-2 rounded-xl bg-gray-800/50 border border-indigo-500/30 text-white" required>
                                    <p class="text-xs text-gray-400 mt-1">Maksimal 10MB, format PDF atau DOCX</p>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm">
                                        Upload KTI
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
let currentUserId = {{ auth()->id() }};

console.log('=== DEBUG KTI ===');
console.log('Current User ID:', currentUserId);
console.log('Total KTI:', ktiData.length);

let currentMenu = 'my-pending';
let currentPage = 1;
const itemsPerPage = 5;
let searchQuery = '';

function getStatusBadge(status) {
    if (status === 'Approved') {
        return '<span class="status-badge status-approved"><i class="fas fa-check-circle"></i> Disetujui</span>';
    } else if (status === 'Pending') {
        return '<span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Persetujuan</span>';
    } else if (status === 'Rejected') {
        return '<span class="status-badge status-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>';
    }
    return '';
}

function getFilteredData() {
    let filtered = [...ktiData];

    if (currentMenu === 'all') {
        filtered = filtered.filter(item => item.status === 'Approved');
    } else if (currentMenu === 'my-approved') {
        filtered = filtered.filter(item => parseInt(item.user_id) === currentUserId && item.status === 'Approved');
    } else if (currentMenu === 'my-pending') {
        filtered = filtered.filter(item => parseInt(item.user_id) === currentUserId && item.status === 'Pending');
    } else if (currentMenu === 'my-rejected') {
        filtered = filtered.filter(item => parseInt(item.user_id) === currentUserId && item.status === 'Rejected');
    }

    if (searchQuery) {
        filtered = filtered.filter(item =>
            (item.title && item.title.toLowerCase().includes(searchQuery.toLowerCase())) ||
            (item.abstract && item.abstract.toLowerCase().includes(searchQuery.toLowerCase()))
        );
    }

    return filtered;
}

function renderKTI() {
    const container = document.getElementById('ktiList');
    if (!container) {
        console.error('Element #ktiList not found!');
        return;
    }
    
    console.log('Container found, rendering...');
    
    const filteredData = getFilteredData();
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const currentData = filteredData.slice(startIndex, startIndex + itemsPerPage);

    container.innerHTML = '';

    if (currentData.length === 0) {
        let emptyMessage = currentMenu === 'my-pending' ? 'Tidak ada KTI yang menunggu persetujuan' : 'Tidak ada data';
        container.innerHTML = `
            <div class="text-center py-12">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-400">${emptyMessage}</p>
            </div>
        `;
        return;
    }

    currentData.forEach(kti => {
        const card = document.createElement('div');
        card.className = 'kti-card p-5';
        
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
                </div>
                ${kti.file_url ? `<a href="${downloadUrl}" target="_blank" class="text-indigo-400 hover:text-indigo-300 text-sm"><i class="fas fa-download"></i> Download</a>` : ''}
            </div>
        `;
        
        container.appendChild(card);
    });
    
    console.log('Rendered', currentData.length, 'cards');
}

// ================= MENU CLICK =================
document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', function() {
        const menu = this.dataset.menu;
        if (menu) {
            currentMenu = menu;
            currentPage = 1;
            
            document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            renderKTI();
        }
    });
});

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