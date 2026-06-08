<footer>
    <div class="footer-content">
        <div class="footer-col" data-aos="fade-right" data-aos-delay="200">
            <h4>Sekolah Keperawatan HKBP Balige</h4>
            <p><i class="fas fa-map-marker-alt"></i> Kompleks HKBP, Jl. Keperawatan No. 1<br>Sumatera Utara, Indonesia.</p>
            <p><i class="fas fa-phone-alt"></i> (061) 1234567</p>
            <p><i class="fas fa-envelope"></i> library@akperhkbp.ac.id</p>
        </div>
        <div class="footer-col" data-aos="fade-up" data-aos-delay="400">
            <h4>Sumber Daya</h4>
            <ul>
                {{-- Jurnal Keperawatan (butuh login) --}}
                <li><a href="{{ route('user.koleksi.jurnal') }}"><i class="fas fa-chevron-right"></i> Jurnal Keperawatan</a></li>
                {{-- Panduan Sitasi APA (butuh login) --}}
                <li><a href="{{ route('user.panduan') }}"><i class="fas fa-chevron-right"></i> Panduan Sitasi APA</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Cek Kemiripan Teks</a></li>
                {{-- Koleksi Tugas Akhir (butuh login) --}}
                <li><a href="{{ route('final_project.kti') }}"><i class="fas fa-chevron-right"></i> Koleksi Tugas Akhir</a></li>
            </ul>
        </div>
        <div class="footer-col" data-aos="fade-left" data-aos-delay="600">
            <h4>Akses Cepat</h4>
            <ul>
                <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Pendaftaran Anggota</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Bebas Pustaka</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Usulan Buku Baru</a></li>
                <li><a href="{{ route('guest.profile.kerjasama') }}"><i class="fas fa-chevron-right"></i> Hubungi Pustakawan</a></li>
            </ul>
        </div>
        <div class="footer-col" data-aos="fade-left" data-aos-delay="600">
            <h4>Ikuti Kami</h4>
            <div class="social-links">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
            <p style="margin-top: 20px; font-size: 0.85rem;">Temukan informasi terbaru dan kegiatan perpustakaan di media sosial kami.</p>
        </div>
    </div>
    <div class="copyright">
        <p>&copy; {{ date('Y') }} Perpustakaan Sekolah Keperawatan HKBP. All Rights Reserved.</p>
        <p class="tagline">Melayani untuk Generasi Sehat dan Berilmu</p>
    </div>
</footer>

<style>
    footer {
        background: linear-gradient(135deg, var(--deep-green) 0%, #0a3b2a 100%);
        color: rgba(220, 240, 230, 0.9);
        padding: 3rem 5% 1.5rem;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        border-top: 5px solid var(--accent-green);
        box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.05);
    }

    .footer-content {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 2.5rem;
    }

    .footer-col h4 {
        color: #ffffff;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--accent-green);
        padding-left: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        position: relative;
    }

    .footer-col h4::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 2px;
        background: var(--accent-green);
        border-radius: 2px;
    }

    .footer-col ul {
        list-style: none;
        padding-left: 0;
    }

    .footer-col ul li {
        margin-bottom: 12px;
        transition: transform 0.2s ease;
    }

    .footer-col ul li:hover {
        transform: translateX(5px);
    }

    .footer-col ul li a {
        color: rgba(210, 235, 220, 0.85);
        transition: 0.25s;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .footer-col ul li a i {
        font-size: 0.7rem;
        color: var(--accent-green);
        transition: 0.2s;
    }

    .footer-col ul li a:hover {
        color: white;
        text-shadow: 0 0 2px rgba(255,255,255,0.3);
    }

    .footer-col ul li a:hover i {
        transform: translateX(3px);
        color: #f1c40f;
    }

    .footer-col p {
        font-size: 0.88rem;
        line-height: 1.7;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .footer-col p i {
        width: 20px;
        color: var(--accent-green);
        font-size: 1rem;
    }

    .social-links {
        display: flex;
        gap: 20px;
        margin-top: 0.5rem;
    }

    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #e0f0e5;
        font-size: 1.2rem;
        transition: all 0.3s;
        text-decoration: none;
    }

    .social-links a:hover {
        background: var(--accent-green);
        color: var(--deep-green);
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .copyright {
        text-align: center;
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 0.85rem;
    }

    .copyright p {
        margin: 5px 0;
    }

    .copyright .tagline {
        font-size: 0.8rem;
        color: var(--accent-green);
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-content {
            gap: 2rem;
            text-align: center;
        }
        .footer-col h4 {
            text-align: center;
            border-left: none;
            border-bottom: 2px solid var(--accent-green);
            padding-left: 0;
            padding-bottom: 8px;
            display: inline-block;
        }
        .footer-col h4::after {
            display: none;
        }
        .footer-col p {
            justify-content: center;
        }
        .social-links {
            justify-content: center;
        }
        .footer-col ul li {
            text-align: center;
        }
        .footer-col ul li a {
            justify-content: center;
        }

         .social-links {
        display: flex;
        gap: 24px; /* dari 20px menjadi 24px */
        margin-top: 0.5rem;
    }

    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;   /* sedikit lebih besar */
        height: 42px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #e0f0e5;
        font-size: 1.3rem;
        transition: all 0.3s;
        text-decoration: none;
    }

    /* tambahkan margin agar tidak terlalu rapat dengan teks */
    .social-links a:not(:last-child) {
        margin-right: 4px;
    }
    }
</style>
