@extends('guest.component.main')

@section('title', 'Berita')

@section('guest_content')

<header>
    @include('guest.component.navbar')
</header>

<div class="container py-4">

    <h2 class="mb-4 text-center">Berita Terbaru</h2>

    <div class="row">

        @forelse($berita as $item)
        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm">

                {{-- GAMBAR --}}
                @if($item->image)
                    <img src="{{ asset('storage/'.$item->image) }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">
                @endif

                <div class="card-body d-flex flex-column">

                    {{-- JUDUL --}}
                    <h5 class="card-title">{{ $item->title }}</h5>

                    {{-- TANGGAL --}}
                    <small class="text-muted mb-2">
                        {{ $item->created_at->format('d M Y') }}
                    </small>
                    <p class="card-text">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}
                    </p>

                    {{-- BUTTON --}}
                    <a href="{{ route('guest.berita.show', $item->id) }}"
                       class="btn btn-primary mt-auto">
                        Baca Selengkapnya
                    </a>

                </div>

            </div>

        </div>
        @empty
        <div class="col-12 text-center">
            <p>Belum ada berita tersedia</p>
        </div>
        @endforelse

    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $berita->links() }}
    </div>

</div>

@endsection