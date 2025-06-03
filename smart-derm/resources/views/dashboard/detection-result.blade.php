@extends('layouts.app')

@section('content')
<div class="result-container">
    <!-- Navigation -->
    <nav class="page-nav">
        <a href="{{ route('detection') }}" class="nav-back">
            <i class="fas fa-arrow-left"></i>
            Deteksi Baru
        </a>
        <h1>Hasil Analisis</h1>
        <a href="{{ route('dashboard') }}" class="nav-home">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
    </nav>

    <div class="result-content">
        <!-- Analysis Summary -->
        <div class="summary-card">
            <div class="summary-header">
                <div class="status-badge success">
                    <i class="fas fa-check-circle"></i>
                    Analisis Selesai
                </div>
                <div class="analysis-time">
                    {{ $analysisResult['analyzed_at']->format('d M Y, H:i') }}
                </div>
            </div>

            <div class="patient-info">
                <h3>Informasi Pasien</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Nama:</span>
                        <span class="value">{{ $analysisResult['patient_name'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Usia:</span>
                        <span class="value">{{ $analysisResult['age'] }} tahun</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Jenis Kelamin:</span>
                        <span class="value">{{ ucfirst($analysisResult['gender'] == 'male' ? 'Laki-laki' : 'Perempuan') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analysis Results -->
        <div class="analysis-grid">
            <!-- Image Analysis -->
            <div class="result-card image-card">
                <h3><i class="fas fa-image"></i> Gambar yang Dianalisis</h3>
                <div class="image-container">
                    <img src="{{ Storage::url($analysisResult['image_path']) }}" alt="Analyzed skin image" class="analyzed-image">
                </div>
                <div class="symptoms-section">
                    <h4>Gejala yang Dilaporkan:</h4>
                    <p class="symptoms-text">{{ $analysisResult['symptoms'] }}</p>
                </div>
            </div>

            <!-- Prediction Results -->
            <div class="result-card prediction-card">
                <h3><i class="fas fa-brain"></i> Hasil Prediksi AI</h3>

                <div class="prediction-main">
                    <div class="condition-result">
                        <h4>Kondisi yang Terdeteksi:</h4>
                        <div class="condition-name">{{ $analysisResult['predicted_condition'] }}</div>
                    </div>

                    <div class="confidence-meter">
                        <h4>Tingkat Keyakinan:</h4>
                        <div class="confidence-bar">
                            <div class="confidence-fill" style="width: {{ $analysisResult['confidence'] }}%"></div>
                        </div>
                        <div class="confidence-text">{{ $analysisResult['confidence'] }}%</div>
                    </div>
                </div>

                <div class="disclaimer">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p><strong>Disclaimer:</strong> Hasil ini adalah prediksi AI dan bukan diagnosis medis resmi. Selalu konsultasikan dengan dokter untuk diagnosis yang akurat.</p>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="recommendations-card">
            <h3><i class="fas fa-clipboard-list"></i> Rekomendasi Perawatan</h3>
            <div class="recommendations-list">
                @foreach($analysisResult['recommendations'] as $recommendation)
                <div class="recommendation-item">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $recommendation }}</span>
                </div>
                @endforeach
            </div>

            <div class="next-steps">
                <h4>Langkah Selanjutnya:</h4>
                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="step-content">
                            <h5>Konsultasi Dokter</h5>
                            <p>Jadwalkan konsultasi dengan dokter spesialis kulit</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-prescription-bottle-alt"></i>
                        </div>
                        <div class="step-content">
                            <h5>Ikuti Perawatan</h5>
                            <p>Lakukan perawatan sesuai rekomendasi medis</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="step-content">
                            <h5>Monitor Progress</h5>
                            <p>Pantau perkembangan kondisi kulit secara berkala</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('detection') }}" class="btn btn-primary">
                <i class="fas fa-redo"></i>
                Deteksi Baru
            </a>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print"></i>
                Cetak Hasil
            </button>
            <a href="{{ route('news') }}" class="btn btn-outline">
                <i class="fas fa-book-open"></i>
                Baca Artikel Terkait
            </a>
        </div>
    </div>
</div>

@vite('resources/css/detection-result.css')
@endsection
