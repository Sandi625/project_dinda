<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\KriteriaPenilaianController;
use App\Http\Controllers\FeedbackController;

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
