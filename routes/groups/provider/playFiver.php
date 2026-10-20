<?php

use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;

Route::post('/playfiver/webhook', [GameController::class, 'webhookPlayFiver']);


Route::middleware('auth:api')->post('/playfiver/free-bonus', [GameController::class, 'schedulePlayFiverFreeBonus']);
