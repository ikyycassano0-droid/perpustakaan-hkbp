@extends('admin.component.main')

@section('title', 'Tambah Anggota - Neptix Admin')
@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Isi formulir di bawah untuk menambahkan anggota baru</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="px-4 py-2 text-sm border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Alert Error -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-exclamation-triangle text-rose-500"></i>
                <p class="text-rose-700 text-sm font-medium">Terjadi kesalahan:</p>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-rose-600 text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card-modern">
        <form action="{{ route('admin.members.store') }}" method="POST">
            @csrf

            <div class="p-6 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">Informasi Anggota</h3>
                <p class="text-slate-400 text-xs mt-0.5">Lengkapi data anggota dengan benar</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- NAMA -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nama <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                               value="{{ old('name') }}" required>
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                               value="{{ old('email') }}" required>
                    </div>

                    <!-- NPM -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            NPM/NIDN <span class="text-slate-400 text-xs font-normal"></span>
                        </label>
                        <input type="text" name="npm"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                               value="{{ old('npm') }}">
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            No HP
                        </label>
                        <input type="text" name="phone"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                               value="{{ old('phone') }}">
                    </div>

                    <!-- ROLE -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Tipe Anggota <span class="text-rose-500">*</span>
                        </label>
                        <select name="role_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" required>
                            <option value="">-- Pilih Tipe --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Password <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700 pr-10" required>
                            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition">
                                <i class="far fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        <p class="text-slate-400 text-[11px] mt-1">Minimal 8 karakter</p>
                    </div>

                    <!-- KONFIRMASI PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Konfirmasi Password <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700 pr-10" required>
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition">
                                <i class="far fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="p-6 border-t border-slate-100 bg-slate-50/30 rounded-b-2xl flex justify-end gap-3">
                <a href="{{ route('admin.members.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
                    <i class="fas fa-save text-xs"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>

@endsection