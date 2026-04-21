@extends('user.component.main')
<header>
  @include('user.component.navbar')
</header>

@section('title', 'Koleksi Elektronik - Video')

@section('user_content')
<div class="container py-4">
    <h2 class="mb-4">Video</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Daftar Video</div>
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
                            @php
                                $file = asset('storage/'.$item->file_url);
                                $ext = strtolower(pathinfo($item->file_url, PATHINFO_EXTENSION));
                            @endphp

                            {{-- Preview --}}
                            @if($ext == 'mp4')
                                <video width="250" controls class="mb-2">
                                    <source src="{{ $file }}" type="video/mp4">
                                </video>

                            @elseif($ext == 'mp3')
                                <audio controls class="mb-2">
                                    <source src="{{ $file }}" type="audio/mpeg">
                                </audio>

                            @elseif($ext == 'pdf')
                                <iframe src="{{ $file }}" width="250" height="150" class="mb-2"></iframe>

                            @elseif($ext == 'docx')
                                {{-- DOCX tidak bisa preview --}}
                                <span>Dokumen tersedia</span>

                            @else
                                <span>File tersedia</span>
                            @endif

                            <br>

                            {{-- Tombol aksi --}}
                            <a href="{{ $file }}" target="_blank">Lihat</a>

                            @auth
                                | <a href="{{ route('final_project.download', $item->id) }}">Download</a>
                            @endauth

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
