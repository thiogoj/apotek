<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/registerpegawai', [AuthController::class, 'registerPegawai']);
Route::post('/loginpegawai', [AuthController::class, 'loginPegawai']);
Route::post('/registerpelanggan', [AuthController::class, 'registerPelanggan']);
Route::post('/loginpelanggan', [AuthController::class, 'loginPelanggan']);

Route::post('/createobat', [ObatController::class, 'createObat']);
Route::get('/obat', [ObatController::class, 'showAll']);
Route::get('/obat/{id}', [ObatController::class, 'showById']);
Route::post('/editobat/{id}', [ObatController::class, 'editObat']);
Route::delete('/deleteobat/{id}', [ObatController::class, 'deleteObat']);

Route::post('/addtocart/{id}', [TransaksiController::class, 'addToCart']);
Route::delete('/deletecart/{id}', [TransaksiController::class, 'deleteCart']);
Route::put('/editcart/{id}', [TransaksiController::class, 'editCart']);
Route::get('/cart/{id}', [TransaksiController::class, 'cart']);

