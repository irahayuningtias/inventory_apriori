<?php

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

Route::get('/dashboard', function () {
    return view('index');
});


//users
Route::get('/users', function () {
    return view('users/users');
});
Route::get('/users/add_users', function () {
    return view('users/add_users');
});
Route::get('/users/edit_users', function () {
    return view('users/edit_users');
});


//goods
Route::get('/goods', function () {
    return view('barang/goods');
});
Route::get('/goods/add_goods', function () {
    return view('barang/add_goods');
});
Route::get('/goods/edit_goods', function () {
    return view('barang/edit_goods');
});


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
Route::get('/transaction', function () {
    return view('transaksi/transaction');
});
Route::get('/transaction/add_transaction', function () {
    return view('transaksi/add_transaction');
});
Route::get('/transaction/edit_transaction', function () {
    return view('transaksi/edit_transaction');
});


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
