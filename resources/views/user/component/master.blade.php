<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ultra 3D Website')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ============================================
           ORIGINAL STYLES - FULLY PRESERVED
        ============================================ */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: radial-gradient(circle at 20% 20%, #1e293b, #020617);
            color: white;
            overflow-x: hidden;
        }

        /* Glow background blobs */
        .blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #6366f1, transparent);
            filter: blur(120px);
            opacity: 0.6;
            z-index: -1;
        }

        /* Glass */
        .glass {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* 3D container */
        .tilt {
            transform-style: preserve-3d;
            transition: transform 0.2s ease;
        }

        /* Depth layers */
        .depth-1 { transform: translateZ(20px); }
        .depth-2 { transform: translateZ(40px); }
        .depth-3 { transform: translateZ(60px); }

        /* Glow */
        .glow {
            box-shadow: 0 0 60px rgba(99,102,241,0.6);
        }

        /* Floating animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .float {
            animation: float 6s ease-in-out infinite;
        }

        /* Fade */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 1s ease;
        }
        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ==========================
           🌌 FUTURISTIC 3D CURSOR
        ========================== */
        .cursor-glow {
            position: fixed;
            width: 150px;
            height: 180px;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 9999;

            /* bentuk tidak kaku (organik blob) */
            border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;

            /* multi-layer glow */
            background:
                radial-gradient(circle at 30% 30%, rgba(99, 107, 185, 0.6), transparent 60%),
                radial-gradient(circle at 70% 70%, rgba(99,102,241,0.5), transparent 70%),
                radial-gradient(circle at 50% 50%, rgba(59,130,246,0.4), transparent 80%);

            /* blur = depth */
            filter: blur(40px);

            /* smooth animation */
            animation: blobMove 8s ease-in-out infinite,
                       pulseGlow 4s ease-in-out infinite;

            transition: transform 0.2s ease, filter 0.3s ease;
        }

        /* ==========================
           🌊 ORGANIC MORPHING SHAPE
        ========================== */
        @keyframes blobMove {
            0% {
                border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;
            }
            25% {
                border-radius: 50% 60% 40% 60% / 60% 40% 60% 40%;
            }
            50% {
                border-radius: 70% 30% 60% 40% / 40% 70% 30% 60%;
            }
            75% {
                border-radius: 40% 60% 50% 50% / 60% 30% 70% 40%;
            }
            100% {
                border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;
            }
        }

        /* ==========================
           ✨ GLOW PULSE (DEPTH)
        ========================== */
        @keyframes pulseGlow {
            0%, 100% {
                filter: blur(40px) brightness(1);
            }
            50% {
                filter: blur(55px) brightness(1.3);
            }
        }

        body {
            background: linear-gradient(-45deg, #020617, #0f172a, #1e293b, #020617);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
        }

        /* 3D Card */
        .card3d {
            transform-style: preserve-3d;
            transition: transform 0.2s ease;
        }

        /* Magnetic button */
        .magnetic {
            transition: transform 0.2s ease;
        }

        /* Ripple style */
        .ripple {
            position: absolute;
            width: 20px;
            height: 20px;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            transform: scale(0);
            animation: rippleAnim 0.6s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(15);
                opacity: 0;
            }
        }

        /* NOTIF BASE */
        .notif {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 14px 20px;
            border-radius: 16px;
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            font-weight: 500;
            z-index: 9999;

            transform: translateX(120%);
            opacity: 0;

            transition: all 0.5s ease;
        }

        /* SHOW */
        .notif.show {
            transform: translateX(0);
            opacity: 1;
        }

        /* SUCCESS */
        .notif.success {
            box-shadow: 0 0 20px rgba(99,102,241,0.6);
        }

        /* WARNING */
        .notif.warning {
            box-shadow: 0 0 20px rgba(255,165,0,0.6);
        }

        /* ICON */
        .notif span {
            margin-right: 8px;
        }

        /* ===== NAVBAR STYLE YANG DIMODIFIKASI ===== */

        /* Navbar Container */
        .navbar-container {
            background: rgba(10, 15, 30, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .navbar-container:hover {
            border-color: rgba(99, 102, 241, 0.6);
            box-shadow: 0 0 25px rgba(99, 102, 241, 0.2);
        }

        /* Logo Styling */
        .nav-logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }

        /* Nav Item Modern */
        .nav-item-modern {
            position: relative;
            padding: 0.5rem 0;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            color: #e2e8f0;
        }

        .nav-item-modern a, .nav-item-modern button {
            color: inherit;
            transition: all 0.3s ease;
        }

        .nav-item-modern:hover {
            color: #a5b4fc;
            text-shadow: 0 0 8px rgba(99, 102, 241, 0.5);
        }

        /* Active Nav Item */
        .nav-item-modern.active {
            color: #ffffff;
        }

        .nav-item-modern.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            border-radius: 2px;
            box-shadow: 0 0 8px rgba(99, 102, 241, 0.6);
        }

        /* Dropdown Modern */
        .dropdown-modern {
            position: relative;
        }

        .dropdown-menu-modern {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.75rem;
            min-width: 200px;
            background: rgba(15, 25, 45, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 16px;
            padding: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 50;
        }

        .dropdown-modern:hover .dropdown-menu-modern {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item-modern {
            display: block;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            color: #cbd5e1;
            transition: all 0.2s ease;
        }

        .dropdown-item-modern:hover {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            transform: translateX(5px);
        }

        /* Submenu Modern */
        .submenu-modern {
            position: relative;
        }

        .submenu-menu-modern {
            position: absolute;
            left: 100%;
            top: 0;
            margin-left: 0.5rem;
            min-width: 180px;
            background: rgba(15, 25, 45, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 16px;
            padding: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .submenu-modern:hover .submenu-menu-modern {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        /* Login Button Modern */
        .btn-login-modern {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(99, 102, 241, 0.5);
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            cursor: pointer;
            color: #c7d2fe;
        }

        .btn-login-modern:hover {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: transparent;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }

        /* Chevron Icon */
        .chevron {
            transition: transform 0.3s ease;
        }

        .dropdown-modern:hover .chevron {
            transform: rotate(180deg);
        }

        /* Mobile Menu Button (hidden on desktop) */
        .mobile-menu-btn {
            display: none;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.4);
            border-radius: 12px;
            padding: 0.5rem;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .desktop-menu {
                display: none;
            }
            .mobile-menu-btn {
                display: block;
            }
            .navbar-container {
                border-radius: 24px;
            }
        }

        /* NAV ITEM (old - kept for compatibility) */
        .nav-item {
            position: relative;
            cursor: pointer;
            color: #ccc;
            transition: 0.3s;
        }

        .nav-item:hover {
            color: white;
            text-shadow: 0 0 10px rgba(99,102,241,0.8);
        }

        .nav-item::after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 50%;
            width: 0%;
            height: 2px;
            background: #6366f1;
            transition: 0.3s;
            transform: translateX(-50%);
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .nav-item.active {
            color: white;
        }

        .nav-item:hover {
            transform: translateY(-2px);
        }

        nav .glass {
            backdrop-filter: blur(16px);
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .animate-gradientMove {
          animation: gradientMove 4s ease infinite;
        }
        .dropdown-item {
            display: block;
            padding: 8px 12px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: rgba(26, 2, 205, 0.389);
            color: #ffffff;
            transform: translateX(5px);
        }

        /* ===== CAROUSEL BUKU STYLES UNTUK PARALLAX SECTION ===== */
        .book-carousel-full {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .book-carousel-track {
            display: flex;
            gap: 30px;
            height: 100%;
            width: max-content;
            animation: scrollBooks 40s linear infinite;
            padding: 0 20px;
        }

        .book-carousel-track:hover {
            animation-play-state: paused;
        }

        @keyframes scrollBooks {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .book-card-large {
            width: 280px;
            height: 380px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(99, 102, 241, 0.4);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            flex-shrink: 0;
            position: relative;
        }

        .book-card-large:hover {
            transform: translateY(-10px) scale(1.03);
            border-color: rgba(99, 102, 241, 0.8);
            box-shadow: 0 25px 40px -15px rgba(99, 102, 241, 0.4);
        }

        .book-cover-large {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .book-card-large:hover .book-cover-large {
            transform: scale(1.05);
        }

        .book-info-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .book-card-large:hover .book-info-overlay {
            transform: translateY(0);
        }

        .book-title-large {
            font-weight: 700;
            font-size: 0.9rem;
            color: white;
            margin-bottom: 4px;
        }

        .book-author-large {
            font-size: 0.7rem;
            color: #cbd5e1;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .book-card-large {
                width: 220px;
                height: 300px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Background blobs -->
<div class="blob top-0 left-0"></div>
<div class="blob bottom-0 right-0"></div>

<!-- Cursor glow -->
<div class="cursor-glow" id="cursorGlow"></div>
@include('user.component.navbars')

<!-- LOGIN MODAL -->
<div id="loginModal"
    class="fixed inset-0 bg-black/60 backdrop-blur-md hidden z-[9999]
           items-center justify-center opacity-0 transition duration-300">

    <div id="loginCard"
        class="max-w-md w-full glass p-8 rounded-3xl relative
               transform scale-90 opacity-0 transition duration-300">

        <!-- CLOSE -->
        <button onclick="closeLogin()"
            class="absolute top-4 right-4 text-white text-xl">
            ✕
        </button>

        <h2 class="text-2xl font-bold text-center mb-6">
            Login Account
        </h2>

        <!-- FORM -->
        <form id="loginForm" class="space-y-6">

            <input type="text" id="name"
                placeholder="NIDN/NPM"
                class="w-full p-3 rounded-xl bg-white/5 border border-gray-700 focus:ring-2 focus:ring-indigo-500">

            <input type="password" id="password"
                placeholder="Password"
                class="w-full p-3 rounded-xl bg-white/5 border border-gray-700 focus:ring-2 focus:ring-indigo-500">

            <button type="button"
                onclick="submitLogin()"
                class="magnetic w-full bg-indigo-500 py-3 rounded-full hover:scale-105 transition">
                Login
            </button>

        </form>

        <!-- SUCCESS -->
<div id="successState" class="hidden mt-6 text-center">

    <div class="glass p-6 rounded-2xl relative overflow-hidden">

        <!-- GLOW BACKGROUND -->
        <div class="absolute inset-0 bg-indigo-500/10 blur-2xl"></div>

        <!-- ICON -->
        <div class="text-5xl mb-3 animate-bounce">
            🎉
        </div>

        <h3 class="text-2xl font-bold mb-2">
            Welcome!
        </h3>

        <p class="text-gray-400 mb-6">
            Login berhasil 🚀
        </p>

        <button onclick="closeLogin()"
            class="magnetic bg-indigo-500 px-6 py-2 rounded-full hover:scale-105 transition">
            Continue
        </button>

    </div>

</div>

    </div>
</div>

{{-- ============================================
    MAIN CONTENT SECTION
============================================ --}}
<main>
    @yield('content')
</main>

<script>
// ==========================
// GLOBAL STATE
// ==========================
const state = {
    mouse: { x: 0, y: 0 },
    cart: [],
    cartOpen: false
};

// ==========================
// MOUSE TRACKING
// ==========================
document.addEventListener("mousemove", (e) => {
    state.mouse.x = e.clientX;
    state.mouse.y = e.clientY;
});


// ==========================
// FADE ANIMATION
// ==========================
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
});

document.querySelectorAll('.fade-up')
    .forEach(el => observer.observe(el));


// ==========================
// 3D CARD EFFECT
// ==========================
document.querySelectorAll('.card3d, .tilt').forEach(card => {

    card.addEventListener('mousemove', (e) => {

        const rect = card.getBoundingClientRect();

        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const rotateX = -(y - rect.height/2) / 12;
        const rotateY = (x - rect.width/2) / 12;

        card.style.transform = `
            rotateX(${rotateX}deg)
            rotateY(${rotateY}deg)
            scale(1.05)
        `;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = `rotateX(0) rotateY(0) scale(1)`;
    });

});
// ==========================
// MAGNETIC BUTTON + RIPPLE
// ==========================
document.querySelectorAll('.magnetic').forEach(btn => {

    btn.addEventListener('mousemove', (e) => {

        const rect = btn.getBoundingClientRect();

        const x = e.clientX - rect.left - rect.width/2;
        const y = e.clientY - rect.top - rect.height/2;

        btn.style.transform = `
            translate(${x * 0.3}px, ${y * 0.3}px)
            scale(1.05)
        `;
    });

    btn.addEventListener('mouseleave', () => {
        btn.style.transform = `translate(0,0) scale(1)`;
    });

    // ripple
    btn.addEventListener('click', function(e) {

        const ripple = document.createElement("span");
        ripple.classList.add("ripple");

        const rect = this.getBoundingClientRect();

        ripple.style.left = (e.clientX - rect.left) + "px";
        ripple.style.top = (e.clientY - rect.top) + "px";

        this.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
    });

});
// ==========================
// CURSOR GLOW
// ==========================
const cursor = document.getElementById('cursorGlow');

if (cursor) {
    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });
}


// ==========================
// SIMPLE PARTICLE ENGINE (OPTIMIZED)
// ==========================
const canvas = document.createElement("canvas");
document.body.appendChild(canvas);

const ctx = canvas.getContext("2d");

canvas.style.position = "fixed";
canvas.style.top = 0;
canvas.style.left = 0;
canvas.style.zIndex = "-1";

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];

for (let i = 0; i < 80; i++) {
    particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        dx: (Math.random() - 0.5),
        dy: (Math.random() - 0.5),
        r: Math.random() * 2
    });
}

function drawParticles() {

    ctx.clearRect(0,0,canvas.width,canvas.height);

    particles.forEach(p => {

        p.x += p.dx;
        p.y += p.dy;

        if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.dy *= -1;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
        ctx.fillStyle = "#6366f1";
        ctx.fill();

    });

    requestAnimationFrame(drawParticles);
}

drawParticles();
// ==========================
// LOGIN MODAL
// ==========================
function openLogin() {
    const modal = document.getElementById("loginModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function closeLogin() {
    const modal = document.getElementById("loginModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}


// ==========================
// NOTIFICATION SYSTEM
// ==========================
function showNotif(text, type="success") {

    const notif = document.createElement("div");

    notif.className = `notif ${type}`;
    notif.innerHTML = `<span>✨</span>${text}`;

    document.body.appendChild(notif);

    setTimeout(() => notif.classList.add("show"), 50);

    setTimeout(() => {
        notif.classList.remove("show");
        setTimeout(() => notif.remove(), 400);
    }, 2500);
}


// ==========================
// NAV ACTIVE
// ==========================
document.querySelectorAll(".nav-item").forEach(item => {

    item.addEventListener("click", () => {

        document.querySelectorAll(".nav-item")
            .forEach(i => i.classList.remove("active"));

        item.classList.add("active");

    });

});

</script>

@stack('scripts')
</body>
</html>
