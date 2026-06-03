{{-- resources/views/guest/page/informasi/panduan.blade.php --}}
@extends('guest.component.master')

@section('title', 'Panduan Layanan - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN PANDUAN (GAYA KLASIK HIJAU)
       Tidak mengganggu master layout
    ============================================ */

    /* Matrix container (canvas background) */
    .matrix-container {
        position: relative;
        background: #ffffff;
        min-height: 100vh;
        perspective: 1500px;
    }

    #matrix-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
    }

    /* Content container (guide grid) */
    .content-container {
        max-width: 1300px;
        margin: 0 auto;
        position: relative;
        z-index: 5;
        padding: 80px 20px;
    }

    /* Search & Filter (gaya klasik) */
    .search-box {
        margin-bottom: 30px;
    }
    .search-input {
        width: 100%;
        padding: 14px 20px;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        font-size: 1rem;
        background: white;
        transition: 0.3s;
        outline: none;
    }
    .search-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(26, 107, 71, 0.2);
    }
    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 40px;
    }
    .filter-btn {
        padding: 8px 20px;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        transition: 0.3s;
    }
    .filter-btn.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    .filter-btn:hover:not(.active) {
        background: #eef3ef;
        border-color: var(--accent-green);
    }

    .guide-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 35px;
    }

    .guide-card {
        background: var(--card-bg);
        padding: 50px 35px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        transition: transform 0.1s ease-out, box-shadow 0.3s ease;
        transform-style: preserve-3d;
        text-align: left;
    }

    .guide-card:hover {
        box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background: #eef5f1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--primary-color);
        font-size: 1.5rem;
        transform: translateZ(40px);
    }

    .guide-card h3 {
        color: var(--text-dark);
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 15px;
        transform: translateZ(30px);
    }

    .guide-card p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 30px;
        transform: translateZ(20px);
    }

    .link-action {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transform: translateZ(25px);
        transition: 0.3s;
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
    }

    .link-action:hover {
        color: var(--accent-green);
        gap: 12px;
    }

    /* Notification (opsional) */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: var(--deep-green);
        color: white;
        border-radius: 12px;
        z-index: 1000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .notification.show {
        transform: translateX(0);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .guide-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="matrix-container">
    <canvas id="matrix-canvas"></canvas>
    <div class="content-container">

        <!-- Guide Grid -->
        <div class="guide-grid" id="guideGrid">
            @forelse($panduan ?? [] as $item)
                <div class="guide-card" data-category="{{ strtolower($item->category ?? 'umum') }}" data-title="{{ $item->title }}" data-desc="{{ $item->description }}">
                    <div class="icon-circle">{!! $item->icon ?? '<i class="fas fa-file-alt"></i>' !!}</div>
                    <h3>{{ $item->title }}</h3>
                    <p>{{ $item->description }}</p>
                    @php
                        $hasFile = isset($item->files) && count($item->files) > 0;
                    @endphp
                    @if($hasFile)
                        <button class="link-action" onclick="downloadFile('{{ $item->files[0]->url ?? '#' }}', '{{ $item->files[0]->original_name ?? 'panduan' }}')">
                            Unduh PDF <i class="fas fa-download"></i>
                        </button>
                    @else
                        <a href="{{ $item->link ?? '#' }}" class="link-action">
                            {{ $item->button_text ?? 'Selengkapnya' }} <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif
                </div>
            @empty
                <!-- Data statis fallback -->
                <div class="guide-card" data-category="umum">
                    <div class="icon-circle"><i class="fas fa-user-plus"></i></div>
                    <h3>Pendaftaran</h3>
                    <p>Langkah mudah mendaftar sebagai anggota resmi perpustakaan untuk mahasiswa.</p>
                    <a href="#" class="link-action">Unduh PDF <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="guide-card" data-category="umum">
                    <div class="icon-circle"><i class="fas fa-exchange-alt"></i></div>
                    <h3>SOP Pinjaman</h3>
                    <p>Aturan peminjaman buku, batas waktu, dan prosedur perpanjangan buku fisik.</p>
                    <a href="#" class="link-action">Lihat Selengkapnya <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="guide-card" data-category="umum">
                    <div class="icon-circle"><i class="fas fa-cloud-upload-alt"></i></div>
                    <h3>Unggah KTI</h3>
                    <p>Panduan pengunggahan mandiri Tugas Akhir ke Repositori sebagai syarat lulus.</p>
                    <a href="#" class="link-action">Buka Tutorial <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="guide-card" data-category="umum">
                    <div class="icon-circle"><i class="fas fa-book-reader"></i></div>
                    <h3>Koleksi Digital</h3>
                    <p>Cara mengakses ribuan E-book dan Jurnal internasional secara online.</p>
                    <a href="#" class="link-action">Mulai Baca <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="guide-card" data-category="umum">
                    <div class="icon-circle"><i class="fas fa-search-plus"></i></div>
                    <h3>Cek Plagiasi</h3>
                    <p>Layanan Turnitin untuk memastikan orisinalitas karya tulis ilmiah mahasiswa.</p>
                    <a href="#" class="link-action">Prosedur Cek <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="guide-card" data-category="umum">
                    <div class="icon-circle"><i class="fas fa-headset"></i></div>
                    <h3>Bantuan Teknis</h3>
                    <p>Hubungi admin jika Anda mengalami kendala pada akun atau akses website.</p>
                    <a href="#" class="link-action">Chat Admin <i class="fas fa-chevron-right"></i></a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div id="notification" class="notification"></div>
@endsection

@push('scripts')
<script>
    // ============================================
    // CANVAS PARTIKEL & 3D STRUCTURE (WARNA HIJAU)
    // ============================================
    (function() {
        const canvas = document.getElementById('matrix-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationId = null;
        const mouse = { x: null, y: null, radius: 180 };

        function resizeCanvas() {
            const container = canvas.parentElement;
            canvas.width = container.clientWidth;
            canvas.height = container.clientHeight;
        }

        window.addEventListener('resize', () => {
            resizeCanvas();
            particles = [];
            for (let i = 0; i < 90; i++) particles.push(new Particle());
        });

        window.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        });

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 1;
                this.speedX = Math.random() * 1.5 - 0.75;
                this.speedY = Math.random() * 1.5 - 0.75;
                this.density = (Math.random() * 30) + 5;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < mouse.radius) {
                    let force = (mouse.radius - distance) / mouse.radius;
                    this.x -= (dx / distance) * force * this.density;
                    this.y -= (dy / distance) * force * this.density;
                }
            }
            draw() {
                ctx.fillStyle = 'rgba(26, 107, 71, 0.25)';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        const vertices = [
            { x: -1, y: 0.618, z: 0 }, { x: 1, y: 0.618, z: 0 }, { x: -1, y: -0.618, z: 0 }, { x: 1, y: -0.618, z: 0 },
            { x: 0, y: -1, z: 0.618 }, { x: 0, y: 1, z: 0.618 }, { x: 0, y: -1, z: -0.618 }, { x: 0, y: 1, z: -0.618 },
            { x: 0.618, y: 0, z: -1 }, { x: 0.618, y: 0, z: 1 }, { x: -0.618, y: 0, z: -1 }, { x: -0.618, y: 0, z: 1 }
        ];

        const structs = [
            { posX: 0.15, posY: 0.25, size: 140, rotX: 0, rotY: 0, rotZ: 0, speedX: 0.005, speedY: 0.007 },
            { posX: 0.85, posY: 0.35, size: 170, rotX: 0, rotY: 0, rotZ: 0, speedX: -0.004, speedY: 0.006 },
            { posX: 0.20, posY: 0.80, size: 150, rotX: 0, rotY: 0, rotZ: 0, speedX: 0.006, speedY: -0.005 },
            { posX: 0.80, posY: 0.85, size: 160, rotX: 0, rotY: 0, rotZ: 0, speedX: -0.005, speedY: -0.004 }
        ];

        function rotate3D(v, rotX, rotY, rotZ) {
            let x = v.x, y = v.y, z = v.z;
            let cosX = Math.cos(rotX), sinX = Math.sin(rotX);
            let y1 = y * cosX - z * sinX;
            let z1 = y * sinX + z * cosX;
            let cosY = Math.cos(rotY), sinY = Math.sin(rotY);
            let x2 = x * cosY + z1 * sinY;
            let z2 = -x * sinY + z1 * cosY;
            let cosZ = Math.cos(rotZ), sinZ = Math.sin(rotZ);
            let x3 = x2 * cosZ - y1 * sinZ;
            let y3 = x2 * sinZ + y1 * cosZ;
            return { x: x3, y: y3, z: z2 };
        }

        function draw3DStructs() {
            structs.forEach(st => {
                st.rotX += st.speedX;
                st.rotY += st.speedY;
                st.rotZ += 0.002;
                const centerX = st.posX * canvas.width;
                const centerY = st.posY * canvas.height;
                const projected = vertices.map(v => {
                    let r = rotate3D(v, st.rotX, st.rotY, st.rotZ);
                    return { x: centerX + r.x * st.size, y: centerY + r.y * st.size };
                });
                ctx.beginPath();
                ctx.strokeStyle = 'rgba(26, 107, 71, 0.4)';
                ctx.lineWidth = 2;
                for (let i = 0; i < projected.length; i++) {
                    for (let j = i + 1; j < projected.length; j++) {
                        let d = Math.hypot(vertices[i].x - vertices[j].x, vertices[i].y - vertices[j].y, vertices[i].z - vertices[j].z);
                        if (d < 1.5) {
                            ctx.moveTo(projected[i].x, projected[i].y);
                            ctx.lineTo(projected[j].x, projected[j].y);
                        }
                    }
                }
                ctx.stroke();
            });
        }

        function connectParticles() {
            for (let a = 0; a < particles.length; a++) {
                for (let b = a; b < particles.length; b++) {
                    let dx = particles[a].x - particles[b].x;
                    let dy = particles[a].y - particles[b].y;
                    let dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 110) {
                        let mDist = Math.sqrt((mouse.x - particles[a].x) ** 2 + (mouse.y - particles[a].y) ** 2);
                        ctx.strokeStyle = `rgba(26, 107, 71, ${mDist < 200 ? 0.2 : 0.05})`;
                        ctx.lineWidth = 0.4;
                        ctx.beginPath();
                        ctx.moveTo(particles[a].x, particles[a].y);
                        ctx.lineTo(particles[b].x, particles[b].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            if (!ctx) return;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            draw3DStructs();
            connectParticles();
            particles.forEach(p => { p.update(); p.draw(); });
            animationId = requestAnimationFrame(animate);
        }

        function init() {
            resizeCanvas();
            for (let i = 0; i < 90; i++) particles.push(new Particle());
            animate();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();

    // ============================================
    // TILT EFFECT UNTUK KARTU (3D)
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.guide-card');
        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const rX = ((e.clientY - rect.top - rect.height / 2) / rect.height) * -20;
                const rY = ((e.clientX - rect.left - rect.width / 2) / rect.width) * 20;
                card.style.transform = `rotateX(${rX}deg) rotateY(${rY}deg) translateY(-10px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = `rotateX(0deg) rotateY(0deg) translateY(0px)`;
            });
        });
    });

    // ============================================
    // SEARCH & FILTER FUNGSIONALITAS
    // ============================================
    const searchInput = document.getElementById('searchInput');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const guideCards = document.querySelectorAll('.guide-card');

    function filterAndSearch() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const activeFilter = document.querySelector('.filter-btn.active')?.getAttribute('data-filter') || 'all';

        guideCards.forEach(card => {
            const title = (card.getAttribute('data-title') || card.querySelector('h3')?.innerText || '').toLowerCase();
            const desc = (card.getAttribute('data-desc') || card.querySelector('p')?.innerText || '').toLowerCase();
            const category = card.getAttribute('data-category') || 'umum';

            const matchesSearch = searchTerm === '' || title.includes(searchTerm) || desc.includes(searchTerm);
            const matchesFilter = activeFilter === 'all' || category === activeFilter;

            card.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterAndSearch);
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterAndSearch();
        });
    });

    // Set data attributes jika belum ada (untuk fallback statis)
    document.querySelectorAll('.guide-card').forEach(card => {
        if (!card.hasAttribute('data-title')) {
            const title = card.querySelector('h3')?.innerText || '';
            card.setAttribute('data-title', title);
        }
        if (!card.hasAttribute('data-desc')) {
            const desc = card.querySelector('p')?.innerText || '';
            card.setAttribute('data-desc', desc);
        }
        if (!card.hasAttribute('data-category')) {
            card.setAttribute('data-category', 'umum');
        }
    });

    // ============================================
    // FUNGSI DOWNLOAD FILE (jika ada)
    // ============================================
    function downloadFile(url, filename) {
        if (!url || url === '#') {
            showNotif('File tidak tersedia', 'error');
            return;
        }
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showNotif('Mengunduh: ' + filename, 'success');
    }

    function showNotif(message, type = 'success') {
        const notif = document.getElementById('notification');
        if (!notif) return;
        notif.innerText = message;
        notif.classList.add('show');
        setTimeout(() => {
            notif.classList.remove('show');
        }, 3000);
    }

    window.downloadFile = downloadFile;
    window.showNotif = showNotif;
</script>
@endpush
