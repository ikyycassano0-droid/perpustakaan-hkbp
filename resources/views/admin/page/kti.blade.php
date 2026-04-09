@extends('admin.component.main')

@section('title', 'Verifikasi KTI')

@section('admin_content')
<div class="container py-4">
    <h2 class="mb-4">Verifikasi Karya Tulis Ilmiah (KTI)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($data->isEmpty())
        <div class="alert alert-info">Tidak ada KTI yang menunggu verifikasi.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Mahasiswa</th>
                    <th>NPM</th>
                    <th>Program Studi</th>
                    <th>Judul</th>
                    <th>Supervisor 1</th>
                    <th>Supervisor 2</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $kti)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kti->student_name }}</td>
                        <td>{{ $kti->npm }}</td>
                        <td>{{ $kti->study_program }}</td>
                        <td>{{ $kti->title }}</td>
                        <td>{{ $kti->firstSupervisor ? $kti->firstSupervisor->name : '-' }}</td>
                        <td>{{ $kti->secondSupervisor ? $kti->secondSupervisor->name : '-' }}</td>
                        <td>
                            @if($kti->file_url)
                                <a href="{{ asset('storage/'.$kti->file_url) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($kti->status == 'Pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($kti->status == 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($kti->status == 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($kti->status == 'Pending')
                                <form action="{{ route('admin.kti.approve', $kti->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.kti.reject', $kti->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @else
                                - {{-- tombol hilang jika sudah di-approve atau reject --}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection