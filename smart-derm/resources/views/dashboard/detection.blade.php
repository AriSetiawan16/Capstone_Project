@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/detection.css') }}">

<div class="detection-container">
    <!-- Navigation -->
    <nav class="page-nav">
        <a href="{{ route('dashboard') }}" class="nav-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>
        <h1>Deteksi Penyakit Kulit</h1>
    </nav>

    <div class="detection-content">
        <!-- Instructions -->
        <div class="instructions-card">
            <h3><i class="fas fa-info-circle"></i> Panduan Penggunaan</h3>
            <div class="instructions-grid">
                <div class="instruction-item">
                    <div class="instruction-icon">1</div>
                    <p>Isi formulir dengan data diri Anda</p>
                </div>
                <div class="instruction-item">
                    <div class="instruction-icon">2</div>
                    <p>Upload foto area kulit yang ingin dianalisis</p>
                </div>
                <div class="instruction-item">
                    <div class="instruction-icon">3</div>
                    <p>Tunggu hasil analisis AI dalam beberapa detik</p>
                </div>
                <div class="instruction-item">
                    <div class="instruction-icon">4</div>
                    <p>Dapatkan rekomendasi dan saran perawatan</p>
                </div>
            </div>
        </div>

        <!-- Detection Form -->
        <div class="form-card">
            <h3><i class="fas fa-clipboard-list"></i> Formulir Deteksi</h3>

            <form method="POST" enctype="multipart/form-data" id="detectionForm">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h4>Informasi Pribadi</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="age">
                                <i class="fas fa-calendar-alt"></i>
                                Usia
                            </label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" min="1" max="120" required>
                            @error('age')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-venus-mars"></i>
                            Jenis Kelamin
                        </label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <span class="radio-custom"></span>
                                Laki-laki
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                Perempuan
                            </label>
                        </div>
                        @error('gender')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-section">
                    <h4>Upload Gambar</h4>
                    <div class="form-group">
                        <label for="image">
                            <i class="fas fa-camera"></i>
                            Foto Area Kulit
                        </label>
                        <div class="image-upload-area" id="imageUploadArea">
                            <input type="file" name="image" id="image" accept="image/*" required>
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik untuk upload gambar atau drag & drop</p>
                                <small>Format: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview">
                                <button type="button" id="removeImage" class="remove-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @error('image')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large" id="submitBtn">
                        <i class="fas fa-search"></i>
                        Analisis Sekarang
                    </button>
                </div>
            </form>

            <!-- Loading Animation -->
            <div id="loadingContainer" class="loading-overlay" style="display: none;">
                <div class="loading-content">
                    <div class="loading-spinner">
                        <div class="spinner-circle"></div>
                        <div class="spinner-circle"></div>
                        <div class="spinner-circle"></div>
                        <div class="spinner-circle"></div>
                    </div>
                    <p class="loading-text">Menganalisis gambar...</p>
                    <div class="progress-container">
                        <div class="progress-bar" id="progressBar"></div>
                    </div>
                    <p class="progress-text">Mengunggah: <span id="progressPercent">0</span>%</p>
                </div>
            </div>

            <!-- Results Section -->
            <div id="resultContainer" class="result-overlay" style="display:none;">
                <div class="result-content">
                    <button type="button" id="closeResult" class="close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                    
                    <div class="result-header">
                        <h3><i class="fas fa-clipboard-check"></i> Hasil Analisis</h3>
                    </div>
                    
                    <div class="result-body">
                        <div class="result-image-container">
                            <h4>Gambar yang Diupload</h4>
                            <div class="image-wrapper">
                                <img id="resultPreview" src="" alt="Uploaded Image">
                            </div>
                        </div>
                        
                        <div class="result-analysis-container">
                            <div class="diagnosis-section">
                                <h4>Diagnosis</h4>
                                <div class="diagnosis-card">
                                    <div class="diagnosis-icon">
                                        <i class="fas fa-diagnoses"></i>
                                    </div>
                                    <div class="diagnosis-content">
                                        <p id="predictionText" class="diagnosis-text">Tunggu hasil analisis...</p>
                                        <div id="confidenceMeter" class="confidence-meter">
                                            <div class="confidence-fill" id="confidenceFill"></div>
                                            <span class="confidence-percent" id="confidencePercent">0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="recommendation-section">
                                <h4>Rekomendasi</h4>
                                <div id="recommendationText" class="recommendation-content">
                                    <!-- Recommendations will be inserted here -->
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                <button type="button" class="btn btn-secondary" id="saveResultBtn">
                                    <i class="fas fa-save"></i> Simpan Hasil
                                </button>
                                <button type="button" class="btn btn-primary" id="newAnalysisBtn">
                                    <i class="fas fa-redo"></i> Analisis Baru
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="tips-card">
            <h3><i class="fas fa-lightbulb"></i> Tips untuk Hasil Terbaik</h3>
            <ul class="tips-list">
                <li><i class="fas fa-check-circle"></i> Pastikan gambar jelas dan tidak blur</li>
                <li><i class="fas fa-check-circle"></i> Ambil foto dengan pencahayaan yang cukup</li>
                <li><i class="fas fa-check-circle"></i> Fokus pada area kulit yang bermasalah</li>
                <li><i class="fas fa-check-circle"></i> Hindari menggunakan filter atau edit gambar</li>
                <li><i class="fas fa-check-circle"></i> Pastikan area kulit terlihat dengan jelas</li>
            </ul>
        </div>
    </div>
</div>

<!-- Pindahkan JS ke bawah halaman untuk memastikan DOM siap -->
<script src="{{ asset('js/detection.js') }}"></script>

@endsection
<script>
document.getElementById('image').addEventListener('change', function () {
    const file = this.files[0];
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    const removeBtn = document.getElementById('removeImage');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    removeBtn.addEventListener('click', function () {
        preview.style.display = 'none';
        img.src = '';
        document.getElementById('image').value = '';
    });
});
</script>
