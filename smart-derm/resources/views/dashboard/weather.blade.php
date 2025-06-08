
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
            <h1>🌤️ Informasi Cuaca & UV</h1>
            <p>Dapatkan informasi cuaca terkini dan saran kesehatan</p>
        </div>
        
        <div class="content">
            <!-- Form Input Lokasi -->
            <div class="location-form">
                <h3>🌍 Pilih Lokasi</h3>
                
                <!-- Form Koordinat -->
                <form method="GET" action="{{ route('weather.show') }}">
                    <div class="form-group">
                        <input type="number" name="lat" step="any" 
                               value="{{ request('lat') ?? '-6.200000' }}" 
                               placeholder="Latitude (contoh: -6.200000)">
                        <input type="number" name="lon" step="any" 
                               value="{{ request('lon') ?? '106.816666' }}" 
                               placeholder="Longitude (contoh: 106.816666)">
                        <button type="submit" class="btn btn-primary">Cek Cuaca</button>
                    </div>
                </form>

                <!-- Form Kota (API endpoint terpisah) -->
                <form method="GET" action="{{ route('weather.city') }}" style="margin-top: 15px;">
                    <div class="form-group">
                        <input type="text" name="city" 
                               value="{{ $searchedCity ?? request('city') ?? 'Jakarta' }}" 
                               placeholder="Nama kota (contoh: Jakarta, Surabaya)"
                               required>
                        <button type="submit" class="btn btn-success">Cari Kota</button>
                    </div>
                </form>
            </div>

            @if(isset($error))
                <div class="error">
                    <strong>❌ Error:</strong> {{ $error }}
                    <br><br>
                    <strong>Kemungkinan solusi:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        <li>Pastikan koneksi internet stabil</li>
                        <li>Coba koordinat yang berbeda</li>
                        <li>Tunggu beberapa menit dan coba lagi</li>
                    </ul>
                </div>
            @else
                <!-- Data Cuaca -->
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
                            <div class="icon">📊</div>
                            <div class="label">Tekanan</div>
                            <div class="value">{{ $pressure }} hPa</div>
                        </div>
                    </div>
                </div>

                <!-- Indeks UV -->
                <div class="uv-section">
                    <h3>☀️ Indeks UV & Peringatan</h3>
                    
                    <div class="uv-indicator">
                        <span>Indeks UV:</span>
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

                    <div class="advice-item">
                        <div class="advice-icon">⚠️</div>
                        <div>{{ $uvWarning }}</div>
                    </div>
                </div>

                <!-- Saran Tambahan -->
                @if(isset($additionalAdvice) && count($additionalAdvice) > 0)
                    <div class="advice-section">
                        <h3>💡 Saran Kesehatan</h3>
                        @foreach($additionalAdvice as $advice)
                        <div class="advice-item">
                            <div class="advice-icon">🏥</div>
                            <div>{{ $advice }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
               

                <!-- Info Koordinat -->
                @if(isset($coordinates))
                <div class="coordinates">
                    📍 Koordinat: {{ $coordinates['lat'] }}, {{ $coordinates['lon'] }}
                    <br>
                    <small>Data diperbarui: {{ date('d/m/Y H:i:s') }} WIB</small>
                </div>
                @endif
            @endif
        </div>
    </div>

    <script>
        // Auto-refresh setiap 10 menit
        setTimeout(function() {
            location.reload();
        }, 600000);

        // Dapatkan lokasi pengguna
       function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Isi hidden input di form
            document.querySelector('input[name="lat"]').value = lat;
            document.querySelector('input[name="lon"]').value = lon;

            // Submit form
            document.querySelector('.location-form').submit();
        }, function(error) {
            alert('Tidak dapat mengakses lokasi: ' + error.message);
        });
    } else {
        alert('Geolocation tidak didukung oleh browser ini.');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const locationForm = document.querySelector('.location-form');

    const autoLocationBtn = document.createElement('button');
    autoLocationBtn.type = 'button';
    autoLocationBtn.className = 'btn btn-success';
     autoLocationBtn.innerHTML = '📍 Gunakan Lokasi Saya';
    autoLocationBtn.style.marginTop = '10px';
    autoLocationBtn.style.width = '100%';
    autoLocationBtn.onclick = getCurrentLocation;

    locationForm.appendChild(autoLocationBtn);
});


    </script>
</body>
</html>