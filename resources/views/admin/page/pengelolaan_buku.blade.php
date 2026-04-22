@extends('admin.component.main')

@section('title', 'Pengelolaan Peminjaman Buku')

@section('admin_content')
<div class="container py-4">

    <h2 class="mb-4">Pengelolaan Peminjaman Buku</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @foreach($order->details as $detail)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $detail->collection->title }}</td>
                    <td>{{ $detail->collection->location->name ?? '-' }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_date->format('d-m-Y') }}</td>
                    <td>{{ $order->return_date->format('d-m-Y') }}</td>
                    <td>{{ number_format($order->fine ?? 0) }}</td>
                    <td>
                        @if($order->status === 'PENDING')
                            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @elseif($order->status === 'APPROVED')
                            <form action="{{ route('admin.orders.return', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-primary btn-sm">Return</button>
                            </form>
                            <form action="{{ route('admin.orders.extend', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-sm">Extend +7d</button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</div>
@endsection
