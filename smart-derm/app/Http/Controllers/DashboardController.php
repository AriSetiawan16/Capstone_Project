<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetectionResult; // Pastikan Model diimpor

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan riwayat deteksi terakhir.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data deteksi terakhir dari pengguna yang sedang login
        $last_detection = DetectionResult::where('user_id', $user->id)
                                         ->latest() // Urutkan dari yang terbaru
                                         ->first(); // Ambil satu saja

        // Kirim data ke view dashboard.index
        return view('dashboard.index', [
            'last_detection' => $last_detection
        ]);
    }
}
