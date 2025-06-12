@extends('layouts.app')

@section('content')
@vite('resources/css/news.css')
<div class="news-container">
    <!-- Navigation -->
    <nav class="page-nav">
        <a href="{{ route('dashboard') }}" class="nav-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>
        <h1>Berita & Artikel Kesehatan</h1>
    </nav>

    <div class="news-content">
        <!-- Featured Section -->
        @if (isset($news[0]))
        <div class="featured-card">
            <div class="featured-image">
                <img src="{{ asset($news[0]['local_thumbnail']) }}" alt="{{ $news[0]['title'] }}">
                
                <div class="featured-overlay">
                    <span class="category-tag {{ strtolower(str_replace(' ', '-', $news[0]['category'] ?? 'umum')) }}">
                        {{ $news[0]['category'] ?? 'Umum' }}
                    </span>
                </div>
            </div>
            <div class="featured-content">
                <h3>{{ $news[0]['title'] }}</h3>
                <p>{{ $news[0]['description'] }}</p>
                <div class="featured-meta">
                    <span class="date">
                        <i class="fas fa-calendar"></i>
                        {{ date('d M Y', strtotime($news[0]['pubDate'])) }}
                    </span>
                     <a href="{{ $news[0]['link'] }}" class="read-link" target="_blank" rel="noopener noreferrer">
                        Baca
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
        </div>
        @else
        <p style="text-align:center; font-style:italic;">Tidak ada artikel pilihan tersedia.</p>
        @endif

        </div>

        <!-- Categories Filter -->
        <div class="filter-section">
            <h3>Berita Kesehatan</h3>
           
        </div>

        <!-- News Grid -->
        <div class="news-grid">
           @forelse ($news as $article)
                @php
                    $thumbnail = $article['thumbnail'] ?? '';
                    $thumbnailHttps = preg_replace("/^http:/i", "https:", $thumbnail);
                @endphp
                <article class="news-card" data-category="{{ $article['category'] ?? 'Umum' }}">
                    <div class="news-image">
                        <img src="{{ asset($article['local_thumbnail']) }}" alt="{{ $article['title'] }}">
                        <div class="news-overlay">
                            <span class="category-tag {{ strtolower(str_replace(' ', '-', $article['category'] ?? 'umum')) }}">
                                {{ $article['category'] ?? 'Umum' }}
                            </span>
                        </div> 
                    </div>
                    <div class="news-content">
                        <h4>{{ $article['title'] }}</h4>
                        <p>{{ $article['description'] }}</p>
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-clock"></i>
                                {{ date('d M Y', strtotime($article['pubDate'])) }}
                            </span>
                            <a href="{{ $article['link'] }}" class="read-link" target="_blank" rel="noopener noreferrer">
                                Baca
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <p style="text-align:center; font-style:italic;">Belum ada berita untuk ditampilkan.</p>
            @endforelse

        </div>


        <!-- Health Tips Section -->
        <div class="tips-section">
            <h3><i class="fas fa-lightbulb"></i> Tips Kesehatan Cepat</h3>
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">
                        <i class="fas fa-sun"></i>
                    </div>
                    <div class="tip-content">
                        <h5>Gunakan Sunscreen</h5>
                        <p>Lindungi kulit dari sinar UV dengan SPF minimal 30</p>
                    </div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div class="tip-content">
                        <h5>Jaga Kelembaban</h5>
                        <p>Gunakan pelembab sesuai jenis kulit setiap hari</p>
                    </div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon">
                        <i class="fas fa-apple-alt"></i>
                    </div>
                    <div class="tip-content">
                        <h5>Pola Makan Sehat</h5>
                        <p>Konsumsi makanan bergizi untuk kesehatan kulit</p>
                    </div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <div class="tip-content">
                        <h5>Istirahat Cukup</h5>
                        <p>Tidur 7-8 jam untuk regenerasi sel kulit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
