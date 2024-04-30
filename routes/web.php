<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;

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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

//users
Route::resource('users', UserController::class);
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');


//category
Route::resource('category', CategoryController::class);
Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/category/search', [CategoryController::class, 'search'])->name('category.search');


//product
Route::resource('product', ProductController::class);
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');


//supply
Route::get('/supply_in', function () {
    return view('persediaan/supply_in');
});
Route::get('/supply_in/add_supply_in', function () {
    return view('persediaan/add_supply_in');
});
Route::get('/supply_in/edit_supply_in', function () {
    return view('persediaan/edit_supply_in');
});
Route::get('/supply_out', function () {
    return view('persediaan/supply_out');
});
Route::get('/supply_out/add_supply_out', function () {
    return view('persediaan/add_supply_out');
});
Route::get('/supply_out/edit_supply_out', function () {
    return view('persediaan/edit_supply_out');
});


//transaction
Route::resource('transaction', TransactionController::class);
Route::get('transaction/{id_transaction}', 'TransactionController@show')->name('transaction.show');
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



Auth::routes();

//Route::get('/login', [LoginController::class, 'login'])->name('login');
//Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

