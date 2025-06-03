@extends('layouts.app')

@section('content')
<div class="news-detail-container">
    <!-- Navigation -->
    <nav class="page-nav">
        <a href="{{ route('news') }}" class="nav-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Berita
        </a>
        <div class="nav-actions">
            <button onclick="window.print()" class="nav-action">
                <i class="fas fa-print"></i>
            </button>
            <button onclick="shareArticle()" class="nav-action">
                <i class="fas fa-share-alt"></i>
            </button>
        </div>
    </nav>

    <article class="article-content">
        <!-- Article Header -->
        <header class="article-header">
            <div class="article-meta">
                <span class="category-badge {{ strtolower(str_replace(' ', '-', $newsItem['category'])) }}">
                    {{ $newsItem['category'] }}
                </span>
                <span class="article-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ date('d F Y', strtotime($newsItem['published_at'])) }}
                </span>
                <span class="article-author">
                    <i class="fas fa-user"></i>
                    {{ $newsItem['author'] }}
                </span>
            </div>

            <h1 class="article-title">{{ $newsItem['title'] }}</h1>

            <div class="article-image">
                <img src="{{ $newsItem['image'] }}" alt="{{ $newsItem['title'] }}">
            </div>
        </header>

        <!-- Article Body -->
        <div class="article-body">
            <div class="article-text">
                {!! nl2br(e($newsItem['content'])) !!}
            </div>

            <!-- Article Tags -->
            <div class="article-tags">
                <h4>Tags:</h4>
                <div class="tags-list">
                    <span class="tag">Kesehatan Kulit</span>
                    <span class="tag">AI Technology</span>
                    <span class="tag">Dermatologi</span>
                    <span class="tag">Teknologi Medis</span>
                </div>
            </div>

            <!-- Share Section -->
            <div class="share-section">
                <h4>Bagikan Artikel:</h4>
                <div class="share-buttons">
                    <button class="share-btn facebook" onclick="shareToFacebook()">
                        <i class="fab fa-facebook-f"></i>
                        Facebook
                    </button>
                    <button class="share-btn twitter" onclick="shareToTwitter()">
                        <i class="fab fa-twitter"></i>
                        Twitter
                    </button>
                    <button class="share-btn whatsapp" onclick="shareToWhatsApp()">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp
                    </button>
                    <button class="share-btn copy" onclick="copyLink()">
                        <i class="fas fa-link"></i>
                        Copy Link
                    </button>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Articles -->
    <section class="related-section">
        <h3><i class="fas fa-newspaper"></i> Artikel Terkait</h3>
        <div class="related-grid">
            <div class="related-card">
                <div class="related-image">
                    <img src="https://via.placeholder.com/300x150/059669/ffffff?text=Tips+Skincare" alt="Related Article">
                </div>
                <div class="related-content">
                    <h5>Tips Merawat Kulit Sensitif</h5>
                    <p>Panduan lengkap merawat kulit sensitif dengan produk yang tepat...</p>
                    <a href="#" class="related-link">Baca Artikel</a>
                </div>
            </div>

            <div class="related-card">
                <div class="related-image">
                    <img src="https://via.placeholder.com/300x150/dc2626/ffffff?text=Prevention" alt="Related Article">
                </div>
                <div class="related-content">
                    <h5>Mencegah Penyakit Kulit</h5>
                    <p>Langkah-langkah pencegahan yang efektif untuk menjaga kesehatan kulit...</p>
                    <a href="#" class="related-link">Baca Artikel</a>
                </div>
            </div>

            <div class="related-card">
                <div class="related-image">
                    <img src="https://via.placeholder.com/300x150/f59e0b/ffffff?text=Technology" alt="Related Article">
                </div>
                <div class="related-content">
                    <h5>Masa Depan Teknologi Medis</h5>
                    <p>Perkembangan teknologi AI dalam dunia kesehatan dan kedokteran...</p>
                    <a href="#" class="related-link">Baca Artikel</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Buttons -->
    <div class="article-actions">
        <a href="{{ route('news') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i>
            Lihat Artikel Lain
        </a>
        <a href="{{ route('detection') }}" class="btn btn-primary">
            <i class="fas fa-camera"></i>
            Coba Deteksi AI
        </a>
    </div>
</div>

@vite('resources/css/news-detail.css')
@vite('resources/js/news-detail.js')
@endsection
