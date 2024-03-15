<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/register', [UserController::class, 'create']);
    Route::get('logout', [AuthenticationController::class, 'logout']);
    Route::post('/register', [UserController::class, 'store']);
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('transaction/detail', DetailTransactionController::class);
});

Route::get('/login', [AuthenticationController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticationController::class, 'authenticate']);

Route::get('/auth/google', [AuthenticationController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthenticationController::class, 'handleGoogleCallback']);