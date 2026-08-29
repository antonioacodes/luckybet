<?php

use App\Http\Controllers\Api\Wallet\DepositController;
use Illuminate\Support\Facades\Route;

Route::prefix('deposit')
    ->group(function ()
    {
        Route::get('/', [DepositController::class, 'index']);
        Route::get('/first-deposit-status', [DepositController::class, 'firstDepositStatus']);
        Route::post('/payment', [DepositController::class, 'submitPayment']);
    });

