<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrsEntryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PengajuanBrsController;
use Illuminate\Support\Facades\Route;

// Halaman publik: form pengajuan nomor BRS, tidak perlu login.
Route::get('/ajukan', [PengajuanBrsController::class, 'create'])->name('pengajuan.create');
Route::post('/ajukan', [PengajuanBrsController::class, 'store'])->name('pengajuan.store');

// Login admin.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Panel admin: registrasi & pengaturan, wajib login.
Route::middleware('auth')->group(function () {
    Route::get('/', [BrsEntryController::class, 'index'])->name('brs.index');
    Route::post('/brs', [BrsEntryController::class, 'store'])->name('brs.store');
    Route::get('/brs/{brsEntry}/edit', [BrsEntryController::class, 'edit'])->name('brs.edit');
    Route::put('/brs/{brsEntry}', [BrsEntryController::class, 'update'])->name('brs.update');
    Route::delete('/brs/{brsEntry}', [BrsEntryController::class, 'destroy'])->name('brs.destroy');
    Route::get('/brs/export/{tahun}', [BrsEntryController::class, 'export'])->name('brs.export');

    Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan/kategori', [SettingController::class, 'storeKategori'])->name('settings.kategori.store');
    Route::delete('/pengaturan/kategori/{kategori}', [SettingController::class, 'destroyKategori'])->name('settings.kategori.destroy');
    Route::post('/pengaturan/tim', [SettingController::class, 'storeTim'])->name('settings.tim.store');
    Route::delete('/pengaturan/tim/{tim}', [SettingController::class, 'destroyTim'])->name('settings.tim.destroy');
    Route::post('/pengaturan/tahun', [SettingController::class, 'storeTahunReferensi'])->name('settings.tahun.store');
    Route::put('/pengaturan/tahun/{tahunReferensi}', [SettingController::class, 'updateTahunReferensi'])->name('settings.tahun.update');
    Route::put('/pengaturan/kode-wilayah', [SettingController::class, 'updateKodeWilayah'])->name('settings.kodewilayah.update');
    Route::delete('/pengaturan/tahun/{tahunReferensi}', [SettingController::class, 'destroyTahunReferensi'])->name('settings.tahun.destroy');
});