<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SalesProductController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::post('login', [LoginController::class, 'tokenExchange'])->name('login');
    Route::post('firebase-login', [LoginController::class, 'signInWithEmailAndPassword'])->name('firebase-login');
    Route::get('logout', LogoutController::class)->name('logout');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/resend-verification', [VerificationController::class, 'resendVerification'])->name('verification.send');
    Route::post('password-reset-link', [PasswordResetController::class, 'sendPasswordResetLink'])->name('password-reset-link');
    Route::post('password-reset', [PasswordResetController::class, 'passwordReset'])->name('password-reset');
});

// GET, PUT, PATCH, DELETE, POST, HEAD (CORS), OPTIONS
Route::apiResource('users', UserController::class);
Route::apiResource('sales', UserSalesController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('sales_product', SalesProductController::class);


