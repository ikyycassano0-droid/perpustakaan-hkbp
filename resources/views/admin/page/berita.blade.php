@extends('admin.component.main')
@section('title', 'Manajemen Berita')
@section('page-title', 'Data Berita')

@section('admin_content')

<div class="container">

    <h3>Manajemen Berita</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    {{-- ========================= --}}
    {{-- FORM TAMBAH --}}
    {{-- ========================= --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Berita</div>

        <div class="card-body">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-2">

                    <div class="col-md-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Excerpt</label>
                        <input type="text" name="excerpt" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Kategori</label>
                        <select name="category" class="form-control">
                            <option value="akademik">Akademik</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="riset">Riset</option>
                            <option value="fasilitas">Fasilitas</option>
                            <option value="sosial">Sosial</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label>Isi</label>
                        <textarea name="content" class="form-control"></textarea>
                    </div>

                    <div class="col-md-2 mt-2">
                        <label>Featured</label>
                        <select name="is_featured" class="form-control">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex align-items-end mt-2">
                        <button class="btn btn-success w-100">+</button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- ========================= --}}
    {{-- TABLE --}}
    {{-- ========================= --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">

            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Excerpt</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($berita as $item)
                <tr>

                    <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <td>
                            <input type="text" name="title" value="{{ $item->title }}" class="form-control">
                        </td>

                        <td>
                            <select name="category" class="form-control">
                                @foreach(['akademik','pengumuman','kegiatan','riset','fasilitas','sosial'] as $cat)
                                    <option value="{{ $cat }}" {{ $item->category==$cat?'selected':'' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="text" name="excerpt" value="{{ $item->excerpt }}" class="form-control">
                        </td>

                        <td>
                            <select name="status" class="form-control">
                                <option value="draft" {{ $item->status=='draft'?'selected':'' }}>Draft</option>
                                <option value="publish" {{ $item->status=='publish'?'selected':'' }}>Publish</option>
                            </select>
                        </td>

                        <td class="text-center">
                            @if($item->is_featured)
                                <span class="badge bg-warning">Featured</span>
                            @else
                                <span class="badge bg-secondary">Normal</span>
                            @endif
                        </td>

                        <td class="d-flex gap-1">
                            <button class="btn btn-primary btn-sm">Update</button>
                    </form>

                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST">
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

</div>

@endsection