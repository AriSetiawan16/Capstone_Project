<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function show(Request $request)
    {
        // Menentukan koordinat lat dan lon
        $lat = $request->lat ?? '-6.200000';  // Default: Jakarta
        $lon = $request->lon ?? '106.816666'; // Default: Jakarta
        $apiKey = env('OPENWEATHER_API_KEY');

        // Cek jika API Key tersedia
        if (!$apiKey) {
            return view('dashboard.weather', [
                
            ]);
        }

        try {
            // OPSI 1: Menggunakan Current Weather API (GRATIS)
            $currentWeatherResponse = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/weather", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'id' // Bahasa Indonesia
            ]);

            // OPSI 2: Menggunakan UV Index API (GRATIS) - Terpisah
            $uvResponse = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/uvi", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $apiKey
            ]);

            // Periksa respons Current Weather
            if (!$currentWeatherResponse->successful()) {
                // Debug: Tampilkan error detail
                $errorDetail = $currentWeatherResponse->json();
                $errorMessage = isset($errorDetail['message']) 
                    ? "Error API: " . $errorDetail['message'] 
                    : "HTTP Error: " . $currentWeatherResponse->status();
                
                return view('dashboard.weather', [
                    'error' => $errorMessage . " - Periksa API Key Anda."
                ]);
            }

            $weatherData = $currentWeatherResponse->json();
            $uvData = $uvResponse->successful() ? $uvResponse->json() : null;

            // Ambil data cuaca
            $weather = $weatherData['weather'][0]['description'] ?? 'Tidak ada data cuaca';
            $temperature = $weatherData['main']['temp'] ?? 'N/A';
            $humidity = $weatherData['main']['humidity'] ?? 'N/A';
            $windSpeed = $weatherData['wind']['speed'] ?? 'N/A';
            $pressure = $weatherData['main']['pressure'] ?? 'N/A';
            $cityName = $weatherData['name'] ?? 'Unknown';
            
            // Ambil data UV Index
            $uvIndex = $uvData['value'] ?? 'N/A';

            // Backup: Jika UV API gagal, estimasi berdasarkan kondisi cuaca
            if ($uvIndex === 'N/A') {
                $uvIndex = $this->estimateUVIndex($weatherData);
            }

            // Menentukan peringatan berdasarkan indeks UV
            $uvWarning = $this->getUVWarning($uvIndex);

            // Saran tambahan berdasarkan cuaca
            $additionalAdvice = $this->getWeatherAdvice($temperature, $humidity, $windSpeed);
     
            return view('dashboard.weather', [
                'cityName' => $cityName,
                'weather' => ucfirst($weather),
                'temperature' => $temperature,
                'humidity' => $humidity,
                'windSpeed' => $windSpeed,
                'pressure' => $pressure,
                'uvIndex' => $uvIndex,
                'uvWarning' => $uvWarning,
                'additionalAdvice' => $additionalAdvice,
                'coordinates' => ['lat' => $lat, 'lon' => $lon]
            ]);
            

        } catch (\Exception $e) {
            return view('dashboard.weather', [
                
            ]);
        }
    }

    /**
     * Alternatif menggunakan nama kota
     */
    public function showByCity(Request $request)
{
    $city = $request->city ?? 'Jakarta';
    $apiKey = env('OPENWEATHER_API_KEY');

    if (!$apiKey) {
        return view('dashboard.weather', [
            
        ]);
    }

    try {
        $response = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        if (!$response->successful()) {
            return view('dashboard.weather', [
                'error' => 'Kota tidak ditemukan. Pastikan nama kota valid.'
            ]);
        }

        $data = $response->json();

        // Ambil koordinat untuk UV Index
        $lat = $data['coord']['lat'];
        $lon = $data['coord']['lon'];

        // Ambil UV Index
        $uvResponse = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/uvi", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey
        ]);

        $uvIndex = $uvResponse->successful() ? $uvResponse->json()['value'] : $this->estimateUVIndex($data);

        return view('dashboard.weather', [
            'cityName' => $data['name'],
            'weather' => ucfirst($data['weather'][0]['description']),
            'temperature' => $data['main']['temp'],
            'humidity' => $data['main']['humidity'],
            'windSpeed' => $data['wind']['speed'] ?? 0,
            'pressure' => $data['main']['pressure'],
            'uvIndex' => $uvIndex,
            'uvWarning' => $this->getUVWarning($uvIndex),
            'additionalAdvice' => $this->getWeatherAdvice(
                $data['main']['temp'],
                $data['main']['humidity'],
                $data['wind']['speed'] ?? 0
            ),
            'coordinates' => ['lat' => $lat, 'lon' => $lon]
        ]);

    } catch (\Exception $e) {
        return view('dashboard.weather', [
            'error' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}


    /**
     * Estimasi UV Index berdasarkan kondisi cuaca (fallback)
     */
    private function estimateUVIndex($weatherData)
    {
        $cloudiness = $weatherData['clouds']['all'] ?? 50; // Default 50% jika tidak ada data
        $hour = date('H');
        
        // Estimasi sederhana berdasarkan tutupan awan dan jam
        if ($hour < 6 || $hour > 18) {
            return 0; // Malam hari
        } elseif ($hour >= 10 && $hour <= 14) {
            // Siang hari puncak
            return $cloudiness < 30 ? 8 : ($cloudiness < 70 ? 6 : 4);
        } else {
            // Pagi/sore
            return $cloudiness < 30 ? 5 : ($cloudiness < 70 ? 3 : 2);
        }
    }

    /**
     * Peringatan UV berdasarkan indeks
     */
    private function getUVWarning($uvIndex)
    {
        if ($uvIndex <= 2) {
            return 'Indeks UV rendah. Aman untuk aktivitas outdoor.';
        } elseif ($uvIndex <= 5) {
            return 'Indeks UV sedang. Gunakan pelindung matahari saat beraktivitas lama di luar.';
        } elseif ($uvIndex <= 7) {
            return 'Indeks UV tinggi. Wajib gunakan sunscreen, topi, dan kacamata hitam.';
        } elseif ($uvIndex <= 10) {
            return 'Indeks UV sangat tinggi! Hindari paparan langsung 10:00-16:00. Gunakan perlindungan maksimal.';
        } else {
            return 'Indeks UV ekstrem! Sangat berbahaya. Hindari aktivitas outdoor siang hari.';
        }
    }

    /**
     * Saran tambahan berdasarkan kondisi cuaca
     */
    private function getWeatherAdvice($temperature, $humidity, $windSpeed)
    {
        $advice = [];

        // Saran berdasarkan suhu
        if ($temperature > 35) {
            $advice[] = '🥵 Cuaca sangat panas! Hindari aktivitas berat di luar ruangan.';
            $advice[] = '💧 Perbanyak minum air putih untuk mencegah dehidrasi.';
        } elseif ($temperature > 30) {
            $advice[] = '🌡️ Cuaca cukup panas. Gunakan pakaian ringan dan sejuk.';
        } elseif ($temperature < 20) {
            $advice[] = '🧥 Cuaca sejuk. Gunakan jaket atau pakaian hangat.';
        }

        // Saran berdasarkan kelembaban
        if ($humidity > 80) {
            $advice[] = '💨 Kelembaban tinggi. Pastikan sirkulasi udara baik.';
        } elseif ($humidity < 30) {
            $advice[] = '🏺 Kelembaban rendah. Gunakan pelembab ruangan jika perlu.';
        }

        // Saran berdasarkan kecepatan angin
        if ($windSpeed > 15) {
            $advice[] = '💨 Angin cukup kencang. Hati-hati saat berkendara.';
        }

        return $advice;
    }
}