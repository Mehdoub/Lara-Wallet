<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\CreditTransferController;
use App\Http\Controllers\Api\V1\AuthController;
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

Route::group([
    'middleware' => ['api', 'auth'],
    'prefix' => 'v1'
], function () {
    Route::get('payments', [PaymentController::class, 'index']);
    Route::get('payments/{payment}', [PaymentController::class, 'show']);
    Route::post('payments', [PaymentController::class, 'store']);
    Route::patch('payments/{payment}/reject', [PaymentController::class, 'reject']);
    Route::patch('payments/{payment}/verify', [PaymentController::class, 'verify']);
    Route::delete('payments/{payment}/destroy', [PaymentController::class, 'destroy']);

    Route::get('currencies', [CurrencyController::class, 'index']);
    Route::post('currencies', [CurrencyController::class, 'store']);
    Route::patch('currencies/{currency}/activate', [CurrencyController::class, 'activate']);
    Route::patch('currencies/{currency}/deactivate', [CurrencyController::class, 'deactivate']);

    Route::post('credit-transfer', [CreditTransferController::class, 'transfer']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('getme', [AuthController::class, 'getme']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});
