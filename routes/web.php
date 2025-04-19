<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\UlasanController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});



// Auth Routes

Route::get('register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/', [AuthController::class, 'home'])->name('home');

// Mitra Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/register/mitra', [MitraController::class, 'showRegisterMitraForm'])->name('register.mitra');
    Route::post('/register/mitra', [MitraController::class, 'registerMitra']);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');


Route::middleware(['auth'])->group(function () {
    // Register Mitra Route
    Route::post('/mitra/register', [MitraController::class, 'registerMitra'])->name('mitra.register');

    // Update Price Route
    Route::put('/mitra/updatePrice/{jenisPakaianId}', [MitraController::class, 'updatePrice'])->name('mitra.updatePrice');

    // Catalog Route (for filtering and viewing mitra catalog)
    Route::get('/catalog', [MitraController::class, 'catalog'])->name('catalog');

    // Verifikasi Mitra Route
    Route::put('/mitra/verifikasi/{id}', [MitraController::class, 'verifikasi'])->name('mitra.verifikasi');
});

Route::get('/catalog', [MitraController::class, 'catalog'])->name('catalog');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
    Route::get('admin/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/mitra/verifikasi/{id}', [MitraController::class, 'verifikasi'])->name('admin.mitra.verifikasi');

});
   
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/mitra/dashboard', [MitraController::class, 'dashboard'])->name('mitra.dashboard');


Route::get('katalog', [KatalogController::class, 'index'])->name('katalog.index'); // Display catalog (Step 1)
Route::get('katalog/{mitra}/detail', [KatalogController::class, 'showKatalogDetail'])->name('katalog.detail'); // Show laundry details (Step 2)
Route::post('katalog/{mitra}/checkout', [KatalogController::class, 'storeAndCheckout'])->name('katalog.storeAndCheckout'); // Handle the checkout (Step 3)
Route::post('katalog/{mitra}/placeOrder', [KatalogController::class, 'placeOrder'])->name('katalog.placeOrder'); // Place the order (Step 4)
Route::get('/laundry/{pesanan}/orderConfirmation', [KatalogController::class, 'orderConfirmation'])->name('katalog.orderConfirmation'); // Order confirmation (Step 5)

Route::get('/lacak-pesanan', [PesananController::class, 'index'])->name('lacak.pesanan');
Route::get('kelola-pesanan', [MitraController::class, 'kelolaPesanan'])->name('mitra.kelolaPesanan');

// Group route khusus mitra dengan autentikasi
Route::get('/mitra/payment', [MitraController::class, 'pembayaran'])->name('mitra.pembayaran');
Route::post('/mitra/payment/confirm/{id}', [MitraController::class, 'konfirmasiPembayaran'])->name('mitra.konfirmasiPembayaran');
Route::get('/mitra/payment/confirm/{id}', [MitraController::class, 'showKonfirmasiPembayaran'])->name('mitra.showKonfirmasiPembayaran');



Route::get('/mitra/pesanan/{id}/update-status', [MitraController::class, 'editStatus'])->name('mitra.editStatus');
Route::post('/mitra/pesanan/{id}/update-status', [MitraController::class, 'updateStatus'])->name('mitra.updateStatus');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan/{pesanan}/qris', [PesananController::class, 'showQRIS'])
         ->name('pesanan.qris');
    Route::post('/pesanan/{pesanan}/konfirmasi', [PesananController::class, 'konfirmasiPembayaran'])
         ->name('pesanan.konfirmasi');
});

// routes/api.php
Route::post('midtrans-callback', [PesananController::class, 'handleWebhook'])
     ->middleware('verify.midtrans');
    
 Route::get('/order-history', [ProfileController::class, 'history'])->name('order.history');
 Route::get('/laundry/nearby', [RekomendasiController::class, 'rekomendasiLaundry']);
 Route::get('/pesanan/{pesanan}/cod', [PesananController::class, 'showCOD'])
     ->name('pesanan.cod');



Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan/{pesanan}/ulas', [UlasanController::class, 'showReviewForm'])->name('pesanan.ulasan');
    Route::post('/pesanan/{pesanan}/ulas', [UlasanController::class, 'storeReview']);
    Route::get('/mitra/reports', [UlasanController::class, 'showReport'])->name('mitra.reports');

});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/mitra', [AdminController::class, 'manageMitra'])->name('admin.mitra');
    Route::get('/pelanggan', [AdminController::class, 'manageCustomers'])->name('admin.customers');
    Route::get('/pesanan', [AdminController::class, 'manageOrders'])->name('admin.orders');
    Route::get('/laporan', [AdminController::class, 'reports'])->name('admin.reports');
    Route::post('/mitra/verify/{id}', [AdminController::class, 'verifyMitra'])->name('admin.verify.mitra');
});

Route::get('/mitra/settings/{id}', [MitraController::class, 'edit'])->name('mitra.pengaturan');
Route::put('/mitra/settings/{id}', [MitraController::class, 'update'])->name('mitra.update');
Route::put('/mitra/{mitraId}/update-price', [MitraController::class, 'updatePrice'])->name('mitra.updatePrice');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/hubungi-kami', [AdminController::class, 'hubungiKami'])->name('admin.hubungiKami');
Route::get('/admin/kelola-pelanggan', [AdminController::class, 'kelolaPelanggan'])->name('admin.kelolaPelanggan');
Route::delete('/admin/kelola-pelanggan/{id}', [AdminController::class, 'deletePelanggan'])->name('admin.deletePelanggan');
Route::get('/admin/verifikasi-mitra', [AdminController::class, 'verifikasiMitra'])->name('admin.verifikasiMitra');
Route::get('/admin/verifikasi-mitra/{id}', [AdminController::class, 'verifikasiMitraDetail'])->name('admin.verifikasiMitraDetail');
Route::put('/admin/verifikasi-mitra/{id}', [AdminController::class, 'updateVerifikasiMitra'])->name('admin.verifikasiMitra.update');
