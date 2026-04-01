@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('admin_content')

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
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data</td>
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
</div>

<div class="modal-body">

    <input type="text" name="title" class="form-control mb-2" placeholder="Title">

    {{-- AUTHOR MULTI --}}
    <div id="authorWrapper">
        <input type="text" name="author[]" class="form-control mb-2" placeholder="Author">
    </div>
    <button type="button" onclick="addField()" class="btn btn-sm btn-secondary mb-2">
        + Author
    </button>

    <input type="text" name="publisher" class="form-control mb-2" placeholder="Publisher">
    <input type="number" name="publication_year" class="form-control mb-2" placeholder="Year">

    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

    {{-- ================= CLASSIFICATION ================= --}}
    <label>Classification</label>
    <div class="d-flex gap-2 mb-2">
        <select id="classificationDropdown" name="classification_id" class="form-control">
            <option value="">Pilih Classification</option>
            @foreach($classifications as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalClassification">+</button>

        <button type="button" class="btn btn-danger" onclick="deleteLast('classification')">
            Hapus Terakhir
        </button>
    </div>

    {{-- ================= CATEGORY ================= --}}
    <label>Category</label>
    <div class="d-flex gap-2 mb-2">
        <select id="categoryDropdown" name="category_collection_id" class="form-control">
            <option value="">Pilih Category</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCategory">+</button>

        <button type="button" class="btn btn-danger" onclick="deleteLast('category')">
            Hapus Terakhir
        </button>
    </div>

    {{-- ================= LOCATION ================= --}}
    <label>Location</label>
    <div class="d-flex gap-2 mb-2">
        <select id="locationDropdown" name="location_id" class="form-control">
            <option value="">Pilih Location</option>
            @foreach($locations as $l)
                <option value="{{ $l->id }}">{{ $l->name }}</option>
            @endforeach
        </select>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLocation">+</button>

        <button type="button" class="btn btn-danger" onclick="deleteLast('location')">
            Hapus Terakhir
        </button>
    </div>

    <input type="file" name="cover_image" class="form-control mb-2">
    <input type="file" name="file_url" class="form-control mb-2">

</div>

<div class="modal-footer">
    <button class="btn btn-primary">Simpan</button>
</div>

</form>

</div>
</div>
</div>

{{-- ================= MODAL TAMBAH RELASI ================= --}}

{{-- CLASSIFICATION --}}
<div class="modal fade" id="modalClassification">
<div class="modal-dialog">
<div class="modal-content p-3">
    <input type="text" id="inputClassification" class="form-control mb-2" placeholder="Nama classification">
    <button class="btn btn-primary" onclick="saveData('classification')">Simpan</button>
</div>
</div>
</div>

{{-- CATEGORY --}}
<div class="modal fade" id="modalCategory">
<div class="modal-dialog">
<div class="modal-content p-3">
    <input type="text" id="inputCategory" class="form-control mb-2" placeholder="Nama category">
    <button class="btn btn-primary" onclick="saveData('category')">Simpan</button>
</div>
</div>
</div>

{{-- LOCATION --}}
<div class="modal fade" id="modalLocation">
<div class="modal-dialog">
<div class="modal-content p-3">
    <input type="text" id="inputLocation" class="form-control mb-2" placeholder="Nama location">
    <button class="btn btn-primary" onclick="saveData('location')">Simpan</button>
</div>
</div>
</div>

{{-- ================= JS ================= --}}
<script>

// tambah author
function addField() {
    let wrapper = document.getElementById('authorWrapper');

    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'author[]';
    input.classList.add('form-control','mb-2');

    wrapper.appendChild(input);
}

// AJAX tambah data
function saveData(type) {

    let config = {
        classification: {
            url: "{{ route('admin.classification.storeAjax') }}",
            input: "inputClassification",
            dropdown: "classificationDropdown",
            modal: "modalClassification"
        },
        category: {
            url: "{{ route('admin.category.storeAjax') }}",
            input: "inputCategory",
            dropdown: "categoryDropdown",
            modal: "modalCategory"
        },
        location: {
            url: "{{ route('admin.location.storeAjax') }}",
            input: "inputLocation",
            dropdown: "locationDropdown",
            modal: "modalLocation"
        }
    };

    let c = config[type];
    let name = document.getElementById(c.input).value;

    fetch(c.url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ name: name })
    })
    .then(res => res.json())
    .then(data => {

        let dropdown = document.getElementById(c.dropdown);

        let option = document.createElement('option');
        option.value = data.id;
        option.text = data.name;
        option.selected = true;

        dropdown.appendChild(option);

        document.getElementById(c.input).value = '';

        let modal = bootstrap.Modal.getInstance(document.getElementById(c.modal));
        modal.hide();
    });
}

// DELETE LAST
function deleteLast(type) {

    if(!confirm('Yakin hapus data terakhir?')) return;

    let urls = {
        classification: "{{ route('admin.classification.deleteLast') }}",
        category: "{{ route('admin.category.deleteLast') }}",
        location: "{{ route('admin.location.deleteLast') }}"
    };

    fetch(urls[type], {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(() => {
        alert('Data terakhir dihapus');
        location.reload();
    });
}

</script>

@endsection