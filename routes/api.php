<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\SaleSearchController;
use App\Http\Controllers\SalesPaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesProductController;
use App\Http\Controllers\UserPaymentController;
use App\Http\Controllers\UserSalesProductController;
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


Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('products-sales', UserSalesProductController::class)->names(
        [
            'index' => 'products-sales.index',
            'store' => 'products-sales.store',
            'show' => 'products-sales.show',
            'update' => 'products-sales.update',
            'destroy' => 'products-sales.destroy',
        ]
    );
    Route::apiResource('products', ProductController::class)->only(['index', 'show'])->names([
        'index' => 'products.index',
        'show' => 'products.show'
    ]);
    Route::apiResource('sales/{sale}/products', SalesProductController::class)->only(['store', 'destroy'])
        ->names([
            'store' => 'sale-products.store',
            'destroy' => 'sale-products.destroy'
        ]);
    Route::patch('sales/{sale}/products-update', [SalesProductController::class, 'update'])->name('sale-products.update');
    Route::apiResource('sales/{sale}/payments', SalesPaymentController::class)->names([
        'index' => 'sales-payments.index',
        'store' => 'sales-payments.store',
        'show' => 'sales-payments.show',
        'update' => 'sales-payments.update',
        'destroy' => 'sales-payments.destroy'
    ]);
    Route::apiResource('payments',UserPaymentController::class)->only(['index','show'])->names([
        'index'=>'payments.index',
        'show'=>'payments.show'
    ]);
    Route::get('sales-search', SaleSearchController::class)->name('sale-search.index');
    Route::get('products-search', ProductSearchController::class)->name('product-search.index');
});



