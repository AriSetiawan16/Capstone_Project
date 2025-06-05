<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetectionController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\LandingPageController;

Route::get('/image-proxy', function (Request $request) {
    $url = $request->query('url');

    if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
        return response('Invalid URL', 400);
    }

    try {
        $response = Http::timeout(10)->get($url);

        if (!$response->successful()) {
            return response('Image not found', 404);
        }

        $mimeType = $response->header('Content-Type', 'image/jpeg');
        return response($response->body())->header('Content-Type', $mimeType);
    } catch (\Exception $e) {
        return response('Proxy error: ' . $e->getMessage(), 500);
    }
});


// Halaman login/register (form UI)
Route::get('/auth', function () {
    return view('login');
})->name('auth');

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard - hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Detection routes
    Route::get('/detection', [DetectionController::class, 'index'])->name('detection');
    Route::post('/detection/analyze', [DetectionController::class, 'analyze'])->name('detection.analyze');

    // News routes
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/detail/{id}', [NewsController::class, 'show'])
            ->where('id', '.*')
            ->name('news.show');


    // Profile routes (simplified)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

});

Route::post('/predict', [PredictionController::class, 'getPrediction']);
Route::get('/detection/create', [DetectionController::class, 'create'])->name('detection.create');
Route::post('/detection/save', [DetectionController::class, 'save'])->name('detection.save');

