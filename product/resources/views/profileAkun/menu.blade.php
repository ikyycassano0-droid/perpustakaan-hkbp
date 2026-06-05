{{-- resources/views/profileAkun/menu.blade.php --}}
@extends('user.component.master')

@section('title', 'Profil Saya - AKPER HKBP')

@push('styles')
<style>
    .profile-wrapper {
        max-width: 850px;
        margin: 40px auto;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* --- KARTU INFORMASI (KIRI) --- */
    .info-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 12px 28px rgba(15, 74, 49, 0.06);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 110px;
    }

    .avatar-circle {
        width: 96px;
        height: 96px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-green));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 8px 20px rgba(26, 107, 71, 0.25);
    }

    .info-name {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .info-detail {
        background: #f6faf8;
        border-radius: 14px;
        padding: 16px 14px;
        margin-top: 20px;
        text-align: left;
    }

    .info-detail .row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        color: var(--text-muted);
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-detail .row:last-child {
        border-bottom: none;
    }

    .info-detail .row i {
        width: 20px;
        color: var(--primary-color);
        font-size: 0.9rem;
        text-align: center;
    }

    /* --- KARTU FORM (KANAN) --- */
    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 35px 30px;
        box-shadow: 0 12px 28px rgba(15, 74, 49, 0.06);
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--accent-yellow);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-dark);
        margin-bottom: 6px;
        display: block;
    }

    .form-group input {
        width: 100%;
        padding: 13px 18px;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        font-size: 0.95rem;
        background: #fafbf9;
        transition: 0.25s;
    }

    .form-group input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.08);
        outline: none;
        background: white;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 13px 26px;
        border-radius: 40px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.25s;
        font-size: 0.95rem;
    }

    .btn-primary:hover {
        background: var(--deep-green);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(15, 74, 49, 0.2);
    }

    .alert {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 22px;
        font-size: 0.88rem;
        font-weight: 600;
    }

    .alert-success {
        background: #e3f5ec;
        color: #0f4a31;
        border: 1px solid #b7dfc9;
    }

    .alert-danger {
        background: #ffe8e8;
        color: #842029;
        border: 1px solid #f5c2c7;
    }

    hr {
        border: none;
        border-top: 1px solid var(--border-color);
        margin: 30px 0 24px;
    }

    @media (max-width: 768px) {
        .profile-wrapper {
            grid-template-columns: 1fr;
            padding: 0 15px;
        }
        .info-card {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">

    {{-- KOLOM KIRI: INFORMASI STATIS --}}
    <div class="info-card">
        <div class="avatar-circle">
            <i class="fas fa-user"></i>
        </div>
        <div class="info-name">{{ $user['name'] ?? 'User' }}</div>
        <div class="info-detail">
            <div class="row">
                <i class="fas fa-id-card"></i>
                <span><strong>NPM</strong><br>{{ $user['npm'] ?? '-' }}</span>
            </div>
            <div class="row">
                <i class="fas fa-envelope"></i>
                <span><strong>Email</strong><br>{{ $user['email'] ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: FORM YANG DAPAT DIUBAH --}}
    <div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form Ganti Nama --}}
        <div class="form-card">
            <div class="section-title">
                <i class="fas fa-user-edit"></i> Ubah Nama Lengkap
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user['name'] ?? '') }}" required>
                </div>
                <button type="submit" class="btn-primary">Simpan Nama</button>
            </form>

            <hr>

            {{-- Form Ganti Password --}}
            <div class="section-title">
                <i class="fas fa-lock"></i> Ubah Password
            </div>
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Password Saat Ini</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" required minlength="8">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" required minlength="8">
                </div>

                <button type="submit" class="btn-primary">Simpan Password</button>
            </form>
        </div>
    </div>

</div>
@endsection
