<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Warga;
use App\Http\Controllers\SecureFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kelola-surat', [Admin\KelolaSuratController::class, 'index'])->name('kelola-surat.index');
    Route::get('/kelola-surat/{id}', [Admin\KelolaSuratController::class, 'show'])->name('kelola-surat.show');
    Route::put('/kelola-surat/{id}', [Admin\KelolaSuratController::class, 'update'])->name('kelola-surat.update');
    Route::get('/cetak-surat/{id}', [Admin\KelolaSuratController::class, 'cetakSurat'])->name('cetak-surat');
    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/cetak-laporan', [Admin\LaporanController::class, 'cetak'])->name('cetak-laporan');
    Route::get('/pengaturan', [Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::get('/profil', [Admin\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/password', [Admin\ProfilController::class, 'updatePassword'])->name('profil.password');
    // Activity Log — Audit Trail
    Route::get('/activity-log', [Admin\ActivityLogController::class, 'index'])->name('activity-log.index');
});

// Warga routes
Route::middleware(['auth', 'verified', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [Warga\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengajuan', [Warga\PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [Warga\PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [Warga\PengajuanController::class, 'store'])->name('pengajuan.store');
    // Detail pengajuan warga (dengan proteksi IDOR)
    Route::get('/pengajuan/{id}', [Warga\PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/profil', [Warga\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/password', [Warga\ProfilController::class, 'updatePassword'])->name('profil.password');
});

// Secure File Route — berlaku untuk admin DAN warga (otorisasi cek di controller)
Route::middleware(['auth', 'verified'])->get(
    '/berkas/{id}/{type}',
    [SecureFileController::class, 'serve']
)->name('berkas.serve')->where('type', 'ktp|kk|pengantar|tambahan');

require __DIR__ . '/auth.php';

