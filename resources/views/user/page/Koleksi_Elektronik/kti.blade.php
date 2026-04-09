@extends('user.component.main')

<header>
    @include('user.component.navbar')
</header>

@section('user_content')
<div class="container py-4">
    <h2 class="mb-4">Karya Tulis (KTI) Saya</h2>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="ktiTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">Upload KTI</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="my-kti-tab" data-bs-toggle="tab" data-bs-target="#my-kti" type="button" role="tab">Daftar KTI Saya</button>
        </li>
    </ul>

    <div class="tab-content" id="ktiTabsContent">
        {{-- Upload KTI --}}
        <div class="tab-pane fade show active" id="upload" role="tabpanel">
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
                    <label for="student_name" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" id="student_name" name="student_name" value="{{ old('student_name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="npm" class="form-label">NPM</label>
                    <input type="text" class="form-control" id="npm" name="npm" value="{{ old('npm') }}" required>
                </div>

                <div class="mb-3">
                    <label for="study_program" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" id="study_program" name="study_program" value="{{ old('study_program') }}" required>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Karya Tulis</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="abstract" class="form-label">Abstract</label>
                    <textarea class="form-control" id="abstract" name="abstract" rows="4">{{ old('abstract') }}</textarea>
                </div>

                {{-- Kategori KTI --}}
                <div class="mb-3">
                    <label for="category_final_project_id" class="form-label">Kategori KTI</label>
                    <select class="form-select" id="category_final_project_id" name="category_final_project_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_final_project_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="first_supervisor_id" class="form-label">Supervisor 1</label>
                    <select class="form-select" id="first_supervisor_id" name="first_supervisor_id" required>
                        <option value="">-- Pilih Supervisor 1 --</option>
                        @foreach($supervisors as $sup)
                            <option value="{{ $sup->id }}" {{ old('first_supervisor_id')==$sup->id?'selected':'' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="second_supervisor_id" class="form-label">Supervisor 2 (opsional)</label>
                    <select class="form-select" id="second_supervisor_id" name="second_supervisor_id">
                        <option value="">-- Pilih Supervisor 2 --</option>
                        @foreach($supervisors as $sup)
                            <option value="{{ $sup->id }}" {{ old('second_supervisor_id')==$sup->id?'selected':'' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="file_url" class="form-label">File Karya Tulis (PDF, MP3, MP4, DOCX)</label>
                    <input type="file" class="form-control" id="file_url" name="file_url" accept=".pdf,.mp3,.mp4,.docx" required>
                </div>

                <button type="submit" class="btn btn-primary">Upload Karya Tulis</button>
            </form>
        </div>

        {{-- Daftar KTI User --}}
        <div class="tab-pane fade" id="my-kti" role="tabpanel">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
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
                            <td>{{ $kti->category->name ?? '-' }}</td>
                            <td>{{ $kti->firstSupervisor->name ?? '-' }}</td>
                            <td>{{ $kti->secondSupervisor->name ?? '-' }}</td>
                            <td>
                                @if($kti->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($kti->status == 'approved')
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
                            <td colspan="7" class="text-center">Belum ada KTI yang diupload</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection