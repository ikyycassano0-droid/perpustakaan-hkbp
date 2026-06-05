@extends('admin.component.main')

@section('title', 'Manajemen Berita - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">
    {{-- HEADER SECTION --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Berita</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola berita, pengumuman, dan kegiatan</p>
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
                <h3 class="font-semibold text-slate-800">Tambah Berita</h3>
            </div>
            <p class="text-slate-400 text-xs mt-0.5">Isi formulir di bawah untuk menambahkan berita baru</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- JUDUL --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Judul <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            required>
                    </div>

                    {{-- EXCERPT --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Excerpt
                        </label>
                        <input type="text" name="excerpt"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            placeholder="Ringkasan berita">
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Kategori
                        </label>
                        <select name="category"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            <option value="akademik">Akademik</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="riset">Riset</option>
                            <option value="fasilitas">Fasilitas</option>
                            <option value="sosial">Sosial</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Status
                        </label>
                        <select name="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                        </select>
                    </div>

                    {{-- GAMBAR --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Gambar
                        </label>
                        <input type="file" name="image"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    </div>

                    {{-- FEATURED --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Featured
                        </label>
                        <select name="is_featured"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-plus text-xs"></i> Tambah Berita
                        </button>
                    </div>

                    {{-- CONTENT (full width) --}}
                    <div class="md:col-span-2 lg:col-span-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Isi Berita <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="content" rows="5"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700"
                            placeholder="Tulis isi berita di sini..."></textarea>
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
                <i class="fas fa-newspaper text-white/70"></i>
                <h3 class="font-semibold text-white">Data Berita</h3>
            </div>
            <p class="text-slate-300 text-xs mt-0.5">Total: {{ $berita->count() }} berita</p>
        </div>

        {{-- Hapus overflow-x-auto agar tidak perlu scroll --}}
        <div>
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Excerpt</th>
                        <th class="text-center px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Featured</th>
                        <th class="text-center px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Gambar</th>
                        <th class="text-center px-3 py-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- JUDUL --}}
                            <td class="px-3 py-2">
                                <input type="text" name="title" value="{{ $item->title }}"
                                    class="w-36 px-2 py-1.5 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-xs text-slate-700">
                            </td>

                            {{-- KATEGORI --}}
                            <td class="px-3 py-2">
                                <select name="category"
                                    class="w-28 px-2 py-1.5 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-xs text-slate-700">
                                    @foreach(['akademik','pengumuman','kegiatan','riset','fasilitas','sosial'] as $cat)
                                    <option value="{{ $cat }}" {{ $item->category == $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- EXCERPT --}}
                            <td class="px-3 py-2">
                                <input type="text" name="excerpt" value="{{ $item->excerpt }}"
                                    class="w-36 px-2 py-1.5 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-xs text-slate-700">
                            </td>

                            {{-- STATUS --}}
                            <td class="px-3 py-2 text-center">
                                <select name="status"
                                    class="px-2 py-1.5 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-xs text-slate-700 w-20">
                                    <option value="draft" {{ $item->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ $item->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                </select>
                            </td>

                            {{-- FEATURED --}}
                            <td class="px-3 py-2 text-center">
                                <select name="is_featured"
                                    class="px-2 py-1.5 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-xs text-slate-700 w-20">
                                    <option value="0" {{ $item->is_featured == 0 ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ $item->is_featured == 1 ? 'selected' : '' }}>Ya</option>
                                </select>
                            </td>

                            {{-- GAMBAR --}}
                            <td class="px-3 py-2 text-center">
                                <input type="file" name="image" class="text-xs w-28">
                                @if($item->image)
                                <div class="text-[10px] text-slate-400 mt-0.5">Current: Ada</div>
                                @endif
                             </td>

                            {{-- ACTION BUTTONS --}}
                            <td class="px-3 py-2">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" onclick="openEditModal({{ $item->id }})" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition flex items-center justify-center" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                        </form>

                                    {{-- DELETE FORM --}}
                                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus berita ini?')"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition flex items-center justify-center"
                                            title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
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

{{-- ==================== MODAL EDIT BERITA ==================== --}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl w-full max-w-4xl mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 sticky top-0 bg-white">
            <div class="flex items-center gap-2">
                <i class="fas fa-edit text-indigo-500"></i>
                <h3 class="text-lg font-bold text-slate-800">Edit Berita</h3>
            </div>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Judul <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="edit_title" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Excerpt
                    </label>
                    <input type="text" name="excerpt" id="edit_excerpt"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition"
                        placeholder="Ringkasan berita">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kategori
                    </label>
                    <select name="category" id="edit_category"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                        <option value="akademik">Akademik</option>
                        <option value="pengumuman">Pengumuman</option>
                        <option value="kegiatan">Kegiatan</option>
                        <option value="riset">Riset</option>
                        <option value="fasilitas">Fasilitas</option>
                        <option value="sosial">Sosial</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status
                    </label>
                    <select name="status" id="edit_status"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                        <option value="draft">Draft</option>
                        <option value="publish">Publish</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Featured
                    </label>
                    <select name="is_featured" id="edit_is_featured"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Gambar Saat Ini
                    </label>
                    <div id="currentImageContainer" class="hidden">
                        <img id="currentImage" src="" class="w-20 h-20 object-cover rounded-lg shadow-sm">
                    </div>
                    <p id="noImageText" class="text-slate-400 text-sm hidden">Tidak ada gambar</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Ganti Gambar (Opsional)
                    </label>
                    <input type="file" name="image"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 transition text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    <p class="text-slate-400 text-xs mt-1">Format: JPG, PNG, GIF, WEBP. Maks 2MB</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Isi Berita <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="content" id="edit_content" rows="6"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition"
                        placeholder="Tulis isi berita di sini..."></textarea>
                </div>
            </div>

            <div class="flex gap-3 p-5 pt-0">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition shadow-sm">
                    <i class="fas fa-save text-xs mr-1"></i> Update Berita
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CKEditor Script --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor pada textarea content (form tambah)
    const contentEditor = document.querySelector('textarea[name="content"]');
    if (contentEditor) {
        ClassicEditor
            .create(contentEditor, {
                toolbar: ['heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link', 'undo', 'redo'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Data berita untuk edit modal
    const beritaData = @json($berita);

    // Fungsi untuk membuka modal edit
    function openEditModal(id) {
        const berita = beritaData.find(b => b.id == id);
        if (!berita) return;

        // Isi form edit dengan data berita
        document.getElementById('edit_title').value = berita.title || '';
        document.getElementById('edit_excerpt').value = berita.excerpt || '';
        document.getElementById('edit_category').value = berita.category || 'akademik';
        document.getElementById('edit_status').value = berita.status || 'draft';
        document.getElementById('edit_is_featured').value = berita.is_featured ? '1' : '0';
        document.getElementById('edit_content').value = berita.content || '';

        // Tampilkan gambar saat ini jika ada
        const currentImageContainer = document.getElementById('currentImageContainer');
        const noImageText = document.getElementById('noImageText');
        if (berita.image) {
            document.getElementById('currentImage').src = "{{ asset('storage') }}/" + berita.image;
            currentImageContainer.classList.remove('hidden');
            noImageText.classList.add('hidden');
        } else {
            currentImageContainer.classList.add('hidden');
            noImageText.classList.remove('hidden');
        }

        // Set action form untuk update
        const editForm = document.getElementById('editForm');
        editForm.action = "{{ url('admin/berita') }}/" + id;

        // Tampilkan modal
        const editModal = document.getElementById('editModal');
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup modal edit
    function closeEditModal() {
        const editModal = document.getElementById('editModal');
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Tutup modal saat klik background
    window.onclick = function(event) {
        const editModal = document.getElementById('editModal');
        if (event.target === editModal) {
            closeEditModal();
        }
    }
</script>

@endsection
