<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class WeatherController extends Controller
{
    /**
     * Menampilkan cuaca berdasarkan koordinat.
     */
    public function show(Request $request)
    {
        $lat = $request->lat ?? '-6.200000';
        $lon = $request->lon ?? '106.816666';
        $apiKey = env('OPENWEATHER_API_KEY');

        // 1. Validasi API Key
        if (!$apiKey) {
            return view('dashboard.weather', [
                'error' => 'Konfigurasi Error: OPENWEATHER_API_KEY belum diatur di file .env Anda.'
            ]);
        }

        try {
            // 2. Panggilan API ke OpenWeatherMap
            $response = Http::timeout(15)->get("https://api.openweathermap.org/data/2.5/weather", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'id'
            ]);

            // 3. Cek jika panggilan API gagal (bukan karena error koneksi)
            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Gagal mengambil data dari API.';
                if ($response->status() == 401) {
                    $errorMessage = 'API Key tidak valid atau belum aktif. Mohon periksa kembali key Anda di file .env dan tunggu beberapa saat jika key baru dibuat.';
                }
                return view('dashboard.weather', [
                    'error' => 'Error API: ' . $errorMessage . ' (Kode: ' . $response->status() . ')'
                ]);
            }

            // 4. Proses data jika berhasil
            $weatherData = $response->json();

            // Ambil data UV Index
            $uvResponse = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/uvi", [
                'lat' => $weatherData['coord']['lat'],
                'lon' => $weatherData['coord']['lon'],
                'appid' => $apiKey
            ]);
            $uvIndex = $uvResponse->successful() ? $uvResponse->json()['value'] : $this->estimateUVIndex($weatherData);

            return view('dashboard.weather', [
                'cityName' => $weatherData['name'] ?? 'Lokasi Tidak Dikenal',
                'weather' => ucfirst($weatherData['weather'][0]['description'] ?? '-'),
                'temperature' => round($weatherData['main']['temp'] ?? 0),
                'humidity' => $weatherData['main']['humidity'] ?? '-',
                'windSpeed' => $weatherData['wind']['speed'] ?? '-',
                'pressure' => $weatherData['main']['pressure'] ?? '-',
                'uvIndex' => round($uvIndex, 2),
                'uvWarning' => $this->getUVWarning($uvIndex),
                'additionalAdvice' => $this->getWeatherAdvice(
                    $weatherData['main']['temp'] ?? 0,
                    $weatherData['main']['humidity'] ?? 0,
                    $weatherData['wind']['speed'] ?? 0,
                    $weatherData['weather'][0]['description'] ?? ''
                ),
                'coordinates' => $weatherData['coord'] ?? ['lat' => $lat, 'lon' => $lon]
            ]);

        } catch (ConnectionException $e) {
            return view('dashboard.weather', [
                'error' => 'Error Koneksi: Aplikasi tidak dapat terhubung ke server OpenWeatherMap. Pastikan Anda memiliki koneksi internet dan tidak ada firewall yang memblokir. Pesan: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return view('dashboard.weather', [
                'error' => 'Terjadi Kesalahan Tak Terduga. Silakan periksa log untuk detail. Pesan: ' . $e->getMessage()
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
                'error' => 'Konfigurasi Error: OPENWEATHER_API_KEY belum diatur di file .env Anda.'
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

            $lat = $data['coord']['lat'];
            $lon = $data['coord']['lon'];

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
                        $data['wind']['speed'] ?? 0,
                        $data['weather'][0]['description']
                    ),
                'coordinates' => ['lat' => $lat, 'lon' => $lon]
            ]);

        } catch (\Exception $e) {
            return view('dashboard.weather', [
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // Fungsi estimasi UV Index
    private function estimateUVIndex($weatherData)
    {
        $cloudiness = $weatherData['clouds']['all'] ?? 50;
        $hour = date('H');
        
        if ($hour < 7 || $hour > 17) return 0;
        if ($hour >= 10 && $hour <= 14) {
            if ($cloudiness < 25) return 8;
            if ($cloudiness < 60) return 6;
            return 3;
        }
        if ($cloudiness < 25) return 4;
        if ($cloudiness < 60) return 2;
        return 1;
    }

    // Fungsi UV Warning
    private function getUVWarning($uvIndex)
    {
        if ($uvIndex <= 2) return 'Indeks UV rendah. Aman untuk aktivitas outdoor.';
        if ($uvIndex <= 5) return 'Indeks UV sedang. Gunakan pelindung matahari saat beraktivitas lama di luar.';
        if ($uvIndex <= 7) return 'Indeks UV tinggi. Wajib gunakan sunscreen, topi, dan kacamata hitam.';
        if ($uvIndex <= 10) return 'Indeks UV sangat tinggi! Hindari paparan langsung 10:00-16:00. Gunakan perlindungan maksimal.';
        return 'Indeks UV ekstrem! Sangat berbahaya. Hindari aktivitas outdoor siang hari.';
    }

    // Fungsi saran berdasarkan kondisi cuaca
    private function getWeatherAdvice($temperature, $humidity, $windSpeed, $weather)
    {
        $advice = [];
        $weather = strtolower($weather);

        if (str_contains($weather, 'hujan') || str_contains($weather, 'gerimis')) {
            $advice[] = '☔ Diperkirakan akan hujan. Siapkan payung atau jas hujan.';
        }
        if ($temperature > 32) {
            $advice[] = '🥵 Cuaca sangat panas! Jaga tubuh tetap terhidrasi dengan banyak minum air putih.';
        }
        if ($humidity > 80) {
            $advice[] = '💨 Kelembaban tinggi. Pastikan sirkulasi udara baik.';
        }

        if (empty($advice)) {
            $advice[] = '👍 Cuaca hari ini cukup bersahabat untuk beraktivitas.';
        }

        return $advice;
    }
}
