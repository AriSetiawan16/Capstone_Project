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

    public function analyze(Request $request)
    {
        // 1. Upload gambar ke Hugging Face Space
        $image = $request->file('image');

        $uploadResponse = Http::attach(
            'file',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )->post('https://amdzz-skindisease-space.hf.space/gradio_api/predict/');

        if (!$uploadResponse->successful()) {
            return response()->json(['error' => 'Failed to upload image'], 500);
        }

        $uploadPath = $uploadResponse->json()[0]; // ambil path tmp dari response

        // 2. Kirim ke run/predict
        $predictResponse = Http::post('https://amdzz-skindisease-space.hf.space/gradio_api/predict/', [
            'data' => [$uploadPath]
        ]);

        if (!$predictResponse->successful()) {
            return response()->json(['error' => 'Prediction failed'], 500);
        }

        $result = $predictResponse->json();

        return response()->json($result);
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
