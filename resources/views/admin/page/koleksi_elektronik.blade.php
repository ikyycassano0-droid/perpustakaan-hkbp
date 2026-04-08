@extends('admin.component.main')

@section('title', 'Koleksi Elektronik')

@section('admin_content')
<div class="container py-4">

    <h2 class="mb-4">Manajemen Koleksi Elektronik</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Data
    </button>

    <!-- Tabel Koleksi -->
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Judul</th>
                <th>Tanggal Upload</th>
                <th>Jenis Koleksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    @php
                        switch($item->category_target){
                            case 'ebook': $badge='bg-primary'; break;
                            case 'e-article': $badge='bg-info text-dark'; break;
                            case 'cd': $badge='bg-warning text-dark'; break;
                            case 'video': $badge='bg-success'; break;
                            default: $badge='bg-secondary';
                        }
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($item->category_target) }}</span>
                </td>
                <td class="d-flex gap-1">
                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.koleksi_elektronik.delete', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $item->id }}">
                <div class="modal-dialog">
                    <form action="{{ route('admin.koleksi_elektronik.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content p-3">
                            <h5>Edit Koleksi</h5>

                            <input type="text" name="title" class="form-control mb-2" value="{{ $item->title }}" placeholder="Judul" required>
                            <textarea name="abstract" class="form-control mb-2" placeholder="Ringkasan singkat (abstract)">{{ $item->abstract }}</textarea>

                            <select name="category_target" class="form-control mb-2" required>
                                <option value="">Pilih Jenis Koleksi</option>
                                <option value="ebook" {{ $item->category_target=='ebook' ? 'selected':'' }}>E-book</option>
                                <option value="e-article" {{ $item->category_target=='e-article' ? 'selected':'' }}>E-article</option>
                                <option value="cd" {{ $item->category_target=='cd' ? 'selected':'' }}>CD</option>
                                <option value="video" {{ $item->category_target=='video' ? 'selected':'' }}>Video</option>
                            </select>

                            <input type="file" name="file_url" class="form-control mb-2">
                            <small>Format: pdf, mp3, mp4, docx</small>

                            <button class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('admin.koleksi_elektronik.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content p-3">
                <h5>Tambah Koleksi</h5>

                <input type="text" name="title" class="form-control mb-2" placeholder="Judul" required>
                <textarea name="abstract" class="form-control mb-2" placeholder="Ringkasan singkat (abstract)"></textarea>

                <select name="category_target" class="form-control mb-2" required>
                    <option value="">Pilih Jenis Koleksi</option>
                    <option value="ebook">E-book</option>
                    <option value="e-article">E-article</option>
                    <option value="cd">CD</option>
                    <option value="video">Video</option>
                </select>

                <input type="file" name="file_url" class="form-control mb-2" required>
                <small>Format: pdf, mp3, mp4, docx</small>

                <button class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection