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


Route::get('/', 'App\Http\Controllers\PagosController@getAllPagos')->middleware(['auth'])->name('dashboard');
Route::get('/factura', function () {
    return view('factura');
})->middleware(['auth'])->name('factura');
Route::post('/generateCip', 'App\Http\Controllers\ApiController@generateCip')->middleware(['auth'])->name('generateCip');

require __DIR__.'/auth.php';
