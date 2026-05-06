@extends('admin.component.main')

@section('title', 'Manajemen Panduan')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">📘 Manajemen Panduan</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola dokumen panduan, kebijakan, dan prosedur perpustakaan</p>
        </div>
        <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition flex items-center gap-2 w-fit">
            <i class="fas fa-plus-circle text-sm"></i>
            <span>Tambah Panduan Baru</span>
        </button>
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

    {{-- Grouped by Category --}}
    @forelse($data as $category => $items)
    <div class="mb-10">
        {{-- Category Header --}}
        <div class="flex items-center gap-3 mb-4">
            <div class="w-1 h-7 bg-indigo-500 rounded-full"></div>
            <h3 class="text-lg font-bold text-slate-800">
                {{ $category }}
            </h3>
            <span class="bg-slate-100 text-slate-500 text-xs px-2 py-0.5 rounded-full">{{ $items->count() }} item</span>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($items as $archive)
            <div class="card-modern p-5 group relative hover:shadow-lg transition-all duration-200">
                {{-- Icon & Title --}}
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500 flex-shrink-0">
                            <i class="{{ $archive->icon ?? 'fas fa-file-alt' }} text-lg"></i>
                        </div>
                        <h4 class="font-bold text-slate-800 truncate">{{ $archive->title }}</h4>
                    </div>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition flex-shrink-0 ml-2">
                        <a href="{{ route('admin.panduan.index', ['edit' => $archive->id]) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 rounded-lg transition">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <button onclick="confirmDelete({{ $archive->id }}, '{{ addslashes($archive->title) }}')" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg transition">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </div>
                </div>
                
                {{-- Description --}}
                @if($archive->description)
                <p class="text-slate-500 text-sm mt-3 line-clamp-2">{{ $archive->description }}</p>
                @endif

                {{-- Files Info --}}
                @if($archive->activeFiles && $archive->activeFiles->count() > 0)
                <div class="mt-3 flex flex-col gap-2">
                    @foreach($archive->activeFiles as $file)
                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-pdf text-red-400 text-sm"></i>
                            <span class="text-xs text-slate-600 truncate max-w-[150px]">{{ $file->file_name }}</span>
                        </div>
                        <a href="{{ $file->file_url_full }}" target="_blank" class="text-indigo-600 hover:text-indigo-700 text-xs">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Footer Meta --}}
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2 text-slate-400">
                        <i class="fas fa-sort-numeric-down-alt text-[10px]"></i>
                        <span>Urutan: {{ $archive->sequence }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span class="text-slate-400">Aktif</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="card-modern p-12 text-center">
        <div class="w-20 h-20 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-folder-open text-3xl text-slate-300"></i>
        </div>
        <h3 class="text-lg font-semibold text-slate-600">Belum ada data panduan</h3>
        <p class="text-slate-400 text-sm mt-1">Klik tombol "Tambah Panduan Baru" untuk mulai membuat panduan.</p>
    </div>
    @endforelse
</div>

{{-- ==================== MODAL CREATE ==================== --}}
<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 sticky top-0 bg-white">
            <h3 class="text-lg font-bold text-slate-800">📝 Tambah Panduan Baru</h3>
            <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="{{ route('admin.panduan.store') }}" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Panduan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="create_category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-white">
                        <option value="">Pilih Kategori</option>
                        <option value="Petunjuk Penggunaan">📖 Petunjuk Penggunaan</option>
                        <option value="Kebijakan">⚖️ Kebijakan</option>
                        <option value="Syarat & Ketentuan">📜 Syarat & Ketentuan</option>
                        <option value="FAQ">❓ FAQ</option>
                        <option value="Lainnya">📌 Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Urutan (Sequence) <span class="text-red-500">*</span></label>
                    <input type="number" name="sequence" required min="1" value="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    <p class="text-xs text-slate-400 mt-1">Semakin kecil angka, semakin atas posisinya dalam kategori.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Icon (Font Awesome)</label>
                    <div class="flex gap-2">
                        <input type="text" name="icon" id="create_icon" placeholder="Akan otomatis terisi" readonly class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500">
                        <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-indigo-500">
                            <i id="create_icon_preview" class="fas fa-question text-lg"></i>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Icon akan otomatis menyesuaikan dengan kategori yang dipilih</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition"></textarea>
                </div>
                
                {{-- Upload File --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Upload File (PDF/DOC)</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-indigo-300 transition cursor-pointer" onclick="document.getElementById('file_input').click()">
                        <input type="file" name="files[]" id="file_input" class="hidden" multiple accept=".pdf,.doc,.docx">
                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 mb-2"></i>
                        <p class="text-sm text-slate-500">Klik atau drag & drop file disini</p>
                        <p class="text-xs text-slate-400 mt-1">Maksimal 10 MB, format PDF atau DOC</p>
                    </div>
                    <div id="file_info" class="hidden mt-2 p-2 bg-slate-50 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-pdf text-red-400"></i>
                            <span id="file_name" class="text-sm text-slate-600"></span>
                            <span id="file_size" class="text-xs text-slate-400"></span>
                        </div>
                        <button type="button" onclick="removeFile()" class="text-red-400 hover:text-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6 pt-3">
                <button type="button" onclick="closeCreateModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition shadow-sm">Simpan Panduan</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL EDIT ==================== --}}
@if($editData)
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 sticky top-0 bg-white">
            <h3 class="text-lg font-bold text-slate-800">✏️ Edit Panduan</h3>
            <a href="{{ route('admin.panduan.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        <form action="{{ route('admin.panduan.update', $editData->id) }}" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Panduan</label>
                    <input type="text" name="title" value="{{ old('title', $editData->title) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select name="category" id="edit_category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-white">
                        <option value="Petunjuk Penggunaan" {{ ($editData->category == 'Petunjuk Penggunaan') ? 'selected' : '' }}>📖 Petunjuk Penggunaan</option>
                        <option value="Kebijakan" {{ ($editData->category == 'Kebijakan') ? 'selected' : '' }}>⚖️ Kebijakan</option>
                        <option value="Syarat & Ketentuan" {{ ($editData->category == 'Syarat & Ketentuan') ? 'selected' : '' }}>📜 Syarat & Ketentuan</option>
                        <option value="FAQ" {{ ($editData->category == 'FAQ') ? 'selected' : '' }}>❓ FAQ</option>
                        <option value="Lainnya" {{ ($editData->category == 'Lainnya') ? 'selected' : '' }}>📌 Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Urutan (Sequence)</label>
                    <input type="number" name="sequence" value="{{ old('sequence', $editData->sequence) }}" min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    <p class="text-xs text-slate-400 mt-1">Semakin kecil angka, semakin atas posisinya dalam kategori.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Icon (Font Awesome)</label>
                    <div class="flex gap-2">
                        <input type="text" name="icon" id="edit_icon" value="{{ old('icon', $editData->icon) }}" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500" readonly>
                        <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-indigo-500">
                            <i id="edit_icon_preview" class="{{ $editData->icon ?? 'fas fa-question' }} text-lg"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">{{ old('description', $editData->description) }}</textarea>
                </div>

                {{-- Existing Files --}}
                @if($editData->activeFiles && $editData->activeFiles->count() > 0)
                <div class="pt-3">
                    <label class="block text-sm font-medium text-slate-700 mb-2">File Terlampir</label>
                    <div class="space-y-2">
                        @foreach($editData->activeFiles as $file)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-file-pdf text-red-400"></i>
                                <div>
                                    <p class="text-sm font-medium text-slate-700">{{ $file->file_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $file->size_label }} • {{ $file->formatted_date }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ $file->file_url_full }}" target="_blank" class="text-indigo-600 hover:text-indigo-700 text-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" onclick="deleteFile({{ $file->id }}, {{ $editData->id }})" class="text-red-400 hover:text-red-600 text-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Upload New File --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tambah File Baru (Opsional)</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-indigo-300 transition cursor-pointer" onclick="document.getElementById('edit_file_input').click()">
                        <input type="file" name="new_files[]" id="edit_file_input" class="hidden" multiple accept=".pdf,.doc,.docx">
                        <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-1"></i>
                        <p class="text-xs text-slate-500">Klik untuk upload file baru</p>
                    </div>
                    <div id="edit_file_info" class="hidden mt-2 p-2 bg-slate-50 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-pdf text-red-400"></i>
                            <span id="edit_file_name" class="text-sm text-slate-600"></span>
                            <span id="edit_file_size" class="text-xs text-slate-400"></span>
                        </div>
                        <button type="button" onclick="removeEditFile()" class="text-red-400 hover:text-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6 pt-3">
                <a href="{{ route('admin.panduan.index') }}" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-center">Batal</a>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition shadow-sm">Update Panduan</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Delete Confirmation Form --}}
<form id="deleteForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>

{{-- Delete File Form --}}
<form id="deleteFileForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Icon mapping berdasarkan kategori
    const iconMap = {
        'Petunjuk Penggunaan': 'fas fa-book-open',
        'Kebijakan': 'fas fa-gavel',
        'Syarat & Ketentuan': 'fas fa-file-contract',
        'FAQ': 'fas fa-question-circle',
        'Lainnya': 'fas fa-ellipsis-h'
    };
    
    // Auto icon for create modal
    document.getElementById('create_category')?.addEventListener('change', function() {
        const category = this.value;
        const icon = iconMap[category] || 'fas fa-file-alt';
        document.getElementById('create_icon').value = icon;
        document.getElementById('create_icon_preview').className = icon + ' text-lg';
    });
    
    // Auto icon for edit modal
    document.getElementById('edit_category')?.addEventListener('change', function() {
        const category = this.value;
        const icon = iconMap[category] || 'fas fa-file-alt';
        document.getElementById('edit_icon').value = icon;
        document.getElementById('edit_icon_preview').className = icon + ' text-lg';
    });
    
    // File upload handling for create modal
    document.getElementById('file_input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileInfo = document.getElementById('file_info');
            const fileName = document.getElementById('file_name');
            const fileSize = document.getElementById('file_size');
            
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            fileInfo.classList.remove('hidden');
        }
    });
    
    function removeFile() {
        document.getElementById('file_input').value = '';
        document.getElementById('file_info').classList.add('hidden');
    }
    
    // File upload handling for edit modal
    document.getElementById('edit_file_input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileInfo = document.getElementById('edit_file_info');
            const fileName = document.getElementById('edit_file_name');
            const fileSize = document.getElementById('edit_file_size');
            
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            fileInfo.classList.remove('hidden');
        }
    });
    
    function removeEditFile() {
        document.getElementById('edit_file_input').value = '';
        document.getElementById('edit_file_info').classList.add('hidden');
    }
    
    // Delete file function
    function deleteFile(fileId) {
        if (confirm('Hapus file ini? Data akan dihapus secara permanen.')) {
            const form = document.getElementById('deleteFileForm');
            form.action = "{{ url('admin/panduan/panduan-file') }}/" + fileId;
            form.submit();
        }
    }
    
    // Create Modal
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
        // Reset form
        document.getElementById('create_category').value = '';
        document.getElementById('create_icon').value = '';
        document.getElementById('create_icon_preview').className = 'fas fa-question text-lg';
        removeFile();
    }
    
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.getElementById('createModal').classList.remove('flex');
        document.body.style.overflow = '';
    }
    
    // Delete Confirmation
    function confirmDelete(id, title) {
        if (confirm(`Hapus panduan "${title}"? Data akan dihapus secara permanen.`)) {
            const form = document.getElementById('deleteForm');
            form.action = "{{ url('admin/panduan') }}/" + id;
            form.submit();
        }
    }
    
    // Close modal on outside click
    window.onclick = function(event) {
        const createModal = document.getElementById('createModal');
        if (event.target === createModal) closeCreateModal();
    }
</script>
@endpush