<?php
use App\Http\Controllers\Api\Missions\MissionController;
use App\Models\Game;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|Sme
*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/age-verification', [App\Http\Controllers\AgeVerificationController::class, 'verify'])->name('age.verification');
Route::post('/salvar-cpf', 'App\Http\Controllers\CpfController@salvar')->name('salvar.cpf')->middleware('auth');

// Em routes/web.php
Route::get('clear', function() {
    Artisan::call('optimize:clear');
    return back()->with('success', 'Cache limpo com sucesso!');
})->name('clear.cache');


Route::prefix('api')->middleware(['web'])->group(function () {
    // Missões - Listar (PÚBLICO)
    Route::get('/missions', [MissionController::class, 'index']);
});

// ============================================
// ROTAS AUTENTICADAS DE MISSÕES
// ============================================

Route::prefix('api')->middleware(['web', 'auth'])->group(function () {
    Route::post('/missions/{id}/participate', [MissionController::class, 'participate']);
    Route::post('/missions/{id}/claim', [MissionController::class, 'claimReward']);
    Route::post('/missions/update-progress', [MissionController::class, 'updateProgress']);
});

// GAMES PROVIDER
include_once(__DIR__ . '/groups/provider/playFiver.php');
require __DIR__.'/groups/provider/igamingplay.php';
include_once(__DIR__ . '/groups/provider/games.php');
include_once(__DIR__ . '/groups/provider/drakon.php');
// include_once(__DIR__ . '/groups/provider/venix.php');
// include_once(__DIR__ . '/groups/provider/salsa.php');


// GATEWAYS
// DigitoPay desativado: controller removido do projeto.
// include_once(__DIR__ . '/groups/gateways/sharkpay.php');
// include_once(__DIR__ . '/groups/gateways/mercadopago.php');
include_once(__DIR__ . '/groups/gateways/suitpay.php');
include_once(__DIR__ . '/groups/gateways/bspay.php');
include_once(__DIR__ . '/groups/gateways/wazerpay.php');

/// SOCIAL
include_once(__DIR__ . '/groups/auth/social.php');

// APP
include_once(__DIR__ . '/groups/layouts/app.php');

