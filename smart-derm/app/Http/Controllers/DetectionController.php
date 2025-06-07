<?php

namespace App\Http\Controllers;

use App\Models\DetectionResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DetectionController extends Controller
{
    public function index()
    {
        return view('dashboard.detection');
    }
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

        $result = DetectionResult::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'predicted_class' => $request->predicted_class,
            'confidence' => $request->confidence,
            'image_path' => $request->image_path,
            'recommendation' => $request->recommendation,
        ]);

        session()->forget('analysisResult'); // bersihkan setelah disimpan

        return redirect()->route('dashboard.index')->with('success', 'Hasil berhasil disimpan!');
    }

    public function detectionForm(Request $request)
    {
        $analysisResult = session('analysisResult');
        return view('dashboard.detection', compact('analysisResult'));
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

            try {
                $response = Http::attach(
                    'image',
                    fopen($image->getRealPath(), 'r'),
                    $image->getClientOriginalName()
                )->post('https://c7aa-103-189-207-206.ngrok-free.app/predict');

                if ($response->successful()) {
                    $result = $response->json();

                    $record = new DetectionResult([
                        'name' => $request->name,
                        'age' => $request->age,
                        'gender' => $request->gender,
                        'predicted_class' => $result['predicted_class'],
                        'confidence' => $result['confidence'],
                        'recommendation' => $result['recommendation'],
                        'image_path' => $imagePath,
                    ]);

                    // Simpan hanya ke session (bukan ke DB langsung)
                    session(['analysisResult' => $record]);

                    return redirect()->route('detection.index'); // Redirect supaya session terbaca
                } else {
                    return back()->withErrors(['error' => 'Gagal menghubungi server prediksi.']);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Server error: ' . $e->getMessage()]);
            }
        }

}
