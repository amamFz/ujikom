<?php

use App\Http\Controllers\JenisPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PembayaranController::class, 'index'])->name('public.history');


// Route::resource('pemakaian', PemakaianController::class);
// Route::get('pemakaian/{id}/pdf', [PemakaianController::class, 'pemakaianPdf'])
//     ->name('pemakaian.report.pdf');
// Route::resource('users', UserController::class);
// Route::resource('tarif', TarifController::class);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $totalUsers = \App\Models\User::count();
        $totalPelanggan = \App\Models\Pelanggan::count();
        $totalPemakaian = \App\Models\Pemakaian::sum('jumlah_pakai');
        $aktivitas = \App\Models\Pelanggan::latest()->take(5)->get();

        return view('dashboard', compact('totalUsers', 'totalPelanggan', 'totalPemakaian', 'aktivitas'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('pelanggan', PelangganController::class);

    Route::middleware('web')->group(function () {
        Route::get('/pembayaran/search', [PembayaranController::class, 'search'])->name('pembayaran.search');
        Route::post('/pembayaran/entry', [PembayaranController::class, 'entry'])->name('pembayaran.entry');
        Route::get('/pembayaran/{pemakaian}/receipt', [PembayaranController::class, 'generateReceipt'])
            ->name('pembayaran.receipt');
        Route::get('/pembayaran/history/search', [PembayaranController::class, 'searchHistory'])
            ->name('pembayaran.search.history');
    });

    Route::middleware('role:admin')->group(function () {
        // Full access to all resources
        Route::resource('pemakaian', PemakaianController::class);
        Route::resource('users', UserController::class);
        Route::resource('tarif', TarifController::class);
        Route::resource('jenis_pelanggan', JenisPelangganController::class);

        Route::get('pemakaian/{id}/pdf', [PemakaianController::class, 'pemakaianPdf'])
            ->name('pemakaian.report.pdf');
    });
});

require __DIR__ . '/auth.php';
