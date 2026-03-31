@extends('admin.component.main')
@section('title', 'Manajemen Berita')
@section('page-title', 'Data Berita')

@section('admin_content')
<div class="container">

    <h3>Manajemen Berita</h3>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ========================= --}}
    {{-- TAMBAH BERITA --}}
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

                    <div class="col-md-4">
                        <label>Isi Berita</label>
                        <textarea name="content" id="editor" class="form-control"></textarea>
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

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100">+</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TABEL BERITA --}}
    {{-- ========================= --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($berita as $item)
                <tr>

                    {{-- UPDATE --}}
                    <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <td>
                            <input type="text" name="title" value="{{ $item->title }}" class="form-control">
                        </td>

                        <td style="max-width:250px;">
                            <textarea name="content" class="form-control" rows="2">{!! $item->content !!}</textarea>
                        </td>

                        <td class="text-center">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" width="80" class="mb-1">
                            @endif
                            <input type="file" name="image" class="form-control">
                        </td>

                        <td>
                            <select name="status" class="form-control">
                                <option value="draft" {{ $item->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="publish" {{ $item->status == 'publish' ? 'selected' : '' }}>Publish</option>
                            </select>

                            {{-- Badge --}}
                            <div class="mt-1 text-center">
                                @if($item->status == 'publish')
                                    <span class="badge bg-success">Publish</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                        </td>

                        <td class="d-flex gap-1">
                            <button class="btn btn-primary btn-sm">Update</button>
                    </form>

                    {{-- DELETE --}}
                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
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