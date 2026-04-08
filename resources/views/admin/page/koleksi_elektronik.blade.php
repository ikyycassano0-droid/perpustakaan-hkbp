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
                <th>Mahasiswa</th>
                <th>Kategori / Tujuan CRUD</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->student_name }} <br><small>{{ $item->study_program }} | {{ $item->npm }}</small></td>
                <td>
                    @if($item->category)
                        @php
                            switch(strtolower($item->category->name)) {
                                case 'ebook': $badge = 'bg-primary'; break;
                                case 'e-article': $badge = 'bg-info text-dark'; break;
                                case 'cd': $badge = 'bg-warning text-dark'; break;
                                case 'video': $badge = 'bg-success'; break;
                                case 'kti': $badge = 'bg-danger'; break;
                                default: $badge = 'bg-secondary';
                            }
                        @endphp
                        <a href="{{ $item->category_target ?? '#' }}">
                            <span class="badge {{ $badge }}">{{ $item->category->name }}</span>
                        </a>
                    @else
                        <span class="badge bg-secondary">-</span>
                    @endif
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
                            <h5>Edit Data</h5>
                            <input type="text" name="student_name" class="form-control mb-2" value="{{ $item->student_name }}" required>
                            <input type="text" name="npm" class="form-control mb-2" value="{{ $item->npm }}" required>
                            <input type="text" name="study_program" class="form-control mb-2" value="{{ $item->study_program }}" required>
                            <input type="text" name="title" class="form-control mb-2" value="{{ $item->title }}" required>

                            <select name="category_final_project_id" class="form-control mb-2" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $item->category_final_project_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="category_target" class="form-control mb-2" required>
                                <option value="">Pilih Menu Tujuan CRUD</option>
                                <option value="{{ url('/koleksi/ebook') }}" {{ $item->category_target == url('/koleksi/ebook') ? 'selected' : '' }}>E-book</option>
                                <option value="{{ url('/koleksi/e-article') }}" {{ $item->category_target == url('/koleksi/e-article') ? 'selected' : '' }}>E-article</option>
                                <option value="{{ url('/koleksi/cd') }}" {{ $item->category_target == url('/koleksi/cd') ? 'selected' : '' }}>CD</option>
                                <option value="{{ url('/koleksi/video') }}" {{ $item->category_target == url('/koleksi/video') ? 'selected' : '' }}>Video</option>
                                <option value="{{ url('/koleksi/kti') }}" {{ $item->category_target == url('/koleksi/kti') ? 'selected' : '' }}>KTI</option>
                            </select>

                            <input type="file" name="file_url" class="form-control mb-2">

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
                <h5>Tambah Data</h5>

                <input type="text" name="student_name" class="form-control mb-2" placeholder="Nama Mahasiswa" required>
                <input type="text" name="npm" class="form-control mb-2" placeholder="NPM" required>
                <input type="text" name="study_program" class="form-control mb-2" placeholder="Prodi" required>
                <input type="text" name="title" class="form-control mb-2" placeholder="Judul" required>

                <select name="category_final_project_id" class="form-control mb-2" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="category_target" class="form-control mb-2" required>
                    <option value="">Pilih Menu Tujuan CRUD</option>
                    <option value="{{ url('/koleksi/ebook') }}">E-book</option>
                    <option value="{{ url('/koleksi/e-article') }}">E-article</option>
                    <option value="{{ url('/koleksi/cd') }}">CD</option>
                    <option value="{{ url('/koleksi/video') }}">Video</option>
                    <option value="{{ url('/koleksi/kti') }}">KTI</option>
                </select>

                <input type="file" name="file_url" class="form-control mb-2">

                <button class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection