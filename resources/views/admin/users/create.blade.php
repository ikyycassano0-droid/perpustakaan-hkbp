@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb / Title -->
    <div class="mb-4">
        <h4 class="font-weight-bold text-primary"><i class="fas fa-user-plus mr-2"></i>Registrasi Anggota Baru</h4>
        <p class="text-muted">Silakan isi formulir di bawah ini untuk membuat akun Mahasiswa atau Dosen.</p>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-top: 4px solid var(--primary);">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Tipe Keanggotaan -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tipe Keanggotaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-id-badge text-primary"></i></span>
                                    </div>
                                    <select name="role_id" class="form-control border-left-0 custom-select" id="role_id" required>
                                        <option value="3">Mahasiswa</option>
                                        <option value="2">Dosen</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-user text-primary"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control border-left-0" placeholder="Contoh: Budi Santoso" required>
                                </div>
                            </div>

                            <!-- Nomor Induk (Dinamis) -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold" id="label_id">NPM (Nomor Pokok Mahasiswa)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-fingerprint text-primary"></i></span>
                                    </div>
                                    <input type="text" name="id_number" class="form-control border-left-0" placeholder="Input nomor induk..." required>
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Nomor Telepon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-phone text-primary"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control border-left-0" placeholder="08..." required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Jenis Kelamin</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-venus-mars text-primary"></i></span>
                                    </div>
                                    <select name="gender" class="form-control border-left-0 custom-select">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tanggal Lahir</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                                    </div>
                                    <input type="date" name="birth_date" class="form-control border-left-0" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold">Password Akun</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-lock text-primary"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control border-left-0" placeholder="Minimal 6 karakter..." required>
                                </div>
                                <small class="text-muted">Password ini akan digunakan anggota untuk login pertama kali.</small>
                            </div>

                            <!-- Upload Foto -->
                            <div class="col-md-12 mb-4">
                                <label class="font-weight-bold">Foto Anggota</label>
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photoInput" accept="image/*">
                                    <label class="custom-file-label" for="photoInput">Pilih file foto...</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i>Simpan Data Anggota
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 ml-2 text-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Preview -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                <div class="card-header bg-primary text-white text-center">
                    <h6 class="m-0 font-weight-bold">Preview Foto</h6>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <img id="imagePreview" src="https://ui-avatars.com/api/?name=User&background=f0f7ff&color=021e69&size=200" 
                             class="rounded shadow-sm border" 
                             style="width: 180px; height: 230px; object-fit: cover;">
                    </div>
                    <p class="text-muted small">Ukuran foto disarankan 3x4 atau 4x6 untuk hasil terbaik pada kartu anggota.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk input agar lebih elegan */
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(2, 30, 105, 0.1);
    }
    .input-group-text {
        border-right: none;
    }
    .input-group .form-control {
        border-left: none;
    }
    .custom-file-label::after {
        background-color: var(--primary);
        color: white;
    }
</style>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role_id');
        const labelId = document.getElementById('label_id');
        const photoInput = document.getElementById('photoInput');
        const imagePreview = document.getElementById('imagePreview');

        // 1. Logic Ganti Label ID (NPM/NIDN)
        if(roleSelect) {
            roleSelect.addEventListener('change', function() {
                // Gunakan animasi transisi sederhana
                labelId.style.opacity = '0';
                setTimeout(() => {
                    labelId.innerText = (this.value == '2') ? 'NIDN (Nomor Induk Dosen)' : 'NPM (Nomor Pokok Mahasiswa)';
                    labelId.style.opacity = '1';
                }, 200);
            });
            // Style transisi CSS
            labelId.style.transition = 'opacity 0.3s ease';
        }

        // 2. Logic Live Preview Foto
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
                // Update label nama file di input
                this.nextElementSibling.innerText = file.name;
            }
        });
    });
</script>
@endpush