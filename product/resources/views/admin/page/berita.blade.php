@extends('admin.component.main')

@section('title', 'Manajemen Berita - Neptix Admin')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
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
                        <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" required>
                    </div>

                    {{-- EXCERPT --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Excerpt
                        </label>
                        <input type="text" name="excerpt" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" placeholder="Ringkasan berita">
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Kategori
                        </label>
                        <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
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
                        <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                        </select>
                    </div>

                    {{-- GAMBAR --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Gambar
                        </label>
                        <input type="file" name="image" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 transition text-sm text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    </div>

                    {{-- FEATURED --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Featured
                        </label>
                        <select name="is_featured" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-plus text-xs"></i> Tambah Berita
                        </button>
                    </div>

                    {{-- CONTENT (full width) --}}
                    <div class="md:col-span-2 lg:col-span-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Isi Berita <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="content" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700" placeholder="Tulis isi berita di sini..."></textarea>
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

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Excerpt</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Featured</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Gambar</th>
                        <th class="text-center px-6 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition">
                        <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- JUDUL --}}
                            <td class="px-6 py-3">
                                <input type="text" name="title" value="{{ $item->title }}" class="w-48 px-3 py-2 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            </td>

                            {{-- KATEGORI --}}
                            <td class="px-6 py-3">
                                <select name="category" class="w-32 px-3 py-2 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                                    @foreach(['akademik','pengumuman','kegiatan','riset','fasilitas','sosial'] as $cat)
                                        <option value="{{ $cat }}" {{ $item->category == $cat ? 'selected' : '' }}>
                                            {{ ucfirst($cat) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- EXCERPT --}}
                            <td class="px-6 py-3">
                                <input type="text" name="excerpt" value="{{ $item->excerpt }}" class="w-48 px-3 py-2 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700">
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-3 text-center">
                                <select name="status" class="px-3 py-2 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700 w-28">
                                    <option value="draft" {{ $item->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ $item->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                </select>
                            </td>

                            {{-- FEATURED --}}
                            <td class="px-6 py-3 text-center">
                                <select name="is_featured" class="px-3 py-2 rounded-lg border border-slate-200 bg-slate-50/30 focus:bg-white focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm text-slate-700 w-24">
                                    <option value="0" {{ $item->is_featured == 0 ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ $item->is_featured == 1 ? 'selected' : '' }}>Ya</option>
                                </select>
                            </td>

                            {{-- GAMBAR --}}
                            <td class="px-6 py-3 text-center">
                                <input type="file" name="image" class="text-sm">
                                @if($item->image)
                                    <div class="text-xs text-slate-400 mt-1">Current: Ada</div>
                                @endif
                            </td>

                            {{-- ACTION BUTTONS --}}
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition flex items-center justify-center" title="Update">
                                        <i class="fas fa-save text-sm"></i>
                                    </button>
                        </form>

                                    {{-- DELETE FORM --}}
                                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition flex items-center justify-center" title="Hapus">
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

{{-- CKEditor Script --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor pada textarea content
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
</script>

@endsection
