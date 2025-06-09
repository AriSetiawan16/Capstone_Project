@extends('layouts.app')

@section('content')
@vite('resources/css/weather.css')

<div class="header-buttons">
    <a href="{{ route('dashboard') }}" class="btn primary-btn">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Dashboard
    </a>
</div>

<body>
    <div class="container">
        <div class="header">
            <h1>🌤️ Informasi Cuaca & Peringatan UV</h1>
            <p>Data cuaca terkini untuk menjaga kesehatan kulit dan aktivitas Anda.</p>
        </div>

        <div class="content">
            <div class="location-form">
                <h3>🌍 Pilih Lokasi Anda</h3>

                <form method="GET" action="{{ route('weather.show') }}" id="coordinate-form">
                    <div class="form-group">
                        <input type="number" name="lat" step="any" value="{{ request('lat', '-6.200000') }}" placeholder="Latitude (contoh: -6.2)">
                        <input type="number" name="lon" step="any" value="{{ request('lon', '106.816666') }}" placeholder="Longitude (contoh: 106.8)">
                        <button type="submit" class="btn btn-primary">Cek Cuaca</button>
                    </div>
                </form>

                <p class="form-separator">atau</p>

                <form method="GET" action="{{ route('weather.city') }}" id="city-form">
                    <div class="form-group">
                        <input type="text" name="city" value="{{ $cityName ?? request('city', 'Jakarta') }}" placeholder="Nama kota (contoh: Bandung)" required>
                        <button type="submit" class="btn btn-success">Cari Kota</button>
                    </div>
                </form>

                <button type="button" class="btn btn-info" id="auto-location-btn" style="width: 100%; margin-top: 10px;">
                    <i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saya Saat Ini
                </button>
            </div>

            @if(isset($error))
                <div class="error">
                    <strong>❌ Terjadi Kesalahan:</strong> {{ $error }}
                    <br><br>
                    <strong>Saran:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        <li>Periksa kembali nama kota atau koordinat yang Anda masukkan.</li>
                        <li>Pastikan API Key di file `.env` sudah benar.</li>
                        <li>Cek koneksi internet Anda dan coba lagi dalam beberapa saat.</li>
                    </ul>
                </div>
            @else
                <div class="weather-card">
                    <div class="weather-header">
                        <div class="city-info">
                            <h2>📍 {{ $cityName ?? 'Lokasi Anda' }}</h2>
                            <p class="weather-description">{{ $weather }}</p>
                        </div>
                        <div class="temperature">{{ $temperature }}°C</div>
                    </div>

                    <div class="weather-grid">
                        <div class="weather-item">
                            <div class="icon">💧</div>
                            <div class="label">Kelembaban</div>
                            <div class="value">{{ $humidity }}%</div>
                        </div>
                        <div class="weather-item">
                            <div class="icon">💨</div>
                            <div class="label">Kecepatan Angin</div>
                            <div class="value">{{ $windSpeed }} m/s</div>
                        </div>
                        <div class="weather-item">
                            <div class="icon">🌡️</div>
                            <div class="label">Tekanan Udara</div>
                            <div class="value">{{ $pressure }} hPa</div>
                        </div>
                    </div>
                </div>

                <div class="uv-section">
                    <h3>☀️ Indeks UV & Peringatan</h3>
                    <div class="uv-indicator">
                        <span>Indeks UV Saat Ini:</span>
                        <span class="uv-level
                            @if($uvIndex <= 2) uv-low
                            @elseif($uvIndex <= 5) uv-moderate
                            @elseif($uvIndex <= 7) uv-high
                            @elseif($uvIndex <= 10) uv-very-high
                            @else uv-extreme
                            @endif">
                            {{ $uvIndex }}
                        </span>
                    </div>
                    <div class="advice-item uv-warning">
                        <div class="advice-icon">🚨</div>
                        <div><strong>Peringatan:</strong> {{ $uvWarning }}</div>
                    </div>
                </div>

                @if(isset($additionalAdvice) && count($additionalAdvice) > 0)
                    <div class="advice-section">
                        <h3>💡 Saran Aktivitas & Kesehatan</h3>
                        @foreach($additionalAdvice as $advice)
                        <div class="advice-item">
                            <div>{{ $advice }}</div>
                        </div>
                        @endforeach
                    </div>
                @endif

                @if(isset($coordinates))
                <div class="coordinates">
                    Koordinat: {{ $coordinates['lat'] }}, {{ $coordinates['lon'] }}
                    <br>
                    <small>Data diperbarui pada: {{ date('d F Y, H:i:s') }} WIB</small>
                </div>
                @endif
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const autoLocationBtn = document.getElementById('auto-location-btn');

            autoLocationBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert('Geolocation tidak didukung oleh browser Anda.');
                    return;
                }

                autoLocationBtn.textContent = 'Mencari Lokasi...';
                autoLocationBtn.disabled = true;

                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // Mengisi form koordinat
                    document.querySelector('input[name="lat"]').value = lat;
                    document.querySelector('input[name="lon"]').value = lon;

                    // Submit form koordinat secara spesifik
                    document.getElementById('coordinate-form').submit();

                }, function(error) {
                    alert('Tidak dapat mengakses lokasi: ' + error.message);
                    autoLocationBtn.textContent = 'Gunakan Lokasi Saya Saat Ini';
                    autoLocationBtn.disabled = false;
                });
            });

            // Auto-refresh halaman setiap 15 menit (900000 milidetik) untuk data baru
            setTimeout(function() {
                location.reload();
            }, 900000);
        });
    </script>
</body>
</html>
