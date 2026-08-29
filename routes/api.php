<?php

use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Wallet\DepositController;
use App\Http\Controllers\Api\Missions\MissionController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\Api\CashbackController;
use App\Http\Controllers\Api\Games\Original\MinesController;
use App\Http\Controllers\Api\Games\Original\CrashController;

//JOGOS ORIGINAIS
Route::middleware(['auth:api'])->group(function () {
    // Rotas Exclusivas do Mines Original
    Route::prefix('games/mines')->group(function () {
        Route::post('/play', [MinesController::class, 'create']);   // Começar jogo
        Route::post('/reveal', [MinesController::class, 'reveal']); // Clicar no quadrado
        Route::post('/cashout', [MinesController::class, 'cashout']); // Parar e sacar
    });
  	// Rotas Exclusivas do Crash Original
  	    Route::prefix('games/crash')->group(function () {
        Route::post('/play', [CrashController::class, 'play']);
        Route::post('/cashout', [CrashController::class, 'cashout']);
        Route::post('/finish', [CrashController::class, 'finish']);
    });
});
//---------------------------------------------------------------

Route::middleware('auth:api')->get('/profile/rewards', [\App\Http\Controllers\Api\Profile\VipController::class, 'userRewards']);
Route::middleware('auth:api')->get('/profile/deposits/recent', [DepositController::class, 'hasRecentDeposit']);
Route::middleware('auth:api')->any('/rewards/claim-free-spins', [\App\Http\Controllers\RewardController::class, 'claimFreeSpins']);
Route::middleware('auth:api')->any('/roulette/claim-prize', [\App\Http\Controllers\RewardController::class, 'claimPrize']);
Route::middleware('auth:api')->get('user_rewards/check/{gameId}', [RewardController::class, 'checkGameReward']);
Route::middleware('auth:api')->post('user_rewards/activate/{rewardId}', [RewardController::class, 'activateGameReward']);
Route::middleware('auth:api')->post('/games/sport/launch', [\App\Http\Controllers\Api\Games\GameController::class, 'launchSportGame']);

Route::middleware('auth:api')->get('/cashback/status', [CashbackController::class, 'getStatus']);
Route::middleware('auth:api')->post('/cashback/claim', [CashbackController::class, 'claim']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* ROTA DA ROLETA GRÁTIS*/
Route::prefix('roulette')
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/api/roulette/index.php');
    });


    include_once(__DIR__ . '/groups/api/missions/mission.php');;
    include_once(__DIR__ . '/groups/api/missions/missionuser.php');;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    include_once(__DIR__ . '/groups/api/auth/auth.php');
});

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::prefix('profile')
        ->group(function ()
        {
            include_once(__DIR__ . '/groups/api/profile/profile.php');
            include_once(__DIR__ . '/groups/api/profile/affiliates.php');
            include_once(__DIR__ . '/groups/api/profile/wallet.php');
            include_once(__DIR__ . '/groups/api/profile/likes.php');
            include_once(__DIR__ . '/groups/api/profile/favorites.php');
            include_once(__DIR__ . '/groups/api/profile/recents.php');
            include_once(__DIR__ . '/groups/api/profile/vip.php');

        });

    Route::prefix('wallet')
        ->group(function ()
        {
            include_once(__DIR__ . '/groups/api/wallet/deposit.php');
            include_once(__DIR__ . '/groups/api/wallet/withdraw.php');
        });

});


Route::prefix('categories')
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/api/categories/index.php');;
    });

include_once(__DIR__ . '/groups/api/games/index.php');
include_once(__DIR__ . '/groups/api/gateways/digitopay.php');
include_once(__DIR__ . '/groups/api/gateways/suitpay.php');
include_once(__DIR__ . '/groups/api/gateways/bspay.php');
include_once(__DIR__ . '/groups/api/gateways/wazerpay.php');

Route::prefix('search')
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/api/search/search.php');
    });

Route::prefix('profile')
    ->group(function ()
    {
        Route::post('/getLanguage', [ProfileController::class, 'getLanguage']);
        Route::put('/updateLanguage', [ProfileController::class, 'updateLanguage']);
    });

Route::prefix('providers')
    ->group(function ()
    {

    });


Route::prefix('settings')
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/api/settings/settings.php');
        include_once(__DIR__ . '/groups/api/settings/banners.php');
        include_once(__DIR__ . '/groups/api/settings/currency.php');
        include_once(__DIR__ . '/groups/api/settings/bonus.php');
    });

// LANDING SPIN
Route::prefix('spin')
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/api/spin/index.php');
    })
    ->name('landing.spin.');
