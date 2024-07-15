<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeSidebarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IncomingProductController;
use App\Http\Controllers\OutcomingProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AprioriController;
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

    Route::get('/users/password', [UserController::class, 'showPasswordForm'])->name('users.password.form');
    Route::post('/users/password', [UserController::class, 'validatePassword'])->name('users.password.validate');
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');

    //category
    Route::resource('category', CategoryController::class);
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category_export', [CategoryController::class, 'export'])->name('category.export');
    Route::post('/category_import', [CategoryController::class, 'import'])->name('category.import');
    Route::post('/category_search', [CategoryController::class, 'search'])->name('category.search');


    //product
    Route::resource('product', ProductController::class);
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product_export', [ProductController::class, 'export'])->name('product.export');
    Route::post('/product_import', [ProductController::class, 'import'])->name('product.import');
    Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');


    // Barang Masuk
    Route::resource('incoming_product', IncomingProductController::class);
    Route::get('/incoming_product', [IncomingProductController::class, 'index'])->name('incoming_product');
    Route::get('/incoming_product_export', [IncomingProductController::class, 'export'])->name('incoming_product.export');
    Route::post('/incoming_product_import', [IncomingProductController::class, 'import'])->name('incoming_product.import');


    // Barang Keluar
    Route::resource('outcoming_product', OutcomingProductController::class);
    Route::get('/outcoming_product', [OutcomingProductController::class, 'index'])->name('outcoming_product');
    Route::get('/outcoming_product_export', [OutcomingProductController::class, 'export'])->name('outcoming_product.export');
    Route::post('/outcoming_product_import', [OUtcomingProductController::class, 'import'])->name('outcoming_product.import');


    //transaction
    Route::resource('transaction', TransactionController::class);
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/transaction_export', [TransactionController::class, 'export'])->name('transaction.export');
    Route::post('/transaction_import', [TransactionController::class, 'import'])->name('transaction.import');
    Route::get('/search_transaction', [TransactionController::class, 'search'])->name('search');

    // Apriori
    Route::get('apriori', [AprioriController::class, 'index'])->name('apriori');
    Route::post('/apriori/result', [AprioriController::class, 'process'])->name('apriori.process');
    Route::post('/apriori_export', [AprioriController::class, 'export'])->name('apriori.export');
});



