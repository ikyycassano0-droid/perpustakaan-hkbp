@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('admin_content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Style untuk tombol X pada select2 */
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
</style>

<div class="container py-4">

    <h2 class="mb-4">Manajemen Koleksi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Koleksi
    </button>

    {{-- TABLE --}}
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Menu</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($collections as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>

                <td>
                    <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : 'https://via.placeholder.com/60' }}"
                        width="60" class="rounded shadow-sm">
                </td>

                <br>

                <td>
                    <br><b>{{ $item->title }}</b><br>
                    <small class="text-muted">{{ $item->publisher }}</small>
                </td>

                <td>{{ $item->author_string }}</td>

                <td>
                    <span class="badge bg-info">
                        {{ ucfirst(str_replace('_',' ',$item->menu_type)) }}
                    </span>
                </td>

                <td>
                    <span class="badge bg-{{ $item->stock > 0 ? 'success' : 'danger' }}">
                        {{ $item->stock }}
                    </span>
                </td>

                <td>
                    <span class="badge bg-{{ $item->active ? 'success' : 'secondary' }}">
                        {{ $item->active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>

                <td>
                    <button class="btn btn-warning btn-sm btn-edit"
                        data-id="{{ $item->id }}">
                        Edit
                    </button>

                    <form action="{{ route('admin.collections.destroy',$item->id) }}"
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Koleksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- MENU --}}
                    <label class="fw-bold">Menu</label>
                    <select name="menu_type" class="form-control mb-3" required>
                        <option value="jurnal">Jurnal</option>
                        <option value="buku_pengayaan">Buku Pengayaan</option>
                        <option value="buku_referensi">Buku Referensi</option>
                        <option value="majalah">Majalah</option>
                    </select>

                    {{-- TITLE --}}
                    <label class="fw-bold">Judul Buku</label>
                    <input type="text" name="title" class="form-control mb-2" required>

                    {{-- AUTHOR --}}
                    <label class="fw-bold">Author</label>
                    <div id="authorWrapper">
                        <div class="d-flex mb-2">
                            <input type="text" name="author[]" class="form-control me-2" required>
                            <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
                        </div>
                    </div>

                    <button type="button" onclick="addAuthor()" class="btn btn-sm btn-primary mb-3">
                        + Tambah Author
                    </button>

                    {{-- PUBLISHER --}}
                    <label class="fw-bold">Publisher</label>
                    <input type="text" name="publisher" class="form-control mb-2">

                    {{-- YEAR --}}
                    <label class="fw-bold">Tahun Terbit</label>
                    <input type="number" name="publication_year" class="form-control mb-2">

                    {{-- DESCRIPTION --}}
                    <label class="fw-bold">Deskripsi</label>
                    <textarea name="description" class="form-control mb-3"></textarea>

                    {{-- CLASSIFICATION --}}
                    <label class="fw-bold">Classification</label>
                    <select name="classification_id[]" id="classificationDropdown"
                        class="form-control select2-multi" multiple>
                        @foreach($classifications as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <div class="d-flex gap-2 mt-2">
                        <button type="button" class="btn btn-success btn-sm" onclick="openModal('classification')">
                            + Tambah
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteLast('classification')">
                            🗑 Hapus Terakhir
                        </button>
                    </div>

                    {{-- CATEGORY --}}
                    <label class="fw-bold mt-3">Category</label>
                    <select name="category_collection_id[]" id="categoryDropdown"
                        class="form-control select2-multi" multiple>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <div class="d-flex gap-2 mt-2">
                        <button type="button" class="btn btn-success btn-sm" onclick="openModal('category')">
                            + Tambah
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteLast('category')">
                            🗑 Hapus Terakhir
                        </button>
                    </div>

                    {{-- LOCATION --}}
                    <label class="fw-bold mt-3">Location</label>
                    <select name="location_id" id="locationDropdown" class="form-control select2-single" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($locations as $l)
                            <option value="{{ $l->id }}">{{ $l->name }}</option>
                        @endforeach
                    </select>

                    <div class="d-flex gap-2 mt-2">
                        <button type="button" class="btn btn-success btn-sm" onclick="openModal('location')">
                            + Tambah
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteLast('location')">
                            🗑 Hapus Terakhir
                        </button>
                    </div>

                    {{-- STOCK --}}
                    <label class="fw-bold mt-3">Stock</label>
                    <input type="number" name="stock" class="form-control" min="1" value="1" required>

                    {{-- COVER IMAGE --}}
                    <label class="fw-bold mt-3">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control">

                    {{-- FILE KOLEKSI --}}
                    <label class="fw-bold mt-2">File Koleksi</label>
                    <input type="file" name="file_url" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5>Edit Koleksi</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="editContent">
                    {{-- DIISI DARI AJAX --}}
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// ================= AUTHOR DINAMIS =================
function addAuthor(){
    $('#authorWrapper').append(`
        <div class="d-flex mb-2">
            <input type="text" name="author[]" class="form-control me-2">
            <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
        </div>
    `);
}

function removeAuthor(btn){
    btn.parentElement.remove();
}

// ================= SELECT2 DENGAN TOMBOL X =================
$(document).ready(function() {
    // Multi select untuk Classification & Category (bisa dihapus per item pakai X)
    $('.select2-multi').select2({
        placeholder: "Pilih / cari",
        width: '100%',
        dropdownParent: $('#modalTambah'),
        closeOnSelect: false,
        allowClear: true
    });

    // Single select untuk Location (dengan tombol X untuk clear)
    $('.select2-single').select2({
        placeholder: "Pilih lokasi",
        width: '100%',
        dropdownParent: $('#modalTambah'),
        allowClear: true
    });
});

// ================= EDIT MODAL =================
$(document).on('click', '.btn-edit', function(){
    let id = $(this).data('id');

    $('#modalEdit').modal('show');
    $('#editContent').html('Loading...');

    $.get('/admin/collections/'+id+'/edit', function(res){
        $('#editContent').html(res.html);
        $('#formEdit').attr('action', res.action);

        // Re-initialize select2 di modal edit
        $('#modalEdit .select2-multi').select2({
            dropdownParent: $('#modalEdit'),
            closeOnSelect: false,
            allowClear: true
        });
        
        $('#modalEdit .select2-single').select2({
            dropdownParent: $('#modalEdit'),
            allowClear: true
        });
    });
});

// Placeholder untuk fungsi openModal dan deleteLast
function openModal(type) {
    let name = prompt("Masukkan nama " + type + " baru:");

    if (!name) return;

    let url = "";

    if (type === "classification") {
        url = "{{ route('admin.classification.storeAjax') }}";
    }

    if (type === "category") {
        url = "{{ route('admin.category.storeAjax') }}";
    }

    if (type === "location") {
        url = "{{ route('admin.location.storeAjax') }}";
    }

    $.ajax({
        url: url,
        method: "POST",
        data: {
            name: name,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {

            let option = new Option(res.name, res.id, true, true);

            if (type === 'classification') {
                $('#classificationDropdown').append(option).trigger('change');
            }

            if (type === 'category') {
                $('#categoryDropdown').append(option).trigger('change');
            }

            if (type === 'location') {
                $('#locationDropdown').append(option).trigger('change');
            }

            alert(type + " berhasil ditambahkan");
        },
        error: function() {
            alert("Gagal menambahkan " + type);
        }
    });
}

function deleteLast(type) {

    let url = "";

    let dropdown = null;

    if (type === "classification") {
        url = "{{ route('admin.classification.deleteLast') }}";
        dropdown = $('#classificationDropdown');
    }

    if (type === "category") {
        url = "{{ route('admin.category.deleteLast') }}";
        dropdown = $('#categoryDropdown');
    }

    if (type === "location") {
        url = "{{ route('admin.location.deleteLast') }}";
        dropdown = $('#locationDropdown');
    }

    if (!dropdown) return;

    if (!confirm("Yakin hapus data terakhir?")) return;

    $.ajax({
        url: url,
        method: "DELETE",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {

            // backend idealnya return {id: xxx}

            if (res.id) {
                dropdown.find(`option[value="${res.id}"]`).remove();
                dropdown.trigger('change');
            } else {
                // fallback: hapus option terakhir
                dropdown.find('option:last').remove();
                dropdown.trigger('change');
            }

            alert("Berhasil dihapus");
        },
        error: function() {
            alert("Gagal menghapus data");
        }
    });
}
</script>
@endsection