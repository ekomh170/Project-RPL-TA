<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenyediaJasaController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk Penyedia Jasa
Route::get('/penyediajasa', [PenyediaJasaController::class, 'index'])->name('penyediajasa');
Route::get('/penyediajasa/biodata', [PenyediaJasaController::class, 'index4'])->name('penyediajasa-informasi');
Route::get('/penyediajasa/transaksi', [PenyediaJasaController::class, 'index2'])->name('penyediajasa-transaksi');
Route::get('/penyediajasa/history', [PenyediaJasaController::class, 'index3'])->name('penyediajasa-history');
Route::get('/dashboard/penyediajasa', [PenyediaJasaController::class, 'index'])->name('penyediajasa-admin');
Route::post('/penyediajasa', [PenyediaJasaController::class, 'store'])->name('add-penyediajasa');
Route::get('/dashboard/penyediajasa/detail/{penyediajasa}', [PenyediaJasaController::class, "show"])->name('detail-penyediajasa');
// Route untuk Penyedia Jasa

// Route Halaman Utama
Route::get('/', function () {
    return view('pengguna.index');
})->name('pengguna');
// Route Halaman Utama

// Route Pengguna
Route::get('/penggunaHandyGo', function () {
    return view('pengguna.index');
});

Route::get('/penggunaHandyGo/tentangkami', function () {
    return view('pengguna.tentangkami');
});

Route::get('/penggunaHandyGo/profile', function () {
    return view('pengguna.profile');
});

Route::get('/penggunaHandyGo/layanan', function () {
    return view('pengguna.layanan');
});

Route::get('/penggunaHandyGo/payment', function () {
    return view('pengguna.payment');
});

Route::get('/penggunaHandyGo/pemesanan', function () {
    return view('pengguna.pemesanan');
});

Route::get('/penggunaHandyGo/history', function () {
    return view('pengguna.history');
});
// Route Pengguna

// Route untuk Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes untuk Job Orders
    Route::get('/job-orders', [JobOrderController::class, 'index'])->name('jobOrders.index');
    Route::post('/job-orders', [JobOrderController::class, 'store'])->name('jobOrders.store');
    Route::delete('/job-orders/{id}', [JobOrderController::class, 'destroy'])->name('jobOrders.destroy');

    // Routes untuk Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Routes untuk Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Routes untuk Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Routes untuk Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/penyediajasa', [PenyediaJasaController::class, 'index'])->name('penyediajasa');
    Route::post('/penyediajasa', [PenyediaJasaController::class, 'store'])->name('add-penyediajasa');
    Route::delete('/penyediajasa/{penyediajasa}', [PenyediaJasaController::class, 'destroy'])->name('delete-penyediajasa');
});

// Route untuk Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// Include File Auth
require __DIR__ . '/auth.php';
