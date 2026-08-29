<?php

use App\Http\Controllers\Api\Missions\MissionController;
use Illuminate\Support\Facades\Route;

// rota pública: listar missões
Route::get('missions', [MissionController::class, 'index']);

// rotas protegidas com JWT
Route::middleware(['auth.jwt'])->group(function () {

    Route::prefix('missions')->group(function () {
        Route::post('{id}/participate', [MissionController::class, 'participate']);
        Route::post('{id}/claim', [MissionController::class, 'claimReward'])->name('missions.claim');
        Route::post('update-progress', [MissionController::class, 'updateProgress']);
    });
});
