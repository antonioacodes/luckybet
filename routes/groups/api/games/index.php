<?php

use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Games\ProviderController;

/*
| ====================================
| ROTAS PÚBLICAS (SEM AUTENTICAÇÃO)
| ====================================
*/
Route::middleware(['api'])->group(function () {
      Route::get('games/all', [GameController::class, 'index']);
    Route::get('games', [GameController::class, 'index']);
    Route::get('games/search', [GameController::class, 'search']);
    Route::get('games/single/{id}', [GameController::class, 'getGameById']);
    Route::get('games/category/{slug}', [GameController::class, 'index']);
    Route::get('games/provider/{slug}', [GameController::class, 'index']);
      Route::get('providers/{id}/games', [ProviderController::class, 'getGamesByProvider']);
});

Route::prefix('featured')
    ->group(function () {
        Route::any('/games', [GameController::class, 'featured']);
    });

Route::middleware(['auth:api'])->group(function () {
    Route::post('games/launch', [GameController::class, 'show'])->name('games.launch');
    Route::get('casinos/games', [GameController::class, 'allGames']);
});
