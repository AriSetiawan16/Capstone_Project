<?php

namespace App\Http\Controllers;

use App\Models\DetectionResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DetectionController extends Controller
{
    public function index()
    {
        return view('dashboard.detection');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'symptoms' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar
        $image = $request->file('image');
        $imagePath = $image->store('image', 'public');

        // Kirim gambar ke API Flask
        try {
            $response = Http::attach(
                'image',
                fopen($image->getRealPath(), 'r'),
                $image->getClientOriginalName()
            )->post('https://c7aa-103-189-207-206.ngrok-free.app/predict');

            if ($response->successful()) {
                $result = $response->json();

                // Simpan ke database
                $record = DetectionResult::create([
                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'predicted_class' => $result['predicted_class'],
                    'confidence' => $result['confidence'],
                    'recommendation' => $result['recommendation'],
                    'image_path' => $imagePath,
                ]);

                session(['last_detection' => $record]);

                return view('dashboard.detection-result', [
                    'analysisResult' => $record,
                ]);
            } else {
                return back()->withErrors(['error' => 'Gagal menghubungi server prediksi.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }
}
