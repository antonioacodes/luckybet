<?php

namespace App\Traits\Providers;
// ✅ ADICIONE ESTES IMPORTS:
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
use App\Helpers\Core as Helper;
use Illuminate\Http\JsonResponse;

trait IgamingPlayTrait
{
    /* -----------------------------------------------------------------
     *  CREDENCIAIS
     * ----------------------------------------------------------------- */
    protected static $token;         // Bearer token
    protected static $callbackToken; // Callback-Token (validação)
    private static function loadCredentials(): void
    {
        $setting = GamesKey::firstOrFail();
        self::$token         = $setting->igamingplay_token;
        self::$callbackToken = $setting->igamingplay_callback_token;
    }
    private static function baseUrl(): string
    {
        return rtrim(env('IGAMINGPLAY_BASE_URL', 'https://prd-api-v1-kr1-en.mega-nodes.com'), '/');
    }
    /* -----------------------------------------------------------------
     *  0️⃣  CRIAÇÃO/RECUPERAÇÃO DE USUÁRIO (usando ID)
     * ----------------------------------------------------------------- */
    private static function getAllGamesFromProvider(): JsonResponse
{
    self::loadCredentials();
    $url = self::baseUrl() . '/v4/game/list'; // endpoint da SlotCity/IgamingPlay
    Log::info('🎮 Solicitando lista de jogos da SlotCity', [
        'url' => $url,
        'token' => self::$token ? 'exists' : 'MISSING',
    ]);
    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$token,
            'Accept'        => 'application/json',
        ])->get($url);
        $status = $response->status();
        $body   = $response->json();
        Log::info('📥 Resposta recebida de /game/list', [
            'status' => $status,
            'count'  => count($body['data'] ?? []),
        ]);
        if ($status !== 200 || !isset($body['data'])) {
            return response()->json([
                'result' => 99,
                'status' => 'ERROR',
                'message'=> $body['message'] ?? 'Erro ao obter lista de jogos'
            ], $status);
        }
        // 🗃️ Atualiza ou apenas retorna
        return response()->json([
            'result' => 0,
            'status' => 'OK',
            'message'=> 'Lista de jogos sincronizada',
            'data'   => $body['data'],
        ]);
    } catch (\Exception $e) {
        Log::error('❌ Erro ao buscar lista de jogos', [
            'error' => $e->getMessage(),
        ]);
        return response()->json([
            'result' => 99,
            'status' => 'ERROR',
            'message'=> $e->getMessage(),
        ], 500);
    }
}
  
      public static function getOnlineGames()
    {
        self::loadCredentials();
        $url = self::baseUrl() . '/v4/game/online-games';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . self::$token,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post($url, []); // POST vazio conforme doc

            if ($response->successful()) {
                return $response->json('data'); // Retorna o array de sessões
            }

            Log::error('❌ Erro ao buscar online-games', ['resp' => $response->json()]);
            return null;
        } catch (\Exception $e) {
            Log::error('❌ Exception online-games: ' . $e->getMessage());
            return null;
        }
    }
  
      public static function sendBonusCall($gplayId, $rounds)
    {
        self::loadCredentials();
        $url = self::baseUrl() . '/v4/game/call_start';

        // Monta o JSON do call_meta para Free Spins (Gift Spin)
        // BonusType: 2 = Gift Spin
        $metaData = [
            'BonusType' => 2,
            'TotalCount' => (int)$rounds,
            'BonusBettingLevel' => 1,
            'GiveCount' => 0
        ];

        $payload = [
            'gplay_id'  => (int)$gplayId,
            'set_point' => 10, // Valor monetário do bônus (0 para apenas rodadas)
            'memo'      => 'Reward Free Spins',
            'call_meta' => json_encode($metaData) // Campo especial para configurar as rodadas
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . self::$token,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post($url, $payload);

            Log::info('📤 Bonus Call Enviado', ['payload' => $payload, 'response' => $response->json()]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('❌ Exception call_start: ' . $e->getMessage());
            return ['code' => 999, 'message' => $e->getMessage()];
        }
    }
private static function getOrCreateSlotCityUser(int $userId): int
{
    self::loadCredentials();
    $sanitizedName = 'user_' . $userId;
    $url = self::baseUrl() . '/v4/user/create';
    $payload = ['name' => $sanitizedName];
    // 🔍 LOG: Payload que será enviado
    \Log::info('🚀 Criando usuário na SlotCity', [
        'user_id' => $userId,
        'sanitized_name' => $sanitizedName,
        'url' => $url,
        'payload' => $payload,
        'token' => self::$token ? 'exists' : 'MISSING',
        'callback_token' => self::$callbackToken ? 'exists' : 'MISSING'
    ]);
    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, $payload);
        $statusCode = $response->status();
        $body = $response->json();
        // 🔍 LOG: Resposta completa da API
        \Log::info('📥 Resposta da SlotCity (user/create)', [
            'status_code' => $statusCode,
            'body' => $body,
            'raw_body' => $response->body()
        ]);
        // Verificar se a resposta está OK
        if ($statusCode !== 200) {
            \Log::error('❌ SlotCity retornou status diferente de 200', [
                'status_code' => $statusCode,
                'body' => $body
            ]);
            throw new \Exception("SlotCity API error: HTTP {$statusCode} - " . ($body['message'] ?? 'Unknown error'));
        }
        // Verificar estrutura da resposta
        if (!isset($body['code'])) {
            \Log::error('❌ Resposta da SlotCity sem campo "code"', [
                'body' => $body
            ]);
            throw new \Exception('Invalid response structure from SlotCity (missing "code")');
        }
        // code === 0 significa sucesso
        if ($body['code'] === 0 && isset($body['data']['user_code'])) {
            $userCode = (int) $body['data']['user_code'];
            \Log::info('✅ Usuário criado/recuperado com sucesso', [
                'user_id' => $userId,
                'user_code' => $userCode
            ]);
            return $userCode;
        }
        // code === 1012 significa que o usuário já existe (isso é OK)
        if ($body['code'] === 1012 && isset($body['data']['user_code'])) {
            $userCode = (int) $body['data']['user_code'];
            \Log::info('✅ Usuário já existe na SlotCity', [
                'user_id' => $userId,
                'user_code' => $userCode
            ]);
            return $userCode;
        }
        // Qualquer outro código é erro
        \Log::error('❌ SlotCity retornou código de erro', [
            'code' => $body['code'],
            'message' => $body['message'] ?? 'No message',
            'body' => $body
        ]);
        throw new \Exception("SlotCity error code {$body['code']}: " . ($body['message'] ?? 'Unknown error'));
    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        \Log::error('❌ Erro de conexão com SlotCity', [
            'error' => $e->getMessage(),
            'url' => $url
        ]);
        throw new \Exception('Connection error with SlotCity: ' . $e->getMessage());
    } catch (\Exception $e) {
        \Log::error('❌ Erro geral ao criar usuário', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}
    /* -----------------------------------------------------------------
     *  1️⃣  LAUNCH GAME (sem sessionToken)
     * ----------------------------------------------------------------- */
private static function launchGameIgamingPlay(Request $request): JsonResponse
{
    self::loadCredentials();
    $user = Auth::guard('api')->user();
    if (!$user) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    // 🚨 ALTERAÇÃO AQUI: Recebe ambos os identificadores
    $gameIdFromRequest = $request->input('game_id'); // O ID único da sua tabela 'games'
    $gameCodeProviderFromRequest = $request->input('game_code_provider'); // O game_code do provedor

    // 🎮 Log para depuração
    Log::info('🎮 Tentativa de lançamento de jogo IgamingPlay', [
        'user_id' => $user->id,
        'game_id_recebido_da_request' => $gameIdFromRequest,
        'game_code_provider_recebido_da_request' => $gameCodeProviderFromRequest,
    ]);

    // 🔥 BUSCA O JOGO AQUI DENTRO DA TRAIT PELO ID PRIMÁRIO
    // Priorizamos o game_id (o ID único da sua tabela) para garantir a unicidade.
    $game = null;
    if ($gameIdFromRequest) {
        $game = Game::where('id', $gameIdFromRequest)
                    ->where('distribution', 'igamingplay')
                    ->first();
    } 
    // Se por algum motivo o game_id não foi enviado ou não encontrou,
    // você pode ter uma lógica de fallback para o game_code_provider,
    // mas esteja ciente dos duplicados.
    // Por enquanto, vamos focar no game_id para resolver o problema principal.

    if (!$game) {
        Log::error('❌ Jogo não encontrado na base de dados', [
            'game_id_recebido' => $gameIdFromRequest,
            'game_code_provider_recebido' => $gameCodeProviderFromRequest,
            'message' => "Jogo com ID '{$gameIdFromRequest}' não encontrado ou não pertence à distribuição 'igamingplay'."
        ]);
        return response()->json([
            'error' => 'Game not found',
            'message' => "Jogo com ID '{$gameIdFromRequest}' não encontrado"
        ], 404);
    }

    // 🎮 Log para depuração
    Log::info('✅ Jogo encontrado na base de dados', [
        'game_id_encontrado' => $game->id,
        'game_name_encontrado' => $game->game_name,
        'game_code_para_api_externa' => $game->game_code, // Este é o game_code do provedor que está no seu DB
        'provider_id_para_api_externa' => $game->provider_id,
    ]);

    // 1️⃣ Cria/recupera usuário na SlotCity
    $userCode = self::getOrCreateSlotCityUser($user->id);
    if (!$userCode) {
        return response()->json([
            'error' => 'Failed to create user',
            'message' => 'Não foi possível criar/recuperar o usuário na SlotCity'
        ], 500);
    }

    // 2️⃣ Gera a URL do jogo
    $payload = [
        'user_code'   => $userCode,
        'provider_id' => $game->provider_id,          // vem da tabela games
        'game_symbol' => $game->game_code,            // código do jogo do provedor, pego do DB
        'lang'        => 6,                           // código numérico conforme doc, não string
        'return_url'  => config('app.url') . '/lobby', // ou o que fizer sentido na sua app
        'win_ratio'   => 0,                           // Valor padrão conforme a documentação
    ];

    try {
        $url = self::baseUrl() . '/v4/game/game-url';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$token,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post($url, $payload);

        Log::info('SlotCity game-url response', [
            'status' => $response->status(),
            'body'   => $response->json(),
            'payload_enviado_para_slotcity' => $payload // Adicionado para ver o payload exato
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Failed to get game URL',
                'details' => $response->json()
            ], $response->status());
        }

        $data = $response->json();
        if (isset($data['code']) && $data['code'] === 0 && isset($data['data']['game_url'])) {
            return response()->json([
                'game_url'  => $data['data']['game_url'],
                'user_code' => $userCode,
                'game_code' => $game->game_code // Retorna o game_code do provedor do jogo encontrado
            ]);
        }

        return response()->json([
            'error' => 'Invalid response from SlotCity',
            'data' => $data
        ], 500);
    } catch (\Exception $e) {
        Log::error('Erro ao chamar SlotCity game-url', [
            'error' => $e->getMessage(),
            'payload' => $payload
        ]);
        return response()->json([
            'error' => 'Failed to launch game',
            'message' => $e->getMessage()
        ], 500);
    }
}


    /* -----------------------------------------------------------------
     *  2️⃣  WEBHOOK CALLBACK (único endpoint)
     * ----------------------------------------------------------------- */
    public static function webhookIgamingPlayAPI(Request $request)
    {
        // 1️⃣ VALIDA CALLBACK-TOKEN
        self::loadCredentials();
        $receivedToken = $request->header('Callback-Token');
        if ($receivedToken !== self::$callbackToken) {
            Log::warning('IgamingPlay – Token inválido', [
                'esperado' => self::$callbackToken,
                'recebido' => $receivedToken
            ]);
            return response()->json([
                'result' => 100,
                'status' => 'ERROR'
            ]);
        }
        // 2️⃣ PARSEIA JSON
        $data = $request->all();
        $command   = $data['command'] ?? null;
        $timestamp = $data['timestamp'] ?? time();
        $check     = $data['check'] ?? '';
        $payload   = $data['data'] ?? [];
        Log::info('IgamingPlay – Callback recebido', [
            'command' => $command,
            'check'   => $check,
            'data'    => $payload
        ]);
        // 3️⃣ EXECUTA VALIDAÇÕES (check codes)
        $checkCodes = explode(',', $check);
        $validationResult = self::validateChecks($checkCodes, $payload);
        if ($validationResult) {
            \Log::warning('⚠️  validateChecks falhou', ['result' => $validationResult]);
            return response()->json($validationResult);
        }
        // 4️⃣ PROCESSA COMANDO
        switch ($command) {
            case 'authenticate':
                return self::handleAuthenticate($payload);
            case 'balance':
                return self::handleBalance($payload);
            case 'bet':
                return self::handleBet($payload);
            case 'win':
                return self::handleWin($payload);
            case 'cancel':
                return self::handleCancel($payload);
            case 'status':
                return self::handleStatus($payload);
            default:
                return response()->json([
                    'result' => 99,
                    'status' => 'ERROR',
                    'message' => 'Comando desconhecido'
                ]);
        }
    }
    /* -----------------------------------------------------------------
     *  3️⃣  VALIDAÇÕES (check codes)
     * ----------------------------------------------------------------- */
    private static function validateChecks(array $checks, array $payload): ?array
    {
        foreach ($checks as $code) {
            $code = trim($code);
            switch ($code) {
                case '21': // Usuário existe?
                    $account = $payload['account'] ?? null;
                    if (!$account) {
                        return ['result' => 21, 'status' => 'ERROR'];
                    }
                    // Extrai ID: user_27 → 27
                    $userId = (int) str_replace('user_', '', $account);
                    $user = User::find($userId);
                    if (!$user) {
                        return ['result' => 21, 'status' => 'ERROR'];
                    }
                    break;
                case '22': // Usuário ativo?
                    $account = $payload['account'] ?? null;
                    $userId  = (int) str_replace('user_', '', $account);
                    $user    = User::find($userId);
                    // Valores considerados como "ativos"
                    $ativaValores = [1, '1', true, 'true', 'active', 'on', 'yes'];
                    if (!$user || !in_array($user->status, $ativaValores, true)) {
                        \Log::warning('❌ Check 22 falhou (usuário não ativo)', [
                            'user_id' => $userId,
                            'status_atual' => $user ? $user->status : null,
                        ]);
                        return ['result' => 22, 'status' => 'ERROR'];
                    }
                    \Log::info('✅ Check 22 passou', ['user_id' => $userId, 'status' => $user->status]);
                    break;
                case '31': // Saldo suficiente?
                    $account = $payload['account'] ?? null;
                    $userId  = (int) str_replace('user_', '', $account);
                    $amount  = $payload['amount'] ?? 0;
                    $wallet  = Wallet::where('user_id', $userId)->first();
                    if (!$wallet) {
                        return [
                            'result' => 31,
                            'status' => 'ERROR',
                            'data'   => ['balance' => 0]
                        ];
                    }
                    $totalBalance = $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus;
                    if ($totalBalance < $amount) {
                        return [
                            'result' => 31,
                            'status' => 'ERROR',
                            'data'   => ['balance' => $totalBalance]
                        ];
                    }
                    break;
                case '41': // Transação já processada?
                    $transId = $payload['trans_id'] ?? null;
                    if (!$transId) {
                        return ['result' => 41, 'status' => 'ERROR'];
                    }
                    $order = Order::where('transaction_id', $transId)
                        ->where('providers', 'igamingplay')
                        ->first();
                    if ($order) {
                        $account = $payload['account'] ?? null;
                        $userId  = (int) str_replace('user_', '', $account);
                        $wallet  = Wallet::where('user_id', $userId)->first();
                        return [
                            'result' => 41,
                            'status' => 'ERROR',
                            'data'   => [
                                'balance' => $wallet 
                                    ? ($wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus) 
                                    : 0
                            ]
                        ];
                    }
                    break;
                case '42': // Transação existe (para cancelar)?
                    $transId = $payload['trans_id'] ?? null;
                    if (!$transId) {
                        return ['result' => 42, 'status' => 'ERROR'];
                    }
                    $order = Order::where('transaction_id', $transId)
                        ->where('providers', 'igamingplay')
                        ->where('refunded', 0)
                        ->first();
                    if (!$order) {
                        $account = $payload['account'] ?? null;
                        $userId  = (int) str_replace('user_', '', $account);
                        $wallet  = Wallet::where('user_id', $userId)->first();
                        return [
                            'result' => 42,
                            'status' => 'ERROR',
                            'data'   => [
                                'balance' => $wallet 
                                    ? ($wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus) 
                                    : 0
                            ]
                        ];
                    }
                    break;
            }
        }
        return null; // Todas validações passaram
    }
    /* -----------------------------------------------------------------
     *  4️⃣  COMANDOS (handlers)
     * ----------------------------------------------------------------- */
    // 📌 AUTHENTICATE
    private static function handleAuthenticate(array $payload): JsonResponse
    {
        $account = $payload['account'] ?? null;
        $userId  = (int) str_replace('user_', '', $account);
        $wallet  = Wallet::where('user_id', $userId)->first();
        if (!$wallet) {
            return response()->json([
                'result' => 21,
                'status' => 'ERROR'
            ]);
        }
        $balanceInCents = (int) round(
            (
                (float)$wallet->balance +
                (float)$wallet->balance_withdrawal +
                (float)$wallet->balance_bonus
            ) * 100
        );
        return response()->json([
            'result' => 0,
            'status' => 'OK',
            'data'   => [
                'account' => $account,
                'balance' => $balanceInCents
            ]
        ]);
    }
    // 📌 BALANCE
private static function handleBalance(array $payload): \Illuminate\Http\JsonResponse
{
    $account = $payload['account'] ?? null;
    $userId  = (int) str_replace('user_', '', $account);
    $wallet  = Wallet::where('user_id', $userId)->first();
    if (!$wallet) {
        return response()->json([
            'result' => 99,
            'status' => 'ERROR',
            'data'   => ['balance' => 0]
        ]);
    }
    // 💰 Soma dos saldos reais
    $saldoReais = round(
        $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus,
        2
    );
    $responseData = [
        'result' => 0,
        'status' => 'OK',
        'data'   => [
            // 👇 envia em reais (não multiplica!)
            'balance' => $saldoReais
        ],
    ];
    Log::info('📤 Resposta balance ENVIADA', [
        'user_id'      => $userId,
        'saldo_reais'  => $saldoReais
    ]);
    return response()->json($responseData, 200, [
        'Content-Type' => 'application/json; charset=utf-8'
    ]);
}
    // 📌 BET
    private static function handleBet(array $payload): JsonResponse
    {
        $account   = $payload['account'] ?? null;
        $transId   = $payload['trans_id'] ?? null;
        $roundId   = $payload['round_id'] ?? null;
        $gameCode  = $payload['game_code'] ?? null;
        $gameName  = $payload['game_name'] ?? null;
        $amount    = $payload['amount'] ?? 0;
        $userId = (int) str_replace('user_', '', $account);
        try {
            DB::beginTransaction();
            $wallet = Wallet::where('user_id', $userId)->lockForUpdate()->first();
            if (!$wallet) {
                DB::rollBack();
                return response()->json([
                    'result' => 21,
                    'status' => 'ERROR'
                ]);
            }
            // Verifica saldo suficiente
            $totalBalance = $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus;
            if ($totalBalance < $amount) {
                DB::rollBack();
                return response()->json([
                    'result' => 31,
                    'status' => 'ERROR',
                    'data'   => ['balance' => $totalBalance]
                ]);
            }
            // Debita usando Helper
            $typeMoneyUsed = Helper::DiscountBalance($wallet, $amount);
            if ($typeMoneyUsed === 'no_balance') {
                DB::rollBack();
                return response()->json([
                    'result' => 31,
                    'status' => 'ERROR',
                    'data'   => ['balance' => 0]
                ]);
            }
            // Cria ordem
            Order::create([
                'user_id'        => $userId,
                'transaction_id' => $transId,
                'game'           => $gameName ?? $gameCode,
                'game_uuid'      => $gameCode,
                'type'           => 'bet',
                'type_money'     => $typeMoneyUsed,
                'amount'         => $amount,
                'providers'      => 'igamingplay',
                'round_id'       => $roundId,
                'status'         => 1,
                'refunded'       => 0,
            ]);
            // Atualiza estatísticas
            $wallet->increment('total_bet', $amount);
            // Rollover/VIP
            Helper::payBonusVip($wallet, $amount);
            DB::commit();
            $newBalance = $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus;
            return response()->json([
                'result' => 0,
                'status' => 'OK',
                'data'   => ['balance' => $newBalance]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('IgamingPlay – Erro no BET', [
                'trans_id'  => $transId,
                'user_id'   => $userId,
                'exception' => $e->getMessage()
            ]);
            return response()->json([
                'result' => 99,
                'status' => 'ERROR',
                'data'   => ['balance' => 0]
            ]);
        }
    }
private static function handleWin(array $payload): JsonResponse
{
    $account   = $payload['account'] ?? null;
    $transId   = $payload['trans_id'] ?? null;
    $roundId   = $payload['round_id'] ?? null;
    $gameCode  = $payload['game_code'] ?? null;
    $gameName  = $payload['game_name'] ?? null;
    $amount    = $payload['amount'] ?? 0;
    $userId = (int) str_replace('user_', '', $account);
    try {
        DB::beginTransaction();
        $wallet = Wallet::where('user_id', $userId)->lockForUpdate()->first();
        if (!$wallet) {
            DB::rollBack();
            return response()->json([
                'result' => 21,
                'status' => 'ERROR'
            ]);
        }
        // Busca a BET correspondente
        $betOrder = Order::where('user_id', $userId)
            ->where('round_id', $roundId)
            ->where('type', 'bet')
            ->where('providers', 'igamingplay')
            ->where('refunded', 0)
            ->first();
        $isBonusBuy = !$betOrder;
        $typeMoneyUsed = $betOrder ? $betOrder->type_money : 'balance';
        $betAmount = $betOrder ? $betOrder->amount : 0;
        // 🔥 Calcula tipo e loss
        $type = ($amount > 0) ? 'win' : 'loss';
        $loss = ($amount <= 0) ? $betAmount : 0;
        Log::info('🎰 Processando WIN', [
            'trans_id' => $transId,
            'round_id' => $roundId,
            'amount' => $amount,
            'bet_amount' => $betAmount,
            'loss' => $loss,
            'type' => $type
        ]);
        // Cria ordem
        Order::create([
            'user_id'        => $userId,
            'transaction_id' => $transId,
            'game'           => $gameName ?? $gameCode,
            'game_uuid'      => $gameCode,
            'type'           => $type,
            'type_money'     => $typeMoneyUsed,
            'amount'         => abs($amount),
            'providers'      => 'igamingplay',
            'round_id'       => $roundId,
            'status'         => 1,
            'refunded'       => 0,
        ]);
        // Processa WIN ou LOSS
        if ($amount > 0) {
            // ✅ WIN: Passa $loss como 6º parâmetro
            Helper::payWithRollover($userId, $typeMoneyUsed, $amount, $betAmount, $type, $loss);
            $wallet->increment('total_won', $amount);
        } else {
            // ❌ LOSS
            if ($loss > 0) {
                $wallet->increment('total_lose', $loss);
            }
        }
        DB::commit();
        $wallet->refresh();
        $newBalance = $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus;
        Log::info('✅ WIN/LOSS processado', [
            'trans_id' => $transId,
            'type' => $type,
            'amount' => $amount,
            'new_balance' => $newBalance
        ]);
        return response()->json([
            'result' => 0,
            'status' => 'OK',
            'data'   => ['balance' => $newBalance]
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('❌ Erro no WIN', [
            'trans_id'  => $transId,
            'user_id'   => $userId,
            'exception' => $e->getMessage(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine()
        ]);
        return response()->json([
            'result' => 99,
            'status' => 'ERROR',
            'data'   => ['balance' => 0]
        ]);
    }
}
    // 📌 CANCEL
    private static function handleCancel(array $payload): JsonResponse
    {
        $account  = $payload['account'] ?? null;
        $transId  = $payload['trans_id'] ?? null;
        $roundId  = $payload['round_id'] ?? null;
        $userId = (int) str_replace('user_', '', $account);
        try {
            DB::beginTransaction();
            $wallet = Wallet::where('user_id', $userId)->lockForUpdate()->first();
            if (!$wallet) {
                DB::rollBack();
                return response()->json([
                    'result' => 21,
                    'status' => 'ERROR'
                ]);
            }
            // Busca a transação original
            $order = Order::where('transaction_id', $transId)
                ->where('providers', 'igamingplay')
                ->where('refunded', 0)
                ->first();
            if (!$order) {
                DB::rollBack();
                return response()->json([
                    'result' => 42,
                    'status' => 'ERROR',
                    'data'   => [
                        'balance' => $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus
                    ]
                ]);
            }
            // Reverte a transação
            if ($order->type === 'bet') {
                // Era BET → devolve o valor
                $typeMoneyUsed = $order->type_money;
                $amount = $order->amount;
                if ($typeMoneyUsed === 'balance') {
                    $wallet->increment('balance', $amount);
                } elseif ($typeMoneyUsed === 'balance_withdrawal') {
                    $wallet->increment('balance_withdrawal', $amount);
                } elseif ($typeMoneyUsed === 'balance_bonus') {
                    $wallet->increment('balance_bonus', $amount);
                }
                $wallet->decrement('total_bet', $amount);
            } elseif ($order->type === 'win') {
                // Era WIN → remove o ganho
                $typeMoneyUsed = $order->type_money;
                $amount = $order->amount;
                if ($typeMoneyUsed === 'balance') {
                    $wallet->decrement('balance', $amount);
                } elseif ($typeMoneyUsed === 'balance_withdrawal') {
                    $wallet->decrement('balance_withdrawal', $amount);
                } elseif ($typeMoneyUsed === 'balance_bonus') {
                    $wallet->decrement('balance_bonus', $amount);
                }
                $wallet->decrement('total_won', $amount);
            }
            // Marca como reembolsado
            $order->update(['refunded' => 1]);
            DB::commit();
            $wallet->refresh();
            $newBalance = $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus;
            return response()->json([
                'result' => 0,
                'status' => 'OK',
                'data'   => ['balance' => $newBalance]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('IgamingPlay – Erro no CANCEL', [
                'trans_id'  => $transId,
                'user_id'   => $userId,
                'exception' => $e->getMessage()
            ]);
            return response()->json([
                'result' => 99,
                'status' => 'ERROR',
                'data'   => ['balance' => 0]
            ]);
        }
    }
    // 📌 STATUS
    private static function handleStatus(array $payload): JsonResponse
    {
        $account = $payload['account'] ?? null;
        $transId = $payload['trans_id'] ?? null;
        $order = Order::where('transaction_id', $transId)
            ->where('providers', 'igamingplay')
            ->first();
        if (!$order) {
            return response()->json([
                'result' => 42,
                'status' => 'ERROR'
            ]);
        }
        $transStatus = ($order->refunded == 1) ? 'CANCELED' : 'OK';
        return response()->json([
            'result' => 0,
            'status' => 'OK',
            'data'   => [
                'trans_id'     => $transId,
                'trans_status' => $transStatus
            ]
        ]);
    }
}
