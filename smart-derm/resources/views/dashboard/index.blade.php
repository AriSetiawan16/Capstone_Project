@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="welcome-section">
                <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p>Dashboard SmartDerm - Analisis Penyakit Kulit Berbasis AI</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('profile.index') }}" class="profile-btn">
                    <i class="fas fa-user"></i>
                    Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Features -->
    <main class="dashboard-main">
        <div class="features-grid">
            <!-- Skin Detection Feature -->
            <div class="feature-card detection-card">
                <div class="feature-icon">
                    <i class="fas fa-camera-retro"></i>
                </div>
                <div class="feature-content">
                    <h2>Deteksi Penyakit Kulit</h2>
                    <p>Gunakan teknologi AI untuk menganalisis kondisi kulit Anda dengan mudah dan cepat.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Upload foto kulit</li>
                        <li><i class="fas fa-check"></i> Analisis AI real-time</li>
                        <li><i class="fas fa-check"></i> Rekomendasi perawatan</li>
                    </ul>
                </div>
                <div class="feature-action">
                    <a href="{{ route('detection') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Mulai Deteksi
                    </a>
                </div>
            </div>

            <!-- News Feature -->
            <div class="feature-card news-card">
                <div class="feature-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="feature-content">
                    <h2>Berita & Artikel</h2>
                    <p>Dapatkan informasi terkini seputar kesehatan kulit dan perkembangan teknologi medis.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Artikel kesehatan</li>
                        <li><i class="fas fa-check"></i> Tips perawatan kulit</li>
                        <li><i class="fas fa-check"></i> Update teknologi AI</li>
                    </ul>
                </div>
                <div class="feature-action">
                    <a href="{{ route('news') }}" class="btn btn-secondary">
                        <i class="fas fa-book-open"></i>
                        Baca Artikel
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <h3>Statistik Platform</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h4>5,000+</h4>
                        <p>Pengguna Aktif</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="stat-info">
                        <h4>15,000+</h4>
                        <p>Gambar Dianalisis</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h4>95%</h4>
                        <p>Akurasi AI</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h4>24/7</h4>
                        <p>Layanan Tersedia</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@vite('resources/css/dashboard.css')
@endsection
