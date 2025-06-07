@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/history.css') }}">
<div class="container">
    <div class="history-header">
        <h2 class="history-title">
            <i class="fas fa-clipboard-list"></i> Semua Riwayat Deteksi
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @forelse ($histories as $item)
        <div class="history-card">
            <div class="history-image-container">
                <img src="{{ asset('storage/' . $item->image_path) }}" class="history-image" alt="Gambar Deteksi">
            </div>
            <div class="history-content">
                <div class="history-meta">
                    <span class="meta-item">
                        <i class="fas fa-user"></i> {{ $item->name }}
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-birthday-cake"></i> {{ $item->age }} tahun
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-{{ $item->gender === 'male' ? 'male' : 'female' }}"></i> 
                        {{ ucfirst($item->gender) }}
                    </span>
                </div>
                
                <div class="history-result">
                    <div class="result-badge {{ strtolower($item->predicted_class) }}">
                        <i class="fas fa-diagnoses"></i> {{ $item->predicted_class }}
                        <span class="confidence">{{ number_format($item->confidence * 100, 2) }}%</span>
                    </div>
                </div>
                
                <div class="history-recommendation">
                    <h4><i class="fas fa-comment-medical"></i> Rekomendasi:</h4>
                    <div class="recommendation-text">
                        {!! $item->recommendation !!}
                    </div>
                </div>
                
                <div class="history-footer">
                    <i class="far fa-clock"></i> Dianalisis: {{ $item->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    @empty
        <div class="history-empty">
            <img src="{{ asset('images/empty-state.svg') }}" alt="Tidak ada data">
            <p>Tidak ada data riwayat ditemukan.</p>
        </div>
    @endforelse
</div>
@endsection