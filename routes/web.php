<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;
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

Route::any('/encrypt/{id}', [CryptoController::class, 'encrypt']);
Route::any('/decrypt', [CryptoController::class, 'decrypt']);
Route::any('/update', [CryptoController::class, 'update']);
Route::get('/', function () {
    return view('welcome');
});
