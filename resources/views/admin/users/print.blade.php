<!DOCTYPE html>
<html>
<head>
    <title>Cetak Kartu - {{ $user->name }}</title>
    <style>
        body { font-family: 'Inter', sans-serif; display: flex; justify-content: center; padding-top: 50px; background: #f4f7fa; }
        .card { 
            width: 350px; height: 210px; border-radius: 12px; background: #fff;
            border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: relative; overflow: hidden; padding: 20px;
        }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 15px; }
        .header h3 { margin: 0; color: #1e293b; font-size: 16px; }
        .header p { margin: 0; font-size: 10px; color: #64748b; }
        .photo { width: 85px; height: 105px; border-radius: 6px; object-fit: cover; float: left; border: 2px solid #f1f5f9; }
        .info { margin-left: 100px; }
        .info div { margin-bottom: 8px; }
        .info label { display: block; font-size: 9px; color: #94a3b8; text-transform: uppercase; }
        .info span { font-size: 13px; font-weight: 600; color: #1e293b; }
        .footer-text { position: absolute; bottom: 10px; width: 100%; text-align: center; font-size: 8px; color: #94a3b8; left: 0;}
        @media print { .no-print { display: none; } body { background: none; padding: 0; } }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h3>PERPUSTAKAAN AKPER HKBP</h3>
            <p>Jl. Gereja No. 17, Indonesia</p>
        </div>
        <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://via.placeholder.com/85x105' }}" class="photo">
        <div class="info">
            <div><label>Nama Anggota</label><span>{{ strtoupper($user->name) }}</span></div>
            <div><label>ID Anggota ({{ $user->role_id == 3 ? 'NPM' : 'NIDN' }})</label><span>{{ $user->npm ?? $user->nidn }}</span></div>
            <div><label>Status</label><span>{{ $user->role_id == 3 ? 'MAHASISWA' : 'DOSEN' }}</span></div>
        </div>
        <div class="footer-text">Kartu ini wajib dibawa saat peminjaman buku.</div>
    </div>

    <div class="no-print" style="position: fixed; top: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>