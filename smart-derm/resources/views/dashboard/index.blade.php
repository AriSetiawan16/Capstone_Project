@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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

        <!-- Story History Section -->
        <div class="story-history-section">
            <h3>Lihat Riwayat Story</h3>
            <div class="history-grid">
                <!-- Story history items will be displayed here -->
                <div class="history-empty">
                    <i class="fas fa-history"></i>
                    <p>Riwayat story Anda akan muncul di sini</p>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection
