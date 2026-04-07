@extends('user.component.main')

@section('title', 'Pinjam Buku')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Pinjam Buku</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($collections as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">

                <img src="{{ asset('storage/'.$item->cover_image) }}" class="card-img-top" height="200">

                <div class="card-body">
                    <h5>{{ $item->title }}</h5>
                    <p>Stock: {{ $item->stock }}</p>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="collection_id" value="{{ $item->id }}">

                        <div class="mb-2">
                            <label>Tanggal Pinjam</label>
                            <input type="date" name="order_date" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Tanggal Kembali</label>
                            <input type="date" name="return_date" class="form-control" required>
                        </div>

                        @if($item->stock > 0)
                            <button class="btn btn-primary w-100">Pinjam</button>
                        @else
                            <button class="btn btn-secondary w-100" disabled>Stok Habis</button>
                        @endif
                    </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection