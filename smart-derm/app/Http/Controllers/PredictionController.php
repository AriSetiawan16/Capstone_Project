<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function getPrediction(Request $request)
    {
        try {
            // Cek jika file tidak ada
            if (!$request->hasFile('image')) {
                return response()->json(['error' => 'No image received'], 400);
            }

            $file = $request->file('image');

            // Validasi file
            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid image uploaded'], 400);
            }

            $tempPath = $file->getRealPath();
            $originalName = $file->getClientOriginalName();

            // Kirim ke endpoint Flask
            $response = Http::attach(
                'image', fopen($tempPath, 'r'), $originalName
            )->post('https://c7aa-103-189-207-206.ngrok-free.app/predict');

            if ($response->successful()) {
                $predictionResult = $response->json();

                // Memastikan bahwa response Flask mengandung predicted_class dan confidence
                if (isset($predictionResult['predicted_class'], $predictionResult['confidence'])) {
                    return response()->json([
                        'predicted_class' => $predictionResult['predicted_class'],
                        'confidence' => $predictionResult['confidence'],
                        'recommendation' => $this->getRecommendation($predictionResult['predicted_class']),
                    ], 200);
                } else {
                    return response()->json(['error' => 'Invalid response from Flask API'], 500);
                }
            } else {
                return response()->json([
                    'error' => 'Flask server error',
                    'details' => $response->body()
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function getRecommendation($predictedClass)
    {
        $recommendations = [
            'Atopic Dermatitis' => 'Gunakan pelembap secara rutin, hindari pemicu alergi, dan gunakan krim kortikosteroid sesuai resep.',
            'Basal Cell Carcinoma (BCC)' => 'Segera konsultasikan ke dokter kulit. Penanganan bisa melibatkan operasi kecil atau terapi cahaya.',
            'Benign Keratosis-like Lesions (BKL)' => 'Biasanya tidak berbahaya, namun jika berubah bentuk/sembuh lama, periksa ke dokter.',
            'Eczema' => 'Gunakan pelembap tanpa parfum, hindari mandi air panas, dan gunakan krim anti-inflamasi jika perlu.',
            'Melanocytic Nevi (NV)' => 'Ini adalah tahi lalat. Awasi perubahan bentuk, ukuran, atau warna dan konsultasikan jika berubah.',
            'Melanoma' => 'Jenis kanker kulit berbahaya. Segera periksa ke dokter kulit untuk tindakan lanjutan.',
            'Psoriasis pictures Lichen Planus and related diseases' => 'Gunakan salep kortikosteroid, jaga kelembapan kulit, dan hindari stres berlebih.',
            'Seborrheic Keratoses and other Benign Tumors' => 'Biasanya tidak perlu perawatan kecuali mengganggu. Bisa diangkat secara medis jika diperlukan.',
            'Tinea Ringworm Candidiasis and other Fungal Infections' => 'Gunakan krim antijamur, jaga area tetap kering, dan hindari pakaian ketat.',
            'Warts Molluscum and other Viral Infections' => 'Gunakan salep antivirus topikal dan hindari menyentuh area kulit yang terinfeksi.',
        ];

        return $recommendations[$predictedClass] ?? 'Konsultasikan dengan dokter kulit untuk penanganan lebih lanjut.';
    }
}
