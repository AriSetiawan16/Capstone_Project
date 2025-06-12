<?php

namespace App\Http\Controllers;

use App\Models\DetectionResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\RecommendationService; 

class DetectionController extends Controller
{
    public function index()
    {
        $analysisResult = session('analysisResult');
        return view('dashboard.detection', compact('analysisResult'));
    }

    public function analyze(Request $request, RecommendationService $recommendationService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imagePath = $image->store('detections', 'public');

        $response = Http::attach(
            'file',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )->post('https://amdzz-skindisease-docker.hf.space/predict/');

        if (!$response->successful()) {
            return redirect()->back()->withErrors(['error' => 'Proses prediksi gagal. Silakan coba lagi.']);
        }

        $result = $response->json();

        $topPrediction = collect($result)->sortDesc()->take(1)->map(function ($value, $key) {
            return ['label' => $key, 'confidence' => $value];
        })->first();

        $diseaseInfo = $recommendationService->getDiseaseInfo($topPrediction['label']);

        $analysisResult = (object)[
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'predicted_class' => $topPrediction['label'],
            'confidence' => $topPrediction['confidence'],
            'image_path' => $imagePath,
            'description' => $diseaseInfo['description'],      
            'recommendation' => $diseaseInfo['recommendation'], 
        ];

        return view('dashboard.detection', compact('analysisResult'));
    }


    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'predicted_class' => 'required|string',
            'confidence' => 'required|numeric',
            'description' => 'required|string', 
            'recommendation' => 'required|string',
            'image_path' => 'required|string',
        ]);

        DetectionResult::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'predicted_class' => $request->predicted_class,
            'confidence' => $request->confidence,
            'description' => $request->description, 
            'recommendation' => $request->recommendation,
            'image_path' => $request->image_path,
        ]);

        session()->forget('analysisResult');

        return redirect()->route('dashboard')->with('success', 'Hasil analisis berhasil disimpan ke riwayat Anda!');
    }

    public function history()
    {
        $histories = DetectionResult::where('user_id', Auth::id())
                                    ->latest()
                                    ->paginate(10);
        return view('dashboard.history', compact('histories'));
    }

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
