@extends('layouts.app')

@section('content')
@vite('resources/css/dashboard.css')
<header class="dashboard-header">
  <div class="header-left">
    <h2>Selamat Datang, <strong>{{ Auth::user()->name }}</strong>!</h2>
    <p>Dashboard SmartDerm – Analisis Penyakit Kulit Berbasis AI</p>
  </div>

  <div class="desktop-actions">
    <a href="{{ route('profile.index') }}" class="profile-btn">
      <i class="fas fa-user"></i> Profil
    </a>
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </form>
  </div>

  <div class="hamburger" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </div>
</header>

<nav id="sidebarMenu">
  <div class="mobile-actions">
    <a href="{{ route('profile.index') }}" class="profile-btn">
      <i class="fas fa-user"></i> Profil
    </a>
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </form>
  </div>
</nav>



    <div class="dashboard-container">
        <div id="sidebarOverlay" class="sidebar-overlay"></div>
        <!-- Header -->


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
        <div class="feature-card weather-card">
            <div class="feature-icon">
                <i class="fas fa-sun"></i>
            </div>
            <div class="feature-content">
                <h2>Cek Cuaca & Indeks UV</h2>
                <p>Ketahui kondisi cuaca terkini dan tingkat paparan sinar UV di lokasi Anda untuk melindungi kesehatan kulit.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check"></i> Informasi suhu, kelembapan, dan angin</li>
                    <li><i class="fas fa-check"></i> Indeks UV harian dan peringatan</li>
                    <li><i class="fas fa-check"></i> Rekomendasi perlindungan kulit</li>
                </ul>
            </div>
            <div class="feature-action">
                <a href="{{ route('weather.show') }}" class="btn btn-info mt-3">
                    <i class="fas fa-sun"></i> Cek Cuaca & UV
                </a>
            </div>
        </div>


            <div class="story-history-section">
            <h3><i class="fas fa-history"></i> Riwayat Deteksi</h3>
            @if($last_detection)
            <div class="last-detection-card">
                <div class="detection-header">
                    <h4><i class="fas fa-clock"></i> Hasil Terakhir</h4>
                    <span class="detection-time">{{ \Carbon\Carbon::parse($last_detection->created_at)->diffForHumans() }}</span>
                </div>

                <div class="detection-content">
                    <div class="detection-image">
                        @if($last_detection->image_path)
                            <img src="{{ asset('storage/' . $last_detection->image_path) }}" alt="Hasil deteksi terakhir">
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
                            <span class="detail-value">{{ $last_detection->name }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-diagnoses"></i> Hasil:</span>
                            <span class="detail-value">{{ $last_detection->predicted_class }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-chart-line"></i> Confidence:</span>
                            <span class="detail-value">
                                {{ number_format($last_detection->confidence * 100, 2) }}%
                                <div class="confidence-bar">
                                    <div class="confidence-level" style="width: {{ $last_detection->confidence * 100 }}%"></div>
                                </div>
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label"><i class="fas fa-info-circle"></i> Deskripsi:</span>
                            <span class="detail-value">{!! $last_detection->description !!}</span>
                        </div>
                    </div>
                </div>

                <div class="detection-actions">
                    <a href="{{ route('detection.history') }}" class="btn-view-details">
                        <i class="fas fa-eye"></i> Lihat Semua Riwayat
                    </button>
                    <a href="{{ route('detection') }}" class="btn-new-analysis">
                        <i class="fas fa-redo"></i> Analisis Baru
                    </a>
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
        @push('scripts')
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('sidebarOverlay');

    hamburger.addEventListener('click', function () {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
});

</script>
@endpush

