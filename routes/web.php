<?php

use App\Models\Siswa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileKepsek;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\BeriNilaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HalamanGuruController;
use App\Http\Controllers\ProfileGuruController;
use App\Http\Controllers\DashboardGuruController;
use App\Http\Controllers\HalamanKepsekController;
use App\Http\Controllers\KepsekLaporanController;
use App\Http\Controllers\LihatRataGuruController;
use App\Http\Controllers\ProfileKepsekController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\JadwalMengajarController;
use App\Http\Controllers\DashboardKepsekController;
use App\Http\Controllers\KriteriaPenilaianController;
use App\Http\Controllers\LaporanPembelajaranController;
use App\Http\Controllers\RiwayatPenilaianGuruController;
use App\Http\Controllers\HomeController; // <- ini error kalau belum ada

Route::prefix('kepsek')->middleware(['auth'])->group(function () {
    Route::get('/laporan', [KepsekLaporanController::class, 'index'])->name('kepsek.laporan.index');
    Route::get('/laporan/{id}', [KepsekLaporanController::class, 'show'])->name('kepsek.laporan.show');
});


Route::get('/guru/riwayat', [RiwayatPenilaianGuruController::class, 'index'])->name('guru.riwayat');

Route::get('/guru/riwayat/{id}', [RiwayatPenilaianGuruController::class, 'detail'])->name('guru.riwayat.detail');

Route::get('/kepsek/rata-rata-nilai', [LihatRataGuruController::class, 'index'])->name('kepsek.rata-guru');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/penilaian/cetak-pdf', [PenilaianController::class, 'exportPdf'])->name('penilaian.pdf');

// Route hanya bisa diakses admin - sementara di-nonaktifkan middleware-nya
Route::resource('penilaian', PenilaianController::class);
Route::resource('kriteria_penilaian', KriteriaPenilaianController::class);
Route::resource('feedback', FeedbackController::class);

// Route hanya bisa diakses guru - sementara di-nonaktifkan middleware-nya
Route::resource('halamanguru', HalamanGuruController::class);

// Route hanya bisa diakses kepala sekolah - sementara di-nonaktifkan middleware-nya




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
Route::get('/penilaian/{id}/download', [PenilaianController::class, 'downloadPerPenilaian'])->name('penilaian.download');








Route::get('/berita/{berita:slug}', [BeritaController::class, 'userShow'])->name('berita.user.show');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('berita', BeritaController::class)->parameters([
        'berita' => 'berita' // <--- Fix penamaan parameter
    ]);
});



Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('users', UsersController::class)->parameters([
        'users' => 'user' // Ini agar Laravel pakai `id_user` di URL, bukan `id`
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});





Route::middleware(['auth', 'role:kepala_sekolah'])->name('kepsek.profile.')->group(function () {
    Route::get('/kepsek/profile', [ProfileKepsekController::class, 'show'])->name('show');
    Route::get('/kepsek/profile/edit', [ProfileKepsekController::class, 'edit'])->name('edit');
    Route::put('/kepsek/profile', [ProfileKepsekController::class, 'update'])->name('update');
    Route::put('/kepsek/profile/password', [ProfileKepsekController::class, 'updatePassword'])->name('password.update');
});

Route::resource('kepsek', HalamanKepsekController::class);


Route::middleware(['auth', 'role:guru'])->name('guru.profile.')->group(function () {
    Route::get('/guru/profile', [ProfileGuruController::class, 'show'])->name('show');
    Route::get('/guru/profile/edit', [ProfileGuruController::class, 'edit'])->name('edit');
    Route::put('/guru/profile', [ProfileGuruController::class, 'update'])->name('update');
    Route::put('/guru/profile/password', [ProfileGuruController::class, 'updatePassword'])->name('password.update');
});


Route::resource('guru', GuruController::class);

Route::get('/penilaian/kepsek-download/{id}', [HalamanKepsekController::class, 'downloadUntukKepalaSekolah'])->name('penilaian.kepsek.download');

Route::resource('mapel', MapelController::class);

Route::resource('siswa', SiswaController::class);

Route::resource('kelas', KelasController::class);




Route::prefix('beri-nilai')->group(function () {
    Route::get('/', [BeriNilaiController::class, 'index'])->name('beri-nilai.index');
    Route::post('/form', [BeriNilaiController::class, 'form'])->name('beri-nilai.form');
    Route::post('/simpan', [BeriNilaiController::class, 'simpan'])->name('beri-nilai.simpan');

    // Tambahan lihat hasil nilai
    Route::get('/lihat', [BeriNilaiController::class, 'lihat'])->name('beri-nilai.lihat');
    Route::post('/hasil', [BeriNilaiController::class, 'hasil'])->name('beri-nilai.hasil');
});


// Route::get('/kepsek/rata-rata-nilai', [LihatRataGuruController::class, 'index'])->name('kepsek.rata-guru');


Route::middleware(['auth'])->group(function () {
    Route::resource('laporan', LaporanPembelajaranController::class);
});



Route::resource('jadwal-mengajar', JadwalMengajarController::class);




