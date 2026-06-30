{{-- resources/views/profileAkun/menu.blade.php --}}
@extends('user.component.master')

@section('title', 'Profil Saya - AKPER HKBP')

@push('styles')
<style>
    /* ============================================================
       RESET & VARIABEL
    ============================================================ */
    :root {
        --primary-color: #1a6b47;
        --deep-green: #0f4a31;
        --accent-green: #2daa6e;
        --accent-yellow: #f1c40f;
        --text-dark: #0d2137;
        --text-muted: #5a7060;
        --light-bg: #f4f7f5;
        --card-bg: #ffffff;
        --border-color: #d4e5d9;
        --success: #2daa6e;
        --danger: #e74c3c;
    }

    /* ============================================================
       MAIN LAYOUT
    ============================================================ */
    .profile-wrapper {
        max-width: 1000px;
        margin: 100px auto 40px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* ============================================================
       KARTU INFORMASI (KIRI)
    ============================================================ */
    .info-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 12px 28px rgba(15, 74, 49, 0.06);
        border: 1px solid var(--border-color);
        border-top: 5px solid var(--accent-yellow);
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
        overflow: hidden;
        position: relative;
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-circle i {
        font-size: 2.5rem;
    }

    /* UPLOAD FOTO */
    .photo-upload-section {
        margin-top: 15px;
        text-align: center;
    }

    .btn-upload-photo {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #f0f7f3;
        color: var(--primary-color);
        border: 1px dashed var(--primary-color);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.25s;
        text-decoration: none;
    }

    .btn-upload-photo:hover {
        background: var(--primary-color);
        color: white;
        border-style: solid;
    }

    .btn-remove-photo {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #fff0f0;
        color: #dc3545;
        border: 1px dashed #dc3545;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.25s;
        margin-top: 8px;
        text-decoration: none;
    }

    .btn-remove-photo:hover {
        background: #dc3545;
        color: white;
        border-style: solid;
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

    .info-detail .row strong {
        color: var(--text-dark);
        font-weight: 700;
    }

    /* ============================================================
       KARTU FORM (KANAN)
    ============================================================ */
    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 35px 30px;
        box-shadow: 0 12px 28px rgba(15, 74, 49, 0.06);
        border: 1px solid var(--border-color);
        border-top: 5px solid var(--accent-yellow);
        margin-bottom: 30px;
    }

    .form-card:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 4px solid var(--accent-yellow);
        padding-left: 12px;
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

    .form-group label i {
        color: var(--primary-color);
        margin-right: 6px;
    }

    .form-group input {
        width: 100%;
        padding: 13px 18px;
        border: 1.5px solid var(--border-color);
        border-radius: 14px;
        font-size: 0.95rem;
        background: #fafbf9;
        transition: 0.25s;
    }

    .form-group input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(26, 107, 71, 0.08);
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
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: var(--deep-green);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(15, 74, 49, 0.2);
        color: white;
    }

    .btn-primary i {
        font-size: 1rem;
    }

    /* ============================================================
       ALERT
    ============================================================ */
    .alert {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 22px;
        font-size: 0.88rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #e3f5ec;
        color: #0f4a31;
        border: 1px solid #b7dfc9;
    }

    .alert-success i {
        color: var(--success);
    }

    .alert-danger {
        background: #ffe8e8;
        color: #842029;
        border: 1px solid #f5c2c7;
    }

    .alert-danger i {
        color: var(--danger);
    }

    hr {
        border: none;
        border-top: 1.5px solid var(--border-color);
        margin: 30px 0 24px;
    }

    /* ============================================================
       MODAL PREVIEW FOTO
    ============================================================ */
    #photoModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    #photoModal.active {
        display: flex;
    }

    .photo-modal-content {
        background: white;
        border-radius: 20px;
        padding: 25px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .photo-modal-content h4 {
        color: var(--text-dark);
        font-size: 1.1rem;
        margin-bottom: 15px;
    }

    .photo-modal-content img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid var(--border-color);
    }

    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .profile-wrapper {
            grid-template-columns: 1fr;
            padding: 0 15px;
            margin: 90px auto 30px auto;
            gap: 25px;
        }

        .info-card {
            position: static;
        }

        .form-card {
            padding: 25px 20px;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .profile-wrapper {
            margin: 80px 10px 20px 10px;
            padding: 0;
        }

        .info-card {
            padding: 20px 16px;
            border-radius: 16px;
        }

        .form-card {
            padding: 20px 16px;
            border-radius: 16px;
        }

        .avatar-circle {
            width: 72px;
            height: 72px;
            font-size: 2rem;
        }

        .info-name {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .form-group input {
            padding: 11px 14px;
            font-size: 0.9rem;
            border-radius: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
    {{-- KOLOM KIRI: INFORMASI STATIS --}}
    <div class="info-card" data-aos="fade-right">
        <div class="avatar-circle" id="avatarContainer">
            @if(!empty($user['photo']))
                <img src="{{ asset('storage/' . $user['photo']) }}" alt="Foto Profil" id="profilePhoto">
            @else
                <i class="fas fa-user" id="defaultIcon"></i>
            @endif
        </div>

        {{-- UPLOAD FOTO (hanya user non-admin) --}}
        @if(($user['role_id'] ?? 0) != 1)
        <div class="photo-upload-section">
            <label class="btn-upload-photo" for="photoInput">
                <i class="fas fa-camera"></i> 
                {{ !empty($user['photo']) ? 'Ganti Foto' : 'Upload Foto' }}
            </label>
            <input type="file" id="photoInput" accept="image/*" style="display: none;" onchange="previewPhoto(event)">
            
            @if(!empty($user['photo']))
            <form action="{{ route('photo.delete') }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-remove-photo">
                    <i class="fas fa-trash"></i> Hapus Foto
                </button>
            </form>
            @endif
        </div>
        @endif

        <div class="info-name">{{ $user['name'] ?? 'User' }}</div>
        <div class="info-detail">
            <div class="row">
                <i class="fas fa-id-card"></i>
                <span>
                    <strong>NPM</strong><br>
                    {{ $user['npm'] ?? '-' }}
                </span>
            </div>
            <div class="row">
                <i class="fas fa-envelope"></i>
                <span>
                    <strong>Email</strong><br>
                    {{ $user['email'] ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: FORM YANG DAPAT DIUBAH --}}
    <div data-aos="fade-left">
        {{-- NOTIFIKASI DI ATAS FORM --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Form Upload Foto (tersembunyi) --}}
        <form id="photoForm" action="{{ route('photo.update') }}" method="POST" enctype="multipart/form-data" style="display: none;">
            @csrf
            @method('PUT')
            <input type="file" name="photo" id="photoFileInput" accept="image/*">
        </form>

        {{-- Form Ganti Nama + Password --}}
        <div class="form-card">
            {{-- FORM GANTI NAMA --}}
            <div class="section-title">
                <i class="fas fa-user-edit"></i> Ubah Nama Lengkap
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user['name'] ?? '') }}" required placeholder="Masukkan nama lengkap Anda">
                </div>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Nama
                </button>
            </form>

            <hr>

            {{-- FORM GANTI PASSWORD --}}
            <div class="section-title">
                <i class="fas fa-lock"></i> Ubah Password
            </div>
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label><i class="fas fa-key"></i> Password Saat Ini</label>
                    <input type="password" name="current_password" required placeholder="Masukkan password saat ini">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-shield-alt"></i> Password Baru</label>
                    <input type="password" name="new_password" required minlength="8" placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-check-circle"></i> Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" required minlength="8" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Password
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW FOTO --}}
<div id="photoModal">
    <div class="photo-modal-content">
        <h4>Preview Foto Profil</h4>
        <img id="previewImage" src="" alt="Preview Foto">
        <div style="margin-top: 15px; display: flex; gap: 10px; justify-content: center;">
            <button type="button" class="btn-remove-photo" onclick="closePhotoModal()" style="margin-top: 0;">
                <i class="fas fa-times"></i> Batal
            </button>
            <button type="button" class="btn-primary" onclick="uploadPhoto()">
                <i class="fas fa-check"></i> Simpan Foto
            </button>
        </div>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG, PNG, GIF, atau WEBP.');
            return;
        }

        // Validasi ukuran (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB!');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('photoModal').classList.add('active');
            document.getElementById('photoFileInput').files = event.target.files;
        };
        reader.readAsDataURL(file);
    }

    function closePhotoModal() {
        document.getElementById('photoModal').classList.remove('active');
        document.getElementById('photoInput').value = '';
    }

    function uploadPhoto() {
        document.getElementById('photoForm').submit();
    }

    // Tutup modal dengan klik di luar
    document.getElementById('photoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePhotoModal();
        }
    });
</script>
@endsection