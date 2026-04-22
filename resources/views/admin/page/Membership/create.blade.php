@extends('admin.layouts.app')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')

@section('admin_content')

<div class="table-card">
    <h5 class="mb-4">Form Tambah Anggota</h5>

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
    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>No HP</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tipe Anggota</label>
                <select name="role_id" class="form-control" required>
                    <option value="">-- Pilih Tipe --</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-primary-custom">
            <i class="fas fa-save"></i> Simpan
        </button>
    </form>
</div>

@endsection
