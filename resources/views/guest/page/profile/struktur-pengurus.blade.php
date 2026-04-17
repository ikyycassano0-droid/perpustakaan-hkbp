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
        @php
            $kepala = $struktur->first();
        @endphp

        <div class="member-card" style="text-align:center;">
            @if($kepala->image)
                <img src="{{ asset('storage/' . $kepala->image) }}" width="100" class="mb-2">
            @endif
            <div class="role">{{ $kepala->title }}</div>
            <div class="name">{{ $kepala->description }}</div>
        </div>

        <div class="tree-line" style="width:2px; height:40px; background:#ccc; margin:10px auto;"></div>

        {{-- Anggota lain --}}
        <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">

            @foreach($struktur->skip(1) as $item)
                <div class="member-card" style="text-align:center;">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" width="100" class="mb-2">
                    @endif
                    <div class="role">{{ $item->title }}</div>
                    <div class="name">{{ $item->description }}</div>
                </div>
            @endforeach

        </div>

    @else

        <p style="text-align:center;">Data struktur organisasi belum tersedia.</p>

    @endif

    <br><br>

    <a href="/" style="color:#021e69;font-weight:bold;text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

</div>

@endsection