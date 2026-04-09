@extends('user.component.main')

<header>
    @include('user.component.navbar')
</header>

@section('user_content')
<div class="container py-4">
    <h2 class="mb-4">Upload Karya Tulis (KTI)</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Notifikasi error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Upload --}}
    <form action="{{ route('user.final_project.store') }}" method="POST" enctype="multipart/form-data">
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
@endsection