@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('admin_content')

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
</style>

<div class="container py-4">

<h2 class="mb-4">Manajemen Koleksi</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<button class="btn btn-primary mb-3" id="btnTambah">
+ Tambah Koleksi
</button>

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
data-id="{{ $item->id }}"
data-title="{{ $item->title }}"
data-author="{{ implode(',', $item->author ?? []) }}"
data-stock="{{ $item->stock }}"
data-menu="{{ $item->menu_type }}">
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
<div class="modal fade" id="modalForm">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form id="formCollection" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="_method" id="methodField">

<div class="modal-header">
<h5 id="modalTitle">Tambah Koleksi</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<label class="fw-bold">Menu</label>
<select name="menu_type" id="menu_type" class="form-control mb-3" required>
<option value="jurnal">Jurnal</option>
<option value="buku_pengayaan">Buku Pengayaan</option>
<option value="buku_referensi">Buku Referensi</option>
<option value="majalah">Majalah</option>
</select>

<label class="fw-bold">Judul Buku</label>
<input type="text" name="title" id="title" class="form-control mb-2" required>

<label class="fw-bold">Series Title</label>
<input type="text" name="series_title" id="series_title" class="form-control mb-2">

<label class="fw-bold">Author</label>
<div id="authorWrapper">
<div class="d-flex mb-2">
<input type="text" name="author[]" id="author" class="form-control me-2">
<button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
</div>
</div>

<button type="button" onclick="addAuthor()" class="btn btn-sm btn-primary mb-3">
+ Tambah Author
</button>

<label class="fw-bold">Publisher</label>
<input type="text" name="publisher" id="publisher" class="form-control mb-2">

<label class="fw-bold">Tahun Terbit</label>
<input type="number" name="publication_year" id="publication_year" class="form-control mb-2">

<label class="fw-bold">Deskripsi</label>
<textarea name="description" id="description" class="form-control mb-3"></textarea>

<label class="fw-bold">Classification</label>
<select name="classification_id[]" id="classificationDropdown"
class="form-control select2-multi" multiple>
@foreach($classifications as $c)
<option value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
</select>

<label>Language</label>
<input type="text" name="language" id="language" class="form-control mb-2">

<label>Edition</label>
<input type="text" name="edition" id="edition" class="form-control mb-2">

<label>Subject</label>
<input type="text" name="subject" id="subject" class="form-control mb-2">

<label>Carrier Type</label>
<input type="text" name="carrier_type" id="carrier_type" class="form-control mb-2">

<label>Format</label>
<input type="text" name="format" id="format" class="form-control mb-2">

<label class="fw-bold mt-3">Category</label>
<select name="category_collection_id[]" id="categoryDropdown"
class="form-control select2-multi" multiple>
@foreach($categories as $c)
<option value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
</select>

<label class="fw-bold mt-3">Location</label>
<select name="location_id" id="locationDropdown" class="form-control select2-single">
<option value="">-- Pilih Lokasi --</option>
@foreach($locations as $l)
<option value="{{ $l->id }}">{{ $l->name }}</option>
@endforeach
</select>

<label class="fw-bold mt-3">Stock</label>
<input type="number" name="stock" id="stock" class="form-control">

<label class="fw-bold mt-3">Cover Image</label>
<input type="file" name="cover_image" class="form-control">

<label class="fw-bold mt-2">File Koleksi</label>
<input type="file" name="file_url" class="form-control">

</div>

<div class="modal-footer">
<button class="btn btn-primary" id="btnSubmit">Simpan</button>
</div>

</form>

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
const baseUrl = "/admin/collections";

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

$(document).ready(function(){

$('.select2-multi').select2({
placeholder: "Pilih / cari",
width: '100%',
dropdownParent: $('#modalForm'),
closeOnSelect: false,
allowClear: true
});

$('.select2-single').select2({
placeholder: "Pilih lokasi",
width: '100%',
dropdownParent: $('#modalForm'),
allowClear: true
});

});

// TAMBAH
$('#btnTambah').click(function(){

$('#modalTitle').text('Tambah Koleksi');
$('#btnSubmit').text('Simpan');

$('#formCollection').attr('action', baseUrl);
$('#methodField').val('');

$('#formCollection')[0].reset();

$('#modalForm').modal('show');
});

// EDIT TANPA AJAX
$(document).on('click','.btn-edit',function(){

let id = $(this).data('id');

$('#modalTitle').text('Edit Koleksi');
$('#btnSubmit').text('Update');

$('#formCollection').attr('action', baseUrl+'/'+id);
$('#methodField').val('PUT');

$('#title').val($(this).data('title'));
$('#author').val($(this).data('author'));
$('#stock').val($(this).data('stock'));
$('#menu_type').val($(this).data('menu'));

$('#modalForm').modal('show');
});
</script>

@endsection