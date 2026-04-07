@extends('admin.component.main')

@section('title', 'Pengelolaan Buku')

@section('admin_content')
<div class="container py-4">

    <h2 class="mb-4">Pengelolaan Buku</h2>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ================= TAMBAH BUKU ================= --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Buku</div>
        <div class="card-body">

            <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-2">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Author</label>
                        <input type="text" name="author[]" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Publisher</label>
                        <input type="text" name="publisher" class="form-control">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Tahun</label>
                        <input type="number" name="publication_year" class="form-control">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Location</label>
                        <select name="location_id" class="form-control">
                            <option value="">-- pilih --</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Cover</label>
                        <input type="file" name="cover_image" class="form-control">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>File</label>
                        <input type="file" name="file_url" class="form-control">
                    </div>

                </div>

                <button class="btn btn-primary mt-2">Simpan</button>
            </form>

        </div>
    </div>

    {{-- ================= DATA KOLEKSI ================= --}}
    <h4>Data Buku</h4>

    <table class="table table-bordered mb-5">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Judul</th>
                <th>Stock</th>
                <th>Publisher</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collections as $item)
            <tr>
                <td>
                    @if($item->cover_image)
                        <img src="{{ asset('storage/'.$item->cover_image) }}" width="60">
                    @endif
                </td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->publisher }}</td>
                <td>{{ $item->publication_year }}</td>
                <td>
                    <form action="{{ route('collections.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ================= DATA PEMINJAMAN ================= --}}
    <h4>Data Peminjaman</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->user->name ?? '-' }}</td>

                <td>
                    @foreach($order->details as $d)
                        {{ $d->collection->title }} <br>
                    @endforeach
                </td>

                <td>{{ $order->order_date }}</td>
                <td>{{ $order->return_date }}</td>

                <td>
                    @if($order->status == 'PENDING')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($order->status == 'APPROVED')
                        <span class="badge bg-success">Approved</span>
                    @elseif($order->status == 'REJECTED')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-primary">Returned</span>
                    @endif
                </td>

                <td>Rp {{ number_format($order->fine) }}</td>

                <td>
                    @if($order->status == 'PENDING')
                        <a href="{{ route('orders.approve', $order->id) }}" class="btn btn-success btn-sm">Approve</a>
                        <a href="{{ route('orders.reject', $order->id) }}" class="btn btn-danger btn-sm">Reject</a>
                    @endif

                    @if($order->status == 'APPROVED')
                        <a href="{{ route('orders.return', $order->id) }}" class="btn btn-primary btn-sm">Return</a>
                        <a href="{{ route('orders.extend', $order->id) }}" class="btn btn-warning btn-sm">Extend</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection