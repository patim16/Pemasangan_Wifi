<!DOCTYPE html>
<html class="no-js" lang="id">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>GuidoTechno - Layanan Internet Cepat & Stabil</title>
    <meta name="description" content="Layanan Internet WiFi Profesional untuk Rumah dan Bisnis" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg"/>

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('landing/assets/css/bootstrap-5.0.0-beta2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/css/LineIcons.2.0.css')}}"/>
    <link rel="stylesheet" href="{{ asset('landing/assets/css/tiny-slider.css')}}"/>
    <link rel="stylesheet" href="{{ asset('landing/assets/css/animate.css')}}"/>
    <link rel="stylesheet" href="{{asset('landing/assets/css/main.css')}}"/>
    
    <style>
      /* Modern Design Variables - Matching Dashboard Theme */
      :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4cc9f0;
        --dark-bg: #1a1d2e;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --gradient-primary: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
        --gradient-accent: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
      }

      /* Global Styles */
      body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--text-primary);
        overflow-x: hidden;
      }

      /* Header/Navbar Modern Styling */
      .header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 999;
      }

      .navbar-brand img {
        height: 40px;
        transition: transform 0.3s ease;
      }

      .navbar-brand:hover img {
        transform: scale(1.05);
      }

      .navbar-nav .nav-link {
        font-weight: 500;
        font-size: 0.95rem;
        color: var(--text-primary) !important;
        padding: 0.75rem 1.25rem !important;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
      }

      .navbar-nav .nav-link:hover {
        color: var(--primary-color) !important;
        background: rgba(67, 97, 238, 0.08);
      }

      .navbar-nav .nav-link.active {
        color: var(--primary-color) !important;
        font-weight: 600;
      }

      .navbar-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: 2px;
      }

      /* Button Modern Styling */
      .header-btn .main-btn {
        background: var(--gradient-primary) !important;
        border: none !important;
        color: #fff !important;
        padding: 0.75rem 2rem !important;
        border-radius: 50px !important;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
        transition: all 0.3s ease;
      }

      .header-btn .main-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(67, 97, 238, 0.5);
      }

      /* Hero Section Modern */
      .hero-section {
        background: linear-gradient(135deg, #1a1d2e 0%, #2d3561 100%);
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
      }

      .hero-section::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, transparent 70%);
        top: -200px;
        right: -200px;
        border-radius: 50%;
      }

      .hero-section::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(76, 201, 240, 0.15) 0%, transparent 70%);
        bottom: -100px;
        left: -100px;
        border-radius: 50%;
      }

      .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        color: #ffffff;
      }

      .hero-content h1 span {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .hero-content p {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 2rem;
        line-height: 1.8;
      }

      .hero-content .main-btn {
        background: var(--gradient-primary);
        color: #fff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        transition: all 0.3s ease;
        display: inline-block;
      }

      .hero-content .main-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(67, 97, 238, 0.5);
      }

      .hero-image img {
        animation: float 3s ease-in-out infinite;
      }

      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
      }

      /* Brands Section */
      .brands-section {
        padding: 60px 0;
        background: linear-gradient(180deg, #f8f9fc 0%, #ffffff 100%);
      }

      .single-brands {
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        border-radius: 12px;
      }

      .single-brands:hover {
        transform: translateY(-5px);
      }

      .single-brands img {
        max-height: 50px;
        opacity: 0.6;
        transition: opacity 0.3s ease;
      }

      .single-brands:hover img {
        opacity: 1;
      }

      /* Feature Section */
      .feature-section {
        padding: 100px 0;
        background: #fff;
      }

      .section-title h2 {
        font-size: 2.8rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
      }

      .single-feature {
        padding: 2.5rem;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        margin-bottom: 30px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
      }

      .single-feature:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(67, 97, 238, 0.15);
      }

      .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        color: #fff;
        transition: all 0.3s ease;
      }

      .feature-icon.color-1 {
        background: var(--gradient-primary);
      }

      .feature-icon.color-2 {
        background: var(--gradient-accent);
      }

      .feature-icon.color-3 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      }

      .single-feature:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
      }

      .feature-content h4 {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
      }

      .feature-content p {
        color: var(--text-secondary);
        line-height: 1.8;
        margin: 0;
        flex-grow: 1;
      }

      /* Paket Cards - Perubahan Utama */
      .paket-cards {
        display: flex;
        flex-wrap: wrap;
        margin: -15px;
      }

      .paket-card {
        flex: 0 0 calc(33.333% - 30px);
        margin: 15px;
        padding: 2rem;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(67, 97, 238, 0.1);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
      }

      .paket-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
      }

      .paket-card:hover::before {
        transform: scaleX(1);
      }

      .paket-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(67, 97, 238, 0.15);
      }

      .paket-card.home::before {
        background: var(--gradient-primary);
      }

      .paket-card.business::before {
        background: var(--gradient-accent);
      }

      .paket-card.education::before {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      }

      .paket-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        color: #fff;
        transition: all 0.3s ease;
      }

      .paket-card.home .paket-icon {
        background: var(--gradient-primary);
      }

      .paket-card.business .paket-icon {
        background: var(--gradient-accent);
      }

      .paket-card.education .paket-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      }

      .paket-card:hover .paket-icon {
        transform: scale(1.1) rotate(5deg);
      }

      .paket-title {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
      }

      .paket-description {
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 1.5rem;
        flex-grow: 1;
      }

      .paket-features {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem;
      }

      .paket-features li {
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
      }

      .paket-features li i {
        color: var(--primary-color);
        margin-right: 0.5rem;
      }

      .paket-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
      }

      .paket-price span {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--text-secondary);
      }

      .paket-btn {
        background: var(--gradient-primary);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
      }

      .paket-card.business .paket-btn {
        background: var(--gradient-accent);
      }

      .paket-card.education .paket-btn {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      }

      .paket-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
      }

      /* Feature Detailed Sections */
      .feature-section-1, .feature-section-2 {
        padding: 100px 0;
        position: relative;
      }

      .feature-section-1 {
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
      }

      .feature-content-wrapper .section-title h2 {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
      }

      .feature-content-wrapper .section-title p {
        color: var(--text-secondary);
        line-height: 1.8;
        font-size: 1.05rem;
      }

      .border-btn {
        background: transparent !important;
        border: 2px solid var(--primary-color) !important;
        color: var(--primary-color) !important;
        padding: 0.875rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
      }

      .border-btn:hover {
        background: var(--gradient-primary) !important;
        color: #fff !important;
        transform: translateY(-2px);
      }

      /* Footer Modern */
      .footer {
        background: var(--dark-bg);
        padding: 80px 0 30px;
        color: rgba(255, 255, 255, 0.8);
      }

      .footer .section-title h2 {
        color: #fff;
        font-size: 2.2rem;
        margin-bottom: 1rem;
      }

      .footer .section-title p {
        color: rgba(255, 255, 255, 0.7);
      }

      .newsletter-form-wrapper form {
        display: flex;
        gap: 1rem;
        max-width: 500px;
        margin: 2rem auto 0;
      }

      .newsletter-form-wrapper input {
        flex: 1;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-size: 0.95rem;
      }

      .newsletter-form-wrapper input::placeholder {
        color: rgba(255, 255, 255, 0.5);
      }

      .newsletter-form-wrapper button {
        padding: 1rem 2rem;
        background: var(--gradient-accent);
        border: none;
        border-radius: 50px;
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
      }

      .newsletter-form-wrapper button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(76, 201, 240, 0.4);
      }

      .footer-menu ul {
        display: flex;
        gap: 2rem;
        padding: 0;
        margin: 3rem 0 2rem;
        list-style: none;
        justify-content: center;
      }

      .footer-menu ul li a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
      }

      .footer-menu ul li a:hover {
        color: var(--accent-color);
      }

      .footer-social ul {
        display: flex;
        gap: 1rem;
        padding: 0;
        margin: 3rem 0 2rem;
        list-style: none;
        justify-content: center;
      }

      .footer-social ul li a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transition: all 0.3s ease;
      }

      .footer-social ul li a:hover {
        background: var(--gradient-primary);
        transform: translateY(-3px);
      }

      /* Scroll Top */
      .scroll-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
        transition: all 0.3s ease;
        z-index: 999;
      }

      .scroll-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 25px rgba(67, 97, 238, 0.5);
      }

      /* Responsive */
      @media (max-width: 992px) {
        .hero-content h1 {
          font-size: 2.5rem;
        }

        .section-title h2 {
          font-size: 2rem;
        }

        .footer-menu ul {
          flex-wrap: wrap;
          gap: 1rem;
        }

        .newsletter-form-wrapper form {
          flex-direction: column;
        }

        .paket-card {
          flex: 0 0 calc(50% - 30px);
        }
      }

      @media (max-width: 768px) {
        .hero-section {
          padding: 80px 0 60px;
        }

        .hero-content h1 {
          font-size: 2rem;
        }

        .hero-content p {
          font-size: 1rem;
        }

        .paket-card {
          flex: 0 0 100%;
        }
      }
    </style>
  </head>
  <body>
    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
      <div class="loader">
        <div class="spinner">
          <div class="spinner-container">
            <div class="spinner-rotator">
              <div class="spinner-left">
                <div class="spinner-circle"></div>
              </div>
              <div class="spinner-right">
                <div class="spinner-circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- preloader end -->

    <!-- ========================= header start ========================= -->
    <header class="header">
      <div class="navbar-area">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}">
                  <img src="assets/images/logo/logo.svg" alt="GuidoTechno Logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="toggler-icon"></span>
                  <span class="toggler-icon"></span>
                  <span class="toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                  <div class="ms-auto">
                    <ul id="nav" class="navbar-nav ms-auto">
                      <li class="nav-item">
                        <a class="page-scroll active" href="#home">Beranda</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#features">Layanan</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#feature-1">Keunggulan</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#feature-2">Paket</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#footer">Kontak</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="header-btn">
                  <a href="{{ url('/login') }}" class="main-btn btn-hover">Login</a>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- ========================= header end ========================= -->

    <!-- ========================= hero-section start ========================= -->
    <section id="home" class="hero-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-10">
            <div class="hero-content">
              <h1>Internet Cepat & Stabil untuk <span>Kebutuhan Anda</span></h1>
              <p>Nikmati layanan internet WiFi profesional dengan kecepatan tinggi, koneksi stabil, dan dukungan teknis 24/7 untuk rumah dan bisnis Anda.</p>
              
              <a href="#features" class="main-btn btn-hover">Lihat Paket Kami</a>
            </div>
          </div>
          <div class="col-xxl-6 col-xl-6 col-lg-6 offset-xxl-1">
            <div class="hero-image text-center text-lg-start">
              <img src="assets/images/hero/hero-image.svg" alt="WiFi Internet">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= hero-section end ========================= -->

    <!-- ========================= brands-section start ========================= -->
    <section class="brands-section pt-120">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="single-brands">
              <img src="assets/images/brands/graygrids.svg" alt="Partner">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="single-brands">
              <img src="assets/images/brands/lineicons.svg" alt="Partner">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="single-brands">
              <img src="assets/images/brands/uideck.svg" alt="Partner">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="single-brands">
              <img src="assets/images/brands/pagebulb.svg" alt="Partner">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= brands-section end ========================= -->

    <!-- ========================= feature-section start ========================= -->
    <section id="features" class="feature-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11">
            <div class="section-title text-center mb-60">
              <h2>Layanan Modern dengan <br class="d-block"> Fitur Terlengkap</h2>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="single-feature">
              <div class="feature-icon color-1">
                <i class="lni lni-rocket"></i>
              </div>
              <div class="feature-content">
                <h4>Kecepatan Tinggi</h4>
                <p>Nikmati internet dengan kecepatan hingga 100 Mbps untuk streaming, gaming, dan bekerja tanpa hambatan.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature">
              <div class="feature-icon color-2">
                <i class="lni lni-shield"></i>
              </div>
              <div class="feature-content">
                <h4>Koneksi Stabil</h4>
                <p>Jaringan fiber optik dengan uptime 99.9% menjamin koneksi internet Anda selalu stabil dan handal.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature">
              <div class="feature-icon color-3">
                <i class="lni lni-headphone-alt"></i>
              </div>
              <div class="feature-content">
                <h4>Support 24/7</h4>
                <p>Tim teknisi profesional siap membantu Anda kapan saja melalui telepon, chat, atau kunjungan langsung.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= feature-section end ========================= -->

    <!-- ========================= feature-section-1 start ========================= -->
    <section id="feature-1" class="feature-section-1">
      <div class="shape-image">
        <img src="assets/images/feature/shape.svg" alt="">
      </div>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-last order-lg-first">
            <div class="feature-image text-center text-lg-start">
              <img src="assets/images/feature/feature-image-1.svg" alt="">
            </div>
          </div>
          <div class="col-lg-6 col-xxl-5 col-md-10 offset-xxl-1">
            <div class="feature-content-wrapper">
              <div class="section-title">
                <h2 class="mb-20">Solusi Internet Terbaik untuk Bisnis Berkembang</h2>
                <p class="mb-30">Kami menyediakan paket internet khusus untuk bisnis dengan bandwidth dedicated, IP static, dan dukungan teknis prioritas. Infrastruktur fiber optik terbaru menjamin kecepatan dan stabilitas koneksi untuk operasional bisnis Anda tanpa gangguan.</p>
                <a href="{{ url('/login') }}" class="main-btn btn-hover border-btn">Konsultasi Gratis</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= feature-section-1 end ========================= -->

    <!-- ========================= feature-section-2 start ========================= -->
    <section id="feature-2" class="feature-section-2">
      <div class="shape-image">
        <img src="assets/images/feature/shape.svg" alt="">
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11">
            <div class="section-title text-center mb-60">
              <h2>Paket Fleksibel Sesuai <br class="d-none d-sm-block"> Kebutuhan Anda</h2>
            </div>
          </div>
        </div>

        <div class="paket-cards">
          <div class="paket-card home">
            <div class="paket-icon">
              <i class="lni lni-home"></i>
            </div>
            <h3 class="paket-title">Paket Rumahan</h3>
            <p class="paket-description">Paket internet untuk keluarga dengan harga terjangkau dan kecepatan hingga 50 Mbps. Cocok untuk streaming, browsing, dan gaming.</p>
            <ul class="paket-features">
              <li><i class="lni lni-checkmark-circle"></i> Kecepatan hingga 50 Mbps</li>
              <li><i class="lni lni-checkmark-circle"></i> Unlimited Kuota</li>
              <li><i class="lni lni-checkmark-circle"></i> Gratis Instalasi</li>
              <li><i class="lni lni-checkmark-circle"></i> Support 24/7</li>
            </ul>
            <div class="paket-price">Rp 299.000 <span>/ bulan</span></div>
            <a href="#" class="paket-btn">Pilih Paket</a>
          </div>
          
          <div class="paket-card business">
            <div class="paket-icon">
              <i class="lni lni-briefcase"></i>
            </div>
            <h3 class="paket-title">Paket Bisnis</h3>
            <p class="paket-description">Solusi internet dedicated untuk kantor dan perusahaan dengan SLA 99.9%, IP static, dan bandwidth hingga 1 Gbps.</p>
            <ul class="paket-features">
              <li><i class="lni lni-checkmark-circle"></i> Bandwidth hingga 1 Gbps</li>
              <li><i class="lni lni-checkmark-circle"></i> IP Static</li>
              <li><i class="lni lni-checkmark-circle"></i> SLA 99.9%</li>
              <li><i class="lni lni-checkmark-circle"></i> Support Prioritas</li>
            </ul>
            <div class="paket-price">Rp 1.299.000 <span>/ bulan</span></div>
            <a href="#" class="paket-btn">Pilih Paket</a>
          </div>
          
          <div class="paket-card education">
            <div class="paket-icon">
              <i class="lni lni-graduation"></i>
            </div>
            <h3 class="paket-title">Paket Edukasi</h3>
            <p class="paket-description">Paket khusus untuk sekolah dan lembaga pendidikan dengan harga spesial dan kontrol konten internet yang aman.</p>
            <ul class="paket-features">
              <li><i class="lni lni-checkmark-circle"></i> Kecepatan hingga 100 Mbps</li>
              <li><i class="lni lni-checkmark-circle"></i> Kontrol Konten</li>
              <li><i class="lni lni-checkmark-circle"></i> Harga Spesial</li>
              <li><i class="lni lni-checkmark-circle"></i> Support Khusus</li>
            </ul>
            <div class="paket-price">Rp 599.000 <span>/ bulan</span></div>
            <a href="#" class="paket-btn">Pilih Paket</a>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= feature-section-2 end ========================= -->

    <!-- ========================= footer start ========================= -->
    <footer class="footer" id="footer">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-7">
            <div class="section-title">
              <h2>Dapatkan Penawaran Spesial</h2>
              <p>Daftarkan email Anda dan dapatkan informasi promo, update layanan, dan penawaran menarik dari kami.</p>
            </div>
            <div class="newsletter-form-wrapper">
              <form action="#">
                <input type="email" placeholder="Alamat Email Anda">
                <button class="main-btn btn-hover">Berlangganan</button>
              </form>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-8">
            <div class="footer-menu">
              <ul>
                <li><a href="#home">Beranda</a></li>
                <li><a href="#features">Layanan</a></li>
                <li><a href="#feature-1">Keunggulan</a></li>
                <li><a href="{{ url('/login') }}">Portal</a></li>
                <li><a href="#footer">Kontak</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6 col-md-4">
            <div class="footer-social">
              <ul>
                <li><a href="#0"><i class="lni lni-facebook"></i></a></li>
                <li><a href="#0"><i class="lni lni-linkedin"></i></a></li>
                <li><a href="#0"><i class="lni lni-instagram"></i></a></li>
                <li><a href="#0"><i class="lni lni-twitter"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- ========================= footer end ========================= -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top btn-hover">
      <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{asset('landing/assets/js/bootstrap-5.0.0-beta2.min.js')}}"></script>
    <script src="{{asset('landing/assets/js/tiny-slider.js')}}"></script>
    <script src="{{asset('landing/assets/js/wow.min.js')}}"></script>
    <script src="{{asset('landing/assets/js/polyfill.js')}}"></script>
    <script src="{{asset('landing/assets/js/main.js')}}"></script>
  </body>
</html>