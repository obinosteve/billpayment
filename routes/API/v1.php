<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\WalletController;
use App\Http\Controllers\API\V1\PurchasesController;
use App\Http\Controllers\API\V1\TransactionsController;
use App\Http\Controllers\API\V1\AuthenticationController;
use App\Http\Controllers\API\V1\NetworkProvidersController;

Route::get('/healthCheck', function () {
    return response()->json(['msg' => 'Running fine..']);
});

// Authentication routes
Route::controller(AuthenticationController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->middleware('throttle:3,5');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Wallet routes
    Route::controller(WalletController::class)->prefix('wallet')->group(function () {
        Route::get('balance', 'checkBalance');
        Route::post('fund', 'fundWallet');
    });

    // Purchases routes
    Route::controller(PurchasesController::class)->prefix('purchase')->group(function () {
        Route::post('airtime', 'airtime');
    });

    // Transactions routes
    Route::get('transactions', TransactionsController::class);

    // Network providers routes
    Route::get('providers', NetworkProvidersController::class);
});
