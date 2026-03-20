@extends('guest.component.main')

@section('guest_content')

@include('guest.component.navbar')

<div class="page-banner">
    <h1>Visi & Misi</h1>
    <p>Arah dan Tujuan Strategis Perpustakaan AKPER HKBP</p>
</div>

<div class="container">

    {{-- VISI --}}
    <div class="card">
        <h2>Visi</h2>

        @if($visi)
            <p style="font-size: 1.2rem; font-style: italic; line-height: 1.8;">
                "{{ $visi->description }}"
            </p>
        @else
            <p>Visi belum tersedia.</p>
        @endif

    </div>

    {{-- MISI --}}
    <div class="card">
        <h2>Misi</h2>

        <ul class="misi-list">
            @forelse($misi as $index => $item)
                <li>
                    {{ $index + 1 }}. {{ $item->description }}
                </li>
            @empty
                <li>Misi belum tersedia.</li>
            @endforelse
        </ul>

        <a href="/" class="btn-back home-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

</div>

@endsection