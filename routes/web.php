<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Auth routes manual
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resources([
        'pelanggan' => PelangganController::class,
        'layanan' => LayananController::class,
        'transaksi' => TransaksiController::class,
    ]);
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/transaksi/cetak/{transaksi}', [TransaksiController::class, 'cetakStruk'])->name('transaksi.cetak');
    Route::get('/transaksi/cetak-thermal/{transaksi}', [TransaksiController::class, 'cetakStrukThermal'])->name('transaksi.cetak-thermal');
    Route::put('/transaksi/status/{transaksi}', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
});