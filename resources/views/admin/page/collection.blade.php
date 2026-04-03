@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('admin_content')
<div class="container py-4">

    <h2 class="mb-4">Manajemen Koleksi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Koleksi</button>

    {{-- ================= TABLE ================= --}}
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
                <td>{{ $i + 1 }}</td>
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

{{-- ================= MODAL TAMBAH KOLEKSI ================= --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Koleksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Title --}}
                    <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>

                    {{-- Author MULTIPLE --}}
                    <div id="authorWrapper">
                        <input type="text" name="author[]" class="form-control mb-2" placeholder="Author" required>
                    </div>
                    <button type="button" onclick="addAuthorField()" class="btn btn-sm btn-secondary mb-2">+ Author</button>

                    {{-- Publisher --}}
                    <input type="text" name="publisher" class="form-control mb-2" placeholder="Publisher">
                    {{-- Year --}}
                    <input type="number" name="publication_year" class="form-control mb-2" placeholder="Publication Year">
                    {{-- Description --}}
                    <textarea id="description" name="description" class="form-control mb-2" placeholder="Description"></textarea>

                    {{-- Classification MULTI --}}
                    <label>Classification</label>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <select name="classification_id[]" id="classificationDropdown" class="form-control" multiple required>
                            @foreach($classifications as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalClassification">+</button>
                        <button type="button" class="btn btn-danger" onclick="deleteLast('classification')">Hapus Terakhir</button>
                    </div>

                    {{-- Category MULTI --}}
                    <label>Category</label>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <select name="category_collection_id[]" id="categoryDropdown" class="form-control" multiple required>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCategory">+</button>
                        <button type="button" class="btn btn-danger" onclick="deleteLast('category')">Hapus Terakhir</button>
                    </div>

                    {{-- Location --}}
                    <label>Location</label>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <select name="location_id" id="locationDropdown" class="form-control" required>
                            <option value="">Pilih Location</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLocation">+</button>
                        <button type="button" class="btn btn-danger" onclick="deleteLast('location')">Hapus Terakhir</button>
                    </div>

                    {{-- Cover & File --}}
                    <input type="file" name="cover_image" class="form-control mb-2">
                    <input type="file" name="file_url" class="form-control mb-2">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL AJAX TAMBAH RELASI ================= --}}
{{-- Classification --}}
<div class="modal fade" id="modalClassification">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputClassification" class="form-control mb-2" placeholder="Nama classification">
            <button type="button" class="btn btn-primary" onclick="saveData('classification')">Simpan</button>
        </div>
    </div>
</div>

{{-- Category --}}
<div class="modal fade" id="modalCategory">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputCategory" class="form-control mb-2" placeholder="Nama category">
            <button type="button" class="btn btn-primary" onclick="saveData('category')">Simpan</button>
        </div>
    </div>
</div>

{{-- Location --}}
<div class="modal fade" id="modalLocation">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <input type="text" id="inputLocation" class="form-control mb-2" placeholder="Nama location">
            <button type="button" class="btn btn-primary" onclick="saveData('location')">Simpan</button>
        </div>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
// ================= AUTHOR =================
function addAuthorField() {
    const wrapper = document.getElementById('authorWrapper');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'author[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Author';
    wrapper.appendChild(input);
}

// ================= CKEDITOR SAFE INIT =================
document.addEventListener("DOMContentLoaded", function () {

    // cek semua kemungkinan id editor
    const editors = ['editor', 'description'];

    editors.forEach(id => {
        const el = document.getElementById(id);

        if (el) {
            ClassicEditor
                .create(el)
                .then(editor => {
                    console.log("CKEditor aktif di:", id);
                })
                .catch(error => {
                    console.error("CKEditor error:", error);
                });
        }
    });

});

// ================= SIMPAN AJAX =================
function saveData(type) {
    console.log("KEPANGGIL:", type);

    const config = {
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

    const c = config[type];
    const name = document.getElementById(c.input).value.trim();

    if (!name) {
        alert('Nama tidak boleh kosong!');
        return;
    }

    fetch(c.url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ name: name })
    })
    .then(res => {
        if (!res.ok) {
            return res.json().then(err => { throw err; });
        }
        return res.json();
    })
    .then(data => {
        console.log("SUCCESS:", data);

        const dropdown = document.getElementById(c.dropdown);

        const option = document.createElement('option');
        option.value = data.id;
        option.text = data.name;
        option.selected = true;

        dropdown.appendChild(option);

        document.getElementById(c.input).value = '';

        const modalEl = document.getElementById(c.modal);
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    })
    .catch(err => {
        console.error("ERROR:", err);
        alert('Gagal menyimpan! Cek console.');
    });
}

// ================= DELETE LAST =================
function deleteLast(type) {
    if (!confirm('Yakin hapus data terakhir?')) return;

    const urls = {
        classification: "{{ route('admin.classification.deleteLast') }}",
        category: "{{ route('admin.category.deleteLast') }}",
        location: "{{ route('admin.location.deleteLast') }}"
    };

    fetch(urls[type], {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(() => {
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Gagal hapus!');
    });
}
</script>
@endsection