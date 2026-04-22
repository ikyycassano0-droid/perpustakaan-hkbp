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
                        <textarea name="description" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="col-md-2">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-1">
                        <label>Urutan</label>
                        <input type="number" name="sequence" class="form-control">
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
                        <th>Kategori</th>
                        <th>Judul</th>
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
                                {{ strtoupper($item->key) }}
                            </span>
                        </td>

                        <td>{{ $item->title }}</td>

                        <td style="max-width: 250px;">
                            <div style="max-height: 60px; overflow-y:auto;" title="{{ $item->description }}">
                                {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                            </div>
                        </td>

                        <td>{{ $item->sequence }}</td>

                        <td class="text-center">
                            @if($item->active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                        <td class="d-flex gap-1">

                            {{-- EDIT BUTTON --}}
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

                    {{-- ========================= --}}
                    {{-- MODAL EDIT --}}
                    {{-- ========================= --}}
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

                                        <label>Deskripsi</label>
                                        <textarea name="description" class="form-control mb-2" rows="4">{!! $item->description !!}</textarea>

                                        <label>Urutan</label>
                                        <input type="number" name="sequence" value="{{ $item->sequence }}" class="form-control mb-2">

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
