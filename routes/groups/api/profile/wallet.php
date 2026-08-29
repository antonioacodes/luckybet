<?php
use App\Http\Controllers\Api\Profile\WalletController;
use Illuminate\Support\Facades\Route;

// Adicionar esta rota que o DepositWidget espera:
Route::get('/', [WalletController::class, 'index']); // Para /api/profile/wallet

Route::prefix('wallet')
    ->group(function ()
    {
        Route::get('/', [WalletController::class, 'index']);
    });
    
Route::prefix('mywallet')
    ->group(function ()
    {
        Route::get('/', [WalletController::class, 'myWallet']);
        Route::post('/{id}', [WalletController::class, 'setWalletActive']);
    });