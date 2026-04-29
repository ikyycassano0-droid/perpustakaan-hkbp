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

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>User</th>
                    <th>Buku</th>
                    <th>Status</th>
                    <th>Order Info</th>
                    <th>Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Denda</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>

                    {{-- USER --}}
                    <td>
                        <strong>{{ $order->user->name }}</strong>
                    </td>

                    {{-- BUKU --}}
                    <td>
                        @foreach($order->details as $detail)
                            <span class="badge bg-secondary mb-1 d-block text-start">
                                {{ $detail->collection->title }}
                                <small class="text-light">
                                    ({{ $detail->collection->location->name ?? '-' }})
                                </small>
                            </span>
                        @endforeach
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($order->status == 'PENDING')
                            <span class="badge bg-warning text-dark">PENDING</span>
                        @elseif($order->status == 'APPROVED')
                            <span class="badge bg-primary">APPROVED</span>
                        @elseif($order->status == 'REJECTED')
                            <span class="badge bg-danger">REJECTED</span>
                        @else
                            <span class="badge bg-success">RETURNED</span>
                        @endif
                    </td>

                    {{-- ORDER INFO --}}
                    <td>
                        <small class="text-muted">
                            Order: {{ $order->order_date?->format('d-m-Y') ?? '-' }} <br>
                            ID: #{{ $order->id }}
                        </small>
                    </td>

                    {{-- BORROW DATE --}}
                    <td>
                        <span class="text-primary fw-semibold">
                            {{ $order->borrow_date?->format('d-m-Y') ?? '-' }}
                        </span>
                    </td>

                    {{-- DUE DATE --}}
                    <td>
                        @if($order->due_date)
                            <span class="{{ $order->is_late ? 'text-danger fw-bold' : 'text-dark' }}">
                                {{ $order->due_date->format('d-m-Y') }}
                            </span>

                            <br>

                            @php
                                $borrow = \Carbon\Carbon::parse($order->borrow_date);
                                $due = \Carbon\Carbon::parse($order->due_date);
                                $diff = $borrow->diffInDays($due);
                            @endphp

                            <small class="text-muted">
                                Durasi: {{ $diff }} hari
                                @if($diff > 7)
                                    <span class="text-danger">(INVALID)</span>
                                @endif
                            </small>
                        @else
                            -
                        @endif
                    </td>

                    {{-- DENDA --}}
                    <td>
                        <span class="text-danger fw-semibold">
                            Rp {{ number_format($order->fine ?? 0) }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td>

                        {{-- PENDING --}}
                        @if($order->status === 'PENDING')

                            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>

                        {{-- APPROVED --}}
                        @elseif($order->status === 'APPROVED')

                            <form action="{{ route('admin.orders.return', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-primary btn-sm">Return</button>
                            </form>

                            <form action="{{ route('admin.orders.extend', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-sm">Extend</button>
                            </form>

                        @else
                            <span class="text-muted">Selesai</span>
                        @endif

                    </td>

                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection