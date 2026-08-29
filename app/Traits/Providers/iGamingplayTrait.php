<?php

namespace App\Traits\Providers;

use App\Models\GamesKey;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Helpers\Core;
use Illuminate\Http\JsonResponse;

trait IgamingPlayTrait
{
    /* -----------------------------------------------------------------
     *  CREDENCIAIS & CONFIGURAÇÃO
     * ----------------------------------------------------------------- */
    protected static $token;         // Bearer token
    protected static $callbackToken; // Callback-Token (se houver na nova API)

    private static function loadCredentials(): void
    {
        $setting = GamesKey::firstOrFail();
        self::$token = $setting->igamingplay_token; // Certifique-se que este é o NOVO token
        self::$callbackToken = $setting->igamingplay_callback_token;
    }

    private static function baseUrl(): string
    {
        // Nova URL base da ScorpioPlay
        return rtrim(env('IGAMINGPLAY_BASE_URL', 'https://new-api.scorpioplay.com'), '/');
    }

    /* -----------------------------------------------------------------
     *  0️⃣  CRIAÇÃO DE JOGADOR (Refatorado para /v1/player/create)
     * ----------------------------------------------------------------- */
    private static function getOrCreateSlotCityUser(int $userId): ?int
    {
        self::loadCredentials();

        // Na nova API, o identificador principal é o playerExternalId.
        // Vamos usar "user_{id}" para garantir unicidade e compatibilidade.
        $externalId = 'user_' . $userId;

        $url = self::baseUrl() . '/v1/player/create';

        $payload = [
            'playerExternalId' => $externalId
        ];

        Log::info('🚀 Criando/Verificando jogador na ScorpioPlay', [
            'user_id' => $userId,
            'payload' => $payload
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . self::$token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($url, $payload);

            $body = $response->json();

            // A nova API retorna "success": true e "data": { "playerCode": ... }
            if ($response->successful() && ($body['success'] ?? false) === true) {
                $playerCode = $body['data']['playerCode'] ?? null;

                Log::info('✅ Jogador sincronizado com sucesso', [
                    'external_id' => $externalId,
                    'player_code' => $playerCode
                ]);

                return $playerCode; // Retorna o código interno da API (se necessário salvar)
            }

            Log::error('❌ Erro na resposta da criação de jogador', ['body' => $body]);
            throw new \Exception("API Error: " . ($body['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            Log::error('❌ Exception ao criar jogador ScorpioPlay', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /* -----------------------------------------------------------------
     *  1️⃣  LAUNCH GAME (Refatorado para /v1/game/launch)
     * ----------------------------------------------------------------- */
    private static function launchGameIgamingPlay(Request $request): JsonResponse
    {
        self::loadCredentials();
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $gameCode = $request->input('game_code'); // O código do jogo (ex: vswaysdogs)

        // Busca o jogo no banco para pegar o provider_id correto
        $game = Game::where('game_code', $gameCode)
            ->where('distribution', 'igamingplay')
            ->first();

        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        // 1. Garante que o jogador existe na API nova
        try {
            $playerInternalCode = self::getOrCreateSlotCityUser($user->id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Player creation failed', 'msg' => $e->getMessage()], 500);
        }

        // 2. Prepara o Payload da Nova API
        // A nova API exige: playerExternalId, providerId, gameCode, language, currency, rtp
        $payload = [
            'playerExternalId' => 'user_' . $user->id,
            'providerId' => (int) $game->provider_id, // Certifique-se que no seu DB o provider_id é o ID numérico da nova API
            'gameCode' => $game->game_code,
            'language' => 'pt', // Ou dinâmico: $user->lang ?? 'pt'
            'currency' => 'BRL', // Ou dinâmico: $user->currency ?? 'BRL'
            'returnUrl' => config('app.url') . '/lobby',
            'rtp' => 0 // 0 usa o padrão da conta
        ];

        $url = self::baseUrl() . '/v1/game/launch';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . self::$token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($url, $payload);

            $data = $response->json();

            Log::info('🎰 Launch Game Response', ['status' => $response->status(), 'data' => $data]);

            if ($response->successful() && ($data['success'] ?? false) === true) {
                return response()->json([
                    'game_url' => $data['data']['gameUrl'],
                    'game_code' => $game->game_code
                ]);
            }

            return response()->json([
                'error' => 'Failed to launch game',
                'message' => $data['message'] ?? 'Unknown error',
                'details' => $data
            ], 400);

        } catch (\Exception $e) {
            Log::error('❌ Erro fatal no Launch Game', ['msg' => $e->getMessage()]);
            return response()->json(['error' => 'Server Error', 'msg' => $e->getMessage()], 500);
        }
    }

    /* -----------------------------------------------------------------
     *  2️⃣  SYNC GAMES (Refatorado para Listar Provedores -> Jogos)
     * ----------------------------------------------------------------- */
    private static function getAllGamesFromProvider(): JsonResponse
    {
        self::loadCredentials();

        // Passo 1: Buscar lista de provedores ativos
        $urlProviders = self::baseUrl() . '/v1/provider/list';
        $responseProviders = Http::withHeaders(['Authorization' => 'Bearer ' . self::$token])->get($urlProviders);

        if (!$responseProviders->successful()) {
            return response()->json(['error' => 'Failed to fetch providers'], 500);
        }

        $providers = $responseProviders->json()['data'] ?? [];
        $allGames = [];

        // Passo 2: Para cada provedor, buscar os jogos
        foreach ($providers as $provider) {
            if (($provider['status'] ?? 0) !== 1)
                continue; // Pula inativos

            $providerId = $provider['providerId'];
            $urlGames = self::baseUrl() . "/v1/game/list/{$providerId}";

            try {
                $resGames = Http::withHeaders(['Authorization' => 'Bearer ' . self::$token])->get($urlGames);
                if ($resGames->successful()) {
                    $gamesData = $resGames->json()['data'] ?? [];

                    // Adiciona o ID do provedor em cada jogo para facilitar a inserção no banco
                    foreach ($gamesData as &$g) {
                        $g['provider_id_api'] = $providerId;
                        $g['provider_name'] = $provider['providerName'];
                    }

                    $allGames = array_merge($allGames, $gamesData);
                }
            } catch (\Exception $e) {
                Log::warning("Falha ao buscar jogos do provider {$providerId}");
                continue;
            }
        }

        return response()->json([
            'status' => 'OK',
            'count' => count($allGames),
            'data' => $allGames
        ]);
    }

    /* -----------------------------------------------------------------
     *  3️⃣  BONUS CALL (Refatorado para /v1/bonus-call/register)
     * ----------------------------------------------------------------- */
    public static function sendBonusCall($gameCode, $rounds, $providerId, $userId)
    {
        self::loadCredentials();
        $url = self::baseUrl() . '/v1/bonus-call/register';

        // Payload específico para Free Spins (BonusType 2)
        $payload = [
            'issueId' => 'bonus_' . uniqid(),
            'providerId' => (int) $providerId,
            'gameCode' => $gameCode,
            'playerExternalId' => 'user_' . $userId,
            'currency' => 'BRL', // Ajuste conforme necessário
            'bonusType' => 2, // 2 = Free Spin Bonus
            'callAmount' => 1000, // Max Win Amount (Defina um limite seguro)
            'metaData' => [
                'spinAmount' => (int) $rounds, // Min 10, Max 100
                'betLevel' => 1, // Min 1, Max 5
                'expireAt' => now()->addDays(7)->toIso8601String()
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . self::$token,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            Log::info('🎁 Bonus Call Enviado', ['payload' => $payload, 'response' => $response->json()]);
            return $response->json();

        } catch (\Exception $e) {
            Log::error('❌ Erro no Bonus Call', ['msg' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private static function findUserFromPlayerId(?string $playerId): ?User
    {
        if (!$playerId || !str_starts_with($playerId, 'user_')) {
            return null;
        }

        $userId = (int) str_replace('user_', '', $playerId);

        if ($userId <= 0) {
            return null;
        }

        return User::find($userId);
    }

    public static function webhookIgamingPlayAPI(Request $request)
    {
        Log::critical('📡 WEBHOOK RECEBIDO', $request->all());

        $command = $request->input('command');

        try {
            switch ($command) {
                case 'balance':
                    return self::handleIgamingBalance($request);

                case 'bet':
                    return self::handleIgamingBet($request);

                case 'win':
                    return self::handleIgamingWin($request);

                case 'cancel':
                    return self::handleIgamingCancel($request);

                default:
                    Log::warning('⚠️ Comando iGamingPlay desconhecido', [
                        'command' => $command,
                    ]);

                    return response()->json([
                        'statusCode' => 'ERR_UNKNOWN',
                    ], 400);
            }
        } catch (\Throwable $e) {
            Log::error('❌ Erro geral no webhook IgamingPlay', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'statusCode' => 'ERR_UNKNOWN',
            ], 500);
        }
    }

 private static function handleIgamingBalance(Request $request)
{
    $playerId = $request->input('playerId');
    $currency = $request->input('currency', 'BRL');

    $user = self::findUserFromPlayerId($playerId);

    if (!$user) {
        Log::warning('⚠️ Balance: playerId inválido', ['playerId' => $playerId]);

        return response()->json([
            'statusCode' => 'ERR_INVALID_PLAYER_ID',
        ]);
    }

    $wallet = Wallet::where('user_id', $user->id)->first();

    if (!$wallet) {
        Log::warning('⚠️ Balance: carteira não encontrada', ['user_id' => $user->id]);

        return response()->json([
            'statusCode' => 'ERR_UNKNOWN',
        ]);
    }

    // Defina a regra de saldo exposto ao provedor:
    // Opção 1 (mais completa): real + saque + bônus
    $rawBalance =
          $wallet->balance
        + $wallet->balance_withdrawal
        + $wallet->balance_bonus;

    // Opção 2 (se quiser excluir saldo de saque):
    // $rawBalance = $wallet->balance + $wallet->balance_bonus;

    $balance = (float) $rawBalance;

    Log::info('💰 Balance respondido', [
        'playerId' => $playerId,
        'user_id'  => $user->id,
        'balance'  => $balance,
        'currency' => $currency,
    ]);

    return response()->json([
        'balance'    => $balance,
        'statusCode' => 'OK',
    ]);
}

private static function handleIgamingBet(Request $request)
{
    $playerId      = $request->input('playerId');
    $currency      = $request->input('currency', 'BRL');
    $transactionId = $request->input('transactionId');
    $amount        = (float) $request->input('amount', 0);

    $user = self::findUserFromPlayerId($playerId);

    if (!$user) {
        Log::warning('⚠️ Bet: playerId inválido', ['playerId' => $playerId]);

        return response()->json([
            'statusCode' => 'ERR_NOT_AUTHENTICATED',
        ]);
    }

    $existing = Order::where('transaction_id', $transactionId)
        ->where('type', 'win')
        ->first();

    if ($existing) {
        $wallet  = Wallet::where('user_id', $user->id)->first();

        $balance = 0;
        if ($wallet) {
            $balance =
                $wallet->balance
                + $wallet->balance_withdrawal
                + $wallet->balance_bonus;
        }

        return response()->json([
            'balance'    => (float) $balance,
            'statusCode' => 'OK',
        ]);
    }

    return DB::transaction(function () use ($user, $currency, $transactionId, $amount, $request) {
        $wallet = Wallet::lockForUpdate()->where('user_id', $user->id)->first();

        if (!$wallet) {
            Log::warning('⚠️ Bet: carteira não encontrada', ['user_id' => $user->id]);

            return response()->json([
                'statusCode' => 'ERR_UNKNOWN',
            ]);
        }

        // Usa a lógica centralizada de débito (inclui bônus)
        $changeBonus = Core::DiscountBalance($wallet, $amount);

        if ($changeBonus === 'no_balance') {
            Log::info('🚫 Bet: saldo insuficiente', [
                'user_id' => $user->id,
                'amount'  => $amount,
            ]);

            $rawBalance =
                  $wallet->balance
                + $wallet->balance_withdrawal
                + $wallet->balance_bonus;

            return response()->json([
                'balance'    => (float) $rawBalance,
                'statusCode' => 'ERR_NOT_ENOUGH_MONEY',
            ]);
        }

        // Cria order da bet
        $order = Order::create([
            'user_id'                => $user->id,
            'amount'                 => $amount,
            'type'                   => 'bet',
            'type_money'             => $changeBonus, // muito importante p/ rollover
            'currency'               => $currency,
            'transaction_id'         => $transactionId,
            'provider_id'            => $request->input('providerId'),
            'game_code'              => $request->input('gameCode'),
            'round_id'               => $request->input('roundId'),
            'status'                 => 1,
        ]);

        // Gera histórico / afiliados / rollover (type = 'bet', win = 0)
        Core::generateGameHistory(
            $user->id,
            'bet',
            0,              // win
            $amount,        // bet
            $changeBonus,
            $transactionId  // tx
        );

        $rawBalance =
              $wallet->balance
            + $wallet->balance_withdrawal
            + $wallet->balance_bonus;

        Log::info('✅ Bet processado ScorpioPlay', [
            'user_id'        => $user->id,
            'transaction_id' => $transactionId,
            'amount'         => $amount,
            'changeBonus'    => $changeBonus,
            'new_balance'    => (float) $rawBalance,
        ]);

        return response()->json([
            'balance'    => (float) $rawBalance,
            'statusCode' => 'OK',
        ]);
    });
}

private static function handleIgamingWin(Request $request)
{
    $playerId      = $request->input('playerId');
    $currency      = $request->input('currency', 'BRL');
    $transactionId = $request->input('transactionId');
    $amount        = (float) $request->input('amount', 0);

    $user = self::findUserFromPlayerId($playerId);

    if (!$user) {
        Log::warning('⚠️ Win: playerId inválido', ['playerId' => $playerId]);

        return response()->json([
            'statusCode' => 'ERR_NOT_AUTHENTICATED',
        ]);
    }

    // Idempotência
    $existing = Order::where('transaction_id', $transactionId)
        ->where('type', 'win')
        ->first();

    if ($existing) {
        $wallet  = Wallet::where('user_id', $user->id)->first();
        $balance = 0;

        if ($wallet) {
            $balance =
                  $wallet->balance
                + $wallet->balance_withdrawal
                + $wallet->balance_bonus;
        }

        return response()->json([
            'balance'    => (float) $balance,
            'statusCode' => 'OK',
        ]);
    }

    return DB::transaction(function () use ($user, $currency, $transactionId, $amount, $request) {
        $wallet = Wallet::lockForUpdate()
            ->where('user_id', $user->id)
            ->first();

        if (!$wallet) {
            Log::warning('⚠️ Win: carteira não encontrada', ['user_id' => $user->id]);

            return response()->json([
                'statusCode' => 'ERR_UNKNOWN',
            ]);
        }

        // Se amount for 0, não altera nada, só retorna saldo atual
        if ($amount > 0) {
            // Aqui você pode usar sua lógica de rollover:
            // Helper::payWithRollover($user->id, $changeBonus, $win, $bet, $type, $loss = 0);
            // mas, como não temos o bet facilmente aqui, faço o mais simples:

            // Creditar diretamente no balance_withdrawal (por ex.)
            $wallet->balance_withdrawal += $amount;
            $wallet->save();
        }

        // Cria order de win
        Order::create([
            'user_id'        => $user->id,
            'session_id'     => null,
            'transaction_id' => $transactionId,
            'game'           => $request->input('gameName'),
            'game_uuid'      => $request->input('gameCode'),
            'type'           => 'win',
            'type_money'     => 'balance', // ou outra regra se quiser marcar
            'amount'         => $amount,
            'providers'      => $request->input('providerName', 'IGAMINGPLAY'),
            'refunded'       => 0,
            'status'         => 1,
            'round_id'       => $request->input('roundId'),
        ]);

        // TODO: se quiser, chame Helper::generateGameHistory(...) aqui, com win > 0

        // Recalcula saldo total para mandar pro provedor
        $wallet->refresh();
        $rawBalance =
              $wallet->balance
            + $wallet->balance_withdrawal
            + $wallet->balance_bonus;

        Log::info('✅ Win processado ScorpioPlay', [
            'user_id'        => $user->id,
            'transaction_id' => $transactionId,
            'amount'         => $amount,
            'new_balance'    => (float) $rawBalance,
        ]);

        return response()->json([
            'balance'    => (float) $rawBalance,
            'statusCode' => 'OK',
        ]);
    });
}


    private static function handleIgamingCancel(Request $request)
    {
        $playerId = $request->input('playerId');
        $currency = $request->input('currency', 'BRL');
        $transactionId = $request->input('transactionId');
        $referenceId = $request->input('referenceId');
        $amount = (float) $request->input('amount', 0);

        $user = self::findUserFromPlayerId($playerId);

        if (!$user) {
            Log::warning('⚠️ Cancel: playerId inválido', ['playerId' => $playerId]);

            return response()->json([
                'statusCode' => 'ERR_NOT_AUTHENTICATED',
            ]);
        }

        // Já cancelado?
        $existingCancel = Order::where('transaction_id', $transactionId)
            ->where('type', 'cancel')
            ->first();

        if ($existingCancel) {
            $wallet = Wallet::where('user_id', $user->id)->first();
            $balance = $wallet?->balance ?? 0;

            return response()->json([
                'balance' => $balance,
                'statusCode' => 'OK',
            ]);
        }

        // Bet original
        $betOrder = Order::where('external_transaction_id', $referenceId)
            ->where('type', 'bet')
            ->first();

        if (!$betOrder) {
            Log::warning('⚠️ Cancel: bet de referência não encontrada', [
                'referenceId' => $referenceId,
            ]);

            $wallet = Wallet::where('user_id', $user->id)->first();
            $balance = $wallet?->balance ?? 0;

            return response()->json([
                'statusCode' => 'ERR_TRANSACTION_DOES_NOT_EXIST',
                'balance' => $balance,
            ]);
        }

        return DB::transaction(function () use ($user, $currency, $transactionId, $amount, $betOrder) {
            $wallet = Wallet::lockForUpdate()->where('user_id', $user->id)->first();

            if (!$wallet) {
                Log::warning('⚠️ Cancel: carteira não encontrada', ['user_id' => $user->id]);

                return response()->json([
                    'statusCode' => 'ERR_UNKNOWN',
                ]);
            }

            // Credita o valor de volta
            $wallet->balance += abs($betOrder->amount); // se amount da bet estiver negativo
            $wallet->save();

            Order::create([
                'user_id' => $user->id,
                'amount' => abs($betOrder->amount),
                'type' => 'cancel',
                'currency' => $currency,
                'transaction_id' => $transactionId,
                'provider_id' => $betOrder->provider_id,
                'game_code' => $betOrder->game_code,
                'round_id' => $betOrder->round_id,
            ]);

            Log::info('✅ Cancel processado', [
                'user_id' => $user->id,
                'transaction_id' => $transactionId,
                'reference_id' => $betOrder->external_transaction_id,
                'new_balance' => $wallet->balance,
            ]);

            return response()->json([
                'balance' => $wallet->balance,
                'statusCode' => 'OK',
            ]);
        });
    }


}
