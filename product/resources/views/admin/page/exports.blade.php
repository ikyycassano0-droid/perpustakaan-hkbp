<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Dashboard Perpustakaan</title>
    <style>
        @page { margin: 15px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1a1a2e; font-size: 11px; line-height: 1.4; }
        
        .header { 
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            color: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; text-align: center;
        }
        .header h1 { margin: 0; font-size: 22px; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; font-size: 12px; opacity: 0.9; }
        
        .summary { margin-bottom: 25px; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { 
            width: 25%; padding: 15px; text-align: center; vertical-align: top;
            border: 1px solid #e5e7eb; border-radius: 8px;
        }
        .summary .num { font-size: 28px; font-weight: 800; color: #4F46E5; }
        .summary .lbl { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }
        
        .sec-title { 
            background: #4F46E5; color: white; padding: 10px 15px; font-size: 14px; font-weight: 700;
            border-radius: 5px; margin: 25px 0 12px;
        }
        
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.data th { 
            background: #f3f4f6; color: #374151; padding: 8px 10px; text-align: left;
            font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #4F46E5;
        }
        table.data td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        table.data tr:nth-child(even) { background: #f9fafb; }
        
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 9px; font-weight: 700; }
        .bg-green { background: #d1fae5; color: #065f46; }
        .bg-yellow { background: #fef3c7; color: #92400e; }
        .bg-red { background: #fee2e2; color: #991b1b; }
        .bg-blue { background: #dbeafe; color: #1e40af; }
        
        .footer { 
            margin-top: 30px; padding-top: 15px; border-top: 2px solid #4F46E5;
            text-align: center; color: #9ca3af; font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DASHBOARD PERPUSTAKAAN</h1>
        <p>AKPER HKBP Balige | Periode: {{ now()->format('d F Y') }} | Dicetak: {{ now()->format('H:i') }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td><div class="num">{{ $totalCollections }}</div><div class="lbl">Total Koleksi</div></td>
                <td><div class="num">{{ $activeMembers }}</div><div class="lbl">Anggota Aktif</div></td>
                <td><div class="num">{{ $activeLoans }}</div><div class="lbl">Peminjaman Aktif</div></td>
                <td><div class="num">{{ $pendingApprovals }}</div><div class="lbl">Menunggu Persetujuan</div></td>
            </tr>
        </table>
    </div>

    <div class="sec-title">Status Peminjaman</div>
    <table class="data">
        <tr><th>Status</th><th>Jumlah</th><th>Persentase</th></tr>
        @php $total = max(1, $borrowedCount + $returnedCount + $pendingCount); @endphp
        <tr><td><span class="badge bg-blue">Dipinjam</span></td><td><strong>{{ $borrowedCount }}</strong></td><td>{{ round($borrowedCount/$total*100) }}%</td></tr>
        <tr><td><span class="badge bg-green">Dikembalikan</span></td><td><strong>{{ $returnedCount }}</strong></td><td>{{ round($returnedCount/$total*100) }}%</td></tr>
        <tr><td><span class="badge bg-yellow">Menunggu</span></td><td><strong>{{ $pendingCount }}</strong></td><td>{{ round($pendingCount/$total*100) }}%</td></tr>
    </table>

    <div class="sec-title">Buku Terpopuler</div>
    <table class="data">
        <tr><th>No</th><th>Judul Buku</th><th>Total Dipinjam</th></tr>
        @foreach($popularBooks as $i => $book)
        <tr><td>{{ $i+1 }}</td><td>{{ $book->title }}</td><td><strong>{{ $book->total_borrowed }}</strong> kali</td></tr>
        @endforeach
    </table>

    <div class="sec-title">Peminjaman Terbaru</div>
    <table class="data">
        <tr><th>No</th><th>Peminjam</th><th>Judul Buku</th><th>Status</th><th>Tanggal</th></tr>
        @foreach($recentLoans as $loan)
        <tr>
            <td>#{{ $loan->id }}</td>
            <td>{{ $loan->user->name ?? '-' }}</td>
            <td>{{ Str::limit($loan->details->first()->collection->title ?? '-', 40) }}</td>
            <td>
                @if($loan->status == 'PENDING') <span class="badge bg-yellow">Menunggu</span>
                @elseif($loan->status == 'APPROVED') <span class="badge bg-blue">Dipinjam</span>
                @elseif($loan->status == 'REJECTED') <span class="badge bg-red">Ditolak</span>
                @elseif($loan->status == 'RETURNED') <span class="badge bg-green">Selesai</span>
                @endif
            </td>
            <td>{{ $loan->created_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="sec-title">Anggota Terbaru</div>
    <table class="data">
        <tr><th>No</th><th>Nama</th><th>NPM/NIDN</th><th>Status</th></tr>
        @foreach($recentUsers as $i => $user)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->npm ?? $user->nidn ?? '-' }}</td>
            <td><span class="badge bg-green">Aktif</span></td>
        </tr>
        @endforeach
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Perpustakaan AKPER HKBP Balige | Laporan dibuat otomatis oleh sistem</p>
    </div>
</body>
</html>

