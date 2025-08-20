<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SINEMANIS - Sistem Penerimaan Mahasiswa Baru Universitas Selamat Sri</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent-gradient: linear-gradient(90deg, #0D47A1, #42A5F5);
            --accent-light: #42A5F5;
            --primary: #2E3192;
            --secondary: #1b72ec;
            --accent: #0D47A1;
            --success: #28a745;
            --light: #F8F9FA;
            --dark: #343A40;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
        }

        html {
            scroll-behavior: smooth;
        }

        /* NAVIGATION */
        .navbar {
            background: #fff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary) !important;
            font-size: 1.2rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 10px;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* HERO SECTION REDESIGN */
        .hero-section {
            min-height: 60vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-image img {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            width: 50%;
            height: auto;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #42A5F5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.7;
        }

        .btn-custom {
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom {
            background: var(--accent-gradient);
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(66, 165, 245, 0.4);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(90deg, #42A5F5, #0D47A1);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(66, 165, 245, 0.6);
            color: #fff;
        }

        .btn-outline-custom {
            border: 2px solid #fff;
            color: #fff;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: #fff;
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* CAMPUS SHOWCASE SECTION */
        .campus-showcase {
            padding: 80px 0;
            background: var(--light);
        }

        .showcase-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .showcase-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .showcase-title p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .campus-carousel {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .campus-carousel .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .carousel-indicators {
            bottom: 20px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.324);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        /* SECTIONS */
        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ABOUT SECTION */
        .about-section {
            background: #fff;
        }

        .about-content h3 {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .about-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .feature-item i {
            color: var(--success);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .about-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* FACULTY CARDS */
        .faculty-card {
            background: #fff;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 100%;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .faculty-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .faculty-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            background: var(--accent-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .faculty-card h4 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }

        .program-list {
            list-style: none;
            padding: 0;
        }

        .program-list li {
            padding: 10px 0;
            position: relative;
            padding-left: 25px;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 500;
        }

        .program-list li:before {
            content: '•';
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .program-list li:last-child {
            border-bottom: none;
        }

        /* PRICING CARDS */
        .pricing-section {
            background: var(--light);
        }

        .pricing-card {
            background: #fff;
            border: 3px solid var(--primary);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .pricing-amount {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .pricing-period {
            color: #666;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .pricing-features {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
            text-align: left;
        }

        .pricing-features li {
            padding: 10px 0;
            position: relative;
            padding-left: 30px;
            font-size: 1rem;
        }

        .pricing-features li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--success);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .sub-items {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
            line-height: 1.4;
        }

        /* REQUIREMENTS SECTION */
        .requirements-section {
            background: var(--light);
        }

        .requirement-item {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .requirement-item:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .requirement-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: var(--accent-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }

        .requirement-content h5 {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .requirement-content p {
            margin: 0;
            color: #666;
        }

        /* PROCESS SECTION */
        .process-section {
            background: #fff;
        }

        .process-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 3rem;
        }

        .process-step {
            text-align: center;
            flex: 1;
            min-width: 150px;
            max-width: 250px;
        }

        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 5px 15px rgba(66, 165, 245, 0.4);
        }

        .step-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .step-description {
            color: #666;
            font-size: 0.95rem;
        }

        .process-arrow {
            color: var(--primary);
            font-size: 2rem;
        }

        /* FOOTER */
        .footer {
            background: var(--dark);
            color: #fff;
            padding: 4rem 0 2rem;
        }

        .footer h5 {
            color: #42A5F5;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .footer p, .footer li {
            color: #ccc;
            margin-bottom: 0.5rem;
        }

        .footer a {
            color: #ccc;
            text-decoration: none;
        }

        .footer a:hover {
            color: #42A5F5;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: var(--primary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #42A5F5;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid #555;
            margin-top: 3rem;
            padding-top: 2rem;
            text-align: center;
            color: #999;
        }

        /* WHATSAPP FLOAT */
        .whatsapp-float {
            position: fixed;
            width: 65px;
            height: 65px;
            bottom: 25px;
            right: 25px;
            background: #25d366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 1000;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            background: #20c454;
            transform: scale(1.1);
            color: #fff;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.4rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .campus-carousel .carousel-item img {
                height: 300px;
            }

            .process-steps {
                flex-direction: column;
            }

            .process-arrow {
                transform: rotate(90deg);
            }

            .faculty-card {
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 100px 0 60px;
            }

            .btn-custom {
                padding: 12px 24px;
                font-size: 1rem;
            }

            .section {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="{{ asset('images/logo.png') }}" alt="UNISS" height="40" class="me-2">
                <span>SINEMANIS</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#programs">Program Studi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Biaya</a></li>
                    <li class="nav-item"><a class="nav-link" href="#requirements">Syarat</a></li>
                    <li class="nav-item"><a class="nav-link" href="#process">Alur Pendaftaran</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-primary-custom btn-custom" href="/login">Masuk/Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">SINEMANIS</h1>
                        <h3 class="hero-subtitle">Sistem Penerimaan Mahasiswa Baru<br>Universitas Selamat Sri</h3>
                        <p class="hero-description">
                            Bergabunglah dengan Universitas Selamat Sri – Tempat dimana impian pendidikan tinggi berkualitas
                            menjadi kenyataan dengan biaya terjangkau.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="/login" class="btn btn-primary-custom btn-custom">Daftar Sekarang</a>
                            <a href="#about" class="btn btn-outline-custom btn-custom">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Campus UNISS" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CAMPUS SHOWCASE SECTION -->
    <section class="campus-showcase">
        <div class="container">
            <div class="showcase-title">
                <h2>Kampus Universitas Selamat Sri</h2>
                <p>Fasilitas modern dan lingkungan yang kondusif untuk mendukung proses pembelajaran</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div id="campusCarousel" class="carousel slide campus-carousel" data-bs-ride="carousel" data-bs-interval="4000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/campus1.webp') }}" alt="Kampus UNISS 1" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/campus3.webp') }}" alt="Kampus UNISS 2" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/campus2.webp') }}" alt="Kampus UNISS 3" class="d-block w-100">
                            </div>
                        </div>

                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#campusCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#campusCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#campusCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#campusCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sebelumnya</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#campusCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Berikutnya</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="section about-section">
        <div class="container">
            <div class="section-title">
                <h2>Tentang Universitas Selamat Sri</h2>
                <p>Universitas Selamat Sri merupakan perguruan tinggi swasta terkemuka di Batang, Jawa Tengah yang berkomitmen memberikan pendidikan berkualitas dengan biaya terjangkau.</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h3>Visi & Misi Kami</h3>
                        <p>Menjadi perguruan tinggi yang unggul di tingkat regional yang mengedepankan nilai-nilai moral, inovatif dan berperan aktif dalam penyelenggaraan perkembangan ilmu pengetahuan dan teknologi di berbagai bidang keilmuan di masa mendatang.</p>
                        <p>Mendirikan universitas yang berada di bawah naungan Yayasan Wakaf Selamat Rahayu dengan mengembangkan 7 fakultas berkualitas untuk memajukan pendidikan di Jawa Tengah.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Terakreditasi Resmi</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Dosen Berkualitas</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Fasilitas Modern</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Biaya Terjangkau</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="{{ asset('images/graduation.jpg') }}" alt="Campus UNISS" class="img-fluid" alt="Fakultas UNISS" class="img-fluid" style="border-radius: 15px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="section">
        <div class="container">
            <div class="section-title">
                <h2>7 Fakultas dengan Program Unggulan</h2>
                <p>Pilih program studi sesuai minat dan bakat Anda dari 12 program studi unggulan di 7 fakultas kami</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <h4>Fakultas Teknik dan Rekayasa</h4>
                        <ul class="program-list">
                            <li>Teknik Sipil S1</li>
                            <li>Teknik Industri S1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h4>Fakultas Komputer dan Desain</h4>
                        <ul class="program-list">
                            <li>Teknik Informatika S1</li>
                            <li>Desain Komunikasi Visual S1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Fakultas Ilmu Sosial & Ilmu Politik</h4>
                        <ul class="program-list">
                            <li>Ilmu Komunikasi S1</li>
                            <li>Ilmu Pemerintahan S1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Fakultas Ekonomika & Bisnis</h4>
                        <ul class="program-list">
                            <li>Manajemen S1</li>
                            <li>Akuntansi S1</li>
                            <li>Bisnis Digital S1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h4>Fakultas Hukum</h4>
                        <ul class="program-list">
                            <li>Ilmu Hukum S1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Fakultas Psikologi</h4>
                        <ul class="program-list">
                            <li>Psikologi S1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="faculty-card">
                        <div class="faculty-icon">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h4>Fakultas Agama Islam</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="program-list">
                                    <li>Hukum Keluarga Islam S1</li>
                                    <li>Hukum Ekonomi Syariah S1</li>
                                    <li>Pendidikan Guru Madrasah Ibtidaiyah S1</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="program-list">
                                    <li>Pendidikan Agama Islam S1</li>
                                    <li>Pendidikan Islam Anak Usia Dini S1</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING SECTION -->
    <section id="pricing" class="section pricing-section">
        <div class="container">
            <div class="section-title">
                <h2>Biaya Pendidikan Terjangkau</h2>
                <p>Investasi terbaik untuk masa depan Anda dengan biaya yang sangat terjangkau dan BEBAS UANG GEDUNG</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h3>Program Teknik</h3>
                            <div class="pricing-amount">Rp 1.415.000</div>
                            <div class="pricing-period">Total Biaya Keseluruhan</div>
                        </div>
                        <ul class="pricing-features">
                            <li>Biaya Pendaftaran: Rp 250.000</li>
                            <li>Daftar Ulang: Rp 715.000
                                <div class="sub-items">
                                    - Operasional: Rp 350.000/bulan<br>
                                    - Semester: Rp 150.000/6 bulan<br>
                                    - Siakad: Rp 90.000/6 bulan<br>
                                    - Administrasi BNI: Rp 25.000/6 bulan<br>
                                    - Kemahasiswaan: Rp 100.000/6 bulan
                                </div>
                            </li>
                            <li>PKKMB: Rp 450.000
                                <div class="sub-items">
                                    - PKKMB: Rp 150.000<br>
                                    - Jas Almamater: Rp 175.000<br>
                                    - Kaos: Rp 75.000<br>
                                    - KTM: Rp 50.000
                                </div>
                            </li>
                            <li>Bebas Uang Gedung & SKS</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h3>Program Non-Teknik</h3>
                            <div class="pricing-amount">Rp 1.365.000</div>
                            <div class="pricing-period">Total Biaya Keseluruhan</div>
                        </div>
                        <ul class="pricing-features">
                            <li>Biaya Pendaftaran: Rp 250.000</li>
                            <li>Daftar Ulang: Rp 665.000
                                <div class="sub-items">
                                    - Operasional: Rp 300.000/bulan<br>
                                    - Semester: Rp 150.000/6 bulan<br>
                                    - Siakad: Rp 90.000/6 bulan<br>
                                    - Administrasi BNI: Rp 25.000/6 bulan<br>
                                    - Kemahasiswaan: Rp 100.000/6 bulan
                                </div>
                            </li>
                            <li>PKKMB: Rp 450.000
                                <div class="sub-items">
                                    - PKKMB: Rp 150.000<br>
                                    - Jas Almamater: Rp 175.000<br>
                                    - Kaos: Rp 75.000<br>
                                    - KTM: Rp 50.000
                                </div>
                            </li>
                            <li>Bebas Uang Gedung & SKS</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- REQUIREMENTS SECTION -->
    <section id="requirements" class="section requirements-section">
        <div class="container">
            <div class="section-title">
                <h2>Syarat Pendaftaran</h2>
                <p>Persiapkan dokumen-dokumen berikut untuk proses pendaftaran yang lancar</p>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="requirement-item">
                        <div class="requirement-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="requirement-content">
                            <h5>Fotocopy Ijazah</h5>
                            <p>SMA/SMK/MA/Sederajat - 1 Lembar</p>
                        </div>
                    </div>
                    <div class="requirement-item">
                        <div class="requirement-icon"><i class="fas fa-certificate"></i></div>
                        <div class="requirement-content">
                            <h5>Fotocopy SKHUN</h5>
                            <p>Surat Keterangan Hasil Ujian Nasional - 1 Lembar</p>
                        </div>
                    </div>
                    <div class="requirement-item">
                        <div class="requirement-icon"><i class="fas fa-id-card"></i></div>
                        <div class="requirement-content">
                            <h5>Fotocopy KTP</h5>
                            <p>Kartu Tanda Penduduk - 1 Lembar</p>
                        </div>
                    </div>
                    <div class="requirement-item">
                        <div class="requirement-icon"><i class="fas fa-users"></i></div>
                        <div class="requirement-content">
                            <h5>Fotocopy Kartu Keluarga</h5>
                            <p>Kartu Keluarga (KK) - 1 Lembar</p>
                        </div>
                    </div>
                    <div class="requirement-item">
                        <div class="requirement-icon"><i class="fas fa-camera"></i></div>
                        <div class="requirement-content">
                            <h5>Pas Photo Terbaru</h5>
                            <p>Ukuran 4x6 Warna - 4 Lembar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <!-- Process Section -->
    <section id="process" class="section process-section">
        <div class="container">
            <div class="section-title">
                <h2>Alur Pendaftaran</h2>
                <p>Ikuti langkah-langkah mudah berikut untuk menjadi mahasiswa UNISS</p>
            </div>
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h5 class="step-title">Registrasi</h5>
                    <p class="step-description">Daftar akun di SINEMANIS dan isi data diri</p>
                </div>
                <div class="process-arrow d-none d-md-block">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h5 class="step-title">Formulir</h5>
                    <p class="step-description">Lengkapi formulir pendaftaran dengan benar</p>
                </div>
                <div class="process-arrow d-none d-md-block">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h5 class="step-title">Pembayaran</h5>
                    <p class="step-description">Lakukan pembayaran biaya pendaftaran</p>
                </div>
                <div class="process-arrow d-none d-md-block">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h5 class="step-title">Verifikasi</h5>
                    <p class="step-description">Upload dokumen dan tunggu verifikasi</p>
                </div>
                <div class="process-arrow d-none d-md-block">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="process-step">
                    <div class="step-number">5</div>
                    <h5 class="step-title">Pengumuman</h5>
                    <p class="step-description">Cek hasil kelulusan di sistem</p>
                </div>
            </div>
            
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded-3 shadow border">
                        <h5 class="text-center mb-3"><i class="fas fa-calendar me-2 text-primary"></i>Periode Pendaftaran</h5>
                        <p class="text-center mb-3"><strong>Oktober 2024 s.d. Agustus 2025</strong></p>
                        <p class="text-center mb-3">Pilihan Kelas:</p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <span class="badge bg-secondary p-3 fs-6"><i class="fas fa-sun me-2"></i> Reguler Pagi</span>
                            <span class="badge bg-secondary p-3 fs-6"><i class="fas fa-moon me-2"></i> Reguler Malam</span>
                            <span class="badge bg-secondary p-3 fs-6"><i class="fas fa-calendar-week me-2"></i> Weekend</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4 text-lg-start">
                    <h5>Universitas Selamat Sri Batang</h5>
                    <p>Yayasan Wakaf Selamat Rahayu<br>Universitas Selamat Sri Batang</p>
                    <p>Jl. Raya Batang-Semarang Km.14 Clapar, Subah, Batang, Jawa Tengah<br>Kode Pos 51263</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/unissbatang/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.tiktok.com/@unissbatang.official" target="_blank"><i class="fab fa-tiktok"></i></a>
                        <a href="https://www.instagram.com/pmb.unissbatang.official/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@unissofficial" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 text-lg-center">
                    <h5>Fakultas</h5>
                    <ul class="list-unstyled">
                        <li>Teknik dan Rekayasa</li>
                        <li>Komputer dan Desain</li>
                        <li>Ilmu Sosial & Politik</li>
                        <li>Ekonomika & Bisnis</li>
                        <li>Hukum</li>
                        <li>Psikologi</li>
                        <li>Agama Islam</li>
                    </ul>
                </div>
                <!-- KANAN -->
                <div class="col-12 col-md-6 col-lg-4 ms-lg-auto text-lg-start ps-lg-4">
                <h5>Kontak PMB</h5>
                <ul class="list-unstyled contact-list ps-0 m-0 text-lg-start">
                    <li class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-phone"></i><span>+62 821 2279 0309</span>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-envelope"></i><span>unissbatang12@gmail.com</span>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                    <i class="fab fa-whatsapp"></i><span>+62 822 2063 052</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                    <i class="fas fa-globe"></i><span>www.batang.uniss.ac.id</span>
                    </li>
                </ul>
                </div>

            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 UNISS </p>
            </div>
        </div>
    </footer>

    <!-- FLOATING WHATSAPP -->
    <a href="https://wa.me/6282122790309?text=Halo,%20saya%20ingin%20bertanya%20tentang%20pendaftaran%20mahasiswa%20baru%20UNISS" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-initialize carousels
        document.addEventListener('DOMContentLoaded', function() {
            // Campus carousel
            const campusCarousel = document.getElementById('campusCarousel');
            if (campusCarousel) {
                new bootstrap.Carousel(campusCarousel, {
                    interval: 4000,
                    pause: 'hover',
                    touch: true
                });
            }
        });

        // Add navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = '#fff';
                navbar.style.backdropFilter = 'none';
            }
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.faculty-card, .requirement-item, .process-step').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });