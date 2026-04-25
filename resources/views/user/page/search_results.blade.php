@extends('user.component.main')

@section('title', 'Hasil Pencarian')

@section('user_content')

@php
    $isGuest = !auth()->check();
@endphp

<div class="container py-4">

    <h4>Hasil pencarian: "{{ $keyword }}"</h4>

    @if($results->count() == 0)
        <div class="alert alert-warning mt-3">
            Tidak ditemukan hasil.
        </div>
    @endif

    <div class="row mt-3">

        @foreach($results as $item)

            <div class="col-md-4 mb-3">

                <div class="card shadow-sm h-100 p-3">

                    <h5>{{ $item->title }}</h5>

                    {{-- 🔒 Badge Restricted --}}
                    @if(!empty($item->is_restricted))
                        <span class="badge bg-danger mb-2">🔒 Restricted</span>
                    @endif

                    @if($item->type == 'collection')

                        <span class="badge bg-primary mb-2">📚 Koleksi</span>

                        {{-- 🔒 CEK RESTRICT --}}
                        @if(!empty($item->is_restricted) && $isGuest)

                            <button class="btn btn-sm btn-secondary mt-2 restricted-btn">
                                🔒 Login untuk akses
                            </button>

                        @else

                            <a href="{{ url('/collections/'.$item->id) }}"
                               class="btn btn-sm btn-primary mt-2">
                               Lihat Detail
                            </a>

                        @endif

                    @else

                        <span class="badge bg-success mb-2">🎓 Final Project</span>

                        <a href="{{ asset('storage/'.$item->file_url) }}"
                           target="_blank"
                           class="btn btn-sm btn-success mt-2">
                           Download
                        </a>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection


{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener('click', function(e){

    if(e.target.classList.contains('restricted-btn')){
        Swal.fire({
            title: 'Login Diperlukan',
            text: 'Anda harus login terlebih dahulu untuk mengakses Koleksi Tercetak',
            icon: 'warning',
            confirmButtonText: 'Login'
        }).then(() => {
            window.location.href = "{{ route('login') }}";
        });
    }

});
</script>
