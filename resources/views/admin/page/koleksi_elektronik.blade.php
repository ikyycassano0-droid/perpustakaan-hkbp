@extends('admin.component.main')

@section('title', 'Koleksi Elektronik - Neptix Admin')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Koleksi Elektronik</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola eBook, e-Article, CD, Video, dan koleksi digital lainnya</p>
        </div>
        <button type="button" id="btnTambah" class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus text-xs"></i> Tambah Data
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- TABLE DATA -->
    <div class="card-modern overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-800 to-slate-700 rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-laptop text-white/70"></i>
                <h3 class="font-semibold text-white">Daftar Koleksi Elektronik</h3>
            </div>
            <p class="text-slate-300 text-xs mt-0.5">Total: {{ $data->count() }} koleksi</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal Upload</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jenis Koleksi</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <!-- JUDUL -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center">
                                    <i class="fas {{ $item->category->slug == 'ebook' ? 'fa-book' : ($item->category->slug == 'video' ? 'fa-video' : 'fa-file') }} text-indigo-500 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $item->title }}</div>
                                    @if($item->abstract)
                                        <div class="text-slate-400 text-[11px] mt-0.5 max-w-md truncate">{{ Str::limit($item->abstract, 60) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- TANGGAL UPLOAD -->
                        <td class="px-6 py-4 text-center text-sm text-slate-600">
                            {{ $item->created_at->format('d M Y') }}
                        </td>

                        <!-- JENIS KOLEKSI -->
                        <td class="px-6 py-4 text-center">
                            @php
                                $slug = $item->category->slug ?? '';
                                switch($slug){
                                    case 'ebook': $badge = 'bg-sky-100 text-sky-700'; $icon = 'fa-book'; break;
                                    case 'e-article': $badge = 'bg-emerald-100 text-emerald-700'; $icon = 'fa-file-alt'; break;
                                    case 'cd': $badge = 'bg-amber-100 text-amber-700'; $icon = 'fa-compact-disc'; break;
                                    case 'video': $badge = 'bg-purple-100 text-purple-700'; $icon = 'fa-video'; break;
                                    default: $badge = 'bg-slate-100 text-slate-600'; $icon = 'fa-file';
                                }
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                <i class="fas {{ $icon }} text-[10px]"></i>
                                {{ ucfirst($item->category->name ?? '-') }}
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit Button -->
                                <button type="button" class="btn-edit w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                        data-id="{{ $item->id }}"
                                        data-title="{{ $item->title }}"
                                        data-abstract="{{ $item->abstract }}"
                                        data-category="{{ $item->category_final_project_id }}"
                                        data-file="{{ $item->file_url }}"
                                        data-file-ext="{{ pathinfo($item->file_url, PATHINFO_EXTENSION) }}"
                                        title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.koleksi_elektronik.delete', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus koleksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition flex items-center justify-center" title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================================= --}}
{{-- MODAL TAMBAH KOLEKSI --}}
{{-- ========================================= --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-2xl">
            <form action="{{ route('admin.koleksi_elektronik.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-b border-slate-100 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-plus-circle text-indigo-500"></i>
                        <h5 class="font-semibold text-slate-800 text-lg">Tambah Koleksi Elektronik</h5>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Judul <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" placeholder="Judul koleksi" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Abstract / Ringkasan</label>
                        <textarea name="abstract" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" placeholder="Ringkasan singkat tentang koleksi ini"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Koleksi <span class="text-rose-500">*</span></label>
                        <select name="category_final_project_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" required>
                            <option value="">Pilih Jenis Koleksi</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">File Koleksi <span class="text-rose-500">*</span></label>
                        <input type="file" name="file_url" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100" required>
                        <p class="text-slate-400 text-[11px] mt-1">Format yang didukung: PDF, MP3, MP4, DOCX</p>
                    </div>
                </div>

                <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ========================================= --}}
{{-- MODAL EDIT KOLEKSI (Dynamic with JS) --}}
{{-- ========================================= --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-2xl border-0 shadow-2xl">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header border-b border-slate-100 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-edit text-indigo-500"></i>
                        <h5 class="font-semibold text-slate-800 text-lg">Edit Koleksi Elektronik</h5>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Judul <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="edit_title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Abstract / Ringkasan</label>
                        <textarea name="abstract" id="edit_abstract" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Koleksi <span class="text-rose-500">*</span></label>
                        <select name="category_final_project_id" id="edit_category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" required>
                            <option value="">Pilih Jenis Koleksi</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Preview File -->
                    <div id="previewContainer" class="mt-2 hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Preview File Saat Ini</label>
                        <div id="filePreview" class="bg-slate-100 rounded-xl p-3 text-center"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Ganti File (Opsional)</label>
                        <input type="file" name="file_url" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        <p class="text-slate-400 text-[11px] mt-1">Kosongkan jika tidak ingin mengubah file. Format: PDF, MP3, MP4, DOCX</p>
                    </div>
                </div>

                <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========================================
    // BUKA MODAL TAMBAH - HANYA SAAT TOMBOL DIKLIK
    // ========================================
    $(document).ready(function() {
        // Tombol Tambah - buka modal tambah
        $('#btnTambah').click(function() {
            // Reset form
            $('#modalTambah form')[0].reset();
            // Buka modal
            $('#modalTambah').modal('show');
        });
        
        // ========================================
        // EDIT MODAL - HANYA SAAT TOMBOL EDIT DIKLIK
        // ========================================
        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let abstract = $(this).data('abstract');
            let categoryId = $(this).data('category');
            let fileUrl = $(this).data('file');
            let fileExt = $(this).data('file-ext');

            // Set form action
            let formAction = "{{ route('admin.koleksi_elektronik.update', ':id') }}";
            formAction = formAction.replace(':id', id);
            $('#editForm').attr('action', formAction);

            // Set values
            $('#edit_title').val(title);
            $('#edit_abstract').val(abstract);
            $('#edit_category').val(categoryId);

            // Preview file
            if (fileUrl) {
                let assetUrl = "{{ asset('storage') }}/" + fileUrl;
                let previewHtml = '';

                if (fileExt === 'mp4') {
                    previewHtml = `<video width="100%" controls class="rounded-xl">
                                        <source src="${assetUrl}">
                                        Browser Anda tidak mendukung video.
                                    </video>`;
                } else if (fileExt === 'mp3') {
                    previewHtml = `<audio controls class="w-full">
                                        <source src="${assetUrl}">
                                        Browser Anda tidak mendukung audio.
                                    </audio>`;
                } else if (fileExt === 'pdf') {
                    previewHtml = `<iframe src="${assetUrl}" width="100%" height="250" class="rounded-xl"></iframe>`;
                } else if (fileExt === 'docx' || fileExt === 'doc') {
                    previewHtml = `<a href="${assetUrl}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition">
                                        <i class="fas fa-file-word"></i> Lihat File DOCX
                                    </a>`;
                } else {
                    previewHtml = `<a href="${assetUrl}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition">
                                        <i class="fas fa-download"></i> Lihat File (${fileExt.toUpperCase()})
                                    </a>`;
                }

                $('#filePreview').html(previewHtml);
                $('#previewContainer').removeClass('hidden');
            } else {
                $('#previewContainer').addClass('hidden');
            }

            // Buka modal edit
            $('#modalEdit').modal('show');
        });
    });
</script>

@endsection