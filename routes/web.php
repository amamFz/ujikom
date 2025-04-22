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

    // ✅ Petugas & Admin bisa lihat pemakaian (index) & report
    Route::middleware('role:admin|petugas')->group(function () {
        Route::get('/pemakaian', [PemakaianController::class, 'index'])->name('pemakaian.index');

        // Report - Change {id} to {pemakaian} for consistency
        Route::get('/pemakaian/report/all', [PemakaianController::class, 'generateAllReport'])
            ->name('pemakaian.report.all');
        Route::get('/pemakaian/report/filter', [PemakaianController::class, 'generateReport'])
            ->name('pemakaian.report');
        Route::get('/pemakaian/{pemakaian}/pdf', [PemakaianController::class, 'pemakaianPdf'])
            ->name('pemakaian.report.pdf');  // Changed from {id} to {pemakaian}
    });

    // ✅ Hanya admin bisa CRUD pemakaian
    Route::middleware('role:admin')->group(function () {
        Route::get('/pemakaian/create', [PemakaianController::class, 'create'])->name('pemakaian.create');
        Route::post('/pemakaian', [PemakaianController::class, 'store'])->name('pemakaian.store');
        Route::get('/pemakaian/{pemakaian}/edit', [PemakaianController::class, 'edit'])->name('pemakaian.edit');
        Route::put('/pemakaian/{pemakaian}', [PemakaianController::class, 'update'])->name('pemakaian.update');
        Route::delete('/pemakaian/{pemakaian}', [PemakaianController::class, 'destroy'])->name('pemakaian.destroy');
        Route::get('/pemakaian/last-meter', [PemakaianController::class, 'getLastMeterAkhir'])->name('pemakaian.last-meter');
        Route::get('/pemakaian/show/{pemakaian}', [PemakaianController::class, 'show'])->name('pemakaian.show');
        Route::resource('users', UserController::class);
        Route::resource('tarif', TarifController::class);
        Route::resource('jenis_pelanggan', JenisPelangganController::class);
    });
});



require __DIR__ . '/auth.php';
