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
use Illuminate\Support\Facades\Auth;

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
    $data = [
        'title' => 'HandyGo - Solusi Jasa Harian Terpercaya',
        'description' => 'Platform jasa harian terpercaya untuk berbagai kebutuhan Anda',
        'services' => \App\Models\Service::all(),
        'services_count' => \App\Models\Service::count(),
        'active_providers' => \App\Models\User::where('role', 'penyedia_jasa')->count(),
        'users' => \App\Models\User::all()
    ];
    return view('pengguna.index', $data);
})->name('pengguna');

// Route Customer - Login
Route::get('/customer/login', [PenggunaController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [PenggunaController::class, 'login'])->name('customer.login.post');

// Route Customer - Protected Pages (dengan middleware auth)
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('index');
    Route::get('/layanan', [PenggunaController::class, 'layanan'])->name('layanan');
    Route::get('/tentangkami', [PenggunaController::class, 'tentangkami'])->name('tentangkami');
    Route::get('/history', [PenggunaController::class, 'history'])->name('history');
    Route::get('/pemesanan', [PenggunaController::class, 'pemesanan'])->name('pemesanan');
    Route::post('/orders', [PenggunaController::class, 'storeOrder'])->name('orders.store');
    Route::patch('/orders/{id}/progress', [PenggunaController::class, 'updateOrderProgress'])->name('orders.progress');
    Route::delete('/orders/{id}/cancel', [PenggunaController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{id}/detail', [PenggunaController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/payment', [PenggunaController::class, 'payment'])->name('payment');
    Route::post('/payment', [PenggunaController::class, 'storePayment'])->name('payment.store');
    Route::get('/profile', [PenggunaController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [PenggunaController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [PenggunaController::class, 'logout'])->name('logout');
});

// Route Pengguna - Public Pages (untuk non-authenticated users)
Route::get('/penggunaHandyGo', function () {
    $data = [
        'title' => 'HandyGo - Solusi Jasa Harian Terpercaya',
        'services' => \App\Models\Service::all(),
        'services_count' => \App\Models\Service::count(),
        'active_providers' => \App\Models\User::where('role', 'penyedia_jasa')->count()
    ];
    return view('pengguna.index', $data);
});

Route::get('/penggunaHandyGo/tentangkami', function () {
    return view('pengguna.tentangkami', ['title' => 'Tentang Kami - HandyGo']);
});

Route::get('/penggunaHandyGo/layanan', function () {
    $data = [
        'title' => 'Layanan - HandyGo',
        'services' => \App\Models\Service::all()
    ];
    return view('pengguna.layanan', $data);
})->name('public.layanan');

Route::get('/penggunaHandyGo/payment', function () {
    $data = [
        'title' => 'Payment - HandyGo',
        'services' => \App\Models\Service::all()
    ];
    return view('pengguna.payment', $data);
})->name('public.payment');

Route::get('/penggunaHandyGo/pemesanan', function () {
    $data = [
        'title' => 'Pemesanan - HandyGo',
        'active_orders' => collect(), // Empty collection for non-authenticated users
        'services' => \App\Models\Service::all()
    ];
    return view('pengguna.pemesanan', $data);
})->name('public.pemesanan');

Route::get('/penggunaHandyGo/history', function () {
    $data = [
        'title' => 'History - HandyGo',
        'orders' => collect() // Empty collection for non-authenticated users
    ];
    return view('pengguna.history', $data);
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
