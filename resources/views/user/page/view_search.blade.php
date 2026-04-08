@extends('user.component.main')

<header>
    @include('user.component.navbar')
</header>

@section('title', 'Hasil Pencarian')

@section('user_content')

<div class="container py-4">

    <h2 class="mb-3">Hasil Pencarian: "{{ $keyword }}"</h2>

    @if($results->isEmpty())
        <div class="alert alert-info">Tidak ada hasil ditemukan.</div>
    @else
        <div class="list-group">
            @foreach($results as $item)
                @php
                    // Tentukan type
                    $type = $item instanceof App\Models\Collection ? 'collection' : 'final_project';

                    // Route berdasarkan kategori
                    if($type === 'collection') {
                        switch(strtolower($item->category ?? '')) {
                            case 'jurnal': 
                                $route = route('user.koleksi.jurnal'); break;
                            case 'buku pengayaan': 
                                $route = route('user.koleksi.buku_pengayaan'); break;
                            case 'buku referensi': 
                                $route = route('user.koleksi.buku_referensi'); break;
                            case 'majalah': 
                                $route = route('user.koleksi.majalah'); break;
                            default: 
                                $route = route('user.koleksi.jurnal'); break;
                        }
                    } else {
                        // Final Project, route berdasarkan kategori
                        switch(strtolower($item->category ?? 'all')) {
                            case 'cd': $route = route('final_project.index', 'cd'); break;
                            case 'video': $route = route('final_project.index', 'video'); break;
                            case 'e-book': $route = route('final_project.index', 'e_book'); break;
                            case 'e-article': $route = route('final_project.index', 'e_article'); break;
                            default: $route = route('final_project.index', 'all'); break;
                        }
                    }

                    $showKeywords = $type === 'final_project';
                @endphp

                <a href="{{ $route }}"
                   class="list-group-item list-group-item-action search-link"
                   data-type="{{ $type }}"
                   data-guest="{{ $isGuest ? 1 : 0 }}">
                   
                   <strong>{{ $item->title }}</strong>
                   
                   @if($type == 'collection')
                       <span class="badge bg-primary">Koleksi Tercetak</span>
                   @else
                       <span class="badge bg-success">Koleksi Elektronik</span>
                   @endif

                   @if($showKeywords)
                       <p class="mb-0 text-muted" style="font-size:0.8rem;">
                           {{ $item->keywords ?? $item->description ?? '-' }}
                       </p>
                   @endif

                </a>
            @endforeach
        </div>
    @endif

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.search-link').forEach(link => {
    link.addEventListener('click', function(e){
        const isGuest = this.dataset.guest == '1';
        const type = this.dataset.type;

        // Guest hanya dibatasi untuk Koleksi Tercetak
        if(isGuest && type === 'collection'){
            e.preventDefault();

            Swal.fire({
                title: 'Harus Login',
                text: 'Anda harus login untuk melihat Koleksi Tercetak',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    });
});
</script>
@endsection