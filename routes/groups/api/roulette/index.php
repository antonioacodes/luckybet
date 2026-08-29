<?php

use App\Http\Controllers\Api\RouletteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.jwt')->group(function () {
    Route::get('/status', [RouletteController::class, 'getRouletteStatus']);
    Route::post('/spin', [RouletteController::class, 'spin']);
    Route::get('/history', [RouletteController::class, 'getSpinHistory']);
});