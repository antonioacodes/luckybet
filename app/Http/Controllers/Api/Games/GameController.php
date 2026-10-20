<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameFavorite;
use App\Models\GameLike;
use App\Models\GamesKey;
use App\Models\Gateway;
use App\Models\Provider;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Providers\iGamingplayTrait;
use App\Traits\Providers\PlayFiverTrait;

class GameController extends Controller
{
    // 🔥 USAR TODAS AS TRAITS
    use iGamingplayTrait, PlayFiverTrait;

    /**
     * 🎮 LANÇAR JOGO (método principal chamado pelo frontend)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
public function show(Request $request)
{
    $request->validate(['game_code' => 'required|string']);
    $user = Auth::guard('api')->user();
    if (!$user) return response()->json(['error' => 'Unauthenticated'], 401);
    $game = Game::with('provider')->where('game_code', $request->game_code)->first();
    if (!$game || !$game->status) return response()->json(['error' => 'Game not found'], 404);
    if ($game->distribution === 'playfiver') return $this->launchGamePlayFiver($game, $user);
    if ($game->distribution === 'igamingplay') return $this->launchGameIgamingPlay($request);
    return response()->json(['error' => 'Game provider not supported'], 422);
}

    public function featured()
    {
        $featured_games = Game::with(['provider'])
            ->where('is_featured', 1)
            ->where('status', 1)
            ->get();
        return response()->json(['featured_games' => $featured_games]);
    }
    /**
     * 🎰 MÉTODO ESPECÍFICO PARA iGAMINGPLAY
     * 
     * Este método está na trait IgamingPlayTrait,
     * mas vamos garantir que existe aqui também
     */
    
public function getGameById($id)
{
    $game = Game::with('provider')->find($id);

    if (!$game) {
        return response()->json([
            'status' => false,
            'message' => 'Jogo não encontrado'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'game' => $game
    ]);
}

  
  	private function getGameUrl($game, $user)
    {
        // Este método está implementado na trait IgamingPlayTrait
        // Chama self::launchGame() da trait
        return self::launchGame($game->game_code, $user->id);
    }

    /**
     * 📋 LISTAR JOGOS (método que você já tem)
     */
    public function index()
    {
        $providers = Provider::with(['games', 'games.provider'])
            ->whereHas('games')
            ->orderBy('name', 'desc')
            ->where('status', 1)
            ->get();

        return response()->json(['providers' =>$providers]);
    }
  
   public function allGames(Request $request)
    {
        $query = Game::query()->with(['provider', 'categories']);
        if (! empty($request->provider) && $request->provider != 'all') {
            $query->where('provider_id', $request->provider);
        }
        if (! empty($request->category) && $request->category != 'all') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        if (isset($request->searchTerm) && ! empty($request->searchTerm) && strlen($request->searchTerm) > 2) {
            $query->whereLike(
                ['game_code', 'game_name', 'description', 'distribution', 'provider.name'],
                $request->searchTerm
            );
        } else {
            $query->orderBy('views', 'desc');
        }
        $games = $query->where('status', 1)
            ->paginate(12)
            ->appends(request()->query());
        return response()->json(['games' => $games]);
    }
  

    public function webhookiGamingplayMethod(Request $request)   
    { 
        return self::webhookIgamingPlayAPI($request); 
    }
  
}
