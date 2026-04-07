@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('admin_content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container py-4">

    <h2 class="mb-4">Manajemen Koleksi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Koleksi
    </button>

    {{-- TABLE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($collections as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    @if($item->cover_image)
                        <img src="{{ asset('storage/'.$item->cover_image) }}" width="60">
                    @endif
                </td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->author_string }}</td>
                <td>{{ $item->publication_year }}</td>
                <td>
                    <form action="{{ route('admin.collections.destroy',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- ================= MODAL TAMBAH ================= --}}
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

                    <input type="text" name="title" class="form-control mb-2" placeholder="Judul Buku" required>

                    {{-- AUTHOR --}}
                    <label>Author</label>
                    <div id="authorWrapper">
                        <div class="d-flex mb-2">
                            <input type="text" name="author[]" class="form-control me-2" required>
                            <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
                        </div>
                    </div>
                    <button type="button" onclick="addAuthor()" class="btn btn-sm btn-primary mb-3">
                        + Tambah Author
                    </button>

                    <input type="text" name="publisher" class="form-control mb-2" placeholder="Publisher">
                    <input type="number" name="publication_year" class="form-control mb-2" placeholder="Tahun">

                    {{-- DESCRIPTION --}}
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control mb-3" rows="3"></textarea>

                    {{-- CLASSIFICATION --}}
                    <label>Classification</label>
                    <select name="classification_id[]" id="classificationDropdown" class="form-control select2" multiple>
                        @foreach($classifications as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalClassification">
                        + Tambah Classification
                    </button>

                    {{-- CATEGORY --}}
                    <label class="mt-3">Category</label>
                    <select name="category_collection_id[]" id="categoryDropdown" class="form-control select2" multiple>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalCategory">
                        + Tambah Category
                    </button>

                    {{-- PREVIEW --}}
                    <div class="mt-3">
                        <label>Preview Pilihan</label>
                        <div id="previewBox" class="border p-2 bg-light rounded">
                            <small class="text-muted">Belum ada pilihan</small>
                        </div>
                    </div>

                    {{-- LOCATION --}}
                    <label class="mt-3">Location</label>
                    <select name="location_id" class="form-control">
                        @foreach($locations as $l)
                            <option value="{{ $l->id }}">{{ $l->name }}</option>
                        @endforeach
                    </select>

                    <input type="file" name="cover_image" class="form-control mt-2">
                    <input type="file" name="file_url" class="form-control mt-2">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- MODAL TAMBAH DATA --}}
<div class="modal fade" id="modalClassification" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputClassification" class="form-control mb-2">
            <button class="btn btn-primary" onclick="saveData('classification')">Simpan</button>
            <button type="button" class="btn btn-danger btn-sm mt-2"
                onclick="deleteLast('classification')">
                🗑 Hapus Terakhir
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCategory" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputCategory" class="form-control mb-2">
            <button class="btn btn-primary" onclick="saveData('category')">Simpan</button>
            <button type="button" class="btn btn-danger btn-sm mt-2"
                onclick="deleteLast('category')">
                🗑 Hapus Terakhir
            </button>
        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){

    // INIT SELECT2 DALAM MODAL
    $('#modalTambah').on('shown.bs.modal', function () {

        $('#classificationDropdown').select2({
            placeholder: "Pilih / cari classification",
            dropdownParent: $('#modalTambah'),
            width: '100%'
        });

        $('#categoryDropdown').select2({
            placeholder: "Pilih / cari category",
            dropdownParent: $('#modalTambah'),
            width: '100%'
        });

    });

});


// AUTHOR
function addAuthor(){
    let div = document.createElement('div');
    div.className = "d-flex mb-2";
    div.innerHTML = `
        <input type="text" name="author[]" class="form-control me-2" required>
        <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
    `;
    document.getElementById('authorWrapper').appendChild(div);
}

function removeAuthor(btn){
    btn.parentElement.remove();
}


// 🔥 FIX EVENT (WAJIB)
$(document).on('change', '#classificationDropdown, #categoryDropdown', function(){

    let c1 = $('#classificationDropdown').select2('data');
    let c2 = $('#categoryDropdown').select2('data');

    let html = "";

    if(c1.length){
        html += "<b>Classification:</b><br>";
        c1.forEach(x => html += `<span class="badge bg-primary me-1">${x.text}</span>`);
        html += "<br>";
    }

    if(c2.length){
        html += "<b>Category:</b><br>";
        c2.forEach(x => html += `<span class="badge bg-success me-1">${x.text}</span>`);
    }

    if(!html) html = "<small class='text-muted'>Belum ada pilihan</small>";

    $('#previewBox').html(html);
});


// AJAX
function saveData(type){

    let url = {
        classification: "{{ route('admin.classification.storeAjax') }}",
        category: "{{ route('admin.category.storeAjax') }}"
    };

    let input = {
        classification: "inputClassification",
        category: "inputCategory"
    };

    let dropdown = {
        classification: "#classificationDropdown",
        category: "#categoryDropdown"
    };

    let modal = {
        classification: "modalClassification",
        category: "modalCategory"
    };

    let name = document.getElementById(input[type]).value;

    fetch(url[type], {
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
        },
        body:JSON.stringify({name})
    })
    .then(res=>res.json())
    .then(data=>{

        let select = $(dropdown[type]);

        let option = new Option(data.name, data.id, true, true);
        select.append(option).trigger('change');

        document.getElementById(input[type]).value = "";

        let modalEl = document.getElementById(modal[type]);
        bootstrap.Modal.getInstance(modalEl).hide();

    });
}
@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('admin_content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container py-4">

    <h2 class="mb-4">Manajemen Koleksi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Koleksi
    </button>

    {{-- TABLE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($collections as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    @if($item->cover_image)
                        <img src="{{ asset('storage/'.$item->cover_image) }}" width="60">
                    @endif
                </td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->author_string }}</td>
                <td>{{ $item->publication_year }}</td>
                <td>
                    <form action="{{ route('admin.collections.destroy',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- MODAL TAMBAH KOLEKSI --}}
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

                    {{-- TITLE --}}
                    <input type="text" name="title" class="form-control mb-2" placeholder="Judul Buku" required>

                    {{-- AUTHOR --}}
                    <label>Author</label>
                    <div id="authorWrapper">
                        <div class="d-flex mb-2">
                            <input type="text" name="author[]" class="form-control me-2" required>
                            <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
                        </div>
                    </div>
                    <button type="button" onclick="addAuthor()" class="btn btn-sm btn-primary mb-3">+ Tambah Author</button>

                    {{-- PUBLISHER & YEAR --}}
                    <input type="text" name="publisher" class="form-control mb-2" placeholder="Publisher">
                    <input type="number" name="publication_year" class="form-control mb-2" placeholder="Tahun">

                    {{-- DESCRIPTION --}}
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control mb-3" rows="3"></textarea>

                    {{-- CLASSIFICATION --}}
                    <label>Classification</label>
                    <select name="classification_id[]" id="classificationDropdown" class="form-control select2" multiple>
                        @foreach($classifications as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalClassification">+ Tambah Classification</button>

                    {{-- CATEGORY --}}
                    <label class="mt-3">Category</label>
                    <select name="category_collection_id[]" id="categoryDropdown" class="form-control select2" multiple>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalCategory">+ Tambah Category</button>

                    {{-- PREVIEW --}}
                    <div class="mt-3">
                        <label>Preview Pilihan</label>
                        <div id="previewBox" class="border p-2 bg-light rounded">
                            <small class="text-muted">Belum ada pilihan</small>
                        </div>
                    </div>

                    {{-- LOCATION --}}
                    <label class="mt-3">Location</label>
                    <select name="location_id" class="form-control">
                        @foreach($locations as $l)
                            <option value="{{ $l->id }}">{{ $l->name }}</option>
                        @endforeach
                    </select>

                    {{-- FILES --}}
                    <input type="file" name="cover_image" class="form-control mt-2">
                    <input type="file" name="file_url" class="form-control mt-2">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH CLASSIFICATION --}}
<div class="modal fade" id="modalClassification" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Classification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" id="inputClassification" class="form-control" placeholder="Nama Classification">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveData('classification')">Simpan</button>
                <button class="btn btn-danger" onclick="deleteLast('classification')">🗑 Hapus Terakhir</button>
            </div>

        </div>
    </div>
</div>

{{-- MODAL TAMBAH CATEGORY --}}
<div class="modal fade" id="modalCategory" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" id="inputCategory" class="form-control" placeholder="Nama Category">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveData('category')">Simpan</button>
                <button class="btn btn-danger" onclick="deleteLast('category')">🗑 Hapus Terakhir</button>
            </div>

        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){

    // INIT SELECT2 DALAM MODAL
    $('#modalTambah').on('shown.bs.modal', function () {

        $('#classificationDropdown').select2({
            placeholder: "Pilih / cari classification",
            dropdownParent: $('#modalTambah'),
            width: '100%'
        });

        $('#categoryDropdown').select2({
            placeholder: "Pilih / cari category",
            dropdownParent: $('#modalTambah'),
            width: '100%'
        });

    });

});


// AUTHOR
function addAuthor(){
    let div = document.createElement('div');
    div.className = "d-flex mb-2";
    div.innerHTML = `
        <input type="text" name="author[]" class="form-control me-2" required>
        <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">✖</button>
    `;
    document.getElementById('authorWrapper').appendChild(div);
}

function removeAuthor(btn){
    btn.parentElement.remove();
}


// 🔥 FIX EVENT (WAJIB)
$(document).on('change', '#classificationDropdown, #categoryDropdown', function(){

    let c1 = $('#classificationDropdown').select2('data');
    let c2 = $('#categoryDropdown').select2('data');

    let html = "";

    if(c1.length){
        html += "<b>Classification:</b><br>";
        c1.forEach(x => html += `<span class="badge bg-primary me-1">${x.text}</span>`);
        html += "<br>";
    }

    if(c2.length){
        html += "<b>Category:</b><br>";
        c2.forEach(x => html += `<span class="badge bg-success me-1">${x.text}</span>`);
    }

    if(!html) html = "<small class='text-muted'>Belum ada pilihan</small>";

    $('#previewBox').html(html);
});


// AJAX
// AJAX untuk menambah data
function saveData(type){
    let url = {
        classification: "{{ route('admin.classification.storeAjax') }}",
        category: "{{ route('admin.category.storeAjax') }}"
    };

    let input = {
        classification: "inputClassification",
        category: "inputCategory"
    };

    let dropdown = {
        classification: "#classificationDropdown",
        category: "#categoryDropdown"
    };

    let modal = {
        classification: "modalClassification",
        category: "modalCategory"
    };

    let name = document.getElementById(input[type]).value;

    fetch(url[type], {
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
        },
        body:JSON.stringify({name})
    })
    .then(res=>res.json())
    .then(data=>{
        let select = $(dropdown[type]);
        let option = new Option(data.name, data.id, true, true);
        select.append(option).trigger('change');
        document.getElementById(input[type]).value = "";
        let modalEl = document.getElementById(modal[type]);
        bootstrap.Modal.getInstance(modalEl).hide();
    });
}

// ================= HAPUS DATA TERAKHIR (GLOBAL) =================
function deleteLast(type){
    if(!confirm("Yakin hapus data terakhir?")) return;

    let url = {
        classification: "{{ route('admin.classification.deleteLast') }}",
        category: "{{ route('admin.category.deleteLast') }}"
    };

    let dropdown = {
        classification: "#classificationDropdown",
        category: "#categoryDropdown"
    };

    fetch(url[type], {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            $(dropdown[type] + " option[value='"+data.id+"']").remove();
            $(dropdown[type]).trigger('change');
            alert("Data terakhir berhasil dihapus");
        } else {
            alert("Tidak ada data untuk dihapus");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Gagal hapus!");
    });
}
</script>

@endsection

</script>

@endsection