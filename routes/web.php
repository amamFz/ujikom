<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('web')->group(function () {
    Route::get('/pembayaran/search', [PembayaranController::class, 'search'])->name('pembayaran.search');
    Route::post('/pembayaran/entry', [PembayaranController::class, 'entry'])->name('pembayaran.entry');
});


Route::resource('pemakaian', PemakaianController::class);
Route::get('pemakaian/{id}/pdf', [PemakaianController::class, 'pemakaianPdf'])
    ->name('pemakaian.report.pdf');
Route::resource('pelanggan', PelangganController::class);
Route::resource('users', UserController::class);
Route::resource('tarif', TarifController::class);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
