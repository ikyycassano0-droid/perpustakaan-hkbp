@extends('admin.component.main')
@section('title', 'Manajemen Profile')
@section('page-title', 'Data Profile')

@section('admin_content')

<div class="container">

    <h3>Manajemen Profile Website</h3>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ========================= --}}
    {{-- FORM TAMBAH --}}
    {{-- ========================= --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Data</div>

        <div class="card-body">
            <form action="{{ route('admin.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-3">
                        <label>Kategori</label>
                        <select name="key" id="kategori" class="form-control" required onchange="ubahLabel()">
                            <option value="">-- Pilih --</option>
                            <option value="visi">Visi</option>
                            <option value="misi">Misi</option>
                            <option value="tugas">Tugas</option>
                            <option value="fungsi">Fungsi</option>
                            <option value="tujuan">Tujuan</option>
                            <option value="struktur">Struktur Organisasi</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label id="labelTitle">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label id="labelDesc">Deskripsi</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Urutan</label>
                        <input type="number" name="sequence" class="form-control">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100">+</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TABLE --}}
    {{-- ========================= --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Urutan</th>
                <th>Aktif</th>
                <th width="250">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($profiles as $item)
            <tr>

                {{-- FORM UPDATE --}}
                <form action="{{ route('admin.profile.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <td><span class="badge bg-info">{{ $item->key }}</span></td>

                    <td>
                        <input type="text" name="title" value="{{ $item->title }}" class="form-control">
                    </td>

                    <td>
                        <input type="text" name="description" value="{{ $item->description }}" class="form-control">
                    </td>

                    <td>
                        <input type="number" name="sequence" value="{{ $item->sequence }}" class="form-control">
                    </td>

                    <td class="text-center">
                        <input type="checkbox" name="active" {{ $item->active ? 'checked' : '' }}>
                    </td>

                    <td class="d-flex gap-1">

                        {{-- UPDATE --}}
                        <button class="btn btn-primary btn-sm">Update</button>
                </form>

                {{-- DELETE --}}
                <form action="{{ route('admin.profile.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>

                    </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- SCRIPT --}}
<script>
function ubahLabel() {
    let val = document.getElementById('kategori').value;

    if(val === 'struktur'){
        document.getElementById('labelTitle').innerText = 'Jabatan';
        document.getElementById('labelDesc').innerText = 'Nama';
    } else {
        document.getElementById('labelTitle').innerText = 'Judul';
        document.getElementById('labelDesc').innerText = 'Deskripsi';
    }
}
</script>

@endsection