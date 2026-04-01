@extends('guest.component.main')

@section('title', $berita->title)

@section('guest_content')

<div class="container py-4">

    <h2>{{ $berita->title }}</h2>

    <p class="text-muted">
        {{ $berita->created_at->format('d M Y') }}
    </p>

    @if($berita->image)
        <img src="{{ asset('storage/'.$berita->image) }}" 
             class="img-fluid mb-3" 
             style="max-height:400px; object-fit:cover;">
    @endif

    <div>
        {!! $berita->content !!}
    </div>

    <a href="{{ route('guest.berita.index') }}" class="btn btn-secondary mt-3">
        Kembali
    </a>

</div>

@endsection