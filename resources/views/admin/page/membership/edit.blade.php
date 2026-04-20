@extends('admin.component.main')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')

@section('admin_content')

<div class="table-card">
    <h5 class="mb-4">Form Edit Anggota</h5>

    {{-- ALERT --}}
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

    {{-- FORM EDIT --}}
    <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <!-- NAMA -->
            <div class="col-md-6 mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $member->name) }}" required>
            </div>

            <!-- EMAIL -->
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $member->email) }}" required>
            </div>

            <!-- NPM -->
            <div class="col-md-6 mb-3">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control"
                       value="{{ old('npm', $member->npm) }}">
            </div>

            <!-- NIDN -->
            <div class="col-md-6 mb-3">
                <label>NIDN</label>
                <input type="text" name="nidn" class="form-control"
                       value="{{ old('nidn', $member->nidn) }}">
            </div>

            <!-- PHONE -->
            <div class="col-md-6 mb-3">
                <label>No HP</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone', $member->phone) }}">
            </div>

            <!-- ROLE -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipe Anggota</label>
                <select name="role_id" class="form-control" required>
                    <option value="">-- Pilih Tipe --</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $member->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- 🔥 STATUS EMAIL -->
            <div class="col-md-6 mb-3">
                <label>Status Email</label><br>

                @if($member->email_verified_at)
                    <span class="badge bg-success">Sudah Diverifikasi</span>
                @else
                    <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                @endif
            </div>

            <!-- 🔥 RESEND VERIFICATION -->
            <div class="col-md-6 mb-3">
                @if(!$member->email_verified_at)
                    <label>&nbsp;</label><br>
                    <form action="{{ route('admin.members.resend', $member->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-info">
                            Kirim Ulang Verifikasi
                        </button>
                    </form>
                @endif
            </div>

            <!-- PASSWORD -->
            <div class="col-md-6 mb-3">
                <label>Password (opsional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="col-md-6 mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

        </div>

        <button class="btn btn-primary-custom">
            <i class="fas fa-save"></i> Update
        </button>
    </form>
</div>

@endsection