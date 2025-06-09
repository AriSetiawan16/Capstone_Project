<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException; // Import untuk menangani error koneksi

class WeatherController extends Controller
{
    /**
     * Menampilkan cuaca berdasarkan koordinat.
     */
    public function show(Request $request)
    {
        // Default koordinat (Jakarta) jika tidak ada input
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
                // Memberikan pesan error yang lebih spesifik jika key tidak valid
                if ($response->status() == 401) {
                    $errorMessage = 'API Key tidak valid atau belum aktif. Mohon periksa kembali key Anda di file .env dan tunggu beberapa saat jika key baru dibuat.';
                }
                return view('dashboard.weather', [
                    'error' => 'Error API: ' . $errorMessage . ' (Kode: ' . $response->status() . ')'
                ]);
            }

            // 4. Proses data jika berhasil
            $weatherData = $response->json();

            // Ambil data UV Index (panggilan API kedua)
            $uvResponse = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/uvi", [
                'lat' => $weatherData['coord']['lat'],
                'lon' => $weatherData['coord']['lon'],
                'appid' => $apiKey
            ]);
            $uvIndex = $uvResponse->successful() ? $uvResponse->json()['value'] : $this->estimateUVIndex($weatherData);

            // 5. Kirim data ke view
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
            // 6. Tangani error spesifik jika tidak ada koneksi internet sama sekali
            return view('dashboard.weather', [
                'error' => 'Error Koneksi: Aplikasi tidak dapat terhubung ke server OpenWeatherMap. Pastikan Anda memiliki koneksi internet dan tidak ada firewall yang memblokir. Pesan: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            // 7. Tangani semua error tak terduga lainnya
            return view('dashboard.weather', [
                'error' => 'Terjadi Kesalahan Tak Terduga. Silakan periksa log untuk detail. Pesan: ' . $e->getMessage()
            ]);
        }
    }

    // Fungsi showByCity dan fungsi private lainnya bisa diletakkan di sini
    // ... (kode dari file sebelumnya untuk showByCity, getUVWarning, dll. bisa tetap sama)
    // ... (disarankan untuk menerapkan struktur try-catch yang sama pada showByCity)

    private function estimateUVIndex($weatherData)
    {
        $cloudiness = $weatherData['clouds']['all'] ?? 50;
        $hour = date('H');
        if ($hour < 7 || $hour > 17) return 0;
        if ($hour >= 10 && $hour <= 14) {
            if ($cloudiness < 25) return 8; if ($cloudiness < 60) return 6; return 3;
        }
        if ($cloudiness < 25) return 4; if ($cloudiness < 60) return 2; return 1;
    }

    private function getUVWarning($uvIndex)
    {
        if ($uvIndex <= 2) return '✅ Rendah: Perlindungan tidak diperlukan.';
        if ($uvIndex <= 5) return '⚠️ Sedang: Gunakan sunscreen jika berada di luar ruangan untuk waktu yang lama.';
        if ($uvIndex <= 7) return '🟠 Tinggi: Wajib gunakan sunscreen SPF 30+, topi, dan kacamata hitam.';
        if ($uvIndex <= 10) return '🔴 Sangat Tinggi: Perlindungan ekstra diperlukan! Hindari paparan matahari langsung.';
        return '🟣 Ekstrem: Sangat berbahaya! Usahakan untuk tetap berada di dalam ruangan.';
    }

    private function getWeatherAdvice($temperature, $humidity, $windSpeed, $weather)
    {
        $advice = [];
        $weather = strtolower($weather);
        if (str_contains($weather, 'hujan') || str_contains($weather, 'gerimis')) {
            $advice[] = '☔️ Diperkirakan akan hujan. Siapkan payung atau jas hujan.';
        }
        if ($temperature > 32) {
            $advice[] = '🥵 Cuaca sangat panas! Jaga tubuh tetap terhidrasi dengan banyak minum air putih.';
        }
        // ... (saran lainnya)
        if (empty($advice)) {
            $advice[] = '👍 Cuaca hari ini cukup bersahabat untuk beraktivitas.';
        }
        return $advice;
    }
}
