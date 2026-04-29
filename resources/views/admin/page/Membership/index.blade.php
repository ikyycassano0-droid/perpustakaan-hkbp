@extends('admin.component.main')

@section('title', 'Manajemen Anggota - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola semua anggota yang terdaftar di sistem</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus text-xs"></i> Tambah Anggota
        </a>
    </div>

    <!-- Table Card -->
    <div class="card-modern overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-slate-800">Daftar Anggota</h3>
                <p class="text-slate-400 text-xs mt-0.5">Total: anggota</p>
            </div>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Cari anggota..." class="pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-sm w-64 focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition bg-slate-50/30">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">NPM / NIDN</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No HP</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status Akun</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status Email</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider" width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <!-- NAMA -->
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-500 text-xs"></i>
                                </div>
                                <span class="font-medium text-slate-700 text-sm">{{ $member->name }}</span>
                            </div>
                        </td>

                        <!-- ROLE -->
                        <td class="px-6 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                @if(optional($member->role)->name == 'Admin') bg-rose-100 text-rose-700
                                @elseif(optional($member->role)->name == 'Dosen') bg-sky-100 text-sky-700
                                @elseif(optional($member->role)->name == 'Mahasiswa') bg-emerald-100 text-emerald-700
                                @else bg-slate-100 text-slate-600
                                @endif
                            ">
                                {{ optional($member->role)->name ?? '-' }}
                            </span>
                        </td>

                        <!-- NPM / NIDN -->
                        <td class="px-6 py-3 text-sm text-slate-600">
                            {{ $member->npm ?? $member->nidn ?? '-' }}
                        </td>

                        <!-- PHONE -->
                        <td class="px-6 py-3 text-sm text-slate-600">
                            {{ $member->phone ?? '-' }}
                        </td>

                        <!-- STATUS AKUN -->
                        <td class="px-6 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $member->active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $member->active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        <!-- STATUS EMAIL -->
                        <td class="px-6 py-3">
                            @if($member->email_verified_at)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px] mr-1"></i> Verified
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <i class="fas fa-clock text-[10px] mr-1"></i> Belum Verifikasi
                                </span>
                            @endif
                        </td>

                        <!-- ACTION -->
                        <td class="px-6 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <!-- EDIT -->
                                <a href="{{ route('admin.members.edit', $member->id) }}"
                                   class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                   title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('admin.members.destroy', $member->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition flex items-center justify-center cursor-pointer"
                                            title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-users text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data anggota</p>
                                <a href="{{ route('admin.members.create') }}" class="mt-2 px-4 py-2 text-sm text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                                    <i class="fas fa-plus mr-1"></i> Tambah anggota pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (if exists) -->
        @if(method_exists($members, 'links') && $members->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>

@endsection