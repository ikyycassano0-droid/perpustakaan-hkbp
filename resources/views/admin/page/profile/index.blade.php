@extends('admin.component.main')

@section('title', 'Manajemen Profile - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Manajemen Profile Website
            </h1>

            <p class="text-slate-500 text-sm mt-0.5">
                Kelola visi misi, tugas fungsi, struktur, dan kerjasama
            </p>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500"></i>

        <p class="text-emerald-700 text-sm">
            {{ session('success') }}
        </p>
    </div>
    @endif


    {{-- ===================================================== --}}
    {{-- BUTTON TAMBAH --}}
    {{-- ===================================================== --}}
    <div class="mb-6">
        <button type="button"
            id="btnTambahForm"
            onclick="toggleTambahForm()"
            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm transition">

            <i class="fas fa-plus"></i>
            Tambah Data
        </button>
    </div>


    {{-- ===================================================== --}}
    {{-- FORM TAMBAH --}}
    {{-- ===================================================== --}}
    <div id="tambahForm" class="card-modern mb-6 hidden">

        {{-- HEADER --}}
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-transparent rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-plus-circle text-indigo-500"></i>

                <h3 class="font-semibold text-slate-800">
                    Tambah Data Profile
                </h3>
            </div>

            <p class="text-slate-400 text-xs mt-0.5">
                Isi formulir di bawah untuk menambahkan data baru
            </p>
        </div>

        {{-- BODY --}}
        <div class="p-6">

            <form action="{{ route('admin.profile.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- TYPE --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Type <span class="text-rose-500">*</span>
                        </label>

                        <select name="type"
                            id="type"
                            onchange="ubahForm()"
                            required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">

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

                        <select name="sub_type"
                            id="sub_type"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">

                            <option value="">-- Pilih Sub Type --</option>
                        </select>
                    </div>

                    {{-- TITLE --}}
                    <div id="fieldTitle">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Judul
                        </label>

                        <input type="text"
                            name="title"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- JABATAN --}}
                    <div id="fieldJabatan" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Jabatan
                        </label>

                        <input type="text"
                            name="jabatan"
                            placeholder="Contoh: Direktur"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div id="fieldDesc" class="md:col-span-2 lg:col-span-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi
                        </label>

                        <textarea name="description"
                            rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30"></textarea>
                    </div>

                    {{-- ICON --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Icon
                        </label>

                        <input type="text"
                            name="icon"
                            placeholder="fas fa-building"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- GAMBAR --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Gambar
                        </label>

                        <input type="file"
                            name="image"
                            accept="image/*"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- ORDER --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Urutan
                        </label>

                        <input type="number"
                            name="order"
                            value="1"
                            min="1"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Status
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox"
                                name="active"
                                value="1"
                                checked>

                            <span class="text-sm text-slate-600">
                                Aktifkan data ini
                            </span>
                        </label>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">

                            Tambah Data
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- ===================================================== --}}
    {{-- TABLE --}}
    {{-- ===================================================== --}}
    <div class="card-modern overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-800 to-slate-700 rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-database text-white/70"></i>

                <h3 class="font-semibold text-white">
                    Data Profile
                </h3>
            </div>

            <p class="text-slate-300 text-xs mt-0.5">
                Total: {{ $profiles->count() }} item
            </p>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full">

                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">

                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            Type
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            Judul
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            Jabatan
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @foreach($profiles as $item)

                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">

                        <td class="px-6 py-4 text-sm">
                            {{ $item->type }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $item->title }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $item->jabatan ?? '-' }}
                        </td>

                        {{-- ACTION --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-2">

                                {{-- EDIT --}}
                                <button type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $item->id }}"
                                    class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center">

                                    <i class="fas fa-edit text-sm"></i>
                                </button>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.profile.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition flex items-center justify-center">

                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    {{-- ===================================================== --}}
    {{-- MODAL EDIT --}}
    {{-- ===================================================== --}}
    @foreach($profiles as $item)

    <div class="modal fade hidden"
        id="editModal{{ $item->id }}"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-2xl border-0 shadow-2xl">

                <form action="{{ route('admin.profile.update', $item->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- HEADER --}}
                    <div class="modal-header border-b border-slate-100 px-6 py-4">

                        <div class="flex items-center gap-2">
                            <i class="fas fa-edit text-indigo-500"></i>

                            <h5 class="font-semibold text-slate-800 text-lg">
                                Edit Data Profile
                            </h5>
                        </div>

                        <button type="button"
                            class="text-slate-400 hover:text-slate-600 transition"
                            data-bs-dismiss="modal">

                            <i class="fas fa-times"></i>
                        </button>

                    </div>

                    {{-- BODY --}}
                    <div class="modal-body p-6 space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Judul
                            </label>

                            <input type="text"
                                name="title"
                                value="{{ $item->title }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jabatan
                            </label>

                            <input type="text"
                                name="jabatan"
                                value="{{ $item->jabatan }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Deskripsi
                            </label>

                            <textarea name="description"
                                rows="3"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200">{{ $item->description }}</textarea>
                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">

                        <button type="button"
                            data-bs-dismiss="modal"
                            class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">

                            Batal
                        </button>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">

                            Simpan
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    @endforeach

</div>



{{-- ========================= --}}
{{-- SCRIPT DINAMIS --}}
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
        title.querySelector('label').innerText = 'Judul';
        jabatan.classList.add('hidden');
        desc.classList.remove('hidden');
    }
    else if(type === 'tugas_fungsi'){
        subType.innerHTML += `
            <option value="tugas">Tugas</option>
            <option value="fungsi">Fungsi</option>
            <option value="tujuan">Tujuan</option>
        `;
        title.querySelector('label').innerText = 'Judul';
        jabatan.classList.add('hidden');
        desc.classList.remove('hidden');
    }
    else if(type === 'struktur'){
        subType.innerHTML += `<option value="pengurus">Pengurus</option>`;
        title.querySelector('label').innerText = 'Nama Lengkap';
        jabatan.classList.remove('hidden');
        jabatan.querySelector('label').innerText = 'Jabatan';
        desc.classList.remove('hidden');
        // Update placeholder deskripsi untuk struktur
        let descTextarea = document.querySelector('textarea[name="description"]');
        if(descTextarea) {
            descTextarea.placeholder = 'Masukkan kontak (email/telepon) atau deskripsi singkat';
        }
        return;
    }
    else if(type === 'kerjasama'){
        subType.innerHTML += `<option value="mitra">Mitra</option>`;
        title.querySelector('label').innerText = 'Nama Mitra';
        jabatan.classList.add('hidden');
        desc.classList.remove('hidden');
    }

    // Reset placeholder untuk deskripsi
    let descTextarea = document.querySelector('textarea[name="description"]');
    if(descTextarea && type !== 'struktur') {
        descTextarea.placeholder = '';
    }
    
    title.querySelector('label').innerText = 'Judul';
    jabatan.classList.add('hidden');
    desc.classList.remove('hidden');
}
</script>

{{-- Bootstrap 5 JS (untuk modal) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleTambahForm() {
    const form = document.getElementById('tambahForm');

    form.classList.toggle('hidden');
}

function ubahForm() {

    let type = document.getElementById('type').value;
    let subType = document.getElementById('sub_type');

    let title = document.getElementById('fieldTitle');
    let jabatan = document.getElementById('fieldJabatan');

    subType.innerHTML = '<option value="">-- Pilih Sub Type --</option>';

    if(type === 'struktur') {
        jabatan.classList.remove('hidden');
    } else {
        jabatan.classList.add('hidden');
    }
}
</script>
@endsection