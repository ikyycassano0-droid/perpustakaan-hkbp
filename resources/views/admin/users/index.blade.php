@extends('admin.dashboard')

@push('css')
<style>
    /* Hero Header Style */
    .hero-header {
        position: relative;
        background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1200&q=80'); /* Gambar Perpustakaan Estetik */
        background-size: cover;
        background-position: center;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(2, 30, 105, 0.2);
    }

    .hero-overlay {
        background: linear-gradient(90deg, rgba(2, 30, 105, 0.9) 0%, rgba(2, 30, 105, 0.6) 100%);
        padding: 50px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .hero-text h1 {
        font-weight: 800;
        font-size: 2.2rem;
        letter-spacing: -1px;
        margin-bottom: 5px;
    }

    .hero-text p {
        opacity: 0.9;
        font-size: 1.1rem;
        max-width: 500px;
    }

    .btn-create {
        background-color: var(--accent);
        color: var(--primary) !important;
        font-weight: 700;
        padding: 12px 25px;
        border-radius: 50px;
        transition: 0.3s;
        border: none;
        box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4);
    }

    .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(241, 196, 15, 0.5);
    }

    /* Statistik Mengapung (Floating Stats) */
    .stat-badge {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        margin-top: 15px;
    }

    /* Styling Table Custom */
    .table-card {
        border-radius: 20px !important;
        margin-top: -20px; /* Membuat table agak masuk ke area hero */
        z-index: 10;
        position: relative;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- HERO HEADER SECTION -->
    <div class="hero-header">
        <div class="hero-overlay">
            <div class="hero-text">
                <h1>Manajemen Anggota</h1>
                <p>Pusat kendali data akademisi, kelola informasi Dosen dan Mahasiswa dengan presisi medis.</p>
                <div class="stat-badge">
                    <i class="fas fa-users mr-2 text-warning"></i>
                    <span class="font-weight-bold">{{ $users->count() }} Total Anggota Terdaftar</span>
                </div>
            </div>
            <div class="hero-action d-none d-md-block">
                <a href="{{ route('admin.users.create') }}" class="btn btn-create">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Anggota Baru
                </a>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- DATA TABLE SECTION -->
    <div class="card table-card shadow-lg border-0">
        <div class="card-header bg-white py-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Database Anggota Aktif</h5>
                <div class="d-md-none"> <!-- Tombol muncul di mobile saja karena di hero sudah ada -->
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary">
                            <th class="border-0 px-4 py-3">ANGGOTA</th>
                            <th class="border-0 py-3">TIPE</th>
                            <th class="border-0 py-3">NPM / NIDN</th>
                            <th class="border-0 py-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=021e69&color=fff' }}" 
                                         class="rounded-circle mr-3 shadow-sm" width="48" height="48" 
                                         style="object-fit: cover; border: 2px solid white;">
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                        <div class="text-muted small"><i class="fas fa-phone-alt mr-1" style="font-size: 0.7rem;"></i> {{ $user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($user->role_id == 2)
                                    <span class="badge badge-info px-3 py-2" style="border-radius: 50px; font-weight: 600;">
                                        <i class="fas fa-user-md mr-1"></i> Dosen
                                    </span>
                                @else
                                    <span class="badge badge-success px-3 py-2" style="border-radius: 50px; font-weight: 600;">
                                        <i class="fas fa-user-graduate mr-1"></i> Mahasiswa
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle font-weight-bold text-primary">
                                {{ $user->role_id == 2 ? $user->nidn : $user->npm }}
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-warning btn-sm border-0 rounded-circle mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.users.print', $user->id) }}" target="_blank" class="btn btn-outline-info btn-sm border-0 rounded-circle mx-1" title="Cetak Kartu"><i class="fas fa-id-card"></i></a>
                                    
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm border-0 rounded-circle mx-1" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Footer Table untuk kesan estetik -->
            <div class="card-footer bg-white text-center py-3 border-top-0">
                <small class="text-muted italic">Menampilkan seluruh basis data perpustakaan AKPER HKBP secara real-time.</small>
            </div>
        </div>
    </div>
</div>
@endsection