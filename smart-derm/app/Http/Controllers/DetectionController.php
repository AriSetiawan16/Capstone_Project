<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // Store the uploaded image
        $imagePath = $request->file('image')->store('image', 'public');

        // Here you would typically integrate with your AI model
        // For now, we'll simulate the analysis
        $analysisResult = $this->simulateAnalysis($request->all(), $imagePath);

        return view('dashboard.detection-result', compact('analysisResult'));
    }

    private function simulateAnalysis($data, $imagePath)
    {
        // Simulate AI analysis - replace with actual AI integration
        $possibleConditions = [
            'Acne Vulgaris',
            'Eczema',
            'Psoriasis',
            'Dermatitis',
            'Skin Irritation',
            'Normal Skin'
        ];

        return [
            'patient_name' => $data['name'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'symptoms' => $data['symptoms'],
            'image_path' => $imagePath,
            'predicted_condition' => $possibleConditions[array_rand($possibleConditions)],
            'confidence' => rand(75, 95),
            'recommendations' => [
                'Konsultasi dengan dokter kulit',
                'Jaga kebersihan area yang terkena',
                'Hindari menggaruk atau menyentuh area tersebut',
                'Gunakan pelembab yang sesuai'
            ],
            'analyzed_at' => now()
        ];
    }
}
