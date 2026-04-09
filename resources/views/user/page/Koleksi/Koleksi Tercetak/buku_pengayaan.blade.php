@extends('user.component.main')
    <header>
      @include('user.component.navbar')
    </header>
@section('title', 'Buku Pengayaan')

@section('user_content')
<div class="container py-5">
    <h2 class="mb-4 text-primary border-bottom border-warning d-inline-block pb-2">Buku Pengayaan</h2>

    @if($collections->isEmpty())
        <div class="alert alert-info">Belum ada data buku pengayaan.</div>
    @endif

    <div class="row">
        @foreach($collections as $item)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                @if($item->cover_image)
                    <img src="{{ asset('storage/'.$item->cover_image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('assets/img/placeholder.png') }}" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary">{{ $item->title }}</h5>
                    <p class="card-text mb-1"><strong>Author:</strong> {{ $item->author_string }}</p>
                    <p class="card-text mb-1"><strong>Tahun:</strong> {{ $item->publication_year ?? '-' }}</p>
                    @if($item->publisher)
                        <p class="card-text mb-1"><strong>Publisher:</strong> {{ $item->publisher }}</p>
                    @endif
                    @if($item->location)
                        <p class="card-text mb-2"><strong>Lokasi:</strong> {{ $item->location->name }}</p>
                    @endif
                    @if($item->description)
                        <p class="card-text text-truncate">{{ Str::limit($item->description, 80) }}</p>
                    @endif
                    <div class="mt-auto d-flex gap-2">
                        @if($item->file_url)
                            <a href="{{ asset('storage/'.$item->file_url) }}" target="_blank" class="btn btn-sm btn-outline-primary flex-fill">Download</a>
                        @endif
                        <a href="{{ route('user.pinjam') }}?collection_id={{ $item->id }}" class="btn btn-sm btn-warning text-white flex-fill">Pinjam</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection