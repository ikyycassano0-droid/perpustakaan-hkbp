@extends('guest.component.main')

@section('guest_content')

@include('guest.component.navbar')

<div class="page-header">
    <h1>Tugas, Fungsi & Tujuan</h1>
    <p>Peran Strategis Perpustakaan dalam Pendidikan Keperawatan HKBP</p>
</div>

<div class="container">

    {{-- TUGAS --}}
    <div class="section-box">
        <h2><i class="fas fa-tasks"></i> Tugas Pokok</h2>

        @forelse($tugas as $item)
        <div class="item">
            <i class="fas fa-check-circle"></i>
            <p>{{ $item->description }}</p>
        </div>
        @empty
        <p>Data tugas belum tersedia.</p>
        @endforelse

    </div>

    {{-- FUNGSI --}}
    <div class="section-box">
        <h2><i class="fas fa-cogs"></i> Fungsi</h2>

        @forelse($fungsi as $item)
        <div class="item">
            <i class="fas fa-check-circle"></i>
            <p>{{ $item->description }}</p>
        </div>
        @empty
        <p>Data fungsi belum tersedia.</p>
        @endforelse

    </div>

    {{-- TUJUAN --}}
    <div class="section-box">
        <h2><i class="fas fa-bullseye"></i> Tujuan</h2>

        @forelse($tujuan as $item)
        <div class="item">
            <i class="fas fa-check-circle"></i>
            <p>{{ $item->description }}</p>
        </div>
        @empty
        <p>Data tujuan belum tersedia.</p>
        @endforelse

    </div>

    <a href="/" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

</div>

@include('guest.component.footer')

@endsection