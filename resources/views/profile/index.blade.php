@extends('layouts.app')

@section('content')
@vite('resources/css/profile.css')
@vite('resources/js/profile.js')
<div class="profile-container">
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
                            <i class="fas fa-user"></i>
                            Informasi Pribadi
                        </h2>
                        <div class="header-buttons">
                            <a href="{{ route('dashboard') }}" class="btn primary-btn">
                                <i class="fas fa-arrow-left"></i>
                                Kembali ke Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn primary-btn">
                                <i class="fas fa-edit"></i>
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-content">
                    <!-- Profile Photo Section -->
                    <div class="photo-section">
                        <div class="profile-photo-container">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/avatar.jpg') }}"
                                 alt="Profile Photo" class="profile-photo">
                        </div>
                        <div class="photo-info">
                            <h3>{{ Auth::user()->name }}</h3>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Profile Information Display -->
                    <div class="profile-info">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                </label>
                                <div class="info-value">{{ Auth::user()->name ?: 'Belum diisi' }}</div>
                            </div>

                            <div class="info-item">
                                <label>
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>
                                <div class="info-value">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="info-item">
                                <label>
                                    <i class="fas fa-phone"></i>
                                    Nomor Telepon
                                </label>
                                <div class="info-value">{{ Auth::user()->phone ?: 'Belum diisi' }}</div>
                            </div>

                            <div class="info-item">
                                <label>
                                    <i class="fas fa-calendar"></i>
                                    Tanggal Lahir
                                </label>
                                <div class="info-value">
                                    {{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d F Y') : 'Belum diisi' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <label>
                                    <i class="fas fa-venus-mars"></i>
                                    Jenis Kelamin
                                </label>
                                <div class="info-value">
                                    @if(Auth::user()->gender == 'male')
                                        Laki-laki
                                    @elseif(Auth::user()->gender == 'female')
                                        Perempuan
                                    @else
                                        Belum diisi
                                    @endif
                                </div>
                            </div>

                            <div class="info-item">
                                <label>
                                    <i class="fas fa-briefcase"></i>
                                    Pekerjaan
                                </label>
                                <div class="info-value">{{ Auth::user()->occupation ?: 'Belum diisi' }}</div>
                            </div>
                        </div>

                        <div class="info-item full-width">
                            <label>
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat
                            </label>
                            <div class="info-value">{{ Auth::user()->address ?: 'Belum diisi' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection
