<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\RekomendasiController;



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
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


Route::get('/', [AuthController::class, 'home'])->name('home');


// Mitra Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/register/mitra', [MitraController::class, 'showRegisterMitraForm'])->name('register.mitra');
    Route::post('/register/mitra', [MitraController::class, 'registerMitra']);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');


// Route::get('/checkout/{mitraId}', [PesananController::class, 'showCheckout'])->name('checkout');
// Route::post('/laundry/order/{mitraId}', [PesananController::class, 'placeOrder'])->name('laundry.placeOrder');

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


// Route::get('/laundry/{id}', [LaundryController::class, 'showDetail'])->name('laundry.detail');

// Route::post('/laundry/order/{mitraId}', [PesananController::class, 'store'])->name('laundry.order');
// Route::post('/laundry/order/{mitraId}', [PesananController::class, 'placeOrder'])->name('laundry.order');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');
    Route::get('admin/reject/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/mitra/verifikasi/{id}', [MitraController::class, 'verifikasi'])->name('admin.mitra.verifikasi');

});
   
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/mitra/dashboard', [MitraController::class, 'dashboard'])->name('mitra.dashboard');
// Route::put('/mitra/jenis-pakaian/{id}/update-price', [MitraController::class, 'updatePrice'])->name('mitra.updatePrice');
// // Route::post('/laundry/order/{mitraId}', [PesananController::class, 'store'])->name('laundry.order');
// // Route::get('/checkout/{mitraId}/{pesananId}', [PesananController::class, 'showCheckout'])->name('laundry.ShowCheckout');
// Route::post('/laundry/order/{mitraId}', [PesananController::class, 'storeAndCheckout'])->name('laundry.storeAndCheckout');

use App\Http\Controllers\KatalogController;

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
Route::get('/pesanan/qris/{pesanan}', [PesananController::class, 'showQRIS'])->name('pesanan.qris');
Route::post('/pesanan/konfirmasi/{pesanan}', [PesananController::class, 'konfirmasiPembayaran'])->name('pesanan.konfirmasi');

Route::get('/mitra/pesanan/{id}/update-status', [MitraController::class, 'editStatus'])->name('mitra.editStatus');
Route::post('/mitra/pesanan/{id}/update-status', [MitraController::class, 'updateStatus'])->name('mitra.updateStatus');

use App\Http\Controllers\ContactController;
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');