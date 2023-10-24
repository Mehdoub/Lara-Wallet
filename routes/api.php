<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\TransferPaymentController;
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
    Route::post('payments', [PaymentController::class, 'store']);
    Route::patch('payments/{id}/reject', [PaymentController::class, 'reject']);
    Route::patch('payments/{id}/verify', [PaymentController::class, 'verify']);
    Route::get('payments', [PaymentController::class, 'index']);
    Route::get('payments/{id}', [PaymentController::class, 'find']);

    Route::get('currencies', [CurrencyController::class, 'index']);
    Route::post('currencies', [CurrencyController::class, 'store']);
    Route::patch('currencies/{id}/activate', [CurrencyController::class, 'activate']);
    Route::patch('currencies/{id}/deactivate', [CurrencyController::class, 'deactivate']);

    Route::post('transfer-payment', [TransferPaymentController::class, 'store']);
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
