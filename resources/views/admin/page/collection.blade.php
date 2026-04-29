@extends('admin.component.main')

@section('title', 'Manajemen Koleksi - Neptix Admin')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
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
    
    /* Sembunyikan modal saat pertama kali load */
    .modal {
        display: none;
    }
</style>

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Koleksi</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola buku, jurnal, majalah, dan koleksi lainnya</p>
        </div>
        <button type="button" id="btnTambah" class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus text-xs"></i> Tambah Koleksi
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
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $item->author_string }}</td>
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
                                <button type="button" class="btn-edit w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                        data-id="{{ $item->id }}"
                                        data-title="{{ $item->title }}"
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
{{-- MODAL FORM TAMBAH/EDIT KOLEKSI --}}
{{-- ========================================= --}}
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-2xl border-0 shadow-2xl">
            <form id="formCollection" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodField">

                <div class="modal-header border-b border-slate-100 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-book-open text-indigo-500"></i>
                        <h5 id="modalTitle" class="font-semibold text-slate-800 text-lg">Tambah Koleksi</h5>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal" aria-label="Close">
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
                            <input type="number" name="stock" id="stock" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700">
                        </div>
                    </div>

                    <!-- AUTHOR -->
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

                    <!-- DESKRIPSI -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700"></textarea>
                    </div>

                    <!-- CLASSIFICATION -->
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

                    <!-- CATEGORY -->
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

                    <!-- LOCATION -->
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

                    <!-- FILES -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>
                            <input type="file" name="cover_image" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">File Koleksi (PDF/DOC)</label>
                            <input type="file" name="file_url" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSubmit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH CLASSIFICATION --}}
<div class="modal fade" id="modalAddClassification" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-2xl">
            <div class="modal-header border-b border-slate-100 px-6 py-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-tag text-indigo-500"></i>
                    <h5 class="font-semibold text-slate-800 text-lg">Tambah Classification</h5>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Classification</label>
                <input type="text" id="newClassificationName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: 000 - Karya Umum">
            </div>
            <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="saveClassificationBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH CATEGORY --}}
<div class="modal fade" id="modalAddCategory" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-2xl">
            <div class="modal-header border-b border-slate-100 px-6 py-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-folder text-indigo-500"></i>
                    <h5 class="font-semibold text-slate-800 text-lg">Tambah Category</h5>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Category</label>
                <input type="text" id="newCategoryName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: Fiksi, Non Fiksi, Pendidikan">
            </div>
            <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="saveCategoryBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH LOCATION --}}
<div class="modal fade" id="modalAddLocation" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-2xl">
            <div class="modal-header border-b border-slate-100 px-6 py-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-indigo-500"></i>
                    <h5 class="font-semibold text-slate-800 text-lg">Tambah Location</h5>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Location</label>
                <input type="text" id="newLocationName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700" placeholder="Contoh: Rak 1A, Rak Fiksi, Rak Referensi">
            </div>
            <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="saveLocationBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">Simpan</button>
            </div>
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
    const baseUrl = "/admin/collections";
    
    // ========================================
    // SELECT2 INIT - TANPA dropdownParent AGAR TIDAK MEMICU MODAL
    // ========================================
    $(document).ready(function() {
        $('.select2-multi').select2({
            placeholder: "Pilih / cari",
            width: '100%',
            closeOnSelect: false,
            allowClear: true
        });
        
        $('.select2-single').select2({
            placeholder: "Pilih lokasi",
            width: '100%',
            allowClear: true
        });
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
    // TAMBAH DATA KOLEKSI - PAKAI BOOTSTRAP MODAL BIASA
    // ========================================
    $('#btnTambah, #btnTambahEmpty').click(function() {
        $('#modalTitle').text('Tambah Koleksi');
        $('#btnSubmit').text('Simpan');
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
        $('#modalForm').modal('show');
    });
    
    // ========================================
    // EDIT DATA KOLEKSI
    // ========================================
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        
        $('#modalTitle').text('Edit Koleksi');
        $('#btnSubmit').text('Update');
        $('#formCollection').attr('action', baseUrl + '/' + id);
        $('#methodField').val('PUT');
        
        $('#title').val($(this).data('title'));
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
        
        $('#modalForm').modal('show');
    });
    
    // ========================================
    // TAMBAH CLASSIFICATION (AJAX)
    // ========================================
    $('.btn-add-classification').click(function() {
        $('#newClassificationName').val('');
        $('#modalAddClassification').modal('show');
    });
    
    $('#saveClassificationBtn').click(function() {
        let name = $('#newClassificationName').val();
        if (!name) {
            alert('Nama classification harus diisi!');
            return;
        }
        
        $.ajax({
            url: '/admin/classifications',
            method: 'POST',
            data: {
                name: name,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    let newOption = new Option(response.data.name, response.data.id, false, false);
                    $('#classificationDropdown').append(newOption).trigger('change');
                    $('#modalAddClassification').modal('hide');
                    $('#newClassificationName').val('');
                    alert('Classification berhasil ditambahkan!');
                }
            },
            error: function(xhr) {
                alert('Gagal menambahkan classification: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    });
    
    // ========================================
    // TAMBAH CATEGORY (AJAX)
    // ========================================
    $('.btn-add-category').click(function() {
        $('#newCategoryName').val('');
        $('#modalAddCategory').modal('show');
    });
    
    $('#saveCategoryBtn').click(function() {
        let name = $('#newCategoryName').val();
        if (!name) {
            alert('Nama category harus diisi!');
            return;
        }
        
        $.ajax({
            url: '/admin/categories',
            method: 'POST',
            data: {
                name: name,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    let newOption = new Option(response.data.name, response.data.id, false, false);
                    $('#categoryDropdown').append(newOption).trigger('change');
                    $('#modalAddCategory').modal('hide');
                    $('#newCategoryName').val('');
                    alert('Category berhasil ditambahkan!');
                }
            },
            error: function(xhr) {
                alert('Gagal menambahkan category: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    });
    
    // ========================================
    // TAMBAH LOCATION (AJAX)
    // ========================================
    $('.btn-add-location').click(function() {
        $('#newLocationName').val('');
        $('#modalAddLocation').modal('show');
    });
    
    $('#saveLocationBtn').click(function() {
        let name = $('#newLocationName').val();
        if (!name) {
            alert('Nama location harus diisi!');
            return;
        }
        
        $.ajax({
            url: '/admin/locations',
            method: 'POST',
            data: {
                name: name,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    let newOption = new Option(response.data.name, response.data.id, false, false);
                    $('#locationDropdown').append(newOption).trigger('change');
                    $('#modalAddLocation').modal('hide');
                    $('#newLocationName').val('');
                    alert('Location berhasil ditambahkan!');
                }
            },
            error: function(xhr) {
                alert('Gagal menambahkan location: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    });
</script>

@endsection