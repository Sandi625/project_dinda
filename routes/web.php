<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\KriteriaPenilaianController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HalamanGuruController;
use App\Http\Controllers\HalamanKepsekController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Guru
Route::resource('guru', GuruController::class);

// Penilaian
Route::resource('penilaian', PenilaianController::class);

// Kriteria Penilaian
Route::resource('kriteria_penilaian', KriteriaPenilaianController::class);

// Feedback
Route::resource('feedback', FeedbackController::class);



Route::resource('halamanguru', HalamanGuruController::class);


Route::resource('kepsek', HalamanKepsekController::class);




Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
