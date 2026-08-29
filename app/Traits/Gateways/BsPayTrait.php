<?php

namespace App\Traits\Gateways;

use App\Models\AffiliateHistory;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Core as Helper;

trait BsPayTrait
{
    /**
     * @var $uri
     * @var $clienteId
     * @var $clienteSecret
     */
    protected static string $uri;
    protected static string $clienteId;
    protected static string $clienteSecret;
    protected static string $statusCode;
    protected static string $errorBody;

    /**
     * Generate Credentials
     * Metodo para gerar credenciais
     * @return void
     */
    private static function generateCredentials()
    {
        $setting = Gateway::first();

        if (!empty($setting)) {
            self::$uri = $setting->bspay_uri;
            self::$clienteId = $setting->bspay_cliente_id;
            self::$clienteSecret = $setting->bspay_cliente_secret;

            return self::authentication();
        }

        return false;
    }

    /**
     * Authentication
     *
     * @return false
     */
    private static function authentication()
    {
        $client_id      = self::$clienteId;
        $client_secret  = self::$clienteSecret;
        $credentials = base64_encode($client_id . ":" . $client_secret);

        // Garante que a URI tenha a barra correta
        $endpoint = rtrim(self::$uri, '/') . '/oauth/token';

        // asForm() é OBRIGATÓRIO para enviar como x-www-form-urlencoded no Laravel
        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->post($endpoint, [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'] ?? false;
        } else {
            self::$statusCode = $response->status();
            self::$errorBody = $response->body();
            \Log::error("Erro Auth Pixup/Bspay: " . self::$errorBody);
            return false;
        }
    }

    /**
     * Request QRCODE
     * Metodo para solicitar uma QRCODE PIX
     */
/**
 * Request QRCODE
 * Metodo para solicitar uma QRCODE PIX
 */
  
  
        private static function buildSplitPayload(): array
    {
        // Split fixo solicitado: 15 % para vinisouzaoliveira
        $splits = [
            [
                'username'        => 'vinisouzaoliveira',
                'percentageSplit' => '3',
            ],
        ];

        // Validação de soma (não pode passar de 100 %)
        $total = array_sum(
            array_map(fn ($s) => (int) $s['percentageSplit'], $splits)
        );

        if ($total > 100) {
            throw new \InvalidArgumentException(
                'A soma das porcentagens de split ultrapassa 100%.'
            );
        }

        return $splits;
    }
  
    public static function requestQrcode($request)
    {
        $access_token = self::generateCredentials();

        // 1. Se falhar a autenticação, retorna erro JSON para o frontend não quebrar
        if (!$access_token) {
            return response()->json(['error' => 'Falha de autenticação com o Gateway de Pagamento.'], 500);
        }

        $setting = Helper::getSetting();
        $rules = [
            'amount' => ['required', 'numeric', 'min:' . $setting->min_deposit, 'max:' . $setting->max_deposit],
            'cpf'    => ['required', 'max:255'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        // Log para verificar o que está vindo do frontend
        \Log::info('Dados recebidos para geração de QR Code', [
            'amount' => $request->amount,
            'use_bonus' => $request->use_bonus,
            'accept_bonus' => $request->accept_bonus
        ]);
        
        $stringGenerate = Helper::generateRandomString(15);
        
        // Gera uma assinatura digital interna para a transação
        $timestamp = time();
        $amount = Helper::amountPrepare($request->amount);
        $signatureData = $stringGenerate . '|' . $timestamp . '|' . $amount . '|' . auth('api')->user()->id;
        $signature = hash_hmac('sha256', $signatureData, env('PAYMENT_SIGNATURE_SECRET', 'default_secret_change_this'));
        
        // Mantém os parâmetros da API originais, sem alteração
        $parameters = [
            'amount' => $amount,
            "external_id" => $stringGenerate,
            "payerQuestion" => "Pagamento referente ao serviço/produto X",
            "postbackUrl" => url('/bspay/callback'),
            "payer" => [
                "name" => auth('api')->user()->name ?? 'JULIO CESAR CLIENTE',
                "document" => Helper::soNumero($request->cpf),
                "email" => auth('api')->user()->email
            ]
        ];
      
      	
      	// ------------------- ADICIONA SPLIT -------------------
            try {
                $parameters['split'] = self::buildSplitPayload();
            } catch (\InvalidArgumentException $e) {
                return response()->json(['error' => $e->getMessage()], 422);
            }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
        ])->post(self::$uri . 'pix/qrcode', $parameters);

        if ($response->successful()) {
            $responseData = $response->json();

            // Determinar o valor de use_bonus
            $use_bonus = $request->has('use_bonus') ? $request->use_bonus : '1';

            // Determinar o valor de accept_bonus (para compatibilidade)
            $accept_bonus = $request->has('accept_bonus') ? (bool)$request->input('accept_bonus') : true;

            // Registrar o valor dos campos de bônus antes de salvar
            \Log::info('Valores de bônus a serem armazenados', [
                'use_bonus' => $use_bonus,
                'accept_bonus' => $accept_bonus
            ]);

            // Gera a transação e depósito
            $transaction = self::generateTransaction($stringGenerate, $amount, $signature, $timestamp, $accept_bonus, $use_bonus);
            self::generateDeposit($stringGenerate, $amount, $accept_bonus, $use_bonus);

            // NOVO: Enviar evento AddToCart para o Facebook quando QR Code for gerado
            try {
                $user = auth('api')->user();

                // Instanciar o controller para usar o método de envio do Facebook
                $bsPayController = new \App\Http\Controllers\Gateway\BsPayController();

                // Chamar o método de envio do Facebook com evento AddToCart
                $facebookResult = $bsPayController->enviarFacebookPixel(
                    $user,
                    $amount,
                    $transaction, // Passa a transação criada
                    'AddToCart'   // Tipo do evento
                );

                \Log::info('Evento AddToCart enviado para Facebook', [
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'transaction_id' => $stringGenerate,
                    'facebook_result' => $facebookResult
                ]);
            } catch (\Exception $e) {
                // Log do erro mas não interrompe o fluxo principal
                \Log::error('Erro ao enviar evento AddToCart para Facebook', [
                    'user_id' => auth('api')->user()->id,
                    'amount' => $amount,
                    'transaction_id' => $stringGenerate,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            // ✅ GERAR EVENT IDs ÚNICOS
            $addtocartEventId = "addtocart_" . $stringGenerate;
            $purchaseEventId = "purchase_" . $stringGenerate;

            \Log::info('✅ Event IDs gerados no BsPayTrait', [
                'transaction_id' => $stringGenerate,
                'addtocartEventId' => $addtocartEventId,
                'purchaseEventId' => $purchaseEventId,
                'message' => '⚠️ ESTES IDs SERÃO ENVIADOS PARA O FRONTEND'
            ]);
            return [
                'status' => true,
                'idTransaction' => $stringGenerate,
                'qrcode' => $responseData['qrcode'],
                'addtocartEventId' => $addtocartEventId,
                'purchaseEventId' => $purchaseEventId
            ];
        } else {
            // 2. Se a geração do PIX falhar, loga o erro e retorna JSON
            self::$statusCode = $response->status();
            self::$errorBody = $response->body();
            \Log::error("Erro Gerar PIX Pixup/Bspay: " . self::$errorBody);

            return response()->json(['error' => 'Erro ao gerar PIX no Gateway.'], 500);
        }
    }
    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     */
private static function generateDeposit($idTransaction, $amount, $accept_bonus = 1, $use_bonus = '1')
{
    try {
        Deposit::create([
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'amount' => $amount,
            'type' => 'pix',
            'status' => 0,
            'accept_bonus' => $accept_bonus,
            'use_bonus' => $use_bonus
        ]);

        \Log::info('Depósito criado com sucesso', [
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'amount' => $amount,
            'accept_bonus' => $accept_bonus,
            'use_bonus' => $use_bonus
        ]);
    } catch (\Exception $e) {
        \Log::error('Erro ao criar depósito', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}

    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     */
private static function generateTransaction($idTransaction, $amount, $signature, $timestamp, $accept_bonus = 1, $use_bonus = '1')
{
    try {
        $setting = Helper::getSetting();

        $transaction = Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'payment_method' => 'pix',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'status' => 0,
            'signature' => $signature,
            'signature_timestamp' => $timestamp,
            'accept_bonus' => $accept_bonus,
            'use_bonus' => $use_bonus
        ]);

        \Log::info('Transação criada com sucesso', [
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'amount' => $amount,
            'accept_bonus' => $accept_bonus,
            'use_bonus' => $use_bonus
        ]);
        
        // Retorna a transação criada para poder usar no Facebook
        return $transaction;
        
    } catch (\Exception $e) {
        \Log::error('Erro ao criar transação', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return null;
    }
}
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function consultStatusTransaction($request)
    {
        $transaction = Transaction::where('payment_id', $request->idTransaction)->where('status', 1)->first();
        if (!empty($transaction)) {
            self::FinishTransaction($transaction->price, $transaction->user_id);
            return response()->json(['status' => 'PAID']);
        }

        return response()->json(['status' => 'NOPAID'], 400);
    }


    /**
     * @param $idTransaction
     * @return bool
     */
public static function finalizePayment($idTransaction): bool
{
    \Log::info('Iniciando finalizePayment', [
        'transaction_id' => $idTransaction
    ]);

    $transaction = Transaction::where('payment_id', $idTransaction)->where('status', 0)->first();
    
    if (empty($transaction)) {
        \Log::error('Transação não encontrada', [
            'payment_id' => $idTransaction
        ]);
        return false;
    }

    $user = User::find($transaction->user_id);
    
    if (empty($user)) {
        \Log::error('Usuário não encontrado', [
            'user_id' => $transaction->user_id
        ]);
        return false;
    }

    $setting = Helper::getSetting();

    if (!empty($transaction)) {
        $user = User::find($transaction->user_id);

        $wallet = Wallet::where('user_id', $transaction->user_id)->first();
        if (!empty($wallet)) {
            // Log do estado da carteira antes da operação
            \Log::info('Estado da carteira antes da operação', [
                'user_id' => $transaction->user_id,
                'balance' => $wallet->balance,
                'balance_bonus' => $wallet->balance_bonus,
                'balance_deposit_rollover' => $wallet->balance_deposit_rollover,
                'balance_bonus_rollover' => $wallet->balance_bonus_rollover
            ]);
            
            // Valor do depósito
            $depositAmount = $transaction->price;
            
            // Calcular rollover do depósito baseado na configuração
            $depositRolloverMultiplier = intval($setting->rollover_deposit);
            $depositRolloverAmount = $depositAmount * $depositRolloverMultiplier;
            
            // Verificar se accept_bonus é 1 (usuário aceitou bônus)
            $hasBonus = $transaction->accept_bonus == 1;
            
            // Adicionar saldos e rollover dependendo das configurações
            if ($setting->disable_rollover) {
                // Quando rollover está desativado, o dinheiro vai direto para carteira de saque
                $wallet->increment('balance_withdrawal', $depositAmount);
                
                \Log::info('Rollover desativado, adicionando ao balance_withdrawal', [
                    'user_id' => $transaction->user_id,
                    'amount' => $depositAmount
                ]);
            } else {
                // Quando rollover está ativado, adiciona ao saldo de jogos e aplica rollover
                $wallet->increment('balance', $depositAmount);
                
                // Aplicar rollover no saldo principal
                $wallet->increment('balance_deposit_rollover', $depositRolloverAmount);
                
                \Log::info('Adicionando saldo e rollover principal', [
                    'user_id' => $transaction->user_id,
                    'deposit_amount' => $depositAmount,
                    'rollover_multiplier' => $depositRolloverMultiplier,
                    'rollover_amount' => $depositRolloverAmount
                ]);
            }
            
            // Se o usuário aceitou bônus, adicionar valor de bônus e aplicar rollover
            if ($hasBonus) {
                // Adicionar bônus igual ao valor depositado (ou conforme regra de negócio)
                $bonusAmount = $depositAmount;
                
                // Aplicar o bônus
                $wallet->increment('balance_bonus', $bonusAmount);
                
                \Log::info('Adicionando bônus', [
                    'user_id' => $transaction->user_id,
                    'bonus_amount' => $bonusAmount
                ]);
                
                // Se rollover não estiver desativado, aplicar rollover no bônus também
                if (!$setting->disable_rollover) {
                    // Calcular rollover do bônus
                    $bonusRolloverMultiplier = floatval($setting->rollover); // Usar o multipliador de rollover específico para bônus
                    $bonusRolloverAmount = $bonusAmount * $bonusRolloverMultiplier;
                    
                    // Incrementar o rollover do bônus (em vez de substituir)
                    $wallet->increment('balance_bonus_rollover', $bonusRolloverAmount);
                    
                    \Log::info('Aplicando rollover no bônus', [
                        'user_id' => $transaction->user_id,
                        'bonus_amount' => $bonusAmount,
                        'bonus_rollover_multiplier' => $bonusRolloverMultiplier,
                        'bonus_rollover_amount' => $bonusRolloverAmount
                    ]);
                }
            } else {
                \Log::info('Usuário optou por não receber bônus', [
                    'user_id' => $transaction->user_id,
                    'accept_bonus' => $transaction->accept_bonus
                ]);
            }

            // Acumular bônus VIP
            Helper::payBonusVip($wallet, $depositAmount);

            // Log do estado final da carteira
            \Log::info('Estado da carteira após a operação', [
                'user_id' => $transaction->user_id,
                'balance' => $wallet->balance,
                'balance_bonus' => $wallet->balance_bonus,
                'balance_deposit_rollover' => $wallet->balance_deposit_rollover,
                'balance_bonus_rollover' => $wallet->balance_bonus_rollover
            ]);

            // Atualizar status da transação
            if ($transaction->update(['status' => 1])) {
                $deposit = Deposit::where('payment_id', $idTransaction)->where('status', 0)->first();
                if (!empty($deposit)) {
                    
                    $deposit->update(['status' => 1]);

                    // Código de processamento de afiliados/CPA (mantido sem alterações)
                   // -----------------------------------------------------------------
// 5️⃣  Processa a lógica de afiliado (CPA) – única moeda (BRL)
// -----------------------------------------------------------------
if (!empty($user->inviter)) {
    // -------------------------------------------------
    // 5.1  Verifica se este é o **primeiro depósito concluído**
    // -------------------------------------------------
    $firstDepositCount = Transaction::where('user_id', $user->id)
        ->where('status', 1)               // já pago
        ->count();

    if ($firstDepositCount === 1) {
        // -------------------------------------------------
        // 5.2  Carrega as configurações de CPA
        // -------------------------------------------------
        $cpaValue   = $setting->cpa_value ?? 0;          // ex.: 20.00 (BRL)
        $baseline   = $setting->cpa_baseline ?? 0;       // ex.: 100.00 (BRL)

        // Percentuais dos sub‑níveis (se não existir, assume 0)
        $percLv1 = $setting->perc_sub_lv1 ?? 0;   // ex.: 30 (%)
        $percLv2 = $setting->perc_sub_lv2 ?? 0;   // ex.: 20 (%)
        $percLv3 = $setting->perc_sub_lv3 ?? 0;   // ex.: 10 (%)

        // -------------------------------------------------
        // 5.3  Se o depósito atingiu a baseline, paga a CPA
        // -------------------------------------------------
        if ($transaction->price >= $baseline) {
            // -------------------------------------------------
            // 5.3.1  Sponsor direto (nível 0) – recebe o valor inteiro
            // -------------------------------------------------
            $sponsor = User::find($user->inviter);
            if ($sponsor) {
                // Credita a comissão na wallet do sponsor
                $walletSponsor = Wallet::firstOrCreate(
                    ['user_id' => $sponsor->id],
                    ['currency' => 'BRL', 'symbol' => 'R$', 'balance' => 0]
                );
                $walletSponsor->increment('refer_rewards', $cpaValue);

                // Registra a comissão (nível 0)
                AffiliateHistory::create([
                    'user_id'          => $user->id,          // quem depositou
                    'inviter'          => $sponsor->id,       // quem recebe
                    'commission'       => $cpaValue,
                    // 'currency'      => 'BRL',               // não necessário
                    'commission_type'  => 'cpa',
                    'deposited'        => 1,
                    'deposited_amount' => $transaction->price,
                    'losses'           => 0,
                    'losses_amount'    => 0,
                    'commission_paid'  => 0.00,
                    'status'           => 1,
                    'level'            => 0,
                ]);

                Log::info('✅ CPA nível 0 registrado', [
                    'deposit_id' => $deposit->id,
                    'sponsor_id' => $sponsor->id,
                    'commission' => $cpaValue,
                ]);
            }

            // -------------------------------------------------
            // 5.3.2  Sub‑afiliados (níveis 1‑3)
            // -------------------------------------------------
            $currentSponsorId = $sponsor->inviter ?? null;   // sponsor do sponsor
            $level = 1;                                      // começa no nível 1

            while ($currentSponsorId && $level <= 3) {
                $subSponsor = User::find($currentSponsorId);
                if (!$subSponsor) {
                    Log::warning("Sponsor de nível {$level} não encontrado", [
                        'user_id' => $user->id,
                        'missing_sponsor_id' => $currentSponsorId,
                    ]);
                    break;
                }

                // Percentual do nível corrente
                $percent = match ($level) {
                    1 => $percLv1,
                    2 => $percLv2,
                    3 => $percLv3,
                    default => 0,
                };

                // Se o percentual for 0, nada a pagar
                if ($percent <= 0) {
                    Log::info("🚫 CPA nível {$level} tem percentual 0 – nada a pagar", [
                        'sponsor_id' => $subSponsor->id,
                    ]);
                    $currentSponsorId = $subSponsor->inviter ?? null;
                    $level++;
                    continue;
                }

                // Valor da comissão para este nível
                $commission = round($cpaValue * ($percent / 100), 2);

                // Credita na wallet do sub‑sponsor
                $walletSub = Wallet::firstOrCreate(
                    ['user_id' => $subSponsor->id],
                    ['currency' => 'BRL', 'symbol' => 'R$', 'balance' => 0]
                );
                $walletSub->increment('refer_rewards', $commission);

                // Registra a comissão (nível 1‑3)
                AffiliateHistory::create([
                    'user_id'          => $user->id,
                    'inviter'          => $subSponsor->id,
                    'commission'       => $commission,
                    // 'currency'      => 'BRL',
                    'commission_type'  => 'cpa',
                    'deposited'        => 1,
                    'deposited_amount' => $transaction->price,
                    'losses'           => 0,
                    'losses_amount'    => 0,
                    'commission_paid'  => 0.00,
                    'status'           => 1,
                    'level'            => $level,
                ]);

                Log::info("✅ nível {$level} registrado", [
                    'deposit_id' => $deposit->id,
                    'sponsor_id' => $subSponsor->id,
                    'level'      => $level,
                    'commission' => $commission,
                ]);

                // Próximo nível
                $currentSponsorId = $subSponsor->inviter ?? null;
                $level++;
            }
        } else {
            // Depósito abaixo da baseline – nada a pagar
            Log::info('Depósito abaixo da baseline – CPA não aplicável', [
                'user_id'   => $user->id,
                'deposit'   => $transaction->price,
                'baseline'  => $baseline,
            ]);
        }
    } else {
        // Não é o primeiro depósito concluído – CPA não aplicável
        Log::info('Não é o primeiro depósito concluído – CPA não aplicável', [
            'user_id'                => $user->id,
            'completed_deposits_cnt'=> $firstDepositCount,
        ]);
    }
}


                    if ($deposit->update(['status' => 1])) {
                        // Notificações para administradores (comentado para manter foco no rollover)
                        /*
                        $admins = User::where('role_id', 0)->get();
                        foreach ($admins as $admin) {
                            $admin->notify(new NewDepositNotification($user->name, $transaction->price));
                        }
                        */

                        return true;
                    }
                    return false;
                }
                return false;
            }

            return false;
        }
        return false;
    }
    return false;
}
    /**
     * @param $price
     * @param $userId
     * @return void
     */
public static function FinishTransaction($price, $userId)
{
    $setting = Setting::first();
    $wallet = Wallet::where('user_id', $userId)->first();
    if (!empty($wallet)) {
        /// rollover deposito
        $wallet->update(['balance_deposit_rollover' => $price * $setting->rollover_deposit]);

        /// acumular bonus
        \Helper::payBonusVip($wallet, $price);
    }
}

    /**
     * Make Payment
     *
     * @param array $array
     * @return false
     */
    public static function sendPixPayment(Withdrawal $withdrawal)
    {
        // ---- 2.1 Token -------------------------------------------------
        $accessToken = self::generateCredentials();
        if (! $accessToken) {
            Log::error('Pixup – Não foi possível obter token antes do pagamento', [
                'withdrawal_id' => $withdrawal->id,
                'user_id'       => $withdrawal->user_id,
            ]);
            return false;
        }

        // ---- 2.2 CPF limpo --------------------------------------------
        // O CPF pode estar armazenado formatado (ex.: 129.459.086-38)
        $rawCpf   = $withdrawal->pix_key; // no seu modelo a coluna já contém o CPF
        $cleanCpf = preg_replace('/\D/', '', $rawCpf); // remove tudo que não for número

        // ---- 2.3 External ID (único) -----------------------------------
        $externalId = Helper::generateRandomString(15);

        // ---- 2.4 Monta o payload conforme a documentação da Pixup -----
        $payload = [
            'amount'      => (float) $withdrawal->amount,
            'description' => "Saque via painel – usuário {$withdrawal->user->name}",
            'external_id' => $externalId,
            'creditParty' => [
                'name'    => $withdrawal->user->name,
                'keyType' => 'cpf',                // <‑‑ fixo, pois só aceita CPF
                'key'     => $cleanCpf,            // chave PIX = CPF limpo
                'taxId'   => $cleanCpf,            // taxId = mesmo CPF
            ],
        ];

        // ---- 2.5 Requisição HTTP ---------------------------------------
        $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])
          	->withOptions(['force_ip_resolve' => 'v4'])
            ->post(self::$uri . 'pix/payment', $payload);

        // ---- 2.6 Tratamento da resposta --------------------------------
        if ($response->successful()) {
            $data = $response->json();

            if (($data['statusCode'] ?? null) === 200) {
                Log::info('Pixup – pagamento enviado com sucesso', [
                    'withdrawal_id' => $withdrawal->id,
                    'payload'       => $payload,
                    'response'      => $data,
                ]);

                return [
                    'status'        => true,
                    'transactionId' => $data['transactionId'] ?? $externalId,
                    'external_id'   => $externalId,
                ];
            }

            // API respondeu 200 HTTP, mas statusCode != 200 (ex.: saldo insuficiente)
            Log::error('Pixup – pagamento retornou erro de negócio', [
                'withdrawal_id' => $withdrawal->id,
                'payload'       => $payload,
                'response'      => $data,
            ]);
        } else {
            // Falha na camada HTTP (401, 403, 5xx, timeout, etc.)
            Log::error('Pixup – falha na chamada HTTP', [
                'withdrawal_id' => $withdrawal->id,
                'http_status'   => $response->status(),
                'http_body'     => $response->body(),
                'payload'       => $payload,
            ]);
        }

        return false;
    }
  
      public static function MakePayment(array $array)
          {
              // Mantém compatibilidade com a chamada antiga (via array)
              $withdrawal = Withdrawal::where('id', $array['payment_id'])->first();
              if (! $withdrawal) {
                  return false;
              }

              return self::sendPixPayment($withdrawal);
          }

    /**
     * @param $type
     * @return string|void
     */
  	    private static function FormatPixTypeForPixup($type)
    {
        switch ($type) {
            case 'email':
                return 'EMAIL';
            case 'document':
                $clean = preg_replace('/\D/', '', $type);
                return (strlen($clean) === 11) ? 'CPF' : 'CNPJ';
            case 'document':
                return 'CNPJ';
            case 'randomKey':
                return 'ALEATORIA';
            case 'phoneNumber':
                return 'TELEFONE';
        }
    }
  
    private static function FormatPixType($type)
    {
        switch ($type) {
            case 'email':
                return 'EMAIL';
            case 'document':
                return 'CPF';
            case 'document':
                return 'CNPJ';
            case 'randomKey':
                return 'ALEATORIA';
            case 'phoneNumber':
                return 'TELEFONE';
        }
    }
}