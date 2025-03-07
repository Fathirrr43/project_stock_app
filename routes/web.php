<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\barangKeluarController;
use App\Http\Controllers\barangMasukController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\pelangganController;
use App\Http\Controllers\suplierController;
use App\Http\Controllers\stokController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index']);
Route::post('/',  [AuthController::class, 'login'])->name('login');

Route::middleware(['auth', 'cekLevel:superadmin,admin'])->group(function(){

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', [dashboardController::class, 'index']);


/**
 *  ini routing Pegawai
 */

Route::controller(pegawaiController::class)->group(function(){

    Route::get('/pegawai', 'index');

    Route::post('/pegawai/add', 'store')->name('addPegawai');

    Route::get('/pegawai/edit/{id}', 'edit');
    Route::post('/pegawai/edit/{id}', 'update');

    Route::get('/pegawai/delete/{id}', 'destroy');

});




/**
 * ini routing stok
 */
Route::controller(stokController::class)->group(function(){

    Route::get('/stok', 'index');

    Route::get('/stok/add', 'create');
    Route::post('/stok/add', 'store');

    Route::get('/stok/edit/{id}', 'edit');
    Route::post('/stok/edit/{id}', 'update');

    // Route::get('/stok/{id}', 'destroy');

});








/**
 * ini routing Barang Masuk
 */
Route::controller(barangMasukController::class)->group(function(){
    Route::get('/barang-masuk', 'index');
    Route::get('/barang-masuk/add', 'create');
    Route::post('/barang-masuk/add', 'store');
    // Route::get('/barang-masuk/edit/{id}', 'edit');
    // Route::post('/barang-masuk/edit/{id}','update');

    Route::get('/barang-masuk/{id}', 'destroy');

});






/**
 * ini routing Barang Keluar
*/
Route::controller(barangKeluarController::class)->group(function(){
    Route::get('/barang-keluar', 'index');
    Route::get('/barang-keluar/add', 'create');
    Route::post('/barang-keluar/add', 'store');
    
    Route::post('/barang-keluar/save', 'saveBarangKeluar')->name('addBarangKeluar');
    
//     Route::post('/barang-keluar/edit/{id}','update');

    Route::get('/barang-keluar/{id}', 'destroy');
    Route::get('/barang-keluar/print/{id}', 'print');


});








/**
 * ini routing Pelanggan
 */

 Route::controller(pelangganController::class)->group(function(){
    Route::get('/pelanggan', 'index');

    Route::get('/pelanggan/add', 'create');
    Route::post('/pelanggan/add', 'store');
    Route::get('/pelanggan/edit/{id}', 'edit');
    Route::post('/pelanggan/edit/{id}','update');

    Route::get('/pelanggan/{id}', 'destroy');
 });









 /**
 * ini routing Suplier
 */

    Route::controller(suplierController::class)->group(function(){

        Route::get('/suplier', 'index');

        Route::get('/suplier/add', 'create');
        Route::post('/suplier/add', 'store');

        Route::get('/suplier/edit/{id}', 'edit');
        Route::post('/suplier/edit/{id}', 'update');

        Route::get('/suplier/{id}', 'destroy');

    });






});
