<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\SiswaController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AdminAspirasiController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminKategoriController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login-admin', [AdminController::class, 'login']);
Route::post('/login-siswa', [SiswaController::class, 'login']);

// Route logout (bisa diakses admin & siswa)
Route::post('/logout', function () {
    if (auth()->guard('admin')->check()) {
        auth()->guard('admin')->logout();
    } elseif (auth()->guard('siswa')->check()) {
        auth()->guard('siswa')->logout();
    }

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Route untuk admin dengan middleware admin
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminAspirasiController::class, 'dashboard'])->name('admin.dashboard');

    // Routes untuk Data Aspirasi
    Route::get('/admin/aspirasi', [AdminAspirasiController::class, 'index'])->name('admin.aspirasi.index');
    Route::get('/admin/aspirasi/{id}', [AdminAspirasiController::class, 'show'])->name('admin.aspirasi.show');
    Route::post('/admin/aspirasi/{id}/update-status', [AdminAspirasiController::class, 'updateStatus'])->name('admin.aspirasi.updateStatus');
    Route::post('/admin/aspirasi/{id}/feedback', [AdminAspirasiController::class, 'addFeedback'])->name('admin.aspirasi.feedback');
    Route::get('/admin/aspirasi/{id}/riwayat', [AdminAspirasiController::class, 'getRiwayatStatus'])->name('admin.aspirasi.riwayat');

    // Routes untuk Data Siswa
    Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa.index');
    Route::get('/admin/siswa/tambah', [AdminSiswaController::class, 'create'])->name('admin.siswa.create');
    Route::post('/admin/siswa/store', [AdminSiswaController::class, 'store'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}/edit', [AdminSiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::post('/admin/siswa/{id}/update', [AdminSiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}/delete', [AdminSiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    // Routes untuk Data Kategori
    Route::get('/admin/kategori', [AdminKategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/admin/kategori/tambah', [AdminKategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/admin/kategori/store', [AdminKategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/admin/kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::post('/admin/kategori/{id}/update', [AdminKategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}/delete', [AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');
});

// Route untuk siswa dengan middleware siswa
Route::middleware('siswa')->group(function () {
    Route::get('/siswa/dashboard', [AspirasiController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/siswa/tambah-aspirasi', [AspirasiController::class, 'create'])->name('siswa.tambah_aspirasi');
    Route::post('/siswa/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/siswa/histori-aspirasi', [AspirasiController::class, 'history'])->name('siswa.histori_aspirasi');
    Route::get('/siswa/aspirasi/{id}', [AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::get('/siswa/profile', [AspirasiController::class, 'profile'])->name('siswa.profile');
    Route::post('/siswa/profile/update', [AspirasiController::class, 'updateProfile'])->name('siswa.profile.update');
});
