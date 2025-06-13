<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HalamanGuruController;
use App\Http\Controllers\DashboardGuruController;
use App\Http\Controllers\HalamanKepsekController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardKepsekController;
use App\Http\Controllers\KriteriaPenilaianController;

Route::get('/', function () {
    return view('index');
});

// Route hanya bisa diakses admin - sementara di-nonaktifkan middleware-nya
Route::resource('guru', GuruController::class);
Route::resource('penilaian', PenilaianController::class);
Route::resource('kriteria_penilaian', KriteriaPenilaianController::class);
Route::resource('feedback', FeedbackController::class);

// Route hanya bisa diakses guru - sementara di-nonaktifkan middleware-nya
Route::resource('halamanguru', HalamanGuruController::class);

// Route hanya bisa diakses kepala sekolah - sementara di-nonaktifkan middleware-nya
Route::resource('kepsek', HalamanKepsekController::class);



Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');



Route::get('/galeri', function () {
    return view('page.galeri');
});

Route::get('/artikel', function () {
    return view('page.artikel');
})->name('artikel.page');

// Ekstrakulikuler page
Route::get('/ekstrakulikuler', function () {
    return view('page.ekstrakulikuler');
})->name('ekstrakulikuler.page');

// Kontak page
Route::get('/kontak', function () {
    return view('page.kontak');
})->name('kontak.page');



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboardadmin', [DashboardAdminController::class, 'index'])->name('dashboard.admin');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboardguru', [DashboardGuruController::class, 'index'])->name('dashboard.guru');
});


Route::middleware(['auth', 'role:kepala_sekolah'])->group(function () {
    Route::get('/dashboardkepsek', [DashboardKepsekController::class, 'index'])->name('dashboard.kepsek');
});





Route::get('/halamanguru/dashboard', [HalamanGuruController::class, 'dashboard'])->name('halamanguru.dashboard');
