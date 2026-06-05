@extends('admin.component.main')

@section('title', 'Koleksi Elektronik - Neptix Admin')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* ========================================
       PENTING: SEMUA MODAL TERSEMBUNYI SAAT LOAD
       ======================================== */
    #modalFormKoleksi, #modalAddClassification, #modalAddCategory {
        display: none !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }

    #modalFormKoleksi.active, #modalAddClassification.active, #modalAddCategory.active {
        display: flex !important;
    }

    .modal-koleksi-content {
        background: white;
        border-radius: 16px;
        max-width: 900px;
        width: 95%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Nonaktifkan scroll body saat modal terbuka */
    body.no-scroll {
        overflow: hidden !important;
    }

    /* ========================================
       STYLE LAINNYA (TIDAK BERUBAH)
       ======================================== */
    .select2-selection__choice__remove {
        color: red !important;
        margin-right: 5px;
    }

    .select2-selection__choice {
        background-color: #e9ecef !important;
        border: 1px solid #ced4da !important;
        border-radius: 20px !important;
        padding: 2px 8px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        border-right: none !important;
    }

    .cover-preview {
        transition: transform 0.2s ease;
    }

    .cover-preview:hover {
        transform: scale(1.05);
    }

    .select2-choice-delete {
        cursor: pointer;
        color: #ef4444;
        margin-left: 5px;
        font-size: 12px;
    }

    .select2-choice-delete:hover {
        color: #dc2626;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none !important;
    }

    .card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
</style>

<div class="max-w-7xl mx-auto">
    {{-- HEADER SECTION --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Koleksi Elektronik</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola eBook, e-Article, CD, Video, dan koleksi digital lainnya</p>
        </div>
        <button type="button" id="btnTambahKoleksi"
            class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus text-xs"></i> Tambah Data
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500"></i>
        <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- TABLE DATA --}}
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
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">ISBN</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tahun</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal Upload</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jenis Koleksi</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Cover</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        {{-- JUDUL --}}
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

                        {{-- ISBN --}}
                        <td class="px-6 py-4 text-center text-sm text-slate-600">
                            {{ $item->isbn ?? '-' }}
                        </td>

                        {{-- TAHUN --}}
                        <td class="px-6 py-4 text-center text-sm text-slate-600">
                            {{ $item->year ?? '-' }}
                        </td>

                        {{-- TANGGAL UPLOAD --}}
                        <td class="px-6 py-4 text-center text-sm text-slate-600">
                            {{ $item->created_at->format('d M Y') }}
                        </td>

                        {{-- JENIS KOLEKSI --}}
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

                        {{-- COVER --}}
                        <td class="px-6 py-4 text-center">
                            @if($item->cover_image)
                                <img src="{{ asset('storage/' . $item->cover_image) }}" alt="Cover" class="w-10 h-14 object-cover rounded-md mx-auto shadow-sm cover-preview">
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Edit Button --}}
                                <button type="button" class="btn-edit-koleksi w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                        data-id="{{ $item->id }}"
                                        data-title="{{ $item->title }}"
                                        data-abstract="{{ $item->abstract }}"
                                        data-isbn="{{ $item->isbn }}"
                                        data-year="{{ $item->year }}"
                                        data-keywords="{{ is_array($item->keywords) ? implode(', ', $item->keywords) : $item->keywords }}"
                                        data-category="{{ $item->category_final_project_id }}"
                                        data-file="{{ $item->file_url }}"
                                        data-file-ext="{{ pathinfo($item->file_url, PATHINFO_EXTENSION) }}"
                                        data-cover="{{ $item->cover_image }}"
                                        data-classifications="{{ $item->classifications->pluck('id')->toJson() }}"
                                        data-categories-many="{{ $item->categoriesMany->pluck('id')->toJson() }}"
                                        title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>

                                {{-- Delete Form --}}
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
{{-- MODAL FORM TAMBAH/EDIT KOLEKSI (CUSTOM) --}}
{{-- ========================================= --}}
<div id="modalFormKoleksi">
    <div class="modal-koleksi-content">
        <form id="formCollection" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="methodField">

            <div class="border-b border-slate-100 px-6 py-4 flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-2">
                    <i class="fas fa-plus-circle text-indigo-500"></i>
                    <h5 id="modalTitle" class="font-semibold text-slate-800 text-lg">Tambah Koleksi Elektronik</h5>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600 transition btn-close-modal-koleksi">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- JUDUL --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Judul <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            placeholder="Judul koleksi" required>
                    </div>

                    {{-- ISBN --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">ISBN</label>
                        <input type="text" name="isbn" id="isbn"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            placeholder="Nomor ISBN (opsional)">
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                        <input type="number" name="year" id="year"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            placeholder="Tahun terbit, contoh: 2024" min="1900" max="2099">
                    </div>

                    {{-- JENIS KOLEKSI --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Koleksi <span class="text-rose-500">*</span></label>
                        <select name="category_final_project_id" id="category_final_project_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            required>
                            <option value="">Pilih Jenis Koleksi</option>
                            @foreach($categories as $cat)
                                @if($cat->slug !== 'kti')
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- KEYWORDS --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Keywords</label>
                        <input type="text" name="keywords" id="keywords"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            placeholder="Pisahkan dengan koma, contoh: AI, Machine Learning, Data">
                        <p class="text-slate-400 text-[11px] mt-1">Pisahkan dengan koma (,)</p>
                    </div>
                </div>

                {{-- ABSTRACT --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Abstract / Ringkasan</label>
                    <textarea name="abstract" id="abstract" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                        placeholder="Ringkasan singkat tentang koleksi ini"></textarea>
                </div>

                {{-- CLASSIFICATION + TOMBOL TAMBAH --}}
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-slate-700">Classification</label>
                        <button type="button" class="btn-add-classification px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                            <i class="fas fa-plus text-[10px]"></i> Tambah Classification
                        </button>
                    </div>
                    <select name="classification_id[]" id="classificationDropdown" class="w-full select2-multi" multiple>
                        @foreach($classifications as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- CATEGORY COLLECTION + TOMBOL TAMBAH --}}
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-slate-700">Kategori Koleksi</label>
                        <button type="button" class="btn-add-category px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                            <i class="fas fa-plus text-[10px]"></i> Tambah Category
                        </button>
                    </div>
                    <select name="category_collection_id[]" id="categoryDropdown" class="w-full select2-multi" multiple>
                        @foreach($categoriesCollection as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- PREVIEW COVER SAAT INI (Untuk Edit) --}}
                <div id="coverPreviewContainer" class="mt-4 hidden">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cover Saat Ini</label>
                    <div class="flex justify-center">
                        <img id="coverPreview" src="" alt="Cover" class="w-24 h-32 object-cover rounded-lg shadow-sm cover-preview">
                    </div>
                </div>

                {{-- PREVIEW FILE SAAT INI (Untuk Edit) --}}
                <div id="previewContainer" class="mt-4 hidden">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Preview File Saat Ini</label>
                    <div id="filePreview" class="bg-slate-100 rounded-xl p-3 text-center"></div>
                </div>

                {{-- FILES --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>
                        <input type="file" name="cover_image"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100"
                            accept="image/*">
                        <p class="text-slate-400 text-[11px] mt-1">Format: JPG, JPEG, PNG, WEBP. Maks 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2" id="labelFile">File Koleksi <span class="text-rose-500">*</span></label>
                        <input type="file" name="file_url" id="file_url"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        <p class="text-slate-400 text-[11px] mt-1">Format: PDF, MP3, MP4, DOCX. Maks 10MB</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 px-6 py-4 flex justify-end gap-3 bg-slate-50">
                <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition btn-close-modal-koleksi">Batal</button>
                <button type="submit" id="btnSubmit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="fas fa-save text-xs"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TAMBAH CLASSIFICATION --}}
<div id="modalAddClassification">
    <div class="modal-koleksi-content" style="max-width: 500px;">
        <div class="border-b border-slate-100 px-6 py-4 flex justify-between items-center bg-slate-50">
            <div class="flex items-center gap-2">
                <i class="fas fa-tag text-indigo-500"></i>
                <h5 class="font-semibold text-slate-800 text-lg">Tambah Classification</h5>
            </div>
            <button type="button" class="text-slate-400 hover:text-slate-600 transition btn-close-modal-koleksi">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Classification</label>
            <input type="text" id="newClassificationName"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700"
                placeholder="Contoh: 000 - Karya Umum">
        </div>
        <div class="border-t border-slate-100 px-6 py-4 flex justify-end gap-3 bg-slate-50">
            <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition btn-close-modal-koleksi">Batal</button>
            <button type="button" id="saveClassificationBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH CATEGORY --}}
<div id="modalAddCategory">
    <div class="modal-koleksi-content" style="max-width: 500px;">
        <div class="border-b border-slate-100 px-6 py-4 flex justify-between items-center bg-slate-50">
            <div class="flex items-center gap-2">
                <i class="fas fa-folder text-indigo-500"></i>
                <h5 class="font-semibold text-slate-800 text-lg">Tambah Category</h5>
            </div>
            <button type="button" class="text-slate-400 hover:text-slate-600 transition btn-close-modal-koleksi">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Category</label>
            <input type="text" id="newCategoryName"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700"
                placeholder="Contoh: Fiksi, Non Fiksi, Pendidikan">
        </div>
        <div class="border-t border-slate-100 px-6 py-4 flex justify-end gap-3 bg-slate-50">
            <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition btn-close-modal-koleksi">Batal</button>
            <button type="button" id="saveCategoryBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // ========================================
    // BASE URL
    // ========================================
    const baseUrl = "{{ route('admin.koleksi_elektronik.store') }}";
    const updateUrl = "{{ route('admin.koleksi_elektronik.update', ':id') }}";

    // ========================================
    // FUNGSI BUKA/TUTUP MODAL
    // ========================================
    function bukaModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.classList.add('no-scroll');
    }

    function tutupModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.classList.remove('no-scroll');
    }

    // Tutup semua modal
    function tutupSemuaModal() {
        document.querySelectorAll('.active[id^="modal"]').forEach(function(el) {
            el.classList.remove('active');
        });
        document.body.classList.remove('no-scroll');
    }

    // ========================================
    // DOKUMEN SIAP
    // ========================================
    $(document).ready(function() {
        // ========================================
        // SELECT2 INIT
        // ========================================
        $('#classificationDropdown').select2({
            placeholder: "Pilih / cari...",
            width: '100%',
            dropdownParent: $('#modalFormKoleksi'),
            closeOnSelect: false,
            allowClear: true,
            templateSelection: function(data) {
                if (!data.id) return data.text;
                return $('<span>' + data.text + ' <i class="fas fa-trash-alt select2-choice-delete" onclick="event.stopPropagation(); deleteClassification(' + data.id + ', \'' + data.text.replace(/'/g, "\\'") + '\')"></i></span>');
            }
        });

        $('#categoryDropdown').select2({
            placeholder: "Pilih / cari...",
            width: '100%',
            dropdownParent: $('#modalFormKoleksi'),
            closeOnSelect: false,
            allowClear: true,
            templateSelection: function(data) {
                if (!data.id) return data.text;
                return $('<span>' + data.text + ' <i class="fas fa-trash-alt select2-choice-delete" onclick="event.stopPropagation(); deleteCategory(' + data.id + ', \'' + data.text.replace(/'/g, "\\'") + '\')"></i></span>');
            }
        });

        // ========================================
        // TAMBAH DATA - BUKA MODAL KOSONG
        // ========================================
        $('#btnTambahKoleksi').click(function() {
            $('#modalTitle').text('Tambah Koleksi Elektronik');
            $('#btnSubmit').html('<i class="fas fa-save text-xs"></i> Simpan');
            $('#formCollection').attr('action', baseUrl);
            $('#methodField').val('');
            $('#formCollection')[0].reset();
            $('#labelFile').html('File Koleksi <span class="text-rose-500">*</span>');
            $('#file_url').prop('required', true);
            $('.select2-multi').val(null).trigger('change');
            $('#coverPreviewContainer').addClass('hidden');
            $('#previewContainer').addClass('hidden');

            bukaModal('modalFormKoleksi');
        });

        // ========================================
        // EDIT DATA - BUKA MODAL DENGAN DATA
        // ========================================
        $(document).on('click', '.btn-edit-koleksi', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let abstract = $(this).data('abstract');
            let isbn = $(this).data('isbn');
            let year = $(this).data('year');
            let keywords = $(this).data('keywords');
            let categoryId = $(this).data('category');
            let fileUrl = $(this).data('file');
            let fileExt = $(this).data('file-ext');
            let coverImage = $(this).data('cover');
            let classifications = $(this).data('classifications');
            let categoriesMany = $(this).data('categories-many');

            $('#modalTitle').text('Edit Koleksi Elektronik');
            $('#btnSubmit').html('<i class="fas fa-save text-xs"></i> Update');
            $('#formCollection').attr('action', updateUrl.replace(':id', id));
            $('#methodField').val('PUT');
            $('#labelFile').html('Ganti File (Opsional)');
            $('#file_url').prop('required', false);

            $('#title').val(title);
            $('#abstract').val(abstract);
            $('#isbn').val(isbn);
            $('#year').val(year);
            $('#keywords').val(keywords);
            $('#category_final_project_id').val(categoryId);

            // Set classifications
            if (classifications && classifications.length > 0) {
                $('#classificationDropdown').val(classifications).trigger('change');
            } else {
                $('#classificationDropdown').val(null).trigger('change');
            }

            // Set categoriesMany
            if (categoriesMany && categoriesMany.length > 0) {
                $('#categoryDropdown').val(categoriesMany).trigger('change');
            } else {
                $('#categoryDropdown').val(null).trigger('change');
            }

            // Preview cover
            if (coverImage) {
                let coverUrl = "{{ asset('storage') }}/" + coverImage;
                $('#coverPreview').attr('src', coverUrl);
                $('#coverPreviewContainer').removeClass('hidden');
            } else {
                $('#coverPreviewContainer').addClass('hidden');
            }

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

            bukaModal('modalFormKoleksi');
        });

        // ========================================
        // TUTUP MODAL
        // ========================================
        $(document).on('click', '.btn-close-modal-koleksi', function() {
            var modalId = $(this).closest('[id^="modal"]').attr('id');
            if (modalId) {
                tutupModal(modalId);
            }
        });

        // Tutup modal jika klik background
        $(document).on('click', '[id^="modal"]', function(e) {
            if (e.target === this) {
                tutupModal(this.id);
            }
        });

        // ========================================
        // TAMBAH CLASSIFICATION (AJAX)
        // ========================================
        $('.btn-add-classification').click(function() {
            $('#newClassificationName').val('');
            bukaModal('modalAddClassification');
        });

        $('#saveClassificationBtn').click(function() {
            let name = $('#newClassificationName').val();

            if (!name) {
                alert('Nama classification harus diisi!');
                return;
            }

            $.ajax({
                url: "{{ route('admin.classification.storeAjax') }}",
                method: "POST",
                data: {
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    let newOption = new Option(res.name, res.id, true, true);
                    $('#classificationDropdown').append(newOption).trigger('change');
                    tutupModal('modalAddClassification');
                    $('#newClassificationName').val('');
                    alert('Classification berhasil ditambahkan!');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal: ' + xhr.responseText);
                }
            });
        });

        // ========================================
        // TAMBAH CATEGORY (AJAX)
        // ========================================
        $('.btn-add-category').click(function() {
            $('#newCategoryName').val('');
            bukaModal('modalAddCategory');
        });

        $('#saveCategoryBtn').click(function() {
            let name = $('#newCategoryName').val();

            if (!name) {
                alert('Nama category harus diisi!');
                return;
            }

            $.ajax({
                url: "{{ route('admin.category.storeAjax') }}",
                method: "POST",
                data: {
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    let newOption = new Option(res.name, res.id, true, true);
                    $('#categoryDropdown').append(newOption).trigger('change');
                    tutupModal('modalAddCategory');
                    $('#newCategoryName').val('');
                    alert('Category berhasil ditambahkan!');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal: ' + xhr.responseText);
                }
            });
        });
    });

    // ========================================
    // FUNGSI DELETE CLASSIFICATION & CATEGORY
    // ========================================
    function deleteClassification(id, name) {
        if (!confirm('Yakin ingin menghapus "' + name + '"?')) return;
        $.ajax({
            url: "{{ url('admin/classification') }}/" + id,
            method: "DELETE",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                $('#classificationDropdown option[value="' + id + '"]').remove();
                $('#classificationDropdown').trigger('change');
            }
        });
    }

    function deleteCategory(id, name) {
        if (!confirm('Yakin ingin menghapus "' + name + '"?')) return;
        $.ajax({
            url: "{{ url('admin/category') }}/" + id,
            method: "DELETE",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                $('#categoryDropdown option[value="' + id + '"]').remove();
                $('#categoryDropdown').trigger('change');
            }
        });
    }
</script>

@endsection
