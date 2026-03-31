@extends('guest.component.main')

@section('guest_content')

@include('guest.component.navbar')

<div class="page-banner">
    <h1>Struktur Organisasi</h1>
    <p>Pengelola Perpustakaan AKPER HKBP</p>
</div>

<div class="container">

    @if($struktur->count() > 0)

        {{-- Kepala Perpustakaan --}}
            <div class="member-card">
            @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" width="100" class="mb-2">
            @endif
            <div class="role">{{ $struktur[0]->title }}</div>
            <div class="name">{{ $struktur[0]->description }}</div>
        </div>

        <div class="tree-line"></div>

        {{-- Anggota lain --}}
        <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">

            @foreach($struktur->skip(1) as $item)
                <div class="member-card">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" width="100" class="mb-2">
                    @endif
                <div class="role">{{ $item->title }}</div>
                <div class="name">{{ $item->description }}</div>
            </div>
            @endforeach

        </div>

    @else

        <p>Data struktur organisasi belum tersedia.</p>

    @endif

    <br><br>

    <a href="/" style="color:#021e69;font-weight:bold;text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

</div>

@endsection