@extends('user.component.navbars')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/20">
        <!-- Header Profil -->
        <div class="flex items-center gap-4 border-b border-white/20 pb-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-indigo-500/30 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-indigo-300 text-sm">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Tombol Edit Profil -->
        <div class="mb-4">
            <a href="{{ route('user.profile.edit') }}" class="btn-outline w-full text-sm py-2 text-center inline-block">
                ✏️ Edit Profil
            </a>
        </div>

        <!-- Menu-menu -->
        <ul class="space-y-2">
            <li>
                <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-3 ...">
                        <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-white">Pengaturan Akun</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition text-left">
                        <svg class="w-5 h-5 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-white">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
@endsection
