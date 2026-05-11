@extends('admin.component.main')

@section('title', 'Manajemen Profile - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Profile Website</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola visi misi, tugas fungsi, struktur, dan kerjasama</p>
        </div>
    </div>

    {{-- ALERT SUCCESS & ERROR --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500"></i>
        <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-rose-500"></i>
        <p class="text-rose-700 text-sm">{{ session('error') }}</p>
    </div>
    @endif

    {{-- BUTTON TAMBAH --}}
    <div class="mb-6">
        <button type="button" onclick="toggleTambahForm()"
            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm transition">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>

    {{-- FORM TAMBAH --}}
    <div id="tambahForm" class="card-modern mb-6 hidden">
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
                        <select name="type" id="type" onchange="ubahForm()" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                            <option value="">-- Pilih --</option>
                            <option value="visi_misi">Visi & Misi</option>
                            <option value="tugas_fungsi">Tugas & Fungsi</option>
                            <option value="struktur">Struktur</option>
                            <option value="kerjasama">Kerjasama</option>
                        </select>
                    </div>

                    {{-- SUB TYPE --}}
                    <div id="fieldSubType">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Sub Type</label>
                        <select name="sub_type" id="sub_type" onchange="ubahSubType()"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                            <option value="">-- Pilih Sub Type --</option>
                        </select>
                    </div>

                    {{-- TITLE --}}
                    <div id="fieldTitle">
                        <label class="block text-sm font-medium text-slate-700 mb-2" id="labelTitle">Judul</label>
                        <input type="text" name="title" id="title_input"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- JABATAN --}}
                    <div id="fieldJabatan" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2" id="labelJabatan">Jabatan / Peran</label>
                        <input type="text" name="jabatan" id="jabatan_input" placeholder="Contoh: Direktur / Institusi Mitra"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div id="fieldDesc" class="md:col-span-2 lg:col-span-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="descriptionTextarea" rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30"></textarea>
                    </div>

                    {{-- ICON --}}
                    <div id="fieldIcon">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Icon</label>
                        <input type="text" name="icon" id="icon_input" placeholder="fas fa-building"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                        <p class="text-slate-400 text-xs mt-1">Contoh: fas fa-building, fas fa-handshake</p>
                    </div>

                    {{-- GAMBAR --}}
                    <div id="fieldGambar">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Gambar</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                        <p class="text-slate-400 text-xs mt-1">Format: JPG, PNG, GIF, WEBP. Maks 2MB</p>
                    </div>

                    {{-- ORDER --}}
                    <div id="fieldOrder">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Urutan</label>
                        <input type="number" name="order" id="order_input" value="1" min="1"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30">
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="active" value="1" checked>
                            <span class="text-sm text-slate-600">Aktifkan data ini</span>
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

    {{-- TABLE --}}
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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Sub Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jabatan</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Gambar</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $item)
                    @php
                        $typeLabels = [
                            'visi_misi'    => 'Visi & Misi',
                            'tugas_fungsi' => 'Tugas & Fungsi',
                            'struktur'     => 'Struktur',
                            'kerjasama'    => 'Kerjasama',
                        ];
                        $isKolaborasi = ($item->type === 'kerjasama' && $item->sub_type === 'kolaborasi');
                    @endphp
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <td class="px-6 py-4 text-sm">{{ $typeLabels[$item->type] ?? $item->type }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->sub_type ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->title ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->jabatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}"
                                     class="w-12 h-12 object-cover rounded-lg mx-auto shadow-sm" alt="Gambar">
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->active)
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px] mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                    <i class="fas fa-circle text-[8px] mr-1"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                        onclick="openEditModal({{ $item->id }})"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <form action="{{ route('admin.profile.destroy', $item->id) }}" method="POST"
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

</div>

{{-- MODAL EDIT (Single Modal) --}}
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-50 transition-opacity" onclick="closeEditModal()"></div>
        
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-auto transform transition-all">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header border-b border-slate-100 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-edit text-indigo-500"></i>
                        <h5 class="font-semibold text-slate-800 text-lg">Edit Data Profile</h5>
                    </div>
                    <button type="button" onclick="closeEditModal()" class="absolute right-6 top-4 text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body p-6 space-y-4">
                    <input type="hidden" id="edit_id" name="id">
                    
                    {{-- Type (readonly) --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Type</label>
                        <input type="text" id="edit_type_display" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100" readonly>
                        <input type="hidden" id="edit_type" name="type">
                    </div>

                    {{-- Sub Type Container --}}
                    <div id="edit_subtype_container">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Sub Type</label>
                        <input type="text" id="edit_subtype_display" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100" readonly>
                        <input type="hidden" id="edit_sub_type" name="sub_type">
                    </div>

                    {{-- Judul --}}
                    <div id="edit_title_container">
                        <label class="block text-sm font-medium text-slate-700 mb-2" id="edit_label_title">Judul</label>
                        <input type="text" id="edit_title" name="title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                    </div>

                    {{-- Jabatan --}}
                    <div id="edit_jabatan_container" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jabatan</label>
                        <input type="text" id="edit_jabatan" name="jabatan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                    </div>

                    {{-- Deskripsi --}}
                    <div id="edit_desc_container">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                        <textarea id="edit_description" name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200"></textarea>
                    </div>

                    {{-- Icon --}}
                    <div id="edit_icon_container">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Icon</label>
                        <input type="text" id="edit_icon" name="icon" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                        <p class="text-slate-400 text-xs mt-1">Contoh: fas fa-building, fas fa-handshake</p>
                    </div>

                    {{-- Gambar Saat Ini --}}
                    <div id="edit_current_image_container" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Gambar Saat Ini</label>
                        <div class="flex justify-center">
                            <img id="edit_current_image" src="" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                        </div>
                    </div>

                    {{-- Upload Gambar Baru --}}
                    <div id="edit_image_container">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Ganti Gambar (Opsional)</label>
                        <input type="file" id="edit_image" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                        <p class="text-slate-400 text-xs mt-1">Format: JPG, PNG, GIF, WEBP. Maks 2MB</p>
                    </div>

                    {{-- Urutan --}}
                    <div id="edit_order_container">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Urutan</label>
                        <input type="number" id="edit_order" name="order" min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="edit_active" name="active" value="1">
                            <span class="text-sm text-slate-600">Aktifkan data ini</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer border-t border-slate-100 px-6 py-4 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Data dari server untuk validasi
const existingVisi = {{ \App\Models\Profile::where('type', 'visi_misi')->where('sub_type', 'visi')->where('active', true)->exists() ? 'true' : 'false' }};
const existingAbout = {{ \App\Models\Profile::where('type', 'visi_misi')->where('sub_type', 'about')->where('active', true)->exists() ? 'true' : 'false' }};

function toggleTambahForm() {
    document.getElementById('tambahForm').classList.toggle('hidden');
}

function ubahForm() {
    const type       = document.getElementById('type').value;
    const subType    = document.getElementById('sub_type');
    const fieldSub   = document.getElementById('fieldSubType');
    const fieldTitle = document.getElementById('fieldTitle');
    const labelTitle = document.getElementById('labelTitle');
    const fieldJabatan = document.getElementById('fieldJabatan');
    const fieldDesc  = document.getElementById('fieldDesc');
    const fieldIcon  = document.getElementById('fieldIcon');
    const fieldGambar = document.getElementById('fieldGambar');
    const fieldOrder = document.getElementById('fieldOrder');
    const descTA     = document.getElementById('descriptionTextarea');

    // Reset
    subType.innerHTML = '<option value="">-- Pilih Sub Type --</option>';
    fieldSub.classList.remove('hidden');
    fieldTitle.classList.remove('hidden');
    fieldJabatan.classList.add('hidden');
    fieldDesc.classList.remove('hidden');
    fieldIcon.classList.remove('hidden');
    fieldGambar.classList.remove('hidden');
    fieldOrder.classList.remove('hidden');
    labelTitle.innerText = 'Judul';

    if (type === 'visi_misi') {
        // Hanya tampilkan visi jika belum ada
        if (!existingVisi) {
            subType.innerHTML += `<option value="visi">Visi</option>`;
        }
        subType.innerHTML += `<option value="misi">Misi</option>`;
        // Hanya tampilkan about jika belum ada
        if (!existingAbout) {
            subType.innerHTML += `<option value="about">About</option>`;
        }
        descTA.placeholder = 'Masukkan deskripsi Visi/Misi/About';
    }
    else if (type === 'tugas_fungsi') {
        subType.innerHTML += `
            <option value="tugas">Tugas</option>
            <option value="fungsi">Fungsi</option>
            <option value="tujuan">Tujuan</option>`;
        descTA.placeholder = 'Masukkan deskripsi Tugas/Fungsi/Tujuan';
    }
    else if (type === 'struktur') {
        subType.innerHTML += `<option value="pengurus">Pengurus</option>`;
        labelTitle.innerText = 'Nama Lengkap';
        fieldJabatan.classList.remove('hidden');
        fieldJabatan.querySelector('label').innerText = 'Jabatan';
        fieldIcon.classList.add('hidden');
        descTA.placeholder = 'Kontak atau deskripsi singkat';
    }
    else if (type === 'kerjasama') {
        subType.innerHTML += `
            <option value="mitra">Mitra</option>
            <option value="bentuk">Bentuk Kerjasama</option>
            <option value="kolaborasi">Kolaborasi</option>`;
        descTA.placeholder = 'Masukkan deskripsi kerjasama';
        subType.onchange = ubahSubType;
    }
    else {
        descTA.placeholder = '';
    }
}

function ubahSubType() {
    const type    = document.getElementById('type').value;
    const subVal  = document.getElementById('sub_type').value;
    const fieldTitle  = document.getElementById('fieldTitle');
    const fieldJabatan = document.getElementById('fieldJabatan');
    const fieldDesc   = document.getElementById('fieldDesc');
    const fieldIcon   = document.getElementById('fieldIcon');
    const fieldOrder  = document.getElementById('fieldOrder');
    const fieldGambar = document.getElementById('fieldGambar');

    if (type === 'kerjasama' && subVal === 'kolaborasi') {
        // Kolaborasi: hanya gambar yang tampil
        fieldTitle.classList.add('hidden');
        fieldJabatan.classList.add('hidden');
        fieldDesc.classList.add('hidden');
        fieldIcon.classList.add('hidden');
        fieldOrder.classList.add('hidden');
    } else {
        // Restore untuk kerjasama non-kolaborasi
        fieldTitle.classList.remove('hidden');
        fieldDesc.classList.remove('hidden');
        fieldIcon.classList.remove('hidden');
        fieldOrder.classList.remove('hidden');
        fieldGambar.classList.remove('hidden');
    }
}

// Data profiles dari server untuk edit modal
const profilesData = @json($profiles);

function openEditModal(id) {
    const profile = profilesData.find(p => p.id == id);
    if (!profile) return;

    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const actionUrl = `/admin/profile/${profile.id}`;
    editForm.action = actionUrl;

    // Set values
    document.getElementById('edit_id').value = profile.id;
    document.getElementById('edit_type_display').value = getTypeLabel(profile.type);
    document.getElementById('edit_type').value = profile.type;
    
    // Handle sub type
    const subtypeContainer = document.getElementById('edit_subtype_container');
    if (profile.sub_type) {
        subtypeContainer.classList.remove('hidden');
        document.getElementById('edit_subtype_display').value = profile.sub_type;
        document.getElementById('edit_sub_type').value = profile.sub_type;
    } else {
        subtypeContainer.classList.add('hidden');
    }

    const isKolaborasi = (profile.type === 'kerjasama' && profile.sub_type === 'kolaborasi');
    const isStruktur = (profile.type === 'struktur');

    if (isKolaborasi) {
        // Kolaborasi: hanya gambar
        document.getElementById('edit_title_container').classList.add('hidden');
        document.getElementById('edit_jabatan_container').classList.add('hidden');
        document.getElementById('edit_desc_container').classList.add('hidden');
        document.getElementById('edit_icon_container').classList.add('hidden');
        document.getElementById('edit_order_container').classList.add('hidden');
    } else {
        document.getElementById('edit_title_container').classList.remove('hidden');
        document.getElementById('edit_desc_container').classList.remove('hidden');
        document.getElementById('edit_icon_container').classList.remove('hidden');
        document.getElementById('edit_order_container').classList.remove('hidden');
        
        // Handle title label
        const labelTitle = document.getElementById('edit_label_title');
        labelTitle.innerText = isStruktur ? 'Nama Lengkap' : 'Judul';
        
        // Set title
        document.getElementById('edit_title').value = profile.title || '';
        
        // Handle jabatan (only for struktur)
        if (isStruktur) {
            document.getElementById('edit_jabatan_container').classList.remove('hidden');
            document.getElementById('edit_jabatan').value = profile.jabatan || '';
        } else {
            document.getElementById('edit_jabatan_container').classList.add('hidden');
        }
        
        // Set description
        document.getElementById('edit_description').value = profile.description || '';
        
        // Handle icon (hidden for struktur)
        if (isStruktur) {
            document.getElementById('edit_icon_container').classList.add('hidden');
        } else {
            document.getElementById('edit_icon_container').classList.remove('hidden');
            document.getElementById('edit_icon').value = profile.icon || '';
        }
        
        // Set order
        document.getElementById('edit_order').value = profile.order || 1;
    }

    // Handle current image
    const currentImageContainer = document.getElementById('edit_current_image_container');
    if (profile.image) {
        currentImageContainer.classList.remove('hidden');
        document.getElementById('edit_current_image').src = `/storage/${profile.image}`;
    } else {
        currentImageContainer.classList.add('hidden');
    }

    // Handle active status
    document.getElementById('edit_active').checked = profile.active == 1;

    // Show modal
    editModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const editModal = document.getElementById('editModal');
    editModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditModal();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    if (typeSelect && typeSelect.value) ubahForm();
});

function getTypeLabel(type) {
    const labels = {
        'visi_misi': 'Visi & Misi',
        'tugas_fungsi': 'Tugas & Fungsi',
        'struktur': 'Struktur',
        'kerjasama': 'Kerjasama'
    };
    return labels[type] || type;
}
</script>

<style>
/* Modal styles */
.fixed {
    position: fixed;
}
.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.z-50 {
    z-index: 50;
}
.overflow-y-auto {
    overflow-y: auto;
}
.bg-opacity-50 {
    --tw-bg-opacity: 0.5;
}
.transition-opacity {
    transition-property: opacity;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
.hidden {
    display: none;
}
</style>

@endsection