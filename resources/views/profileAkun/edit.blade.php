@extends('user.component.navbars')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/20">
        <h2 class="text-2xl font-bold text-white mb-6">Edit Profil</h2>

        <form method="POST" action="{{ route('user.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:border-indigo-500 outline-none">
                @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:border-indigo-500 outline-none">
                @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">NPM / NIDN</label>
                <input type="text" name="npm" value="{{ old('npm', $user->npm) }}" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
                @error('npm') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">Program Studi</label>
                <input type="text" name="study_program" value="{{ old('study_program', $user->study_program) }}" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
                @error('study_program') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">Angkatan</label>
                <input type="text" name="angkatan" value="{{ old('angkatan', $user->angkatan) }}" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
                @error('angkatan') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
                @error('phone') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-indigo-200 mb-2">Password Baru (kosongkan jika tidak ingin mengganti)</label>
                <input type="password" name="password" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
                @error('password') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-indigo-200 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg">Simpan Perubahan</button>
                <a href="{{ route('user.profile.show') }}" class="btn-outline px-6 py-2 rounded-lg inline-block text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
