@extends('admin.component.main')

@section('title', 'Manajemen Anggota - Perpustakaan HKBP Balige')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Anggota</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola semua anggota yang terdaftar di sistem perpustakaan</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md hover:-translate-y-0.5">
            <i class="fas fa-plus text-xs"></i> Tambah Anggota
        </a>
    </div>

    <!-- Table Card -->
    <div class="card-modern overflow-hidden border border-slate-200/60 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white/50">
            <div>
                <h3 class="font-semibold text-slate-800">Daftar Anggota</h3>
                <p class="text-slate-400 text-xs mt-1">Total: {{ $members->count() }} anggota</p>
            </div>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" placeholder="Cari anggota..." class="pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-sm w-64 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all bg-white">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-14">Foto</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">NPM / NIDN</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No HP</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status Akun</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status Email</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors duration-150">
                        <!-- ✅ FOTO PROFIL -->
                        <td class="px-4 py-3 text-center">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" 
                                     alt="Foto {{ $member->name }}" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center mx-auto border-2 border-white shadow-sm">
                                    <i class="fas fa-user text-slate-400 text-xs"></i>
                                </div>
                            @endif
                        </td>

                        <!-- NAMA -->
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <span class="font-semibold text-slate-700 text-sm">{{ $member->name }}</span>
                            </div>
                        </td>

                        <!-- ROLE -->
                        <td class="px-6 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
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
                        <td class="px-6 py-3 text-sm text-slate-600 font-medium">
                            {{ $member->npm ?? $member->nidn ?? '-' }}
                        </td>

                        <!-- PHONE -->
                        <td class="px-6 py-3 text-sm text-slate-600">
                            {{ $member->phone ?? '-' }}
                        </td>

                        <!-- STATUS AKUN -->
                        <td class="px-6 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $member->active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                @if($member->active)
                                    <i class="fas fa-check-circle text-[10px] mr-1"></i> Aktif
                                @else
                                    <i class="fas fa-ban text-[10px] mr-1"></i> Nonaktif
                                @endif
                            </span>
                        </td>

                        <!-- STATUS EMAIL -->
                        <td class="px-6 py-3">
                            @if($member->email_verified_at)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px] mr-1"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    <i class="fas fa-clock text-[10px] mr-1"></i> Belum Verifikasi
                                </span>
                            @endif
                        </td>

                        <!-- ✅ ACTION + TAKEDOWN PHOTO -->
                        <td class="px-6 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- EDIT -->
                                <a href="{{ route('admin.members.edit', $member->id) }}"
                                   class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition-all duration-200 flex items-center justify-center hover:scale-105"
                                   title="Edit Anggota">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <!-- ✅ TAKEDOWN FOTO -->
                                @if($member->photo)
                                <form action="{{ route('admin.members.takedownPhoto', $member->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus foto profil anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 hover:text-orange-700 transition-all duration-200 flex items-center justify-center cursor-pointer hover:scale-105"
                                            title="Takedown Foto">
                                        <i class="fas fa-times-circle text-sm"></i>
                                    </button>
                                </form>
                                @endif

                                <!-- DELETE -->
                                <form action="{{ route('admin.members.destroy', $member->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 transition-all duration-200 flex items-center justify-center cursor-pointer hover:scale-105"
                                            title="Hapus Anggota">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-4">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-users text-slate-400 text-3xl"></i>
                                </div>
                                <div>
                                    <p class="text-slate-500 font-medium text-base">Belum ada data anggota</p>
                                    <p class="text-slate-400 text-sm mt-1">Silakan tambahkan anggota pertama Anda</p>
                                </div>
                                <a href="{{ route('admin.members.create') }}" class="mt-2 px-5 py-2.5 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-all duration-200 hover:shadow-sm">
                                    <i class="fas fa-plus mr-2"></i> Tambah Anggota
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
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>

@endsection