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
    Route::post('/detection/save', [DetectionController::class, 'save'])->name('detection.save'); 
    Route::get('/detection/history', [DetectionController::class, 'history'])->name('detection.history');


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

// Route ini mungkin tidak lagi digunakan jika Anda mengikuti alur dari DetectionController
//Route::post('/predict', [PredictionController::class, 'getPrediction']);
