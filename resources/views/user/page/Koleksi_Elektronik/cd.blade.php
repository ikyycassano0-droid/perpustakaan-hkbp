@extends('user.component.main')
    <header>
      @include('user.component.navbar')
    </header>
@section('title', 'Koleksi Elektronik - CD')

@section('user_content')
<div class="container py-4">
    <h2 class="mb-4">CD</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Table Data --}}
    <div class="card">
        <div class="card-header">Daftar CD</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Abstract</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->abstract ?? '-' }}</td>
                            <td>
                                @if($item->file_url)
                                    <a href="{{ asset('storage/'.$item->file_url) }}" target="_blank">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada karya tulis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection