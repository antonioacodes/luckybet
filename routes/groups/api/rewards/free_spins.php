<?php

use App\Http\Controllers\RewardController;

Route::post('/claim-free-spins', [RewardController::class, 'claimFreeSpins']);
