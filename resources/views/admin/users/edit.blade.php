@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h4 class="font-weight-bold text-primary"><i class="fas fa-user-edit mr-2"></i>Perbarui Data Anggota</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manajemen User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit {{ $user->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- SISI KIRI: PROFIL SAAT INI -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h6 class="m-0 font-weight-bold">Status Keanggotaan</h6>
                </div>
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img id="imagePreview" src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=f0f7ff&color=021e69&size=200' }}" 
                             class="rounded shadow-sm border" 
                             style="width: 150px; height: 200px; object-fit: cover;">
                        <span class="position-absolute border border-white rounded-circle bg-success p-2" style="bottom: 10px; right: 10px;" title="User Active"></span>
                    </div>
                    <h5 class="font-weight-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->role_id == 2 ? 'Dosen Tetap' : 'Mahasiswa Aktif' }}</p>
                    
                    <div class="bg-light rounded p-3 text-left">
                        <div class="small text-muted mb-1">ID Terdaftar:</div>
                        <div class="font-weight-bold text-primary"><i class="fas fa-id-card mr-2"></i>{{ $user->role_id == 2 ? $user->nidn : $user->npm }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: FORM EDIT -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tipe Keanggotaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-user-tag text-primary"></i></span>
                                    </div>
                                    <select name="role_id" class="form-control border-left-0 custom-select" id="role_id">
                                        <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Dosen</option>
                                        <option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Mahasiswa</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-user text-primary"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control border-left-0" value="{{ $user->name }}" required>
                                </div>
                            </div>

                            <!-- ID Number -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold" id="label_id">Nomor Induk ({{ $user->role_id == 2 ? 'NIDN' : 'NPM' }})</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-fingerprint text-primary"></i></span>
                                    </div>
                                    <input type="text" name="id_number" class="form-control border-left-0" value="{{ $user->role_id == 2 ? $user->nidn : $user->npm }}" required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">No. WhatsApp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fab fa-whatsapp text-primary"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control border-left-0" value="{{ $user->phone }}" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold text-danger">Ganti Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-key text-danger"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control border-left-0" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                </div>
                                <small class="form-text text-muted italic">*Hanya isi jika ingin mengganti password lama.</small>
                            </div>

                            <!-- Photo -->
                            <div class="col-md-12 mb-4">
                                <label class="font-weight-bold">Perbarui Foto Profil</label>
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photoInput" accept="image/*">
                                    <label class="custom-file-label" for="photoInput">Pilih foto baru...</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-4 text-right">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 mr-2">Kembali</a>
                            <button type="submit" class="btn btn-warning px-5 shadow-sm font-weight-bold">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-text { border-right: none; }
    .form-control { border-left: none; }
    .form-control:focus { 
        border-color: #dee2e6;
        box-shadow: none;
        background-color: #fcfdfe;
    }
    .custom-file-label::after {
        background-color: var(--primary);
        color: white;
        content: "Telusuri";
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

        // Logic Ganti Label ID
        roleSelect.addEventListener('change', function() {
            labelId.innerText = (this.value == '2') ? 'Nomor Induk (NIDN)' : 'Nomor Induk (NPM)';
        });

        // Live Preview Foto Baru
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.add('border-warning'); // Beri tanda foto baru
                }
                reader.readAsDataURL(file);
                this.nextElementSibling.innerText = file.name;
            }
        });
    });
</script>
@endpush