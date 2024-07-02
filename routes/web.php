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
    Route::get('/pdf', [UserController::class, 'exportPdf'])->name('pdf.export');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');

    //category
    Route::resource('category', CategoryController::class);
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/pdf', [CategoryController::class, 'exportPdf'])->name('pdf.export');
    Route::get('/category/search', [CategoryController::class, 'search'])->name('category.search');


    //product
    Route::resource('product', ProductController::class);
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/pdf', [ProductController::class, 'exportPdf'])->name('pdf.export');
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

    // Apriori
    Route::get('apriori', [AprioriController::class, 'index'])->name('apriori');
    Route::post('/apriori/result', [AprioriController::class, 'process'])->name('apriori.process');
});



