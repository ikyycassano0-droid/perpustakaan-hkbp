@extends('user.component.main')

<header>
    @include('user.component.navbar')
</header>

@section('user_content')
<div class="container py-4">
    <h2 class="mb-4">Karya Tulis (KTI) Saya</h2>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="ktiTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#upload">Upload KTI</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#my-kti">Daftar KTI Saya</button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ================= UPLOAD ================= --}}
        <div class="tab-pane fade show active" id="upload">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('final_project.kti.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="student_name" class="form-control" value="{{ old('student_name') }}" required>
                </div>

                <div class="mb-3">
                    <label>NPM</label>
                    <input type="text" name="npm" class="form-control" value="{{ old('npm') }}" required>
                </div>

                <div class="mb-3">
                    <label>Program Studi</label>
                    <input type="text" name="study_program" class="form-control" value="{{ old('study_program') }}" required>
                </div>

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label>Abstract</label>
                    <textarea name="abstract" class="form-control">{{ old('abstract') }}</textarea>
                </div>

                {{-- SUPERVISOR --}}
                <div class="mb-3">
                    <label>Supervisor 1</label>
                    <select name="first_supervisor_id" class="form-select" required>
                        <option value="">-- Pilih Supervisor 1 --</option>
                        @foreach($supervisors as $sup)
                            <option value="{{ $sup->id }}" {{ old('first_supervisor_id')==$sup->id?'selected':'' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Supervisor 2 (Opsional)</label>
                    <select name="second_supervisor_id" class="form-select">
                        <option value="">-- Pilih Supervisor 2 --</option>
                        @foreach($supervisors as $sup)
                            <option value="{{ $sup->id }}" {{ old('second_supervisor_id')==$sup->id?'selected':'' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>File KTI</label>
                    <input type="file" name="file_url" class="form-control" required>
                </div>

                <button class="btn btn-primary">Upload</button>
            </form>
        </div>

        {{-- ================= LIST ================= --}}
        <div class="tab-pane fade" id="my-kti">

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Supervisor 1</th>
                        <th>Supervisor 2</th>
                        <th>Status</th>
                        <th>File</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $index => $kti)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kti->title }}</td>
                            <td>{{ $kti->firstSupervisor->name ?? '-' }}</td>
                            <td>{{ $kti->secondSupervisor->name ?? '-' }}</td>

                            <td>
                                @if($kti->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($kti->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            <td>
                                @if($kti->file_url)
                                    <a href="{{ asset('storage/'.$kti->file_url) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada KTI</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>
</div>
@endsection