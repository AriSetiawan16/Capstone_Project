@extends('layouts.app')
@section('content')
@vite('resources/css/LandingPage.css')
@vite('resources/js/LandingPage.js')
<nav class="navbar">
    <div class="container">
        <a href="#" class="logo">SmartDerm</a>
        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="{{ route('auth') }}" class="btn appointment-btn">Login</a>
        </div>
        <button class="hamburger">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Selamat Datang di <span>SmartDerm</span></h1>
            <p class="subtitle">Platform analitik untuk mendeteksi penyakit kulit berbasis gambar digital</p>
            <div class="hero-buttons">
                <a href="#about" class="btn primary-btn">Learn More</a>
                <a href="#services" class="btn secondary-btn">Our Services</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Skin Analysis">
        </div>
    </div>
</section>
<!-- About Section -->
<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="about-header">
            <h2><i class="fas fa-question-circle"></i> Apa Itu SmartDerm?</h2>
            <p class="subtitle">Platform inovatif berbasis teknologi analitik untuk deteksi dini penyakit kulit melalui analisis citra digital.</p>
        </div>

        <div class="about-features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bridge"></i>
                </div>
                <h3>Tujuan Utama</h3>
                <p>Menjembatani kesenjangan dalam layanan dermatologis dengan solusi diagnosis mandiri yang akurat dan mudah digunakan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Solusi Digital</h3>
                <p>Hadir sebagai solusi terhadap keterbatasan layanan dermatologis, terutama di area yang sulit menjangkau tenaga medis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3>Layanan Kesehatan</h3>
                <p>Mempercepat identifikasi masalah kulit dan mendorong kesadaran menjaga kesehatan kulit sejak dini.</p>
            </div>
        </div>
         <div class="about-card">
            <div class="card-overlay"></div>
            <div class="card-content">
                <div class="details-header">
                    <h2><i class="fas fa-info-circle"></i> Tentang Kami</h2>
                    <p>SmartDerm adalah layanan digital berbasis teknologi yang menyediakan solusi cepat dan akurat dalam mengidentifikasi masalah kulit.</p>
                </div>

                <div class="details-content">
                    <div class="detail-point">
                        <div class="point-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="point-text">
                            <h4>Cepat dan Akurat</h4>
                            <p>Proses identifikasi berbasis gambar hanya dalam hitungan detik dengan akurasi tinggi.</p>
                        </div>
                    </div>
                    <div class="detail-point">
                        <div class="point-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="point-text">
                            <h4>Teknologi AI</h4>
                            <p>Sistem klasifikasi cerdas berbasis kecerdasan buatan dan data dermatologis terpercaya.</p>
                        </div>
                    </div>
                    <div class="detail-point">
                        <div class="point-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="point-text">
                            <h4>Kesadaran Dini</h4>
                            <p>Membantu pengguna lebih peduli dan waspada terhadap kesehatan kulit mereka.</p>
                        </div>
                    </div>
                    <div class="detail-point">
                        <div class="point-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="point-text">
                            <h4>Dukungan Profesional</h4>
                            <p>Didukung oleh tim ahli dermatologi berpengalaman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section -->
<section id="services" class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Services</h2>
            <p>Layanan lengkap untuk kesehatan kulit digital Anda</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h3>Deteksi Kulit Otomatis</h3>
                <p>Sistem cerdas yang mampu menganalisis gambar kulit dan memberikan hasil klasifikasi secara cepat dan akurat.</p>
                <a href="{{ Auth::check() ? route('dashboard') : route('auth') }}" class="btn primary-btn">Mulai Deteksi</a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <h3>Analisis Gejala Kulit</h3>
                <p>Mendeteksi gejala awal dari berbagai permasalahan kulit berdasarkan pola visual yang terdeteksi.</p>

            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <h3>Rekomendasi Perawatan</h3>
                <p>Saran perawatan kulit yang sesuai dengan hasil analisis, lengkap dengan produk dan tindakan yang direkomendasikan.</p>

            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h3>Riwayat Pemeriksaan</h3>
                <p>Menyimpan dan memantau hasil pemeriksaan sebelumnya untuk mengetahui perkembangan kondisi kulit dari waktu ke waktu.</p>

            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Panduan Perawatan Harian</h3>
                <p>Tips perawatan kulit harian yang dipersonalisasi berdasarkan jenis dan kondisi kulit pengguna.</p>

            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Berita Kulit Terkini</h3>
                <p>Informasi terbaru seputar kesehatan kulit, tren perawatan, dan penelitian terbaru yang dapat membantu menjaga kulit tetap sehat.</p>

            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-col">
                <h3>SmartDerm</h3>
                <p>Platform analitik penyakit kulit berbasis gambar dengan teknologi AI terpercaya.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#appointment">Appointments</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="#">Deteksi Kulit Otomatis</a></li>
                    <li><a href="#">Analisis Gejala Kulit</a></li>
                    <li><a href="#">Rekomendasi Perawatan</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 SmartDerm. All rights reserved.</p>
        </div>
    </div>

</footer>
</body>
</html>
