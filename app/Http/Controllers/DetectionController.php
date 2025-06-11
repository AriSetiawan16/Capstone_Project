<?php

namespace App\Http\Controllers;

use App\Models\DetectionResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\RecommendationService; // Pastikan ini di-import

class DetectionController extends Controller
{
    /**
     * Menampilkan halaman deteksi dan hasil analisis dari session jika ada.
     */
    public function index()
    {
        $analysisResult = session('analysisResult');
        return view('dashboard.detection', compact('analysisResult'));
    }

    /**
     * Menganalisis gambar yang diupload dan menyimpan hasilnya ke session.
     */
    public function analyze(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imagePath = $image->store('image', 'public');

        try {
            $response = Http::attach(
                'image',
                fopen($image->getRealPath(), 'r'),
                $image->getClientOriginalName()
            )->post('https://0e53-103-189-207-213.ngrok-free.app/predict'); // PASTIKAN URL INI MASIH VALID

            if ($response->successful()) {
                $result = $response->json();
                $diseaseName = $result['predicted_class'] ?? 'Unknown';

                // ==================================================================
                // KODE DIPERBAIKI: Menggunakan getDiseaseInfo untuk mendapatkan deskripsi dan rekomendasi
                // ==================================================================
                $recommendationService = new RecommendationService();
                $diseaseInfo = $recommendationService->getDiseaseInfo($diseaseName); // Mengambil array ['description' => ..., 'recommendation' => ...]

                // Buat instance record dengan data yang sudah dipisah
                $record = new DetectionResult([
                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'predicted_class' => $diseaseName,
                    'confidence' => $result['confidence'] ?? 0,
                    'description' => $diseaseInfo['description'], // <-- MENAMBAHKAN DESKRIPSI
                    'recommendation' => $diseaseInfo['recommendation'], // Mengambil rekomendasi dari array
                    'image_path' => $imagePath,
                ]);
                // ==================================================================

                // Simpan seluruh data record ke session untuk ditampilkan di pop-up
                session(['analysisResult' => $record]);

                return redirect()->route('detection');
            } else {
                Storage::disk('public')->delete($imagePath); // Hapus gambar jika gagal
                return back()->withInput()->withErrors(['api_error' => 'Gagal menghubungi server prediksi. Silakan coba lagi.']);
            }
        } catch (\Exception $e) {
            Storage::disk('public')->delete($imagePath); // Hapus gambar jika gagal
            return back()->withInput()->withErrors(['server_error' => 'Terjadi kesalahan pada server: ' . $e->getMessage()]);
        }
    }

    /**
     * Menyimpan hasil analisis ke database.
     */
    public function save(Request $request)
    {
        // ==================================================================
        // KODE DIPERBAIKI: Menambahkan validasi untuk 'description'
        // ==================================================================
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'predicted_class' => 'required|string',
            'confidence' => 'required|numeric',
            'description' => 'required|string', // <-- VALIDASI BARU
            'recommendation' => 'required|string',
            'image_path' => 'required|string',
        ]);
        // ==================================================================

        DetectionResult::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'predicted_class' => $request->predicted_class,
            'confidence' => $request->confidence,
            'description' => $request->description, // <-- MENYIMPAN DESKRIPSI KE DB
            'recommendation' => $request->recommendation,
            'image_path' => $request->image_path,
        ]);

        session()->forget('analysisResult');

        return redirect()->route('dashboard')->with('success', 'Hasil analisis berhasil disimpan ke riwayat Anda!');
    }

    /**
     * Menampilkan riwayat deteksi.
     */
    public function history()
    {
        $histories = DetectionResult::where('user_id', Auth::id())
                                    ->latest()
                                    ->paginate(10);
        return view('dashboard.history', compact('histories'));
    }

    /**
     * Menghapus data riwayat.
     */
    public function destroy($id)
    {
        $history = DetectionResult::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($history->image_path && Storage::disk('public')->exists($history->image_path)) {
            Storage::disk('public')->delete($history->image_path);
        }

        $history->delete();

        return redirect()->back()->with('success', 'Riwayat berhasil dihapus.');
    }
}
