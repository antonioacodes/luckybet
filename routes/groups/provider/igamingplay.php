<?php
use App\Http\Controllers\Api\Games\GameController;
Route::prefix('api/igamingplay')->group(function () {
    // Endpoint que a SlotCity vai chamar
    Route::any('callback', [GameController::class, 'webhookiGamingplayMethod'])
        ->middleware('api');
});
