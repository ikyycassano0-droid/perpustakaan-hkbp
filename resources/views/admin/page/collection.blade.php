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

    {{-- ================= TABLE ================= --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th width="170">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($collections as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>

                <td>
                    @if($item->cover_image)
                        <img src="{{ asset('storage/'.$item->cover_image) }}" width="60">
                    @endif
                </td>

                <td>{{ $item->title }}</td>
                <td>{{ $item->author_string }}</td>
                <td>{{ $item->publication_year }}</td>

                <td>
                    <button class="btn btn-warning btn-sm"
                        onclick='editData(@json($item))'>
                        Edit
                    </button>

                    <form action="{{ route('admin.collections.destroy',$item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
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
                    <h5 class="modal-title">Tambah Koleksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>

                    {{-- AUTHOR --}}
                    <div id="authorWrapper">
                        <input type="text" name="author[]" class="form-control mb-2" placeholder="Author" required>
                    </div>
                    <button type="button" onclick="addAuthorField()" class="btn btn-sm btn-secondary mb-2">
                        + Author
                    </button>

                    <input type="text" name="publisher" class="form-control mb-2" placeholder="Publisher">
                    <input type="number" name="publication_year" class="form-control mb-2" placeholder="Year">

                    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

                    {{-- CLASSIFICATION --}}
                    <label>Classification</label>
                    <div class="d-flex gap-2 mb-2">
                        <select name="classification_id[]" id="classificationDropdown" class="form-control" multiple required>
                            @foreach($classifications as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalClassification">+</button>
                    </div>

                    {{-- CATEGORY --}}
                    <label>Category</label>
                    <div class="d-flex gap-2 mb-2">
                        <select name="category_collection_id[]" id="categoryDropdown" class="form-control" multiple required>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCategory">+</button>
                    </div>

                    {{-- LOCATION --}}
                    <label>Location</label>
                    <div class="d-flex gap-2 mb-2">
                        <select name="location_id" id="locationDropdown" class="form-control" required>
                            <option value="">Pilih Location</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLocation">+</button>
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

{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5>Edit Koleksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="editTitle" name="title" class="form-control mb-2">

                    <div id="editAuthorWrapper"></div>

                    <input type="text" id="editPublisher" name="publisher" class="form-control mb-2">
                    <input type="number" id="editYear" name="publication_year" class="form-control mb-2">

                    <textarea id="editDescription" name="description" class="form-control mb-2"></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL AJAX ================= --}}
<div class="modal fade" id="modalClassification">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputClassification" class="form-control mb-2">
            <button class="btn btn-primary" onclick="saveData('classification')">Simpan</button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCategory">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputCategory" class="form-control mb-2">
            <button class="btn btn-primary" onclick="saveData('category')">Simpan</button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLocation">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputLocation" class="form-control mb-2">
            <button class="btn btn-primary" onclick="saveData('location')">Simpan</button>
        </div>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
function addAuthorField() {
    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'author[]';
    input.className = 'form-control mb-2';
    document.getElementById('authorWrapper').appendChild(input);
}

function editData(item) {
    document.getElementById('formEdit').action = "/admin/collections/" + item.id;

    document.getElementById('editTitle').value = item.title;
    document.getElementById('editPublisher').value = item.publisher ?? '';
    document.getElementById('editYear').value = item.publication_year ?? '';
    document.getElementById('editDescription').value = item.description ?? '';

    let wrapper = document.getElementById('editAuthorWrapper');
    wrapper.innerHTML = '';

    if(item.author){
        item.author.forEach(a=>{
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'author[]';
            input.value = a;
            input.className = 'form-control mb-2';
            wrapper.appendChild(input);
        });
    }

    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

function saveData(type){
    let urlMap = {
        classification: "{{ route('admin.classification.storeAjax') }}",
        category: "{{ route('admin.category.storeAjax') }}",
        location: "{{ route('admin.location.storeAjax') }}"
    };

    let inputMap = {
        classification: "inputClassification",
        category: "inputCategory",
        location: "inputLocation"
    };

    let dropdownMap = {
        classification: "classificationDropdown",
        category: "categoryDropdown",
        location: "locationDropdown"
    };

    let name = document.getElementById(inputMap[type]).value;

    fetch(urlMap[type], {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ name })
    })
    .then(res => res.json())
    .then(data => {
        let opt = document.createElement('option');
        opt.value = data.id;
        opt.text = data.name;
        opt.selected = true;

        document.getElementById(dropdownMap[type]).appendChild(opt);
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menyimpan!');
    });
}
</script>

@endsection