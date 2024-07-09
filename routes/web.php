<?php
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductMasterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiPembelianController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\UserController;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DetailOrder;
use App\Models\Menu;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// User
Route::get('/', function () {
    return view('ui_user.layouts.index', [
        'menus' => Menu::with('category')->limit(4)->get(),
        'categories' => Category::all(),
    ]);
});
Route::post('/sudahBayar',[CartController::class, 'sudahBayar']);
Route::resource('/product', ProductController::class);
Route::get('/sort/{sort}', [ProductController::class, 'sort']);
Route::get('/category/{nama_kategori}', [CustomerCategoryController::class, 'index']);
Route::group(['middleware' => ['cekCustomer']], function () {
    Route::get('customer-login', [CustomerLoginController::class, 'index'])->name('customer-login');
    Route::post('customer-login', [CustomerLoginController::class, 'authenticate'])->name('customer-login');
    Route::get('register', [CustomerRegisterController::class, 'register'])->name('register');
    Route::post('register', [CustomerRegisterController::class, 'store'])->name('register');
    Route::get('cek-password-customer', [CustomerLoginController::class, 'showLupaPassword'])->name('cek-password-customer');
    Route::post('cek-password-customer', [CustomerLoginController::class, 'storeEmail'])->name('cek-password-customer');
    Route::post('reset-password-customer', [CustomerLoginController::class, 'resetPassword'])->name('reset-password-customer');
});
Route::group(['middleware' => ['cekCustomerSession']], function () {
    Route::get('/transaction-history', [CartController::class, 'transaction_history']);
    Route::get('/transaction-history/{id_order}', [CartController::class, 'show']);
    Route::get('/checkout', [CartController::class, 'checkout']);
    Route::get('/kota/{id}', [CartController::class, 'get_city']);
    Route::get('/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}', [CartController::class, 'get_ongkir']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/updateCart', [CartController::class, 'updateCart']);
    Route::post('/checkStokCart', [CartController::class, 'checkStokCart']);
    Route::post('/finishOrder', [CartController::class, 'finishOrder']);
    Route::get('/myProfile',[CustomerLoginController::class, 'myProfile']);
    Route::post('/ubahMyProfile', [CustomerLoginController::class, 'ubahMyProfile']);
    Route::post('logout-customer', [CustomerLoginController::class, 'logout'])->name('logout-customer');
    Route::get('/snapToken', [CartController::class, 'token']);
    Route::post('/finish', [CartController::class, 'finish']);
});


// Admin
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('lupa-password', [LoginController::class, 'lupa_password'])->name('lupa-password');
Route::post('cek-password', [LoginController::class, 'cek_password'])->name('cek-password');
Route::get('form-ubah-password', [LoginController::class, 'cek_password'])->name('form-ubah-password');
Route::post('ubah-password', [LoginController::class, 'ubah_password'])->name('ubah-password');

// Admin
Route::group(['middleware' => ['auth', 'cekLevel:2']], function () {
    Route::resource('master/users', UserController::class);
    Route::get('laporan-pembelian', [LaporanPembelianController::class, 'index'])->name('laporan-pembelian');
    Route::post('/laporan-pembelian/tanggal', [LaporanPembelianController::class, 'search']);
    Route::get('laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan');
    Route::post('/laporan-penjualan/tanggal', [LaporanPenjualanController::class, 'search']);
});

Route::group(['middleware' => ['auth', 'cekLevel:1,2']], function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');
    Route::resource('/master/products', ProductMasterController::class);
    Route::resource('/master/category', CategoryController::class);
    Route::resource('/master/customer', CustomerController::class);
    Route::resource('/master/suppliers', SupplierController::class);
    Route::post('/ambilGambar', [ProductMasterController::class, 'ambilGambar']);
    // Route::resource('/transaksi-pembelian', PembelianController::class);
    Route::get('/transaksi-pembelian', [TransaksiPembelianController::class, 'index']);
    Route::get('/transaksi-pembelian/create', [TransaksiPembelianController::class, 'create']);
    Route::post('/transaksi-pembelian/store', [TransaksiPembelianController::class, 'store']);
    Route::post('/transaksi-pembelian/store_pembelian', [TransaksiPembelianController::class, 'store_pembelian']);
    Route::post('/transaksi-pembelian/cekFaktur',[TransaksiPembelianController::class, 'cekFaktur']);
    Route::delete('/transaksi-pembelian/{id_detail_pembelian}',[TransaksiPembelianController::class, 'destroy']);
    Route::get('/transaksi-pembelian/detail/{id_pembelian}', [TransaksiPembelianController::class, 'show']);
    Route::post('/transaksi-penjualan/cekResi', [TransaksiPenjualanController::class, 'cekResi']);
    Route::post('/transaksi-penjualan/update-resi', [TransaksiPenjualanController::class, 'update']);
    Route::get('transaksi-penjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksi-penjualan');
});
