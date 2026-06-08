<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Login — Akademi Keperawatan HKBP Balige</title>

    {{-- Font & CSS murni (tanpa Tailwind, mengikuti desain baru) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           RESET & BASE
        ============================================================ */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 60px 16px 40px;
        }

        /* ============================================================
           LOGIN CARD — animasi fade + slide up
        ============================================================ */
        .login-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            max-width: 380px;
            padding: 30px 40px 35px;
            animation: cardIn 0.35s ease both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0);    }
        }

        /* ============================================================
           LOGO / HEADER
        ============================================================ */
        .login-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-logo img {
            width: 72px;
            height: auto;
            display: block;
            margin: 0 auto 8px;
        }

        .login-logo .logo-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 6px;
            background: #1f7d54;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-align: center;
            line-height: 1.3;
        }

        .login-logo .institution-name {
            font-size: 13px;
            color: #555;
            font-weight: 400;
            line-height: 1.4;
        }

        /* ============================================================
           DIVIDER
        ============================================================ */
        .login-divider {
            border: none;
            border-top: 1px solid #e8e8e8;
            margin: 0 -40px 24px;
        }

        /* ============================================================
           FORM GROUP & ANIMASI STAGGER
        ============================================================ */
        .form-group {
            margin-bottom: 16px;
            animation: fieldIn 0.3s ease both;
        }
        .form-group:nth-child(2) { animation-delay: 0.10s; }
        .form-group:nth-child(3) { animation-delay: 0.18s; }

        @keyframes fieldIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0);   }
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #333;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            display: block;
            width: 100%;
            height: 36px;
            padding: 6px 36px 6px 10px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        /* state error dari server (ditambahkan class via JS atau inline) */
        .form-group input.is-error {
            border-color: #d9534f;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px rgba(217,83,79,.4);
        }

        .form-group input:focus {
            border-color: #66afe9;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
        }

        .error-msg {
            display: none;
            margin-top: 5px;
            font-size: 12px;
            color: #d9534f;
            animation: errIn 0.2s ease both;
        }
        .error-msg.visible { display: block; }

        @keyframes errIn {
            from { opacity: 0; transform: translateY(-4px); }
            to   { opacity: 1; transform: translateY(0);    }
        }

        /* toggle password */
        .toggle-password {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #999;
            display: flex;
            align-items: center;
            transition: color 0.15s ease;
        }
        .toggle-password:hover { color: #555; }

        .icon-eye, .icon-eye-off { width: 16px; height: 16px; }
        .icon-eye-off             { display: none; }

        .toggle-password.active .icon-eye     { display: none;  }
        .toggle-password.active .icon-eye-off { display: block; }

        /* footer (remember & button) */
        .login-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            animation: fieldIn 0.3s 0.26s ease both;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            user-select: none;
        }
        .remember-me input[type="checkbox"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: #1f7d54;
        }

        /* Tombol Sign In dengan loading spinner */
        .btn-signin {
            position: relative;
            background-color: #1f7d54;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 7px 18px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            transition: background-color 0.15s ease, opacity 0.15s ease;
            white-space: nowrap;
            min-width: 80px;
        }
        .btn-signin:hover:not(:disabled) { background-color: #196644; }
        .btn-signin:active:not(:disabled){ background-color: #155436; }
        .btn-signin:disabled {
            cursor: not-allowed;
            opacity: 0.75;
        }

        .btn-signin .btn-text    { transition: opacity 0.15s; }
        .btn-signin .btn-spinner { display: none; }

        .btn-signin.loading .btn-text    { opacity: 0; }
        .btn-signin.loading .btn-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            inset: 0;
        }

        .spinner-svg {
            width: 16px;
            height: 16px;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Alert global (pesan dari server) */
        .login-alert {
            display: none;
            margin-top: 16px;
            padding: 9px 12px;
            border-radius: 4px;
            font-size: 13px;
            line-height: 1.4;
            animation: errIn 0.25s ease both;
        }
        .login-alert.visible       { display: block; }
        .login-alert.alert-success {
            background: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
        }
        .login-alert.alert-error {
            background: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
        }

        @media (max-width: 480px) {
            body { padding: 30px 12px; }
            .login-card { padding: 24px 24px 28px; }
            .login-divider { margin-left: -24px; margin-right: -24px; }
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- Logo & Institusi -->
    <div class="login-logo">
        <img src="{{ asset('assets/img/logo akper.png') }}"
             alt="Logo Akper HKBP Balige"
             onerror="this.style.display='none'; document.getElementById('logo-placeholder').style.display='flex';" />
        <div class="logo-placeholder" id="logo-placeholder" style="display:none;">
            LOGO<br>AKPER
        </div>
        <span class="institution-name">AKADEMI KEPERAWATAN HKBP BALIGE</span>
    </div>

    <hr class="login-divider" />

    <!-- Alert global (pesan error/sukses dari server) -->
    <div class="login-alert" id="loginAlert" role="alert"></div>

    {{-- FORM LOGIN LARAVEL (logic tetap sama) --}}
    <form method="POST" action="{{ route('login.submit') }}" id="loginForm" novalidate>
        @csrf

        {{-- NPM / NIDN --}}
        <div class="form-group">
            <label for="npm">NPM / NIDN</label>
            <div class="input-wrap">
                <input type="text"
                       id="npm"
                       name="npm"
                       value="{{ old('npm') }}"
                       autocomplete="username"
                       placeholder="Masukkan NPM / NIDN">
            </div>
            <span class="error-msg" id="npmError"></span>
        </div>

        {{-- PASSWORD --}}
        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <div class="input-wrap">
                <input type="password"
                       id="password"
                       name="password"
                       autocomplete="current-password"
                       placeholder="Masukkan password">
                <button type="button"
                        class="toggle-password"
                        id="togglePassword"
                        aria-label="Tampilkan / sembunyikan password">
                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8 a18.45 18.45 0 015.06-5.94"/>
                        <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8 a18.5 18.5 0 01-2.16 3.19"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            <span class="error-msg" id="passwordError"></span>
        </div>

        {{-- Remember Me & Tombol --}}
        <div class="login-footer">
            <label class="remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                Ingat saya
            </label>

            <button type="submit" class="btn-signin" id="btnSignin">
                <span class="btn-text">MASUK</span>
                <span class="btn-spinner" aria-hidden="true">
                    <svg class="spinner-svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M12 2a10 10 0 0 1 10 10" opacity=".3"/>
                        <path d="M12 2a10 10 0 0 1 10 10"/>
                    </svg>
                </span>
            </button>
        </div>
    </form>
</div>

<script>
    // ==================== TOGGLE PASSWORD ====================
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    toggleBtn.addEventListener('click', function () {
        const show = passwordInput.type === 'password';
        passwordInput.type = show ? 'text' : 'password';
        this.classList.toggle('active', show);
    });

    // ==================== TAMPILKAN PESAN DARI SERVER ====================
    // (menangani error validasi Laravel atau session error/success)
    function showServerMessage() {
        const alertBox = document.getElementById('loginAlert');
        let hasError = false;
        let message = '';

        // Cek error dari validasi Laravel (@errors)
        @if ($errors->any())
            hasError = true;
            message = 'Terjadi kesalahan:<br>';
            @foreach ($errors->all() as $error)
                message += '• {{ $error }}<br>';
            @endforeach
        @endif

        // Cek session error
        @if (session('error'))
            hasError = true;
            message = '{{ session('error') }}';
        @endif

        // Cek session success
        @if (session('success'))
            alertBox.className = 'login-alert visible alert-success';
            alertBox.innerHTML = '{{ session('success') }}';
            return;
        @endif

        if (hasError && message) {
            alertBox.className = 'login-alert visible alert-error';
            alertBox.innerHTML = message;
        }
    }
    showServerMessage();

    // ==================== VALIDASI FRONTEND + LOADING SPINNER ====================
    const form = document.getElementById('loginForm');
    const btnSignin = document.getElementById('btnSignin');
    const npmInput = document.getElementById('npm');
    const pwdInput = document.getElementById('password');

    function clearFieldError(fieldId, errorId) {
        document.getElementById(fieldId).classList.remove('is-error');
        document.getElementById(errorId).classList.remove('visible');
        document.getElementById(errorId).textContent = '';
    }

    function setFieldError(fieldId, errorId, message) {
        document.getElementById(fieldId).classList.add('is-error');
        const errSpan = document.getElementById(errorId);
        errSpan.textContent = message;
        errSpan.classList.add('visible');
    }

    // Hapus error saat user mulai mengetik
    npmInput.addEventListener('input', () => clearFieldError('npm', 'npmError'));
    pwdInput.addEventListener('input', () => clearFieldError('password', 'passwordError'));

    form.addEventListener('submit', function(e) {
        // Cek validasi dasar (tidak kosong)
        let valid = true;
        const npm = npmInput.value.trim();
        const pwd = pwdInput.value;

        if (!npm) {
            setFieldError('npm', 'npmError', 'NPM / NIDN tidak boleh kosong.');
            valid = false;
        } else if (npm.length < 3) {
            setFieldError('npm', 'npmError', 'NPM / NIDN minimal 3 karakter.');
            valid = false;
        } else {
            clearFieldError('npm', 'npmError');
        }

        if (!pwd) {
            setFieldError('password', 'passwordError', 'Password tidak boleh kosong.');
            valid = false;
        } else if (pwd.length < 6) {
            setFieldError('password', 'passwordError', 'Password minimal 6 karakter.');
            valid = false;
        } else {
            clearFieldError('password', 'passwordError');
        }

        if (!valid) {
            e.preventDefault();
            return;
        }

        // Jika valid, aktifkan loading spinner dan disable tombol
        // (form akan tetap disubmit ke server)
        btnSignin.classList.add('loading');
        btnSignin.disabled = true;

        // Tidak perlu e.preventDefault(), biarkan form submit normal
        // Namun karena ada event listener, kita biarkan submit berjalan.
        // Untuk mencegah double spinner jika terjadi error server (halaman reload), tidak masalah.
    });

    // (Opsional) Jika halaman reload karena error, tombol akan kembali normal.
    // Tidak ada kode tambahan yang mengganggu backend.
</script>

</body>
</html>
