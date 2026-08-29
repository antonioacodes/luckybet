<?php

namespace App\Http\Controllers\Api\Missions;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionUser;
use App\Models\Game;
use Carbon\Carbon;
use App\Models\UserReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MissionController extends Controller
{
    public function index(Request $request)
    {
        try {
            
            $isLoggedIn = Auth::guard('api')->check();
            $userId = $isLoggedIn ? Auth::guard('api')->id() : null;
            $now = Carbon::now();

            // Buscar todas as missões ativas/futuras
            $allMissions = Mission::where(function($query) use ($now) {
                $query->where(function($q) use ($now) {
                    $q->where('challenge_start_date', '<=', $now)
                      ->where('challenge_end_date', '>=', $now);
                })
                ->orWhere(function($q) use ($now) {
                    $q->where('challenge_start_date', '>', $now);
                });
            })
            ->orderBy('challenge_start_date', 'asc')
            ->get();
            
            // ✅ SEPARAR missão em destaque das normais
            $featuredMission = null;
            $regularMissions = collect();
            
            foreach ($allMissions as $mission) {
                $processed = $this->processMission($mission, $userId, $isLoggedIn, $now);
                
                if ($mission->is_featured) {
                    // ✅ Se é destaque, vai apenas para featured
                    $featuredMission = $processed;
                } else {
                    // Se não é destaque, vai para lista normal
                    $regularMissions->push($processed);
                }
            }
            
            
            return response()->json([
                'status' => true,
                'featured' => $featuredMission, // ✅ Missão em destaque separada
                'missions' => $regularMissions->values(), // ✅ Missões normais
                'is_logged_in' => $isLoggedIn,
                'user_id' => $userId,
                'total' => ($featuredMission ? 1 : 0) + $regularMissions->count(),
            ]);
            
        } catch (\Exception $e) {
            
            return response()->json([
                'status' => false,
                'error' => 'Erro ao buscar missões'
            ], 500);
        }
    }

 private function processMission($mission, $userId, $isLoggedIn, $now)
{
    $game = null;
    if ($mission->challenge_gameid) {
        $game = Game::where('game_code', $mission->challenge_gameid)->first();
    }

    $status = 'upcoming';
    if ($now->between($mission->challenge_start_date, $mission->challenge_end_date)) {
        $status = 'active';
    } elseif ($now->gt($mission->challenge_end_date)) {
        $status = 'expired';
    }

    $userProgress = null;
    if ($isLoggedIn && $userId) {
      	        Log::info('Buscando progresso da missão', [
            'user_id' => $userId,
            'mission_id' => $mission->id,
            'is_logged_in' => $isLoggedIn
        ]);
      
        $missionUser = MissionUser::where('user_id', $userId)
            ->where('mission_id', $mission->id)
            ->first();

          Log::info('Resultado da busca', [
        'found' => $missionUser ? 'SIM' : 'NÃO',
        'mission_user_id' => $missionUser ? $missionUser->id : null,
        'progress' => $missionUser ? $missionUser->progress : null,
        'completed' => $missionUser ? $missionUser->completed : null,
        'claimed' => $missionUser ? $missionUser->claimed : null,
    ]);
      
        if ($missionUser) {
            // ATUALIZAR O PROGRESSO ANTES DE RETORNAR
            $this->updateMissionProgress($missionUser, $mission);
            $missionUser->refresh();

            $userProgress = [
                'participated' => true,
                'progress' => floatval($missionUser->progress ?? 0),
                'completed' => (bool) $missionUser->completed,
                'claimed' => (bool) $missionUser->claimed,
                'claimed_at' => $missionUser->claimed_at,
            ];
        }
    }

    $missionImage = null;
    if (!empty($mission->challenge_image)) {
        $missionImage = filter_var($mission->challenge_image, FILTER_VALIDATE_URL) 
            ? $mission->challenge_image 
            : asset('storage/' . $mission->challenge_image);
    } elseif ($game) {
        if (!empty($game->banner)) {
            $missionImage = asset('storage/' . $game->banner);
        } elseif (!empty($game->cover)) {
            $missionImage = asset('storage/' . $game->cover);
        }
    }

    $description = !empty($mission->challenge_description) 
        ? $mission->challenge_description 
        : "Complete o desafio e ganhe recompensas incriveis!";

    $rules = !empty($mission->challenge_rules) 
        ? $mission->challenge_rules 
        : "Jogue o jogo especificado e atinja a meta do desafio";

    return [
        'id' => $mission->id,
        'title' => !empty($mission->challenge_name) ? $mission->challenge_name : "Missao #{$mission->id}",
        'description' => $description,
        'rules' => $rules,
        'type' => $mission->challenge_type ?? 'spins',
        'type_label' => $this->getTypeLabel($mission->challenge_type),
        'reward' => floatval($mission->challenge_bonus ?? 0),
        'reward_formatted' => 'R$ ' . number_format($mission->challenge_bonus ?? 0, 2, ',', '.'),
        'reward_display' => $this->formatReward($mission),
        'reward_type' => $mission->reward_type ?? 'bonus',
        'reward_freespins' => intval($mission->reward_freespins ?? 0),
        'target' => floatval($mission->challenge_total ?? 1),
        'target_formatted' => $this->formatTarget($mission),
        'game_code' => $mission->challenge_gameid,
        'game_name' => $game ? $game->game_name : ($mission->challenge_gameid ?? 'Qualquer jogo'),
        'image' => $missionImage,
        'game_image' => $missionImage,
        'provider_code' => $game ? $game->provider_code : $mission->challenge_provider,
        'provider_name' => $game && $game->provider ? $game->provider->name : 'Provedor',
        'is_featured' => (bool) $mission->is_featured,
        'status' => $status,
        'status_label' => $this->getStatusLabel($status),
        'start_date' => $mission->challenge_start_date->toIso8601String(),
        'end_date' => $mission->challenge_end_date->toIso8601String(),
        'time_to_start' => $status === 'upcoming' ? $now->diffInSeconds($mission->challenge_start_date, false) : 0,
        'time_to_end' => $status === 'active' ? $now->diffInSeconds($mission->challenge_end_date, false) : 0,
        'user_progress' => $userProgress,
        'is_logged_in' => $isLoggedIn,
        'currency' => $mission->challenge_currency ?? 'BRL',
        'link' => $mission->challenge_link ?? null,
    ];
}


    /**
     * Formatar prêmio para exibição
     */
    private function formatReward($mission)
    {
        $rewardType = $mission->reward_type ?? 'bonus';
        $bonus = floatval($mission->challenge_bonus ?? 0);
        $freespins = intval($mission->reward_freespins ?? 0);
        
        if ($rewardType === 'freespins' && $freespins > 0) {
            return $freespins . ' Rodadas Grátis';
        }
        
        if ($bonus > 0) {
            return 'R$ ' . number_format($bonus, 2, ',', '.');
        }
        
        return 'Sem recompensa';
    }

    /**
     * Formatar target
     */
    private function formatTarget($mission)
    {
        $type = $mission->challenge_type ?? 'spins';
        $total = floatval($mission->challenge_total ?? 1);
        
        switch ($type) {
            case 'wallet':
            case 'deposit':
            case 'bet':
            case 'wager':
                return 'R$ ' . number_format($total, 2, ',', '.');
                
            case 'spins':
            case 'plays':
            case 'rounds':
                return number_format($total, 0, '', '.') . ' ' . ($total == 1 ? 'rodada' : 'rodadas');
                
            case 'win':
            case 'wins':
                return number_format($total, 0, '', '.') . ' ' . ($total == 1 ? 'vitória' : 'vitórias');
                
            case 'multiplier':
                return number_format($total, 2, ',', '.') . 'x';
                
            default:
                return number_format($total, 0, '', '.');
        }
    }

    private function getTypeLabel($type)
    {
        $labels = [
            'wallet' => 'Apostar valor',
            'deposit' => 'Depositar',
            'bet' => 'Apostar',
            'wager' => 'Apostar',
            'spins' => 'Rodadas',
            'plays' => 'Jogadas',
            'win' => 'Vitórias',
            'multiplier' => 'Multiplicador',
        ];
        return $labels[$type] ?? ucfirst($type);
    }

    private function getStatusLabel($status)
    {
        return [
            'active' => 'Ativa',
            'upcoming' => 'Em breve',
            'expired' => 'Expirada',
        ][$status] ?? $status;
    }

public function participate(Request $request, $id)
{
    try {
        // ✅ CORRIGIDO: Obter o usuário autenticado de forma robusta
        $user = Auth::guard('api')->user() ?? Auth::guard('web')->user();
        $userId = $user ? $user->id : null;

        if (!$userId) {
            return response()->json([
                'status' => false,
                'error' => 'Você precisa estar logado para participar.'
            ], 401);
        }

        $mission = Mission::findOrFail($id);
        $now = Carbon::now();

        if ($now->lt($mission->challenge_start_date) || $now->gt($mission->challenge_end_date)) {
            return response()->json([
                'status' => false,
                'error' => 'Esta missão não está ativa no momento.'
            ], 400);
        }

        $existing = MissionUser::where('user_id', $userId)
            ->where('mission_id', $id)
            ->first();

        if ($existing) {
            $gameUrl = $this->getGameUrl($mission);
            return response()->json([
                'status' => true,
                'message' => 'Você já está participando desta missão!',
                'game_url' => $gameUrl,
                'redirect' => true
            ]);
        }

        MissionUser::create([
            'user_id' => $userId,
            'mission_id' => $id,
            'progress' => 0,
            'rounds' => $mission->reward_freespins,
            'rewards' =>$mission->challenge_bonus,
            'status' => true,
            'completed' => false,
            'claimed' => false,
        ]);

        $gameUrl = $this->getGameUrl($mission);
        return response()->json([
            'status' => true,
            'message' => 'Você entrou na missão! Boa sorte!',
            'game_url' => $gameUrl,
            'redirect' => true
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Missão não encontrada ao tentar participar: ' . $e->getMessage(), ['mission_id' => $id]);
        return response()->json([
            'status' => false,
            'error' => 'Missão não encontrada.'
        ], 404);
    } catch (\Exception $e) {
        Log::error('Erro inesperado ao participar da missão: ' . $e->getMessage(), [
            'mission_id' => $id,
            'user_id' => $userId ?? 'N/A',
            'stack' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'status' => false,
            'error' => 'Ocorreu um erro interno ao participar da missão.'
        ], 500);
    }
}


public function claimReward(Request $request, $id)
{
    try {
        $user = auth()->user();

        if (!$user) {
            Log::warning('⚠️ CLAIM SEM AUTENTICAÇÃO', ['mission_id' => $id, 'headers' => $request->headers->all()]);
            return response()->json([
                'status' => false,
                'message' => 'Usuário não autenticado.',
            ], 401);
        }

        $mission = Mission::find($id);
        if (!$mission) {
            return response()->json(['status' => false, 'message' => 'Missão não encontrada.'], 404);
        }

        $missionUser = MissionUser::where('user_id', $user->id)
            ->where('mission_id', $id)
            ->first();

        if (!$missionUser) {
            return response()->json(['status' => false, 'message' => 'Progresso da missão não encontrado.'], 404);
        }

        if (!$missionUser->completed) {
            return response()->json(['status' => false, 'message' => 'Missão ainda não concluída.'], 400);
        }

        if ($missionUser->claimed) {
            return response()->json(['status' => false, 'message' => 'Recompensa já resgatada.'], 400);
        }

        $game = Game::where('game_code', $mission->challenge_gameid)->first();
        if (!$game) {
            Log::error('Jogo da missão não encontrado para resgate.', [
                'mission_id' => $id,
                'game_code' => $mission->challenge_gameid,
            ]);
            return response()->json([
                'status' => false,
                'error' => 'Jogo da recompensa não encontrado.'
            ], 404);
        }

        DB::beginTransaction();

        // 🔸 Marca missão como resgatada
        $missionUser->claimed = true;
        $missionUser->claimed_at = Carbon::now();
        $missionUser->save();

        // 🔸 Determina tipo de recompensa
        $rewardType   = $mission->reward_type ?? 'bonus';
        $rewardAmount = $mission->challenge_bonus ?? 0;
        $rewardRounds = $mission->reward_freespins ?? 0;
        $providerId   = $game->provider_id ?? null;
        $gameId       = $game->id ?? null;
        $gameCode     = $game->game_code ?? null;

        // 🔸 Insere dado em user_rewards
        $reward = [
            'user_id'     => $user->id,
            'provider_id' => $providerId,
            'game_id'     => $gameId,
            'reward_type' => $rewardType,
            'reward_bonus'=> $rewardType === 'bonus' ? $rewardAmount : null,
            'rounds'      => $rewardType === 'freespins' ? $rewardRounds : 0,
            'game_code'   => $gameCode,
            'created_at'  => now(),
        ];

        DB::table('user_rewards')->insert($reward);

        // 🔸 Se for bônus, aplica na carteira imediatamente (ajuste para sua lógica)
        if ($rewardType === 'bonus') {
            DB::table('wallets')->where('user_id', $user->id)->increment('balance_bonus', $rewardAmount);
        }

        DB::commit();

        Log::info('🏆 Recompensa salva com sucesso', [
            'mission_id' => $id,
            'user_id'    => $user->id,
            'reward'     => $reward,
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Recompensa resgatada com sucesso!',
            'reward'    => $reward,
            'missionId' => $id,
        ]);

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('❌ Erro ao resgatar recompensa', [
            'mission_id' => $id,
            'error'      => $e->getMessage(),
            'trace'      => $e->getTraceAsString(),
        ]);
        return response()->json([
            'status'  => false,
            'message' => 'Erro interno ao resgatar recompensa.',
        ], 500);
    }
}





    public function updateProgress(Request $request)
    {
        return response()->json(['status' => true]);
    }

  
  private function updateMissionProgress($missionUser, $mission)
  {
      if ($missionUser->completed) {
          return;
      }

      $userId = $missionUser->user_id;
      $gameCode = $mission->challenge_gameid;
      $startDate = $missionUser->created_at;
      $type = $mission->challenge_type;
      $target = floatval($mission->challenge_total);
      $progress = 0;

      if ($type === 'wallet' || $type === 'bet' || $type === 'wager') {
          $progress = \App\Models\Order::where('user_id', $userId)
              ->where('game_uuid', $gameCode)
              ->where('type', 'bet')
              ->where('created_at', '>=', $startDate)
              ->sum('amount');
      } elseif ($type === 'spins' || $type === 'plays' || $type === 'rounds') {
          $progress = \App\Models\Order::where('user_id', $userId)
              ->where('game_uuid', $gameCode)
              ->where('type', 'bet')
              ->where('created_at', '>=', $startDate)
              ->count();
      }

      $missionUser->progress = $progress;

      if ($progress >= $target) {
          $missionUser->completed = true;
          $missionUser->completed_at = Carbon::now();
      }

      $missionUser->save();
  }

  /**
   * Obter URL do jogo
   */
  private function getGameUrl($mission)
  {
      if (!empty($mission->challenge_link)) {
          return $mission->challenge_link;
      }

      if (!empty($mission->challenge_gameid)) {
          $game = Game::where('game_code', $mission->challenge_gameid)->first();
          if ($game && $game->provider_id && $game->game_id) {
              return url("/games/play/" . $game->id . "/" . $game->game_id);
          }
      }

      return url('/casino');
  }

}
