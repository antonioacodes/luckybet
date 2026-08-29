<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\WazerPayController;

Route::prefix('wazerpay')->group(function () {
    // Criar QRCode PIX (depósito)
    Route::post('qrcode-pix', [WazerPayController::class, 'getQRCodePix']);

    // Webhook/callback WazerPay (charge.paid, charge.failed etc.)
    Route::any('webhook', [WazerPayController::class, 'webhook']);

    // Consulta de status via polling (igual BsPay)
    Route::post('consult-status-transaction', [WazerPayController::class, 'consultStatusTransactionPix']);
});
