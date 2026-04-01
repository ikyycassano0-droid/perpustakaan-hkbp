@extends('admin.component.main')

@section('title', 'Manajemen Koleksi')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Manajemen Koleksi</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- BUTTON TAMBAH --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Koleksi
    </button>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($collections as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        @if($item->cover_image)
                            <img src="{{ asset('storage/'.$item->cover_image) }}" width="60">
                        @endif
                    </td>

                    <td>{{ $item->title }}</td>
                    <td>{{ $item->author }}</td>
                    <td>{{ $item->publication_year }}</td>

                    <td>
                        {{-- EDIT --}}
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}">
                            Edit
                        </button>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.collection.delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- MODAL EDIT --}}
                <div class="modal fade" id="edit{{ $item->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <form action="{{ route('admin.collection.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5>Edit Koleksi</h5>
                                </div>

                                <div class="modal-body">

                                    <input type="text" name="title" class="form-control mb-2" value="{{ $item->title }}" placeholder="Title">
                                    <input type="text" name="author" class="form-control mb-2" value="{{ $item->author }}" placeholder="Author">
                                    <input type="text" name="publisher" class="form-control mb-2" value="{{ $item->publisher }}" placeholder="Publisher">
                                    <input type="number" name="publication_year" class="form-control mb-2" value="{{ $item->publication_year }}" placeholder="Year">

                                    <textarea name="description" class="form-control mb-2" placeholder="Description">{{ $item->description }}</textarea>

                                    {{-- 🔥 FIELD TAMBAHAN --}}
                                    <input type="text" name="responsibility_statement" class="form-control mb-2" value="{{ $item->responsibility_statement }}" placeholder="Responsibility Statement">
                                    <input type="text" name="content_type" class="form-control mb-2" value="{{ $item->content_type }}" placeholder="Content Type">
                                    <input type="text" name="media_type" class="form-control mb-2" value="{{ $item->media_type }}" placeholder="Media Type">
                                    <input type="text" name="carrier_type" class="form-control mb-2" value="{{ $item->carrier_type }}" placeholder="Carrier Type">

                                    <textarea name="specific_detail_info" class="form-control mb-2" placeholder="Specific Detail Info">{{ $item->specific_detail_info }}</textarea>

                                    <input type="file" name="cover_image" class="form-control mb-2">
                                    <input type="file" name="file_url" class="form-control mb-2">

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">Update</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.collection.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Koleksi</h5>
                </div>

                <div class="modal-body">

                    <input type="text" name="title" class="form-control mb-2" placeholder="Title">
                    <input type="text" name="author" class="form-control mb-2" placeholder="Author">
                    <input type="text" name="publisher" class="form-control mb-2" placeholder="Publisher">
                    <input type="number" name="publication_year" class="form-control mb-2" placeholder="Year">

                    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

                    {{-- 🔥 FIELD TAMBAHAN --}}
                    <input type="text" name="responsibility_statement" class="form-control mb-2" placeholder="Responsibility Statement">
                    <input type="text" name="content_type" class="form-control mb-2" placeholder="Content Type">
                    <input type="text" name="media_type" class="form-control mb-2" placeholder="Media Type">
                    <input type="text" name="carrier_type" class="form-control mb-2" placeholder="Carrier Type">

                    <textarea name="specific_detail_info" class="form-control mb-2" placeholder="Specific Detail Info"></textarea>

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

@endsection