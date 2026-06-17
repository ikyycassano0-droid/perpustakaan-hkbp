@extends('admin.component.main')

@section('title', 'Manajemen Koleksi - Neptix Admin')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* ========================================
       PENTING: SEMUA MODAL TERSEMBUNYI SAAT LOAD
       ======================================== */
    #modalFormKoleksi,
    #modalAddClassification,
    #modalAddCategory,
    #modalAddLocation {
        display: none !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }

    #modalFormKoleksi.active,
    #modalAddClassification.active,
    #modalAddCategory.active,
    #modalAddLocation.active {
        display: flex !important;
    }

    .modal-koleksi-content {
        background: white;
        border-radius: 16px;
        max-width: 900px;
        width: 95%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none !important;
    }

    .select2-selection__choice {
        position: relative !important;
        padding-right: 25px !important;
    }

    .select2-choice-delete {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #ef4444;
        font-size: 12px;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .select2-choice-delete:hover {
        opacity: 1;
    }

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

    .card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="max-w-7xl mx-auto">
    {{-- HEADER SECTION --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Koleksi</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola buku, jurnal, majalah, dan koleksi lainnya</p>
        </div>
        <button type="button" id="btnTambahKoleksi"
            class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus text-xs"></i> Tambah Koleksi
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500"></i>
        <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 mb-4 bg-rose-50 border border-rose-200 rounded-xl">
        <ul class="text-rose-700 text-sm">
            @foreach ($errors->all() as $error)
            <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- TABLE DATA --}}
    <div class="card-modern overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-800 to-slate-700 rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-book text-white/70"></i>
                <h3 class="font-semibold text-white">Daftar Koleksi</h3>
            </div>
            <p class="text-slate-300 text-xs mt-0.5">Total: {{ $collections->count() }} koleksi</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-20">Cover</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Penulis</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menu</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Stok</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collections as $i => $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $i+1 }}</td>
                        <td class="px-4 py-3 text-center">
                            <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : 'https://via.placeholder.com/60x80?text=No+Cover' }}"
                                class="w-12 h-16 object-cover rounded-lg shadow-sm cover-preview" alt="Cover">
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800 text-sm">{{ $item->title }}</div>
                            <div class="text-slate-400 text-[10px] mt-0.5">{{ $item->publisher }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ is_array($item->author) ? implode(', ', $item->author) : ($item->author ?? '-') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                @if($item->menu_type == 'jurnal') bg-purple-100 text-purple-700
                                @elseif($item->menu_type == 'buku_pengayaan') bg-emerald-100 text-emerald-700
                                @elseif($item->menu_type == 'buku_referensi') bg-blue-100 text-blue-700
                                @elseif($item->menu_type == 'majalah') bg-amber-100 text-amber-700
                                @else bg-slate-100 text-slate-600
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $item->menu_type)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center justify-center min-w-[40px] px-2 py-1 rounded-lg text-xs font-semibold
                                {{ $item->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $item->stock }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($item->active)
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                <i class="fas fa-check-circle text-[10px] mr-1"></i> Aktif
                            </span>
                            @else
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                <i class="fas fa-circle text-[8px] mr-1"></i> Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" class="btn-edit-koleksi w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->title }}"
                                    data-isbn="{{ $item->isbn }}"
                                    data-author="{{ implode(',', $item->author ?? []) }}"
                                    data-stock="{{ $item->stock }}"
                                    data-menu="{{ $item->menu_type }}"
                                    title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <form action="{{ route('admin.collections.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus koleksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition flex items-center justify-center" title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-book text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada koleksi</p>
                                <button type="button" id="btnTambahEmpty" class="mt-2 px-4 py-2 text-sm text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                                    <i class="fas fa-plus mr-1"></i> Tambah koleksi pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
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
        <form id="formCollection" method="POST" enctype="multipart/form-data" action="{{ route('admin.collections.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodField">

            <div class="border-b border-slate-100 px-6 py-4 flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-2">
                    <i class="fas fa-book-open text-indigo-500"></i>
                    <h5 id="modalTitle" class="font-semibold text-slate-800 text-lg">Tambah Koleksi</h5>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600 transition btn-close-modal-koleksi">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body p-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Menu <span class="text-rose-500">*</span></label>
                        <select name="menu_type" id="menu_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" required>
                            <option value="jurnal">Jurnal</option>
                            <option value="buku_pengayaan">Buku Pengayaan</option>
                            <option value="buku_referensi">Buku Referensi</option>
                            <option value="majalah">Majalah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Series Title</label>
                        <input type="text" name="series_title" id="series_title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: 9786028519323">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Publisher</label>
                        <input type="text" name="publisher" id="publisher" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Terbit</label>
                        <input type="number" name="publication_year" id="publication_year" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Language</label>
                        <input type="text" name="language" id="language" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Edition</label>
                        <input type="text" name="edition" id="edition" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Subject</label>
                        <input type="text" name="subject" id="subject" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Carrier Type</label>
                        <input type="text" name="carrier_type" id="carrier_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Format</label>
                        <input type="text" name="format" id="format" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Stock</label>
                        <input type="number" name="stock" id="stock" min="0" step="1"
                            oninput="if (this.value < 0) this.value = 0;"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    </div>
                </div>

                {{-- AUTHOR --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Author</label>
                    <div id="authorWrapper">
                        <div class="flex gap-2 mb-2">
                            <input type="text" name="author[]" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                            <button type="button" class="remove-author w-10 h-10 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition flex items-center justify-center">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="addAuthorBtn" class="mt-1 px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition flex items-center gap-2">
                        <i class="fas fa-plus text-xs"></i> Tambah Author
                    </button>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700"></textarea>
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

                {{-- CATEGORY + TOMBOL TAMBAH --}}
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-slate-700">Category</label>
                        <button type="button" class="btn-add-category px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                            <i class="fas fa-plus text-[10px]"></i> Tambah Category
                        </button>
                    </div>
                    <select name="category_collection_id[]" id="categoryDropdown" class="w-full select2-multi" multiple>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- LOCATION + TOMBOL TAMBAH --}}
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-slate-700">Location</label>
                        <button type="button" class="btn-add-location px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                            <i class="fas fa-plus text-[10px]"></i> Tambah Location
                        </button>
                    </div>
                    <select name="location_id" id="locationDropdown" class="w-full select2-single">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($locations as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- COVER IMAGE (FULL WIDTH) --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>
                    <input type="file" name="cover_image" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
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
            <input type="text" id="newClassificationName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: 000 - Karya Umum">
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
            <input type="text" id="newCategoryName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: Fiksi, Non Fiksi, Pendidikan">
        </div>
        <div class="border-t border-slate-100 px-6 py-4 flex justify-end gap-3 bg-slate-50">
            <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition btn-close-modal-koleksi">Batal</button>
            <button type="button" id="saveCategoryBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH LOCATION --}}
<div id="modalAddLocation">
    <div class="modal-koleksi-content" style="max-width: 500px;">
        <div class="border-b border-slate-100 px-6 py-4 flex justify-between items-center bg-slate-50">
            <div class="flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-indigo-500"></i>
                <h5 class="font-semibold text-slate-800 text-lg">Tambah Location</h5>
            </div>
            <button type="button" class="text-slate-400 hover:text-slate-600 transition btn-close-modal-koleksi">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Location</label>
            <input type="text" id="newLocationName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: Rak 1A, Rak Fiksi, Rak Referensi">
        </div>
        <div class="border-t border-slate-100 px-6 py-4 flex justify-end gap-3 bg-slate-50">
            <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition btn-close-modal-koleksi">Batal</button>
            <button type="button" id="saveLocationBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
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
    const baseUrl = "{{ route('admin.collections.store') }}";
    const updateUrl = "{{ route('admin.collections.update', ':id') }}";

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

    // ========================================
    // DOKUMEN SIAP
    // ========================================
    $(document).ready(function() {
        // ========================================
        // SELECT2 INIT
        // ========================================
        $('#classificationDropdown').select2({
            placeholder: "Pilih / cari",
            width: '100%',
            dropdownParent: $('#modalFormKoleksi'),
            closeOnSelect: false,
            allowClear: true,
            templateSelection: function(data) {
                if (!data.id) return data.text;
                return $('<span>' + data.text +
                    ' <i class="fas fa-trash-alt select2-choice-delete" onclick="event.stopPropagation(); deleteClassification(' +
                    data.id + ', \'' + data.text.replace(/'/g, "\\'") + '\')"></i></span>');
            }
        });

        $('#categoryDropdown').select2({
            placeholder: "Pilih / cari",
            width: '100%',
            dropdownParent: $('#modalFormKoleksi'),
            closeOnSelect: false,
            allowClear: true,
            templateSelection: function(data) {
                if (!data.id) return data.text;
                return $('<span>' + data.text +
                    ' <i class="fas fa-trash-alt select2-choice-delete" onclick="event.stopPropagation(); deleteCategory(' +
                    data.id + ', \'' + data.text.replace(/'/g, "\\'") + '\')"></i></span>');
            }
        });

        $('#locationDropdown').select2({
            placeholder: "Pilih lokasi",
            width: '100%',
            dropdownParent: $('#modalFormKoleksi'),
            allowClear: true,
            templateSelection: function(data) {
                if (!data.id) return data.text;
                return $('<span>' + data.text +
                    ' <i class="fas fa-trash-alt select2-choice-delete" onclick="event.stopPropagation(); deleteLocation(' +
                    data.id + ', \'' + data.text.replace(/'/g, "\\'") + '\')"></i></span>');
            }
        });

        // ========================================
        // FUNGSI AUTHOR
        // ========================================
        $('#addAuthorBtn').click(function() {
            $('#authorWrapper').append(`
                <div class="flex gap-2 mb-2">
                    <input type="text" name="author[]" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    <button type="button" class="remove-author w-10 h-10 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition flex items-center justify-center">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
            `);
        });

        $(document).on('click', '.remove-author', function() {
            if ($('#authorWrapper .flex').length > 1) {
                $(this).closest('.flex').remove();
            }
        });

        // ========================================
        // TAMBAH DATA KOLEKSI
        // ========================================
        $('#btnTambahKoleksi, #btnTambahEmpty').click(function() {
            $('#modalTitle').text('Tambah Koleksi');
            $('#btnSubmit').html('<i class="fas fa-save text-xs"></i> Simpan');
            $('#formCollection').attr('action', baseUrl);
            $('#methodField').val('');
            $('#formCollection')[0].reset();
            $('#authorWrapper').html(`
                <div class="flex gap-2 mb-2">
                    <input type="text" name="author[]" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                    <button type="button" class="remove-author w-10 h-10 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition flex items-center justify-center">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
            `);
            $('.select2-multi').val(null).trigger('change');
            $('.select2-single').val(null).trigger('change');
            bukaModal('modalFormKoleksi');
        });

        // ========================================
        // EDIT DATA KOLEKSI
        // ========================================
        $(document).on('click', '.btn-edit-koleksi', function() {
            let id = $(this).data('id');

            $('#modalTitle').text('Edit Koleksi');
            $('#btnSubmit').html('<i class="fas fa-save text-xs"></i> Update');
            $('#formCollection').attr('action', baseUrl + '/' + id);
            $('#methodField').val('PUT');

            $('#title').val($(this).data('title'));
            $('#isbn').val($(this).data('isbn'));
            $('#stock').val($(this).data('stock'));
            $('#menu_type').val($(this).data('menu'));

            let authorVal = $(this).data('author') || '';
            let authors = authorVal.split(',');
            $('#authorWrapper').html('');
            authors.forEach(function(author) {
                if (author.trim()) {
                    $('#authorWrapper').append(`
                        <div class="flex gap-2 mb-2">
                            <input type="text" name="author[]" value="${author.trim()}" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                            <button type="button" class="remove-author w-10 h-10 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition flex items-center justify-center">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    `);
                }
            });

            if ($('#authorWrapper .flex').length === 0) {
                $('#authorWrapper').html(`
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="author[]" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                        <button type="button" class="remove-author w-10 h-10 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition flex items-center justify-center">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                `);
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

        // ========================================
        // TAMBAH LOCATION (AJAX)
        // ========================================
        $('.btn-add-location').click(function() {
            $('#newLocationName').val('');
            bukaModal('modalAddLocation');
        });

        $('#saveLocationBtn').click(function() {
            let name = $('#newLocationName').val();

            if (!name) {
                alert('Nama location harus diisi!');
                return;
            }

            $.ajax({
                url: "{{ route('admin.location.storeAjax') }}",
                method: "POST",
                data: {
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    let newOption = new Option(res.name, res.id, true, true);
                    $('#locationDropdown').append(newOption).trigger('change');
                    tutupModal('modalAddLocation');
                    $('#newLocationName').val('');
                    alert('Location berhasil ditambahkan!');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal: ' + xhr.responseText);
                }
            });
        });
    });

    // ========================================
    // FUNGSI DELETE CLASSIFICATION, CATEGORY, LOCATION
    // ========================================
    function deleteClassification(id, name) {
        if (!confirm('Yakin ingin menghapus classification "' + name + '"?')) return;
        $.ajax({
            url: "{{ url('admin/classification') }}/" + id,
            method: "DELETE",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                $('#classificationDropdown option[value="' + id + '"]').remove();
                $('#classificationDropdown').trigger('change');
                alert('Classification berhasil dihapus!');
            },
            error: function(xhr) {
                alert('Gagal menghapus: ' + xhr.responseText);
            }
        });
    }

    function deleteCategory(id, name) {
        if (!confirm('Yakin ingin menghapus category "' + name + '"?')) return;
        $.ajax({
            url: "{{ url('admin/category') }}/" + id,
            method: "DELETE",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                $('#categoryDropdown option[value="' + id + '"]').remove();
                $('#categoryDropdown').trigger('change');
                alert('Category berhasil dihapus!');
            },
            error: function(xhr) {
                alert('Gagal menghapus: ' + xhr.responseText);
            }
        });
    }

    function deleteLocation(id, name) {
        if (!confirm('Yakin ingin menghapus location "' + name + '"?')) return;
        $.ajax({
            url: "{{ url('admin/location') }}/" + id,
            method: "DELETE",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                $('#locationDropdown option[value="' + id + '"]').remove();
                $('#locationDropdown').trigger('change');
                alert('Location berhasil dihapus!');
            },
            error: function(xhr) {
                alert('Gagal menghapus: ' + xhr.responseText);
            }
        });
    }

    $('#formCollection').on('submit', function(e) {
        var stock = parseInt($('#stock').val(), 10);
        if (isNaN(stock) || stock < 0) {
            alert('Stok tidak boleh negatif!');
            e.preventDefault();
            return false;
        }
    });
</script>

@endsection
