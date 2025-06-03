@extends('layouts.app')

@section('content')
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

            <form action="{{ route('detection.analyze') }}" method="POST" enctype="multipart/form-data" id="detectionForm">
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

                <!-- Symptoms -->
                <div class="form-section">
                    <h4>Gejala & Keluhan</h4>
                    <div class="form-group">
                        <label for="symptoms">
                            <i class="fas fa-notes-medical"></i>
                            Deskripsikan gejala yang Anda alami
                        </label>
                        <textarea name="symptoms" id="symptoms" rows="4" placeholder="Contoh: Kulit kemerahan, gatal, terdapat ruam kecil..." required>{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-section">
                    <h4>Upload Gambar</h4>
                    <div class="form-group">
                        <label for="skin_image">
                            <i class="fas fa-camera"></i>
                            Foto Area Kulit
                        </label>
                        <div class="image-upload-area" id="imageUploadArea">
                            <input type="file" name="skin_image" id="skin_image" accept="image/*" required>
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
                        @error('skin_image')
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

@vite('resources/css/detection.css')
@vite('resources/js/detection.js')
@endsection
