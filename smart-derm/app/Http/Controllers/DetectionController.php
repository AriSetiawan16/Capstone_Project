<?php

namespace App\Http\Controllers;

use App\Models\DetectionResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Services\RecommendationService; // Pastikan ini ada

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
     * Menyimpan hasil analisis ke database.
     */
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'predicted_class' => 'required|string',
            'confidence' => 'required|numeric',
            'image_path' => 'required|string',
            'recommendation' => 'required|string',
        ]);

        DetectionResult::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'predicted_class' => $request->predicted_class,
            'confidence' => $request->confidence,
            'image_path' => $request->image_path,
            'recommendation' => $request->recommendation,
        ]);

        session()->forget('analysisResult');

        return redirect()->route('dashboard')->with('success', 'Hasil berhasil disimpan!');
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
            )->post('https://0beb-103-189-207-213.ngrok-free.app/predict');

            if ($response->successful()) {
                $result = $response->json();

                $recommendationService = new RecommendationService();
                $diseaseName = $result['predicted_class'];
                $recommendationText = $recommendationService->getRecommendation($diseaseName);

                $record = new DetectionResult([
                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'predicted_class' => $diseaseName,
                    'confidence' => $result['confidence'],
                    'recommendation' => $recommendationText,
                    'image_path' => $imagePath,
                ]);

                session(['analysisResult' => $record]);

                return redirect()->route('detection');
            } else {
                return back()->withErrors(['error' => 'Gagal menghubungi server prediksi.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }
    public function history()
    {
        $histories = DetectionResult::latest()->get();
        return view('dashboard.history', compact('histories'));
    }
    public function destroy($id)
    {
        $history = DetectionResult::findOrFail($id);

        if ($history->image_path && Storage::exists('public/' . $history->image_path)) {
            Storage::delete('public/' . $history->image_path);
        }

        $history->delete();

        return redirect()->back()->with('success', 'Riwayat berhasil dihapus.');
    }

}
