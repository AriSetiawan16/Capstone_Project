<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionResult;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $latest = DetectionResult::latest()->first(); // Ambil hasil terakhir
        return view('dashboard.index', ['last_detection' => $latest]);
    }
}