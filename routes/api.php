<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SalesProductController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// GET, PUT, PATCH, DELETE, POST, HEAD (CORS), OPTIONS
Route::apiResource('users', UserController::class);
Route::apiResource('sales', UserSalesController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('sales_product', SalesProductController::class);
Route::post('firebase-login', [LoginController::class, 'signInWithEmailAndPassword']);
Route::post('login', [LoginController::class, 'tokenExchange']);
Route::get('logout', LogoutController::class);
