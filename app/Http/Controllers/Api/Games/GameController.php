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
    if ($game->distribution === 'igamingplay') {
        try {
            return $this->launchGameIgamingPlay($request);
        } catch (\Throwable $e) {
            \Log::error('Erro ao lançar jogo iGamingPlay', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to launch game'], 500);
        }
    }
    return response()->json(['error' => 'Game provider not supported'], 422);
}

    private function configuredGameDistribution(): ?string
    {
        $keys = GamesKey::first();

        if ($keys && $keys->playfiver_code && $keys->playfiver_token && $keys->playfiver_secret) {
            return 'playfiver';
        }

        if ($keys && $keys->igamingplay_token && $keys->igamingplay_callback_token) {
            return 'igamingplay';
        }

        return null;
    }

    public function featured()
    {
        $distribution = $this->configuredGameDistribution();

        if (!$distribution) {
            return response()->json(['featured_games' => []]);
        }

        $providers = Provider::query()
            ->where('status', 1)
            ->where('distribution', $distribution)
            ->whereHas('featuredGames', fn ($query) => $query->where('distribution', $distribution))
            ->with(['featuredGames' => function ($query) use ($distribution) {
                $query->where('distribution', $distribution)->limit(8);
            }])
            ->get();

        $featuredGames = $providers->flatMap(function ($provider) {
            return $provider->featuredGames->each(fn ($game) => $game->setAppends([]));
        })->values();

        return response()->json(['featured_games' => $featuredGames]);
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
    public function search(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if (mb_strlen($term) < 3) {
            return response()->json([
                'games' => [],
                'minimum_characters' => 3,
            ]);
        }

        $distribution = $this->configuredGameDistribution();

        if (!$distribution) {
            return response()->json(['games' => []]);
        }

        $searchPattern = '%' . $term . '%';
        $games = Game::query()
            ->select(['id', 'provider_id', 'game_code', 'game_name', 'cover', 'distribution', 'is_featured', 'views'])
            ->where('status', 1)
            ->where('distribution', $distribution)
            ->whereHas('provider', function ($query) use ($distribution) {
                $query->where('status', 1)
                    ->where('distribution', $distribution);
            })
            ->where(function ($query) use ($searchPattern) {
                $query->where('game_name', 'like', $searchPattern)
                    ->orWhere('game_code', 'like', $searchPattern);
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('views')
            ->limit(12)
            ->get();

        $games->each(fn ($game) => $game->setAppends([]));

        return response()->json(['games' => $games]);
    }

    public function index()
    {
        $distribution = $this->configuredGameDistribution();

        if (!$distribution) {
            return response()->json(['providers' => []]);
        }

        $providers = Provider::query()
            ->where('status', 1)
            ->where('distribution', $distribution)
            ->whereHas('games', fn ($query) => $query->where('distribution', $distribution))
            ->with(['games' => function ($query) use ($distribution) {
                $query->where('distribution', $distribution)->limit(8);
            }])
            ->orderBy('name', 'desc')
            ->get();

        $providers->each(function ($provider) {
            $provider->games->each(fn ($game) => $game->setAppends([]));
        });

        return response()->json(['providers' => $providers]);
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
