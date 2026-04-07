@extends('user.component.main')
    <header>
      @include('user.component.navbar')
    </header>
@section('title', 'Jurnal')

@section('user_content')
<div class="container py-4">
    <h2 class="mb-4">Jurnal</h2>

    @if($collections->isEmpty())
        <div class="alert alert-info">Belum ada data jurnal.</div>
    @endif

    <div class="row">
        @foreach($collections as $item)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($item->cover_image)
                    <img src="{{ asset('storage/'.$item->cover_image) }}" class="card-img-top" alt="{{ $item->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text"><strong>Author:</strong> {{ $item->author_string }}</p>
                    <p class="card-text"><strong>Tahun:</strong> {{ $item->publication_year }}</p>
                    @if($item->publisher)
                        <p class="card-text"><strong>Publisher:</strong> {{ $item->publisher }}</p>
                    @endif
                    @if($item->description)
                        <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                    @endif
                </div>
                @if($item->file_url)
                    <div class="card-footer">
                        <a href="{{ asset('storage/'.$item->file_url) }}" target="_blank" class="btn btn-sm btn-primary w-100">Download</a>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection