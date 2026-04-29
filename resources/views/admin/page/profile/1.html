@extends('admin.component.main')
@section('title', 'Manajemen Profile')
@section('page-title', 'Data Profile')

@section('admin_content')

<div class="container">

    <h3 class="mb-3">Manajemen Profile Website</h3>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ========================= --}}
    {{-- FORM TAMBAH --}}
    {{-- ========================= --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Tambah Data</div>

        <div class="card-body">
            <form action="{{ route('admin.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-2">

                    {{-- TYPE --}}
                    <div class="col-md-3">
                        <label>Type</label>
                        <select name="type" id="type" class="form-control" required onchange="ubahForm()">
                            <option value="">-- Pilih --</option>
                            <option value="visi_misi">Visi & Misi</option>
                            <option value="tugas_fungsi">Tugas & Fungsi</option>
                            <option value="struktur">Struktur</option>
                            <option value="kerjasama">Kerjasama</option>
                        </select>
                    </div>

                    {{-- SUB TYPE --}}
                    <div class="col-md-3">
                        <label>Sub Type</label>
                        <select name="sub_type" id="sub_type" class="form-control">
                            <option value="">-- Pilih Sub Type --</option>
                        </select>
                    </div>

                    {{-- TITLE --}}
                    <div class="col-md-3" id="fieldTitle">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    {{-- JABATAN --}}
                    <div class="col-md-3 d-none" id="fieldJabatan">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-md-3" id="fieldDesc">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>

                    {{-- ICON --}}
                    <div class="col-md-2">
                        <label>Icon</label>
                        <input type="text" name="icon" class="form-control">
                    </div>

                    {{-- IMAGE --}}
                    <div class="col-md-2">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- ORDER --}}
                    <div class="col-md-1">
                        <label>Urutan</label>
                        <input type="number" name="order" class="form-control" value="1" min="1" required>
                    </div>

                    <div class="col-md-12 mt-2">
                        <button class="btn btn-success w-100">+ Tambah Data</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TABLE --}}
    {{-- ========================= --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Data Profile</div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Sub Type</th>
                        <th>Judul</th>
                        <th>Jabatan</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Aktif</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($profiles as $item)
                    <tr>

                        <td>
                            <span class="badge bg-info text-dark">
                                {{ strtoupper($item->type) }}
                            </span>
                        </td>

                        <td>{{ $item->sub_type ?? '-' }}</td>

                        <td>{{ $item->title ?? '-' }}</td>

                        <td>{{ $item->jabatan ?? '-' }}</td>

                        <td style="max-width: 250px;">
                            {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                        </td>

                        <td>{{ $item->order }}</td>

                        <td class="text-center">
                            @if($item->active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                        <td class="d-flex gap-1">

                            {{-- EDIT --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                Edit
                            </button>

                            {{-- DELETE --}}
                            <form action="{{ route('admin.profile.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>

                        </td>

                    </tr>

                    {{-- MODAL EDIT --}}
                    <div class="modal fade" id="editModal{{ $item->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.profile.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5>Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <label>Judul</label>
                                        <input type="text" name="title" value="{{ $item->title }}" class="form-control mb-2">

                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" value="{{ $item->jabatan }}" class="form-control mb-2">

                                        <label>Deskripsi</label>
                                        <textarea name="description" class="form-control mb-2">{{ $item->description }}</textarea>

                                        <label>Urutan</label>
                                        <input type="number" name="order" class="form-control" value="1" min="1" required>

                                        <label>Gambar</label>
                                        <input type="file" name="image" class="form-control mb-2">

                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="active" class="form-check-input" {{ $item->active ? 'checked' : '' }}>
                                            <label class="form-check-label">Aktif</label>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

{{-- ========================= --}}
{{-- SCRIPT DINAMIS --}}
{{-- ========================= --}}
<script>
function ubahForm() {
    let type = document.getElementById('type').value;
    let subType = document.getElementById('sub_type');

    let title = document.getElementById('fieldTitle');
    let jabatan = document.getElementById('fieldJabatan');
    let desc = document.getElementById('fieldDesc');

    subType.innerHTML = '<option value="">-- Pilih Sub Type --</option>';

    if(type === 'visi_misi'){
        subType.innerHTML += `
            <option value="visi">Visi</option>
            <option value="misi">Misi</option>
            <option value="about">About</option>
        `;
    }

    if(type === 'tugas_fungsi'){
        subType.innerHTML += `
            <option value="tugas">Tugas</option>
            <option value="fungsi">Fungsi</option>
            <option value="tujuan">Tujuan</option>
        `;
    }

    if(type === 'struktur'){
        subType.innerHTML += `<option value="pengurus">Pengurus</option>`;
        title.querySelector('label').innerText = 'Nama';
        jabatan.classList.remove('d-none');
        desc.classList.add('d-none');
        return;
    }

    // default
    title.querySelector('label').innerText = 'Judul';
    jabatan.classList.add('d-none');
    desc.classList.remove('d-none');
}
</script>

@endsection