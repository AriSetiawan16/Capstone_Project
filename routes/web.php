<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetectionController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\LandingPageController;

// Halaman login/register (form UI)

Route::get('/auth', function () {
    return view('login');
})->name('auth');

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', function () {
    return redirect('/login');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard - hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Detection routes
    Route::get('/detection', [DetectionController::class, 'index'])->name('detection');
    Route::post('/detection/analyze', [DetectionController::class, 'analyze'])->name('detection.analyze');
    Route::post('/detection/save', [DetectionController::class, 'save'])->name('detection.save'); 
    Route::get('/detection/history', [DetectionController::class, 'history'])->name('detection.history');
    Route::delete('/detection/history/{id}', [DetectionController::class, 'destroy'])->name('destroy');

    // News routes
    Route::get('/news/detail', [NewsController::class, 'show'])->name('news.show');

    // Profile routes (simplified)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

});

Route::get('/weather', [WeatherController::class, 'show'])->name('weather.show');

Route::get('/weather/city', [WeatherController::class, 'showByCity'])->name('weather.city');

Route::get('/api/weather', [WeatherController::class, 'apiWeather'])->name('api.weather');

Route::get('/weather/test', function() {
    $apiKey = env('OPENWEATHER_API_KEY');
    
    if (!$apiKey) {
        return response()->json(['error' => 'API Key tidak ditemukan dalam file .env']);
    }
    
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
        'q' => 'Jakarta',
        'appid' => $apiKey,
        'units' => 'metric'
    ]);
    
    if ($response->successful()) {
        return response()->json([
            'status' => 'success',
            'message' => 'API Key berfungsi dengan baik!',
            'sample_data' => $response->json()
        ]);
    } else {
        return response()->json([
            'status' => 'error', 
            'message' => 'API Key tidak valid atau ada masalah lain',
            'error_detail' => $response->json()
        ]);
    }
})->name('weather.test');
