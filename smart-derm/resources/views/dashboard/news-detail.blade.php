@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/news-detail.css') }}">
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
                <span class="article-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ !empty($newsItem['pubDate']) ? date('d F Y', strtotime($newsItem['pubDate'])) : '-' }}
                </span>
            </div>

            <h1 class="article-title">{{ $newsItem['title'] ?? 'Judul Artikel Tidak Tersedia' }}</h1>

           @php
                $originalImage = $newsItem['thumbnail'] ?? null;
                $imageUrl = $originalImage ? url('/image-proxy?url=' . urlencode($originalImage)) : null;
            @endphp

            @if($imageUrl)
            <div class="article-image">
                <img src="{{ $imageUrl }}" alt="{{ $newsItem['title'] ?? 'Gambar Artikel' }}">
            </div>
            @endif


        </header>

        <!-- Article Body -->
        <div class="article-body">
            <div class="article-text">
                {!! !empty($newsItem['description']) ? nl2br(e($newsItem['description'])) : 'Konten artikel tidak tersedia.' !!}
            </div>

            @if(!empty($newsItem['link']))
            <div class="mt-4">
                <a href="{{ $newsItem['link'] }}" target="_blank" rel="noopener" class="btn btn-primary">
                    Baca Selengkapnya di Sumber Asli
                </a>
            </div>
            @endif

            <!-- Article Tags -->
            <div class="article-tags mt-4">
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
            {{-- Tambahkan data dinamis atau statis di sini --}}
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

@endsection
