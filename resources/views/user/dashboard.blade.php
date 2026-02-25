<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - College Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">

      <a href="/" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">College</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Admissions</a></li>
              <li><a href="#">Academics</a></li>
              <li><a href="#">Faculty &amp; Staff</a></li>
              <li><a href="#">Campus &amp; Facilities</a></li>
            </ul>
          </li>

          <li><a href="#">Students Life</a></li>
          <li><a href="#">News</a></li>
          <li><a href="#">Events</a></li>
          <li><a href="#">Alumni</a></li>
          
          <!-- LOGIKA LOGIN DINAMIS -->
          @guest
            <li><a href="{{ route('login') }}" style="color: #0d6efd; font-weight: bold;">Login</a></li>
          @else
            <li class="dropdown"><a href="#"><span style="color: #0d6efd; font-weight: bold;">Account ({{ Auth::user()->name }})</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li>
                  @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                  @else
                    <a href="{{ route('user.dashboard') }}">My Dashboard</a>
                  @endif
                </li>
                <li>
                  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: red;">Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          @endguest

          <li><a href="#">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="hero-wrapper">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 hero-content" data-aos="fade-right" data-aos-delay="100">
              <h1>Inspiring Excellence Through Education</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget lacus id tortor facilisis tincidunt. Donec gravida risus at sollicitudin luctus.</p>
              <div class="stats-row">
                <div class="stat-item">
                  <span class="stat-number">96%</span>
                  <span class="stat-label">Employment Rate</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">12:1</span>
                  <span class="stat-label">Student-Teacher Ratio</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">50+</span>
                  <span class="stat-label">Programs</span>
                </div>
              </div>
              <div class="action-buttons">
                @guest
                  <a href="{{ route('login') }}" class="btn-primary">Start Your Journey</a>
                @else
                  <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @endguest
                <a href="#" class="btn-secondary">Virtual Tour</a>
              </div>
            </div>
            <div class="col-lg-6 hero-media" data-aos="zoom-in" data-aos-delay="200">
              <img src="assets/img/education/showcase-6.webp" alt="Education" class="img-fluid main-image">
              <div class="image-overlay">
                <div class="badge-accredited">
                  <i class="bi bi-patch-check-fill"></i>
                  <span>Accredited Excellence</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="feature-cards-wrapper" data-aos="fade-up" data-aos-delay="300">
        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
              <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-book-fill"></i></div>
                <div class="feature-content">
                  <h3>Innovative Curriculum</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget lacus id tortor facilisis.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
              <div class="feature-card active">
                <div class="feature-icon"><i class="bi bi-laptop-fill"></i></div>
                <div class="feature-content">
                  <h3>Modern Facilities</h3>
                  <p>Donec gravida risus at sollicitudin luctus. Nullam feugiat odio vitae justo pharetra.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
              <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                <div class="feature-content">
                  <h3>Expert Faculty</h3>
                  <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="upcoming-event" data-aos="fade-up" data-aos-delay="400">
        <div class="container">
          <div class="event-content">
            <div class="event-date">
              <span class="day">15</span>
              <span class="month">NOV</span>
            </div>
            <div class="event-info">
              <h3>Spring Semester Open House</h3>
              <p>Join us to explore campus facilities, meet our faculty, and learn about scholarship opportunities.</p>
            </div>
            <div class="event-action">
              <a href="#" class="btn-event">RSVP Now</a>
              <span class="countdown">Starts in 3 weeks</span>
            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- About Section -->
    <section id="about" class="about section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="about-content" data-aos="fade-up" data-aos-delay="200">
              <h3>Our Story</h3>
              <h2>Educating Minds, Inspiring Hearts</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vitae odio ac nisi tristique venenatis. Nullam feugiat ipsum vitae justo finibus, in sagittis dolor malesuada.</p>
              <div class="timeline">
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content"><h4>1965</h4><p>Established as a small college.</p></div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content"><h4>1982</h4><p>Accredited by national education board.</p></div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content"><h4>1998</h4><p>Introduced postgraduate programs.</p></div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content"><h4>2010</h4><p>Became a leading research institution.</p></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="about-image" data-aos="zoom-in" data-aos-delay="300">
              <img src="assets/img/education/campus-5.webp" alt="Campus" class="img-fluid rounded">
              <div class="mission-vision" data-aos="fade-up" data-aos-delay="400">
                <div class="mission"><h3>Our Mission</h3><p>To provide high-quality education and research excellence.</p></div>
                <div class="vision"><h3>Our Vision</h3><p>To be a globally recognized center of learning and innovation.</p></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Programs Section -->
    <section id="featured-programs" class="featured-programs section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Programs</h2>
        <p>Explore our top-rated academic tracks designed for your future success.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
            <div class="program-banner">
              <div class="banner-image">
                <img src="assets/img/education/campus-3.webp" alt="Program" class="img-fluid">
                <div class="banner-badge"><span class="badge-text">Popular</span></div>
              </div>
              <div class="banner-info">
                <h3>Engineering &amp; Technology</h3>
                <div class="program-stats">
                  <span><i class="bi bi-people-fill"></i> 450+ Students</span>
                  <span><i class="bi bi-award-fill"></i> 95% Success Rate</span>
                </div>
                <p>Leading the way in technological innovation and infrastructure design.</p>
                <a href="#" class="discover-btn">Discover Program</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="programs-grid">
              <div class="row g-3">
                <div class="col-12" data-aos="fade-left" data-aos-delay="200">
                  <div class="program-item">
                    <div class="item-icon"><img src="assets/img/education/education-4.webp" alt="Program" class="img-fluid"></div>
                    <div class="item-content"><h4>Business Management</h4><p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur.</p></div>
                    <div class="item-arrow"><i class="bi bi-arrow-right"></i></div>
                  </div>
                </div>
                <div class="col-12" data-aos="fade-left" data-aos-delay="300">
                  <div class="program-item">
                    <div class="item-icon"><img src="assets/img/education/education-6.webp" alt="Program" class="img-fluid"></div>
                    <div class="item-content"><h4>Digital Marketing</h4><p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p></div>
                    <div class="item-arrow"><i class="bi bi-arrow-right"></i></div>
                  </div>
                </div>
                <div class="col-12" data-aos="fade-left" data-aos-delay="400">
                  <div class="program-item">
                    <div class="item-icon"><img src="assets/img/education/education-8.webp" alt="Program" class="img-fluid"></div>
                    <div class="item-content"><h4>Health Sciences</h4><p>Temporibus autem quibusdam et aut officiis debitis.</p></div>
                    <div class="item-arrow"><i class="bi bi-arrow-right"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Students Life Section -->
    <section id="students-life-block" class="students-life-block section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Students Life</h2>
        <p>Beyond the classroom, a world of opportunity awaits.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center g-5 mb-5">
          <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
            <div class="hero-image-wrapper">
              <img src="assets/img/education/students-7.webp" alt="Student Life" class="img-fluid main-image">
              <div class="floating-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="card-icon"><i class="bi bi-people-fill"></i></div>
                <div class="card-content"><span class="card-number">2500+</span><span class="card-label">Active Students</span></div>
              </div>
            </div>
          </div>
          <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
            <div class="content-wrapper">
              <h2 data-aos="fade-up" data-aos-delay="400">A Vibrant Campus Community</h2>
              <p class="lead-text" data-aos="fade-up" data-aos-delay="450">Join student-led organizations, research labs, and sports teams.</p>
              <div class="info-grid" data-aos="fade-up" data-aos-delay="500">
                <div class="info-item">
                  <div class="info-icon"><i class="bi bi-calendar-event"></i></div>
                  <div class="info-text"><strong>Year-Round Events</strong><span>Sports, festivals, and guest lectures.</span></div>
                </div>
                <div class="info-item">
                  <div class="info-icon"><i class="bi bi-award"></i></div>
                  <div class="info-text"><strong>Achievement Programs</strong><span>Excepteur sint occaecat cupidatat non proident.</span></div>
                </div>
              </div>
              <div class="cta-section" data-aos="fade-up" data-aos-delay="600">
                <a href="#" class="btn-primary">Discover More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>What our students and alumni say about us.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonial-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": { "delay": 4000 },
              "slidesPerView": "auto",
              "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true },
              "breakpoints": { "320": { "slidesPerView": 1, "spaceBetween": 40 }, "1200": { "slidesPerView": 3, "spaceBetween": 40 } }
            }
          </script>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="testimonial-header">
                  <img src="assets/img/person/person-f-12.webp" alt="Person" class="img-fluid">
                  <div class="rating"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                </div>
                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.</p>
                <div class="testimonial-footer"><h5>Jessica Martinez</h5><span>UX Designer</span></div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="testimonial-header">
                  <img src="assets/img/person/person-m-8.webp" alt="Person" class="img-fluid">
                  <div class="rating"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                </div>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat.</p>
                <div class="testimonial-footer"><h5>David Rodriguez</h5><span>Software Engineer</span></div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 mt-4">
          <div class="col-xl-3 col-lg-6">
            <div class="metric-card" data-aos="flip-left" data-aos-delay="300">
              <div class="metric-header"><i class="bi bi-mortarboard-fill"></i><div class="metric-value">87%</div></div>
              <div class="metric-info"><h4>Success Rate</h4><p>Alumni employment within 6 months</p></div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="metric-card" data-aos="flip-left" data-aos-delay="400">
              <div class="metric-header"><i class="bi bi-building"></i><div class="metric-value">8</div></div>
              <div class="metric-info"><h4>Campus Locations</h4><p>Across the country serving students</p></div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="metric-card" data-aos="flip-left" data-aos-delay="500">
              <div class="metric-header"><i class="bi bi-trophy-fill"></i><div class="metric-value">250+</div></div>
              <div class="metric-info"><h4>Awards Received</h4><p>Recognition for excellence</p></div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="metric-card" data-aos="flip-left" data-aos-delay="600">
              <div class="metric-header"><i class="bi bi-globe"></i><div class="metric-value">65+</div></div>
              <div class="metric-info"><h4>Countries Represented</h4><p>Diverse international student body</p></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent News Section -->
    <section id="recent-news" class="recent-news section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Recent News</h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-xl-6">
            <article class="post-item d-flex">
              <div class="post-img"><img src="assets/img/blog/blog-post-1.webp" alt="" class="img-fluid"></div>
              <div class="post-content flex-grow-1">
                <a href="#" class="category">Design</a>
                <h2 class="post-title"><a href="#">Sed ut perspiciatis unde omnis</a></h2>
                <p class="post-description">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p>
                <div class="post-meta"><span class="author-name">Lina Chen</span><span class="post-date">Mar 15, 2025</span></div>
              </div>
            </article>
          </div>
          <div class="col-xl-6">
            <article class="post-item d-flex">
              <div class="post-img"><img src="assets/img/blog/blog-post-2.webp" alt="" class="img-fluid"></div>
              <div class="post-content flex-grow-1">
                <a href="#" class="category">Product</a>
                <h2 class="post-title"><a href="#">At vero eos et accusamus</a></h2>
                <p class="post-description">Et harum quidem rerum facilis est et expedita distinctio nam libero tempore.</p>
                <div class="post-meta"><span class="author-name">Sofia Rodriguez</span><span class="post-date">Apr 22, 2025</span></div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="events section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Events</h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="event-item">
              <div class="event-image">
                <img src="assets/img/education/events-3.webp" alt="Workshop" class="img-fluid">
                <div class="event-date-overlay"><span class="date">MAR<br>18</span></div>
              </div>
              <div class="event-details">
                <div class="event-category"><span class="badge academic">Academic</span><span class="event-time">2:00 PM</span></div>
                <h3>Advanced Mathematics Workshop</h3>
                <p>Room 205, Science Building</p>
                <a href="#" class="register-btn">Register Now</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="event-item">
              <div class="event-image">
                <img src="assets/img/education/events-5.webp" alt="Tournament" class="img-fluid">
                <div class="event-date-overlay"><span class="date">APR<br>05</span></div>
              </div>
              <div class="event-details">
                <div class="event-category"><span class="badge sports">Sports</span><span class="event-time">9:00 AM</span></div>
                <h3>Basketball Championship</h3>
                <p>Sports Complex Gym</p>
                <a href="#" class="register-btn">Register Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer position-relative light-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="/" class="logo d-flex align-items-center"><span class="sitename">College</span></a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street, New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> +1 5589 55488 55</p>
            <p><strong>Email:</strong> info@example.com</p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li><li><a href="#">About us</a></li><li><a href="#">Terms of service</a></li><li><a href="#">Privacy policy</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">College</strong> <span>All Rights Reserved</span></p>
      <div class="credits">Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a></div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>