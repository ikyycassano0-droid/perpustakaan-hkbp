@extends('admin.component.main')

@section('title', 'Manajemen KTI')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">📚 Manajemen Karya Tulis Ilmiah</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola, approve, dan reject KTI yang diupload oleh mahasiswa</p>
        </div>
            <div class="flex gap-3 flex-wrap items-center">
            {{-- Filter Status Dropdown --}}
            <select id="statusFilter" class="px-4 py-2 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:border-indigo-300 cursor-pointer" onchange="filterStatus(this.value)">
                <option value="all" {{ !request('status') ? 'selected' : '' }}>📋 Semua Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>✅ Disetujui</option>
                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>❌ Ditolak</option>
            </select>
            
            {{-- Filter Periode --}}
            <a href="?{{ request('status') ? 'status='.request('status').'&' : '' }}period=today" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('period') == 'today' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                📅 Hari Ini
            </a>
            <a href="?{{ request('status') ? 'status='.request('status').'&' : '' }}period=week" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('period') == 'week' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                📅 1 Minggu
            </a>
            <a href="?{{ request('status') ? 'status='.request('status').'&' : '' }}period=month" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('period') == 'month' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                📅 1 Bulan
            </a>
            <button onclick="openCustomDateModal()" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('start') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                📅 Custom
            </button>
            
            {{-- Reset --}}
            @if(request('status') || request('period') || request('start'))
            <a href="{{ route('admin.kti.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium bg-red-100 text-red-600 hover:bg-red-200 transition">
                🔄 Reset Filter
            </a>
            @endif
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500"></i>
        <span class="text-sm">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Total KTI</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $data->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Pending Approval</p>
                    <p class="text-3xl font-bold text-amber-500">{{ $data->where('status', 'Pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Approved</p>
                    <p class="text-3xl font-bold text-emerald-500">{{ $data->where('status', 'Approved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">NPM</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Dosen Pembimbing</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">File</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $index => $kti)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $index + 1 }}
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="font-semibold text-slate-800 truncate">{{ $kti->title }}</p>
                                @if($kti->abstract)
                                <p class="text-xs text-slate-400 mt-1 truncate">{{ Str::limit($kti->abstract, 60) }}</p>
                                @endif
                            </div>
                        
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700">{{ $kti->student_name ?? $kti->user?->name ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $kti->study_program ?? '-' }}</p>
                        
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $kti->npm ?? '-' }}
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700">{{ $kti->firstSupervisor?->name ?? '-' }}</p>
                            @if($kti->secondSupervisor)
                            <p class="text-xs text-slate-400">{{ $kti->secondSupervisor?->name }}</p>
                            @endif
                        
                        <td class="px-6 py-4">
                            @if($kti->status == 'Approved')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Approved
                                </span>
                            @elseif($kti->status == 'Pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Rejected
                                </span>
                            @endif
                        
                        <td class="px-6 py-4">
                            @if($kti->file_url)
                                {{-- 🔥 PERBAIKAN: Gunakan route admin.kti.download --}}
                                <a href="{{ route('admin.kti.download', $kti->id) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 text-sm">
                                    <i class="fas fa-download"></i>
                                    Download
                                </a>
                            @else
                                <span class="text-slate-400 text-sm">Tidak ada file</span>
                            @endif
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                @if($kti->status == 'Pending')
                                    <button onclick="approveKTI({{ $kti->id }}, '{{ addslashes($kti->title) }}')" 
                                            class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-medium transition flex items-center gap-1">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button onclick="rejectKTI({{ $kti->id }}, '{{ addslashes($kti->title) }}')" 
                                            class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition flex items-center gap-1">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                @endif
                                <button onclick="deleteKTI({{ $kti->id }}, '{{ addslashes($kti->title) }}')" 
                                        class="px-3 py-1.5 bg-slate-100 hover:bg-red-100 text-slate-600 hover:text-red-600 rounded-lg text-xs font-medium transition flex items-center gap-1">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                       
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                            <i class="fas fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                            <p>Belum ada data KTI</p>
                        
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ==================== MODAL APPROVE CONFIRMATION ==================== --}}
<div id="approveModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl">
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-check-circle text-emerald-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Approve KTI</h3>
            <p class="text-slate-500 mb-6">Apakah Anda yakin ingin menyetujui KTI <strong id="approveTitle"></strong>?</p>
            <div class="flex gap-3">
                <button onclick="closeApproveModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <form id="approveForm" method="POST" action="">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold transition shadow-sm">Ya, Approve</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ==================== MODAL REJECT CONFIRMATION ==================== --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl">
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Reject KTI</h3>
            <p class="text-slate-500 mb-6">Apakah Anda yakin ingin menolak KTI <strong id="rejectTitle"></strong>? File akan dihapus.</p>
            <div class="flex gap-3">
                <button onclick="closeRejectModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition shadow-sm">Ya, Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ==================== MODAL DELETE CONFIRMATION ==================== --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl">
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-trash-alt text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus KTI</h3>
            <p class="text-slate-500 mb-6">Apakah Anda yakin ingin menghapus KTI <strong id="deleteTitle"></strong>? Data akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition shadow-sm">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="customDateModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Filter Custom Tanggal</h3>
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">Dari Tanggal</label>
            <input type="date" id="startDate" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">Sampai Tanggal</label>
            <input type="date" id="endDate" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <div class="flex gap-2">
            <button onclick="closeCustomDateModal()" class="flex-1 px-4 py-2 border border-slate-300 rounded-lg text-slate-700">Batal</button>
            <button onclick="applyCustomDate()" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg">Terapkan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openCustomDateModal() {
    document.getElementById('customDateModal').classList.remove('hidden');
    document.getElementById('customDateModal').classList.add('flex');
    }

    function closeCustomDateModal() {
        document.getElementById('customDateModal').classList.add('hidden');
        document.getElementById('customDateModal').classList.remove('flex');
    }

    function applyCustomDate() {
        let start = document.getElementById('startDate').value;
        let end = document.getElementById('endDate').value;
        if (start && end) {
            window.location.href = `?start=${start}&end=${end}`;
        }
    }

    function filterStatus(status) {
    let url = new URL(window.location.href);
    if (status === 'all') {
        url.searchParams.delete('status');
    } else {
        url.searchParams.set('status', status);
    }
        window.location.href = url.toString();
    }
    // ============================================
    // APPROVE KTI
    // ============================================
    function approveKTI(id, title) {
        document.getElementById('approveTitle').innerHTML = title;
        const form = document.getElementById('approveForm');
        form.action = "{{ url('admin/kti') }}/" + id + "/approve";
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
        document.getElementById('approveModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    // ============================================
    // REJECT KTI
    // ============================================
    function rejectKTI(id, title) {
        document.getElementById('rejectTitle').innerHTML = title;
        const form = document.getElementById('rejectForm');
        form.action = "{{ url('admin/kti') }}/" + id + "/reject";
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    // ============================================
    // DELETE KTI
    // ============================================
    function deleteKTI(id, title) {
        document.getElementById('deleteTitle').innerHTML = title;
        const form = document.getElementById('deleteForm');
        form.action = "{{ url('admin/kti') }}/" + id;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Close modal on outside click
    window.onclick = function(event) {
        const approveModal = document.getElementById('approveModal');
        const rejectModal = document.getElementById('rejectModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === approveModal) closeApproveModal();
        if (event.target === rejectModal) closeRejectModal();
        if (event.target === deleteModal) closeDeleteModal();
    }
</script>
@endpush



