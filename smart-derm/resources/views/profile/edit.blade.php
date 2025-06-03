@extends('layouts.app')

@section('content')
<div class="profile-container">
    <!-- Header -->
    <header class="profile-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('profile.index') }}" class="breadcrumb-link">Profil</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">Edit</span>
            </div>
            <h1>Edit Profil</h1>
            <p class="subtitle">Perbarui informasi pribadi Anda</p>
        </div>
    </header>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                <div class="alert-content">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container">
            <div class="alert alert-error">
                <div class="alert-content">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="profile-main">
        <div class="container">
            <div class="profile-card">
                <div class="card-header">
                    <div class="header-content">
                        <h2>
                            <i class="fas fa-user-edit"></i>
                            Edit Informasi Pribadi
                        </h2>
                        <a href="{{ route('profile.index') }}" class="btn secondary-btn">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card-content">
                    <!-- Profile Photo Section -->
                    <div class="photo-section">
                        <div class="profile-photo-container">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default-avatar.png') }}"
                                 alt="Profile Photo" id="profile-display-image" class="profile-photo">
                            <div class="photo-overlay">
                                <button type="button" class="photo-btn" onclick="document.getElementById('profile_photo').click()">
                                    <i class="fas fa-camera"></i>
                                    Ubah Foto
                                </button>
                                @if(Auth::user()->profile_photo)
                                    <button type="button" class="photo-btn delete-btn" onclick="deletePhoto()">
                                        <i class="fas fa-trash"></i>
                                        Hapus Foto
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="photo-info">
                            <h3>Foto Profil</h3>
                            <p>JPG, PNG maksimal 2MB</p>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                        @csrf
                        @method('PUT')

                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;" onchange="previewImage(this)">

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap *
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email *
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i>
                                    Nomor Telepon
                                </label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Masukkan nomor telepon">
                                @error('phone')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="birth_date">
                                    <i class="fas fa-calendar"></i>
                                    Tanggal Lahir
                                </label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}">
                                @error('birth_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gender">
                                    <i class="fas fa-venus-mars"></i>
                                    Jenis Kelamin
                                </label>
                                <select id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="occupation">
                                    <i class="fas fa-briefcase"></i>
                                    Pekerjaan
                                </label>
                                <input type="text" id="occupation" name="occupation" value="{{ old('occupation', Auth::user()->occupation) }}" placeholder="Masukkan pekerjaan">
                                @error('occupation')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat
                            </label>
                            <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('profile.index') }}" class="btn secondary-btn">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn primary-btn">
                                <i class="fas fa-save"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

@vite(['resources/css/profile.css', 'resources/js/profile.js'])
@endsection
