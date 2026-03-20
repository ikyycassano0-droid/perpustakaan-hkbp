@extends('user.component.main')

@section('user_content')
    <header>
      @include('user.component.navbar')
    </header>
  <div class="page-header">
        <h1>Jaringan Kerjasama</h1>
        <p>Kemitraan Perpustakaan dengan Institusi Nasional & Internasional</p>
    </div>
    <div class="container">
        <div class="partner-grid">
            <div class="partner-card"><i class="fas fa-university"></i><br><span class="tag">Institusi</span><h3>Perpustakaan Nasional RI</h3><p>Kerjasama akses e-resources dan ISBN.</p></div>
            <div class="partner-card"><i class="fas fa-hospital"></i><br><span class="tag">Kesehatan</span><h3>RS HKBP Balige</h3><p>Penyediaan referensi klinis bagi tenaga medis.</p></div>
            <div class="partner-card"><i class="fas fa-book"></i><br><span class="tag">Penerbit</span><h3>EGC Medical Publisher</h3><p>Pengadaan buku-buku keperawatan original.</p></div>
            <div class="partner-card"><i class="fas fa-network-wired"></i><br><span class="tag">Jaringan</span><h3>APTIK</h3><p>Asosiasi Perguruan Tinggi Katolik & Kristen.</p></div>
        </div>
        <br>
        <a href="guest.html" style="color: #021e69; font-weight: bold; text-decoration: none;"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    
  
    <footer>
      @include('user.component.footer')
    </footer>