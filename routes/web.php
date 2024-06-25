<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IncomingProductController;
use App\Http\Controllers\OutcomingProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
});


//Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');


// users/karyawan & profile
Route::resource('users', UserController::class);
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');


//category
Route::resource('category', CategoryController::class);
Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/category/search', [CategoryController::class, 'search'])->name('category.search');


//product
Route::resource('product', ProductController::class);
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');


// Barang Masuk
Route::resource('incoming_product', IncomingProductController::class);
Route::get('/incoming_product', [IncomingProductController::class, 'index'])->name('incoming_product');


// Barang Keluar
Route::resource('outcoming_product', OutcomingProductController::class);
Route::get('/outcoming_product', [OutcomingProductController::class, 'index'])->name('outcoming_product');


//transaction
Route::resource('transaction', TransactionController::class);
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
Route::get('/search_transaction', [TransactionController::class, 'search'])->name('search');


//apriori
Route::get('apriori_process', function () {
    return view('apriori/apriori_process');
});
Route::get('/apriori/apriori_result', function () {
    return view('apriori/apriori_result');
});


Route::get('/report', function () {
    return view('reports');
});
Route::get('/account', function () {
    return view('users/account');
});

//Route::get('/login', [LoginController::class, 'login'])->name('login');
//Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
//Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

