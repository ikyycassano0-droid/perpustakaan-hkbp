<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Akper Balige | Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }

        .overlay {
            background: linear-gradient(125deg, rgba(6, 27, 52, 0.92), rgba(2, 17, 36, 0.88));
        }

        .btn-transition {
            transition: all 0.2s ease;
        }

        input:focus {
            outline: none;
        }

        .border-accent {
            border-left: 3px solid #60a5fa;
        }
    </style>
</head>

<body class="h-screen flex antialiased">

<!-- LEFT HERO (FULL SAMA SEPERTI REFERENSI) -->
<div class="hidden lg:flex w-1/2 relative text-white overflow-hidden">

    <img src="{{ asset('assets/img/login2.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover object-center">

    <div class="absolute inset-0 overlay"></div>

    <div class="relative z-10 p-12 xl:p-16 flex flex-col justify-between w-full">

        <div class="mt-4">

            <p class="uppercase tracking-[0.2em] text-[11px] font-semibold text-blue-100 mb-8 border-accent pl-3">
                DIGITAL CURATOR EXCELLENCE
            </p>

            <h1 class="text-5xl xl:text-6xl font-extrabold leading-tight mb-6">
                Gerbang Pengetahuan <br>
                Akademi Keperawatan Balige
            </h1>

            <p class="text-gray-100 max-w-md mb-12">
                Mengakses ribuan jurnal medis, literatur keperawatan, dan arsip penelitian digital.
            </p>

            <div class="flex gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold">15k+</h2>
                    <p class="text-xs text-gray-200">KOLEKSI DIGITAL</p>
                </div>

                <div class="w-px h-8 bg-white/30"></div>

                <div>
                    <h2 class="text-3xl font-bold">24/7</h2>
                    <p class="text-xs text-gray-200">AKSES RISET</p>
                </div>
            </div>

        </div>

        <div class="text-sm text-gray-200 border-t border-white/20 pt-5">
            Akper Balige • Scientific Library
        </div>

    </div>
</div>

<!-- RIGHT LOGIN (UI FULL DIUBAH SESUAI REFERENSI 2) -->
<div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 px-6 py-10">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 px-8 py-8">

            <!-- HEADER -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Silakan masuk ke sistem perpustakaan
                </p>
            </div>

            <!-- ROLE UI (TANPA LOGIC) -->
            <div class="mb-6">
                <label class="text-xs font-bold text-gray-500 uppercase">Pilih Role</label>

                <div class="flex gap-3 mt-2">
                    <button type="button"
                        class="flex-1 py-2 rounded-xl bg-[#0c2d5c] text-white font-semibold btn-transition">
                        Mahasiswa
                    </button>

                    <button type="button"
                        class="flex-1 py-2 rounded-xl bg-gray-100 text-gray-700 font-semibold">
                        Dosen
                    </button>
                </div>
            </div>

            <!-- FORM (LOGIC TETAP AMAN) -->
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- NPM -->
                <div class="mb-5">
                    <label class="text-xs font-bold text-gray-600 uppercase">
                        NPM / NIDN
                    </label>

                    <input type="text"
                        name="npm"
                        placeholder="Masukkan NPM / NIDN"
                        class="w-full mt-1 px-4 py-3 rounded-xl border bg-gray-50 focus:bg-white focus:ring-2 focus:ring-[#0c2d5c]">
                </div>

                <!-- PASSWORD -->
                <div class="mb-5">
                    <label class="text-xs font-bold text-gray-600 uppercase">
                        Kata Sandi
                    </label>

                    <input type="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full mt-1 px-4 py-3 rounded-xl border bg-gray-50 focus:bg-white focus:ring-2 focus:ring-[#0c2d5c]">
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox">
                        Ingat saya
                    </label>

                    <a href="#" class="text-sm text-blue-600 hover:underline">
                        Lupa password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full py-3 rounded-xl bg-[#0c2d5c] text-white font-semibold hover:bg-[#082246] btn-transition">
                    MASUK
                </button>

            </form>

            <!-- FOOTER -->
            <div class="mt-8 text-center text-xs text-gray-400">
                © 2026 Akper Balige • Perpustakaan Digital
            </div>

        </div>
    </div>
</div>

</body>
</html>