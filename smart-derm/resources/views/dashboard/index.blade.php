@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">>
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

        <div class="story-history-section">
        <h3><i class="fas fa-history"></i> Riwayat Deteksi</h3>
        
        @if(session('last_detection'))
            <div class="last-detection-card">
                <div class="detection-header">
                    <h4><i class="fas fa-clock"></i> Hasil Terakhir</h4>
                    <span class="detection-time">{{ session('last_detection.created_at')->diffForHumans() }}</span>
                </div>
                
                <div class="detection-content">
                    <div class="detection-image">
                        @if(session('last_detection.image_path'))
                            <img src="{{ asset('storage/' . session('last_detection.image_path')) }}" alt="Hasil deteksi terakhir">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <p>Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="detection-details">
                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-user"></i> Nama:</span>
                            <span class="detail-value">{{ session('last_detection.name') }}</span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-diagnoses"></i> Hasil:</span>
                            <span class="detail-value">{{ session('last_detection.predicted_class') }}</span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-chart-line"></i> Confidence:</span>
                            <span class="detail-value">
                                {{ number_format(session('last_detection.confidence') * 100, 2) }}%
                                <div class="confidence-bar">
                                    <div class="confidence-level" style="width: {{ session('last_detection.confidence') * 100 }}%"></div>
                                </div>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-comment-medical"></i> Rekomendasi:</span>
                            <span class="detail-value">{{ session('last_detection.recommendation') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="detection-actions">
                    <button class="btn-view-details">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </button>
                    <button class="btn-new-analysis">
                        <i class="fas fa-redo"></i> Analisis Baru
                    </button>
                </div>
            </div>
        @else
            <div class="history-empty">
                <i class="fas fa-history"></i>
                <p>Belum ada riwayat deteksi</p>
                
            </div>
        @endif
    </div>
        </main>
    </div>

    @endsection
