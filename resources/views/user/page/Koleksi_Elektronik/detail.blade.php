@extends('user.component.master')

@section('title', 'Detail Koleksi')

@section('content')
<div class="max-w-6xl mx-auto px-5 pt-32 pb-16">

    <div class="bg-slate-900/70 border border-indigo-500/20 rounded-3xl p-8 backdrop-blur-xl">

        <div class="grid md:grid-cols-3 gap-8">

            {{-- COVER --}}
            <div>
                @if($item->cover_image)
                    <img
                        src="{{ asset('storage/'.$item->cover_image) }}"
                        class="w-full rounded-2xl shadow-lg"
                    >
                @else
                    <div class="aspect-[3/4] rounded-2xl bg-slate-800 flex items-center justify-center text-6xl">
                        📚
                    </div>
                @endif
            </div>

            {{-- DETAIL --}}
            <div class="md:col-span-2">

                <div class="mb-3">
                    <span class="px-4 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-sm">
                        {{ $item->category->name ?? '-' }}
                    </span>
                </div>

                <h1 class="text-4xl font-bold text-white mb-4">
                    {{ $item->title }}
                </h1>

                <div class="space-y-3 text-gray-300">

                    <div>
                        <span class="text-indigo-300 font-semibold">
                            Tanggal Upload:
                        </span>
                        {{ $item->created_at->format('d M Y') }}
                    </div>

                    @if($item->isbn)
                    <div>
                        <span class="text-indigo-300 font-semibold">
                            ISBN:
                        </span>
                        {{ $item->isbn }}
                    </div>
                    @endif

                    @if($item->keywords)
                    <div>
                        <span class="text-indigo-300 font-semibold">
                            Keywords:
                        </span>

                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($item->keywords as $keyword)
                                <span class="px-3 py-1 rounded-full bg-slate-800 text-sm">
                                    #{{ $keyword }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <span class="text-indigo-300 font-semibold">
                            Deskripsi:
                        </span>

                        <p class="mt-2 leading-relaxed text-gray-400">
                            {{ $item->abstract ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex flex-wrap gap-4 mt-8">

                    @if($item->file_url)
                        <a href="{{ asset('storage/'.$item->file_url) }}"
                           target="_blank"
                           class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold">
                            📥 Buka File
                        </a>
                    @endif

                    <a href="{{ url()->previous() }}"
                       class="px-6 py-3 rounded-xl border border-indigo-400/30 text-indigo-300 hover:bg-indigo-500/10 transition">
                        ← Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection