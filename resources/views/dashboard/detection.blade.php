@extends('layouts.app')

@section('content')
@vite('resources/css/detection.css')
@vite('resources/js/detection.js')

<div class="detection-container">
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-circle"></div>
                <div class="spinner-circle"></div>
                <div class="spinner-circle"></div>
                <div class="spinner-circle"></div>
            </div>
            <p class="loading-text">Menganalisis Gambar Anda...</p>
            <p class="progress-text">Proses ini mungkin memakan waktu beberapa saat. Mohon jangan menutup halaman ini.</p>
        </div>
    </div>

    <nav class="page-nav">
        <a href="{{ route('dashboard') }}" class="nav-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>
        <h1>Deteksi Penyakit Kulit</h1>
    </nav>

    <div class="detection-content">
        <div class="instructions-card">
            <h3><i class="fas fa-info-circle"></i> Panduan Penggunaan</h3>
            <div class="instructions-grid">
                <div class="instruction-item"><div class="instruction-icon">1</div><p>Isi formulir dengan data diri Anda</p></div>
                <div class="instruction-item"><div class="instruction-icon">2</div><p>Upload foto area kulit yang ingin dianalisis</p></div>
                <div class="instruction-item"><div class="instruction-icon">3</div><p>Tunggu hasil analisis AI dalam beberapa detik</p></div>
                <div class="instruction-item"><div class="instruction-icon">4</div><p>Dapatkan rekomendasi dan simpan hasilnya</p></div>
            </div>
        </div>

        <div class="form-card">
            <h3><i class="fas fa-clipboard-list"></i> Formulir Deteksi</h3>
            <form method="POST" action="{{ route('detection.analyze') }}" enctype="multipart/form-data" id="detectionForm">
                @csrf

                <div class="form-section">
                    <h4>Informasi Pribadi</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="age"><i class="fas fa-calendar-alt"></i> Usia</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" min="1" max="120" required>
                            @error('age')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required><span class="radio-custom"></span> Laki-laki</label>
                            <label class="radio-label"><input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}><span class="radio-custom"></span> Perempuan</label>
                        </div>
                        @error('gender')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-section">
                    <h4>Upload Gambar</h4>
                    <div class="form-group">
                        <label for="image"><i class="fas fa-camera"></i> Foto Area Kulit</label>
                        <div class="image-upload-area" id="imageUploadArea">
                            <input type="file" name="image" id="image" accept="image/*" required>
                            <div class="upload-placeholder"><i class="fas fa-cloud-upload-alt"></i><p>Klik untuk upload gambar atau drag & drop</p><small>Format: JPG, PNG, GIF (Max: 2MB)</small></div>
                            <div class="image-preview" id="imagePreview" style="display: none;"><img id="previewImg" src="" alt="Preview"><button type="button" id="removeImage" class="remove-btn"><i class="fas fa-times"></i></button></div>
                        </div>
                        @error('image')<span class="error-text">{{ $message }}</span>@enderror
                        @error('error')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large" id="submitBtn"><i class="fas fa-search"></i> Analisis Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Pop-up Hasil Analisis --}}
    <div id="resultContainer" class="result-overlay" style="display: {{ !empty($analysisResult) ? 'flex' : 'none' }};">
        <div class="result-content">
            <button type="button" id="closeResultBtn" class="close-btn"><i class="fas fa-times"></i></button>
            <div class="result-header">
                <h3><i class="fas fa-clipboard-check"></i> Hasil Analisis</h3>
            </div>

            @if(!empty($analysisResult))
            <div class="result-body">
                <div class="result-image-container">
                    <h4>Gambar yang Dianalisis</h4>
                    <div class="image-wrapper">
                        <img src="{{ asset('storage/' . $analysisResult->image_path) }}" alt="Uploaded Image">
                    </div>
                </div>
                <div class="result-analysis-container">
                    <div class="diagnosis-section">
                        <h4>Diagnosis</h4>
                        <div class="diagnosis-card">
                            <div class="diagnosis-icon"><i class="fas fa-diagnoses"></i></div>
                            <div class="diagnosis-content">
                                <p class="diagnosis-text">{{ $analysisResult->predicted_class }}</p>
                                <div class="confidence-meter">
                                    <div class="confidence-fill" style="width: {{ $analysisResult->confidence * 100 }}%;"></div>
                                </div>
                                <span class="confidence-percent">{{ number_format($analysisResult->confidence * 100, 2) }}%</span>
                            </div>
                        </div>
                    </div>

                    {{-- ================================================================== --}}
                    {{-- KODE BARU: Menambahkan bagian untuk menampilkan deskripsi/ringkasan --}}
                    {{-- ================================================================== --}}
                    <div class="description-section">
                        <h4>Penjelasan Penyakit</h4>
                        <div class="description-content">{!! $analysisResult->description !!}</div>
                    </div>
                    {{-- ================================================================== --}}

                    <div class="recommendation-section">
                        <h4>Rekomendasi</h4>
                        <div class="recommendation-content">{!! $analysisResult->recommendation !!}</div>
                    </div>

                    <div class="action-buttons">
                        <form method="POST" action="{{ route('detection.save') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $analysisResult->name }}">
                            <input type="hidden" name="age" value="{{ $analysisResult->age }}">
                            <input type="hidden" name="gender" value="{{ $analysisResult->gender }}">
                            <input type="hidden" name="predicted_class" value="{{ $analysisResult->predicted_class }}">
                            <input type="hidden" name="confidence" value="{{ $analysisResult->confidence }}">
                            <input type="hidden" name="image_path" value="{{ $analysisResult->image_path }}">
                            {{-- KODE BARU: Menambahkan input hidden untuk description --}}
                            <input type="hidden" name="description" value="{{ $analysisResult->description }}">
                            <input type="hidden" name="recommendation" value="{{ $analysisResult->recommendation }}">
                            <button type="submit" class="btn btn-secondary"><i class="fas fa-save"></i> Simpan Hasil</button>
                        </form>
                        <button type="button" class="btn btn-primary" id="newAnalysisBtn" data-detection-url="{{ route('detection') }}">
                            <i class="fas fa-redo"></i> Analisis Baru
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
