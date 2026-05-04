@extends('admin.component.main')

@section('title', 'Manajemen Profile - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Profile Website</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola visi misi, tugas fungsi, struktur, dan kerjasama</p>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- ========================= --}}
    {{-- FORM TAMBAH --}}
    {{-- ========================= --}}
    <div class="card-modern mb-6">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-transparent rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-plus-circle text-indigo-500"></i>
                <h3 class="font-semibold text-slate-800">Tambah Data Profile</h3>
            </div>
            <p class="text-slate-400 text-xs mt-0.5">Isi formulir di bawah untuk menambahkan data baru</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- TYPE --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Type <span class="text-rose-500">*</span>
                        </label>
                        <select name="type" id="type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" required onchange="ubahForm()">
                            <option value="">-- Pilih --</option>
                            <option value="visi_misi">Visi & Misi</option>
                            <option value="tugas_fungsi">Tugas & Fungsi</option>
                            <option value="struktur">Struktur</option>
                            <option value="kerjasama">Kerjasama</option>
                        </select>
                    </div>

                    {{-- SUB TYPE --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Sub Type
                        </label>
                        <select name="sub_type" id="sub_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            <option value="">-- Pilih Sub Type --</option>
                        </select>
                    </div>

                    {{-- TITLE --}}
                    <div id="fieldTitle">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Judul
                        </label>
                        <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                    </div>

                    {{-- JABATAN (hidden by default) --}}
                    <div id="fieldJabatan" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Jabatan
                        </label>
                        <input type="text" name="jabatan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div id="fieldDesc" class="md:col-span-2 lg:col-span-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"></textarea>
                    </div>

                    {{-- ICON --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Icon
                        </label>
                        <div class="relative">
                            <i class="fas fa-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" name="icon" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" placeholder="fas fa-building">
                        </div>
                        <p class="text-slate-400 text-[11px] mt-1">Contoh: fas fa-building, fas fa-users</p>
                    </div>

                    {{-- IMAGE --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Gambar
                        </label>
                        <input type="file" name="image" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    </div>

                    {{-- ORDER --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Urutan <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="order" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" value="1" min="1" required>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-save text-xs"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TABLE DATA --}}
    {{-- ========================= --}}
    <div class="card-modern overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-800 to-slate-700 rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-database text-white/70"></i>
                <h3 class="font-semibold text-white">Data Profile</h3>
            </div>
            <p class="text-slate-300 text-xs mt-0.5">Total: {{ $profiles->count() }} item</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Sub Type</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jabatan</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Urutan</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Aktif</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        {{-- TYPE --}}
                        <td class="px-6 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                @if($item->type == 'visi_misi') bg-sky-100 text-sky-700
                                @elseif($item->type == 'tugas_fungsi') bg-emerald-100 text-emerald-700
                                @elseif($item->type == 'struktur') bg-purple-100 text-purple-700
                                @elseif($item->type == 'kerjasama') bg-amber-100 text-amber-700
                                @else bg-slate-100 text-slate-600
                                @endif
                            ">
                                {{ strtoupper(str_replace('_', ' ', $item->type)) }}
                            </span>
                        </td>

                        {{-- SUB TYPE --}}
                        <td class="px-6 py-3 text-sm text-slate-600">
                            {{ $item->sub_type ?? '-' }}
                        </td>

                        {{-- JUDUL --}}
                        <td class="px-6 py-3 text-sm font-medium text-slate-700">
                            {{ $item->title ?? '-' }}
                        </td>

                        {{-- JABATAN --}}
                        <td class="px-6 py-3 text-sm text-slate-600">
                            {{ $item->jabatan ?? '-' }}
                        </td>

                        {{-- DESKRIPSI --}}
                        <td class="px-6 py-3 text-sm text-slate-500 max-w-xs truncate">
                            {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                        </td>

                        {{-- ORDER --}}
                        <td class="px-6 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">
                                {{ $item->order }}
                            </span>
                        </td>

                        {{-- ACTIVE STATUS --}}
                        <td class="px-6 py-3 text-center">
                            @if($item->active)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px] mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                    <i class="fas fa-circle text-[8px] mr-1"></i> Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- ACTION BUTTONS --}}
                        <td class="px-6 py-3">
                            <div class="flex items-center justify-center gap-2">
                                {{-- EDIT BUTTON (trigger modal) --}}
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                        title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>

                                {{-- DELETE FORM --}}
                                <form action="{{ route('admin.profile.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline-block">
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

                    {{-- ========================= --}}
                    {{-- MODAL EDIT --}}
                    {{-- ========================= --}}
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-2xl border-0 shadow-2xl">
                                <form action="{{ route('admin.profile.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header border-b border-slate-100 px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-edit text-indigo-500"></i>
                                            <h5 class="font-semibold text-slate-800 text-lg">Edit Data Profile</h5>
                                        </div>
                                        <button type="button" class="text-slate-400 hover:text-slate-600 transition" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body p-6 space-y-4">
                                        {{-- JUDUL --}}
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Judul</label>
                                            <input type="text" name="title" value="{{ $item->title }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                                        </div>

                                        {{-- JABATAN --}}
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Jabatan</label>
                                            <input type="text" name="jabatan" value="{{ $item->jabatan }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                                        </div>

                                        {{-- DESKRIPSI --}}
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                                            <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">{{ $item->description }}</textarea>
                                        </div>

                                        {{-- URUTAN --}}
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Urutan</label>
                                            <input type="number" name="order" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" value="{{ $item->order }}" min="1" required>
                                        </div>

                                        {{-- GAMBAR --}}
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Gambar</label>
                                            <input type="file" name="image" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                                            @if($item->image)
                                                <p class="text-slate-400 text-[11px] mt-1">Gambar saat ini: {{ basename($item->image) }}</p>
                                            @endif
                                        </div>

                                        {{-- ACTIVE CHECKBOX --}}
                                        <div class="flex items-center gap-3 pt-2">
                                            <input type="checkbox" name="active" id="active{{ $item->id }}" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ $item->active ? 'checked' : '' }}>
                                            <label for="active{{ $item->id }}" class="text-sm font-medium text-slate-700">Aktifkan data ini</label>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                                        <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                                            <i class="fas fa-save text-xs"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- SCRIPT DINAMIS (TIDAK DIUBAH) --}}
{{-- ========================= --}}
<script>
function ubahForm() {
    let type = document.getElementById('type').value;
    let subType = document.getElementById('sub_type');

    let title = document.getElementById('fieldTitle');
    let jabatan = document.getElementById('fieldJabatan');
    let desc = document.getElementById('fieldDesc');

    subType.innerHTML = '<option value="">-- Pilih Sub Type --</option>';

    if(type === 'visi_misi'){
        subType.innerHTML += `
            <option value="visi">Visi</option>
            <option value="misi">Misi</option>
            <option value="about">About</option>
        `;
    }

    if(type === 'tugas_fungsi'){
        subType.innerHTML += `
            <option value="tugas">Tugas</option>
            <option value="fungsi">Fungsi</option>
            <option value="tujuan">Tujuan</option>
        `;
    }

    if(type === 'struktur'){
        subType.innerHTML += `<option value="pengurus">Pengurus</option>`;
        title.querySelector('label').innerText = 'Nama';
        jabatan.classList.remove('hidden');
        desc.classList.add('hidden');
        return;
    }

    // default
    title.querySelector('label').innerText = 'Judul';
    jabatan.classList.add('hidden');
    desc.classList.remove('hidden');
}
</script>

{{-- Bootstrap 5 JS (untuk modal) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection