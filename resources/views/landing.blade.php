<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuidoTechno - Internet Cepat & Stabil untuk Semua</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4A90E2;
            --secondary: #667EEA;
            --accent: #90CDF4;
            --dark: #1A202C;
            --light: #F7FAFC;
            --white: #FFFFFF;
            --gradient-1: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
            --gradient-2: linear-gradient(135deg, #4A90E2 0%, #667EEA 100%);
            --gradient-3: linear-gradient(135deg, #90CDF4 0%, #4A90E2 100%);
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 30px 80px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background: var(--light);
            overflow-x: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
            opacity: 0.03;
        }

        .animated-bg span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(102, 126, 234, 0.3);
            animation: float-particles 25s linear infinite;
            border-radius: 50%;
        }

        .animated-bg span:nth-child(1) { left: 10%; animation-delay: 0s; }
        .animated-bg span:nth-child(2) { left: 30%; animation-delay: 2s; }
        .animated-bg span:nth-child(3) { left: 50%; animation-delay: 4s; }
        .animated-bg span:nth-child(4) { left: 70%; animation-delay: 6s; }
        .animated-bg span:nth-child(5) { left: 90%; animation-delay: 8s; }

        @keyframes float-particles {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(1); opacity: 0; }
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header.scrolled {
            padding: 10px 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(74, 144, 226, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 10px;
        }

        .nav-links a {
            padding: 10px 20px;
            color: var(--dark);
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 60%;
            height: 3px;
            background: var(--gradient-2);
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
            background: rgba(74, 144, 226, 0.1);
        }

        .nav-links a:hover::before {
            transform: translateX(-50%) scaleX(1);
        }

        .login-btn {
            padding: 12px 30px;
            background: var(--gradient-2);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(74, 144, 226, 0.3);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(74, 144, 226, 0.4);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 150px 5% 100px;
            background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
            animation: slideInLeft 1s ease;
        }

        .hero-text h1 span {
            background: linear-gradient(135deg, #90CDF4 0%, #F6E05E 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-text p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            line-height: 1.8;
            animation: slideInLeft 1s ease 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            animation: slideInLeft 1s ease 0.4s backwards;
        }

        .btn-primary, .btn-secondary {
            padding: 18px 40px;
            border-radius: 35px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(255, 255, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-5px);
        }

        .hero-image {
            position: relative;
            animation: slideInRight 1s ease;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-image img {
            width: 100%;
            filter: drop-shadow(0 30px 60px rgba(0, 0, 0, 0.3));
            animation: float 5s ease-in-out infinite;
        }

        /* Features Section */
        .features {
            padding: 120px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title h2 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: var(--gradient-2);
            border-radius: 5px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-top: 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .feature-card {
            padding: 50px 40px;
            background: white;
            border-radius: 30px;
            box-shadow: var(--shadow);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--gradient-2);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-hover);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: var(--gradient-2);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(74, 144, 226, 0.3);
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(10deg);
        }

        .feature-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .feature-card p {
            color: #718096;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* Packages Section */
        .packages {
            padding: 120px 5%;
            background: linear-gradient(135deg, #EBF8FF 0%, #F7FAFC 100%);
        }

        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 60px auto 0;
        }

      .package-card {
    background: white;
    border-radius: 30px;
    padding: 50px;
    box-shadow: var(--shadow);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    border: 3px solid transparent;
    display: flex;
    flex-direction: column;
    border-color: transparent !important;
}


        .package-card.featured {
            border-color: var(--primary);
            transform: scale(1.05);
            border-color: transparent !important;
        }

        .package-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-2);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .package-card:hover::before {
            opacity: 0.05;
        }

        .package-card:hover {
            transform: translateY(-20px) scale(1.02);
            box-shadow: var(--shadow-hover);
            border-color: transparent !important;
        }

        .package-card > * {
            position: relative;
            z-index: 1;
        }

        .package-icon {
            width: 100px;
            height: 100px;   
            background: var(--gradient-2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(74, 144, 226, 0.3);
        }

        .package-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .package-card p {
            color: #718096;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .package-price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .package-price span {
            font-size: 1rem;
            font-weight: 400;
            color: #718096;
        }

        .package-features {
            list-style: none;
            margin: 30px 0;
        }

        .package-features li {
            padding: 12px 0;
            display: flex;
            align-items: center;
            color: #4A5568;
            font-size: 1.05rem;
        }

        .package-features i {
            color: #48BB78;
            margin-right: 15px;
            font-size: 1.2rem;
        }

       .package-btn {
    width: 100%;
    max-width: 260px;
    padding: 18px;
    background: var(--gradient-2);
    margin-top: auto;
    align-self: center;
    color: white;
    border: none;
    border-radius: 35px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(74, 144, 226, 0.3);
    text-decoration: none;
    display: inline-block;
    text-align: center;   
}

      .package-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(74, 144, 226, 0.4);
    text-decoration: none;
}

        /* Testimonials */
        .testimonials {
            padding: 120px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .testimonial-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary);
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .testimonial-text {
            font-style: italic;
            color: #4A5568;
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: 1.05rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .testimonial-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--gradient-2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            box-shadow: 0 5px 20px rgba(74, 144, 226, 0.3);
        }

        .testimonial-info h4 {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .testimonial-info p {
            color: #718096;
            font-size: 0.95rem;
        }

        .stars {
            color: #F6E05E;
            margin-top: 15px;
            font-size: 1.2rem;
        }

        /* CTA Section */
        .cta {
            padding: 120px 5%;
            background: var(--gradient-1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '🚀';
            position: absolute;
            font-size: 15rem;
            top: -50px;
            right: -50px;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta h2 {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 25px;
        }

        .cta p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            line-height: 1.8;
        }

        /* Footer */
        footer {
            background: var(--dark);
            padding: 80px 5% 30px;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-section h3 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .footer-section p {
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--accent);
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .features-grid,
            .packages-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .cta h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="animated-bg">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <header>
        <nav>
            <a href="#" class="logo">
                <div class="logo-icon">GT</div>
                GuidoTechno
            </a>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#features">Layanan</a></li>
                <li><a href="#packages">Paket</a></li>
                <li><a href="#testimonials">Testimoni</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
            <a href="{{url('/login')}}" class="login-btn">Login</a>
        </nav>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Internet Cepat & Stabil untuk <span>Kebutuhan Anda</span></h1>
                <p>Nikmati layanan internet fiber optik berkecepatan tinggi dengan teknologi terkini. Streaming, gaming, dan bekerja tanpa hambatan!</p>
                <div class="hero-buttons">
                    <a href="#packages" class="btn-primary">Lihat Paket</a>
                    <a href="#features" class="btn-secondary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://illustrations.popsy.co/amber/remote-work.svg" alt="Internet WiFi">
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-title">
            <h2>Mengapa Memilih GuidoTechno?</h2>
            <p>Layanan terbaik dengan teknologi terdepan untuk pengalaman internet yang luar biasa</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>Super Cepat</h3>
                <p>Kecepatan hingga 1 Gbps untuk streaming 4K, gaming online, dan download tanpa buffering. Rasakan internet masa depan hari ini.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Aman & Terpercaya</h3>
                <p>Teknologi fiber optik dengan enkripsi tingkat enterprise menjamin keamanan data Anda. Privasi adalah prioritas kami.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Support 24/7</h3>
                <p>Tim teknis profesional siap membantu Anda kapan saja. Respons cepat dan solusi tepat untuk setiap kendala.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Unlimited Bandwidth</h3>
                <p>Tanpa batasan kuota! Nikmati internet sepuasnya untuk semua aktivitas digital Anda tanpa khawatir FUP.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3>Instalasi Gratis</h3>
                <p>Pemasangan cepat dan profesional tanpa biaya tambahan. Teknisi berpengalaman siap membantu setup optimal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Garansi Uptime 99.9%</h3>
                <p>Koneksi stabil dan andal dengan infrastruktur redundan. Produktivitas Anda adalah prioritas kami.</p>
            </div>
        </div>
    </section>

    <section class="packages" id="packages">
        <div class="section-title">
            <h2>Paket Fleksibel Sesuai Kebutuhan</h2>
            <p>Pilih paket yang tepat untuk rumah, bisnis, atau kebutuhan khusus Anda</p>
        </div>
       <div class="packages-grid">

    @forelse ($pakets as $paket)
        <div class="package-card {{ $loop->iteration == 2 ? 'featured' : '' }}">
            <div class="package-icon">
                <i class="{{ $paket->icon ?? 'fas fa-wifi' }}"></i>
            </div>

            <h3>{{ $paket->nama_paket }}</h3>

            <p>{{ $paket->deskripsi }}</p>

            <div class="package-price">
                Rp {{ number_format($paket->harga, 0, ',', '.') }}
                <span>/bulan</span>
            </div>

            <ul class="package-features">
                <li>
                    <i class="fas fa-check-circle"></i>
                    Kecepatan {{ $paket->kecepatan }} Mbps
                </li>

                @if(!empty($paket->fitur))
                    @foreach(explode(',', $paket->fitur) as $fitur)
                        <li>
                            <i class="fas fa-check-circle"></i>
                            {{ trim($fitur) }}
                        </li>
                    @endforeach
                @endif
            </ul>
<a href="{{url('/login') }}"
   class="package-btn">
   Pilih Paket
</a>
        </div>
    @empty
        <p style="grid-column:1/-1; text-align:center; color:#718096;">
            🚧 Paket belum tersedia.
        </p>
    @endforelse

</div>

        </div>
    </section>

    <section class="testimonials" id="testimonials">
        <div class="section-title">
            <h2>Apa Kata Pelanggan Kami</h2>
            <p>Ribuan pelanggan puas telah mempercayai layanan kami</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p class="testimonial-text">"Internet GuidoTechno sangat cepat dan stabil. Support 24/7 sangat membantu ketika ada masalah koneksi. Recommended banget!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">AW</div>
                    <div class="testimonial-info">
                        <h4>Ahmad Wijaya</h4>
                        <p>Pengusaha</p>
                    </div>
                </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="testimonial-card">
                <p class="testimonial-text">"Sudah 2 tahun pakai GuidoTechno, gak pernah kecewa. Kecepatan konsisten, harga terjangkau, pelayanan memuaskan!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">SN</div>
                    <div class="testimonial-info">
                        <h4>Siti Nurhaliza</h4>
                        <p>Ibu Rumah Tangga</p>
                    </div>
                </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="testimonial-card">
                <p class="testimonial-text">"Pemasangan cepat, teknisi profesional, dan internet super kenceng! Perfect untuk WFH dan streaming Netflix."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">BS</div>
                    <div class="testimonial-info">
                        <h4>Budi Santoso</h4>
                        <p>Freelancer</p>
                    </div>
                </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-content">
            <h2>🚀 Siap Upgrade Internet Anda?</h2>
            <p>Dapatkan penawaran khusus untuk pelanggan baru! Gratis instalasi + Bonus router WiFi untuk paket 12 bulan.</p>
            <a href="#packages" class="btn-primary">Pilih Paket Sekarang</a>
        </div>
    </section>

    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>GuidoTechno</h3>
                <p>Layanan Internet WiFi terpercaya untuk kebutuhan digital Anda. Cepat, stabil, dan terjangkau.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Layanan</h3>
                <ul class="footer-links">
                    <li><a href="#home">Internet Rumah</a></li>
                    <li><a href="#packages">Internet Bisnis</a></li>
                    <li><a href="#features">Fiber Optik</a></li>
                    <li><a href="#packages">Dedicated Line</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Perusahaan</h3>
                <ul class="footer-links">
                    <li><a href="#home">Tentang Kami</a></li>
                    <li><a href="#testimonials">Testimoni</a></li>
                    <li><a href="#features">Karir</a></li>
                    <li><a href="#contact">Blog</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kontak</h3>
                <ul class="footer-links">
                    <li><a href="tel:+6281234567890"><i class="fas fa-phone"></i> +62 812-3456-7890</a></li>
                    <li><a href="mailto:info@guidotechno.com"><i class="fas fa-envelope"></i> info@guidotechno.com</a></li>
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Panjalu,Ciamis,Jawa Barat</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 GuidoTechno. All rights reserved. Made with ❤️ in Indonesia</p>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.feature-card, .package-card, .testimonial-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html> 