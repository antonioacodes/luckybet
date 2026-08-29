<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\Providers\iGamingplayTrait;
use Illuminate\Support\Facades\Log;

class RewardController extends Controller
{
    use iGamingplayTrait;

    public function claimPrize(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuário não autenticado.'], 401);
        }

        $data = $request->only(['prize_index', 'prize_name', 'prize_value', 'spin_date']);
        \Log::info('🔔 Método claimPrize chamado com dados:', $data);

        // Mapear tipos de prêmios para rodadas
        $map = [
            /*'3 Giros Grátis' => ['reward_type' => 'comum', 'rounds' => 3],
            '5 Giros Grátis' => ['reward_type' => 'raro', 'rounds' => 5],
            '10 Giros Grátis' => ['reward_type' => 'épico', 'rounds' => 10],
            '15 Giros Grátis' => ['reward_type' => 'lendário', 'rounds' => 15]*/
         	'Sem Prêmio' => ['reward_type' => 'comum', 'rounds' => 0],
        ];

        $prizeName = $data['prize_name'] ?? null;
        if (isset($map[$prizeName]) && $map[$prizeName]) {
            // É um prêmio com rodadas grátis
            return $this->creditFreeSpins($user, $map[$prizeName]['reward_type'], $map[$prizeName]['rounds']);
        }

        return response()->json(['success' => true, 'message' => 'Prêmio registrado. (sem efeito automático)']);
    }

    public function claimFreeSpins(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            Log::warning('Tentativa de resgate sem usuário autenticado.');
            return response()->json(['status' => false, 'msg' => 'Usuário não autenticado.']);
        }

        $rewardType = $request->input('reward_type');

        $roundsMap = [
            'comum' => 3,
            'raro' => 5,
            'épico' => 10,
            'lendário' => 15,
        ];

        if (!isset($roundsMap[$rewardType])) {
            Log::warning('Tipo de recompensa inválido recebido.', ['reward_type' => $rewardType]);
            return response()->json(['status' => false, 'msg' => 'Tipo de recompensa inválido.']);
        }

        return $this->creditFreeSpins($user, $rewardType, $roundsMap[$rewardType]);
    }

    protected function creditFreeSpins($user, $rewardType, $rounds)
    {
        self::credencialFiverPlay();

        // Escolher jogo válido aleatoriamente
        $game = DB::table('games')
            ->where('has_freespins', 1)
            ->where('distribution', 'play_fiver')
            ->inRandomOrder()
            ->first();

        if (!$game) {
            return response()->json(['success' => false, 'message' => 'Nenhum jogo com giros disponível']);
        }

        $payload = [
            'agent_token' => self::$tokenPlayFiver,
            'secret_key'  => self::$secretPlayFiver,
            'user_code'  => $user->email,
            'game_code'  => $game->game_code,
            'rounds'     => $rounds
        ];

        $response = Http::withOptions([
            'force_ip_resolve' => 'v4' // força uso de IPv4
        ])->post('https://api.playfivers.com/api/v2/free_bonus', $payload);


        Log::info('🎯 Enviando giros grátis para iGamingPlay', [
            'user_code' => $user->email,
            'game_code' => $game->game_code,
            'rounds' => $rounds,
            'response' => $response->json()
        ]);

        if ($response->json('status')) {
            DB::table('user_rewards')->insert([
                'user_id' => $user->id,
                'reward_type' => $rewardType,
              	'game_code' => $game->game_code,
                'rounds' => $rounds,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rodadas grátis ativadas com sucesso!',
                'game' => $game->game_name,
                'rounds' => $rounds
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao ativar rodadas: ' . ($response->json('msg') ?? 'desconhecido')
        ], 500);
    }
      public function checkGameReward($gameId)
    {
        $user = auth()->user();

        // Busca uma recompensa que pertença a este jogo e esteja pendente
        // Assumindo que você salva o game_id na tabela user_rewards
        $reward = DB::table('user_rewards')
            ->where('user_id', $user->id)
            ->where('game_id', $gameId) 
            ->where('status', 'pending') // Só pega se não foi resgatado
            ->first();

        if ($reward) {
            return response()->json([
                'status' => true,
                'reward' => $reward
            ]);
        }

        return response()->json(['status' => false]);
    }

    /**
     * 2. O usuário clicou no banner: Envia para a PlayFiver e marca como usado
     */
    public function activateGameReward($rewardId)
    {
        $user = auth()->user();

        // 1. Valida a recompensa no banco
        $reward = DB::table('user_rewards')
            ->where('id', $rewardId)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$reward) {
            return response()->json(['status' => false, 'message' => 'Recompensa inválida ou já resgatada.']);
        }

        // 2. Busca as sessões ativas na API
        $activeSessions = self::getOnlineGames();

        if (!$activeSessions) {
            return response()->json(['status' => false, 'message' => 'Erro ao comunicar com o provedor de jogos.']);
        }

        // 3. Filtra a sessão do usuário para este jogo
        // Precisamos do user_code. Assumindo que você salva isso na tabela users ou gera dinamicamente.
        // Se o user_code for algo como o ID do usuário ou um campo específico:
        // Verifique nos seus logs qual user_code está sendo enviado no /game/launch.
        // Pelo log anterior parecia ser um número grande (401211519). 
        // Vou assumir que você tem esse valor em $user->user_code ou similar.

        // Tenta encontrar pelo user_code ou pelo user_name (email/login)
        $targetSession = null;

        foreach ($activeSessions as $session) {
            // Verifica se a sessão é deste usuário E deste jogo (pelo game_code)
            // Nota: A API retorna 'game_code' (string). O seu banco tem 'game_code' também.

            // Ajuste a lógica de comparação de usuário conforme seu sistema:
            // Opção A: Pelo user_code (se você tiver salvo no user)
            // Opção B: Pelo user_name (se for o login/email)

            $isUserMatch = ($session['user_name'] == $user->name || $session['user_name'] == 'user_'.$user->id); 
            // ^ Ajuste acima conforme como você cria o usuário na SlotCity ('user_1' nos logs antigos)

            if ($isUserMatch && $session['game_code'] == $reward->game_code) {
                $targetSession = $session;
                break;
            }
        }

        if (!$targetSession) {
            return response()->json([
                'status' => false, 
                'message' => 'Sessão de jogo não encontrada. Por favor, certifique-se de que o jogo está aberto e carregado na tela.'
            ]);
        }

        // 4. Envia o comando de Free Spins
        $gplayId = $targetSession['gplay_id'];
        $result = self::sendBonusCall($gplayId, $reward->rounds);

        // 5. Verifica sucesso (code 0 geralmente é sucesso nessa API)
        if (isset($result['code']) && $result['code'] === 0) {

            // Atualiza banco
            DB::table('user_rewards')
                ->where('id', $rewardId)
                ->update([
                    'status' => 'claimed',
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => true, 
                'message' => 'Rodadas enviadas com sucesso! Gire para jogar.'
            ]);
        }

        return response()->json([
            'status' => false, 
            'message' => 'Erro ao ativar rodadas: ' . ($result['message'] ?? 'Erro desconhecido')
        ]);
    }
}
