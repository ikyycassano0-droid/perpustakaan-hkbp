@extends('admin.component.main')
@section('title', 'Dashboard - Perpustakaan HKBP')

@section('page-title', 'Dashboard Overview')

@section('admin_content')
<!-- Welcome Banner -->
<div class="welcome-card">
    <div>
        <h1>Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}! 👋</h1>
        <p>Selamat datang di dashboard manajemen Perpustakaan AKPER HKBP. Kelola perpustakaan dengan lebih mudah dan efisien.</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Anggota</div>
                    <div class="stat-value">1,284</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 12.5% dari bulan lalu
                    </div>
                </div>
                <div class="stat-icon" style="background: rgba(46, 139, 86, 0.1); color: #2E8B57;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Koleksi Buku</div>
                    <div class="stat-value">5,892</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 8.3% dari bulan lalu
                    </div>
                </div>
                <div class="stat-icon" style="background: rgba(46, 139, 86, 0.1); color: #2E8B57;">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Peminjaman Aktif</div>
                    <div class="stat-value">234</div>
                    <div class="stat-change negative">
                        <i class="fas fa-clock"></i> 18 akan jatuh tempo
                    </div>
                </div>
                <div class="stat-icon" style="background: rgba(46, 139, 86, 0.1); color: #2E8B57;">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Pengunjung Hari Ini</div>
                    <div class="stat-value">147</div>
                    <div class="stat-change positive">
                        <i class="fas fa-chart-line"></i> +23 dari kemarin
                    </div>
                </div>
                <div class="stat-icon" style="background: rgba(46, 139, 86, 0.1); color: #2E8B57;">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-header">
                <h5><i class="fas fa-chart-line me-2"></i> Statistik Peminjaman & Pengembalian</h5>
                <i class="fas fa-ellipsis-h"></i>
            </div>
            <canvas id="loanChart" height="280"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-header">
                <h5><i class="fas fa-chart-pie me-2"></i> Kategori Buku</h5>
                <i class="fas fa-ellipsis-h"></i>
            </div>
            <canvas id="categoryChart" height="280"></canvas>
        </div>
    </div>
</div>

<!-- Second Row Charts -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="chart-card">
            <div class="chart-header">
                <h5><i class="fas fa-chart-bar me-2"></i> Tren Kunjungan Mingguan</h5>
                <i class="fas fa-ellipsis-h"></i>
            </div>
            <canvas id="weeklyChart" height="250"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="chart-card">
            <div class="chart-header">
                <h5><i class="fas fa-tags me-2"></i> Kata Kunci Populer</h5>
                <i class="fas fa-ellipsis-h"></i>
            </div>
            <div class="mt-3">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Pemrograman</span>
                        <span class="fw-bold">234 pencarian</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: 100%; background: #2E8B57;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Keperawatan</span>
                        <span class="fw-bold">189 pencarian</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: 81%; background: #2E8B57;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Manajemen</span>
                        <span class="fw-bold">156 pencarian</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: 67%; background: #2E8B57;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Kesehatan</span>
                        <span class="fw-bold">143 pencarian</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: 61%; background: #2E8B57;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Database</span>
                        <span class="fw-bold">98 pencarian</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: 42%; background: #2E8B57;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Members Table -->
<div class="table-card">
    <div class="table-header">
        <h5><i class="fas fa-user-plus me-2"></i> Anggota Terbaru</h5>
        <button class="btn btn-primary-custom btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Anggota
        </button>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>HKBP-001</strong></td>
                    <td>Budi Santoso</td>
                    <td>budi.santoso@email.com</td>
                    <td>0812-3456-7890</td>
                    <td><span class="badge-status badge-active">Aktif</span></td>
                    <td>15 Mar 2026</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1 rounded-circle" style="width: 30px;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 30px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><strong>HKBP-002</strong></td>
                    <td>Siti Rahayu</td>
                    <td>siti.rahayu@email.com</td>
                    <td>0813-4567-8901</td>
                    <td><span class="badge-status badge-active">Aktif</span></td>
                    <td>14 Mar 2026</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1 rounded-circle" style="width: 30px;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 30px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><strong>HKBP-003</strong></td>
                    <td>Andi Wijaya</td>
                    <td>andi.wijaya@email.com</td>
                    <td>0814-5678-9012</td>
                    <td><span class="badge-status badge-pending">Pending</span></td>
                    <td>12 Mar 2026</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1 rounded-circle" style="width: 30px;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 30px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><strong>HKBP-004</strong></td>
                    <td>Maria Gultom</td>
                    <td>maria.gultom@email.com</td>
                    <td>0815-6789-0123</td>
                    <td><span class="badge-status badge-active">Aktif</span></td>
                    <td>10 Mar 2026</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1 rounded-circle" style="width: 30px;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 30px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Loan Chart (Line Chart)
    const ctx1 = document.getElementById('loanChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'Peminjaman',
                    data: [65, 78, 92, 85, 98, 112, 125, 138, 142, 156, 168, 184],
                    borderColor: '#2E8B57',
                    backgroundColor: 'rgba(46, 139, 86, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengembalian',
                    data: [58, 70, 85, 80, 90, 105, 118, 130, 135, 148, 160, 175],
                    borderColor: '#FFA500',
                    backgroundColor: 'rgba(255, 165, 0, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Category Chart (Doughnut)
    const ctx2 = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Keperawatan', 'Kedokteran', 'Teknologi', 'Manajemen', 'Agama', 'Lainnya'],
            datasets: [{
                data: [28, 22, 18, 15, 10, 7],
                backgroundColor: ['#2E8B57', '#3CB371', '#66CDAA', '#8FBC8F', '#98FB98', '#C1E1C1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Weekly Chart (Bar)
    const ctx3 = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Kunjungan',
                data: [42, 38, 45, 52, 58, 35, 28],
                backgroundColor: '#2E8B57',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endpush
halaman putih 