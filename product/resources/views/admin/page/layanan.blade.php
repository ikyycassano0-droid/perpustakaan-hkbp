@extends('admin.component.main')
@section('title', 'Manajemen Layanan')
@section('page-title', 'Data Layanan')

@section('admin_content')

<div class="container">

    <h3 class="mb-3">Manajemen Layanan</h3>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ========================= --}}
    {{-- FORM TAMBAH --}}
    {{-- ========================= --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Tambah Data</div>

        <div class="card-body">
            <form action="{{ route('admin.layanan.store') }}" method="POST">
                @csrf

                <div class="row g-2">

                    <div class="col-md-3">
                        <label>Kategori</label>
                        <select name="category" class="form-control" required>
                            <option value="pinjam_buku">Pinjam Buku</option>
                            <option value="waktu_layanan">Waktu Layanan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-2">
                        <label>Urutan</label>
                        <input type="number" name="sequence" class="form-control" min="1" required>
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
        <div class="card-header bg-dark text-white">Data Layanan</div>

        <div class="card-body table-responsive">


            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kategori</th>
                        <th>Urutan</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $category => $items)

                    <tr style="background:#f1f1f1;">
                        <td colspan="5">
                            <strong>{{ strtoupper(str_replace('_',' ', $category)) }}</strong>
                        </td>
                    </tr>

                    @foreach($items as $item)
                    <tr>

                        <td>
                            <span class="badge bg-info text-dark">
                                {{ strtoupper($item->category) }}
                            </span>
                        </td>

                        <td style="font-size:20px; color:red;">
                            {{ $item->sequence }}
                        </td>

                        <td>{{ $item->title }}</td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                        </td>

                        <td class="d-flex gap-1">

                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $item->id }}">
                                Edit
                            </button>

                            <form action="{{ route('admin.layanan.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>

                        </td>

                    </tr>

                    {{-- 🔥 MODAL HARUS ADA DI SINI --}}
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.layanan.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5>Edit Layanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <label>Judul</label>
                                        <input type="text" name="title" value="{{ $item->title }}" class="form-control mb-2">

                                        <label>Deskripsi</label>
                                        <textarea name="description" class="form-control mb-2">{{ $item->description }}</textarea>

                                        <label>Kategori</label>
                                        <select name="category" class="form-control mb-2">
                                            <option value="">-- Tidak diubah --</option>
                                            <option value="pinjam_buku" {{ $item->category=='pinjam_buku'?'selected':'' }}>Pinjam Buku</option>
                                            <option value="waktu_layanan" {{ $item->category=='waktu_layanan'?'selected':'' }}>Waktu Layanan</option>
                                        </select>

                                        <label>Urutan</label>
                                        <input type="number" name="sequence" value="{{ $item->sequence }}" class="form-control">

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

                    @endforeach

                    </tbody>
            </table>

        </div>
    </div>

</div>

@endsection
