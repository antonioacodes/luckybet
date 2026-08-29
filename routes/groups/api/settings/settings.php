<?php
use App\Http\Controllers\Api\Settings\SettingController;
use Illuminate\Support\Facades\Route;

// DEPOIS (correto):
Route::get('/', [SettingController::class, 'index']);
Route::get('/data', [SettingController::class, 'index']); // Manter compatibilidade