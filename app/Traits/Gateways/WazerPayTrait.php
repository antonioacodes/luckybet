<?php

namespace App\Traits\Gateways;

use App\Helpers\Core as Helper;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait WazerPayTrait
{
    protected static string $wazerApiKey;
    protected static ?int $wazerStatusCode = null;
    protected static ?string $wazerErrorBody = null;

    /**
     * Carrega credenciais do WazerPay
     */
    private static function loadCredentials(): bool
    {
        $gateway = Gateway::first();
        if (!$gateway || empty($gateway->wazerpay_api_key)) {
            Log::error('WazerPay API Key não configurada em gateways');
            return false;
        }

        self::$wazerApiKey = $gateway->wazerpay_api_key;
        return true;
    }

    /**
     * Cria cobrança PIX no WazerPay e gera QR Code
     */
public static function requestQrcodeWazerPay($request)
{
    if (!self::loadCredentials()) {
        return response()->json(['message' => 'Gateway WazerPay não configurado.'], 500);
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

    $user         = auth('api')->user();
    $amountReal = (float) $request->amount;
    $amountCents = (int) round($amountReal * 100);
    $stringGenerate = Helper::generateRandomString(15);      // nosso payment_id interno

    Log::info('WazerPay - Gerando cobrança PIX', [
        'user_id'      => $user->id,
        'amount_raw'   => $request->amount,
        'amount_cents' => $amountCents,
    ]);

    $payload = [
        'amount'         => $amountCents,
        'payment_method' => 'pix',
        'description'    => 'Depósito cassino - user #' . $user->id,
        'customer'       => [
            'name'     => $user->name,
            'email'    => $user->email,
            'document' => Helper::soNumero($request->cpf),
        ],
        'metadata'       => [
            'user_id'     => $user->id,
            'internal_id' => $stringGenerate,
            'gateway'     => 'wazerpay',
        ],
    ];

    $idempotencyKey = (string) \Illuminate\Support\Str::uuid();

    $url = 'https://api.wazerpay.com.br/api/v1/external/charges';

    Log::info('WazerPay - Enviando requisição', [
        'url'     => $url,
        'headers' => [
            'X-API-Key'       => '***hidden***',
            'Content-Type'    => 'application/json',
            'Idempotency-Key' => $idempotencyKey,
        ],
        'payload' => $payload,
    ]);

    $response = Http::withHeaders([
        'X-API-Key'       => self::$wazerApiKey,
        'Content-Type'    => 'application/json',
        'Idempotency-Key' => $idempotencyKey,
        'Accept'          => 'application/json',
    ])->post($url, $payload);

    Log::info('WazerPay - Resposta bruta', [
        'status' => $response->status(),
        'body'   => $response->body(),
    ]);

    if (!$response->successful()) {
        self::$wazerStatusCode = $response->status();
        self::$wazerErrorBody  = $response->body();

        Log::error('WazerPay - Erro HTTP ao criar cobrança PIX', [
            'status' => self::$wazerStatusCode,
            'body'   => self::$wazerErrorBody,
        ]);

        return response()->json(['message' => 'Erro ao criar cobrança PIX.'], 500);
    }

    $data = $response->json();

    // Agora batendo com a resposta que você mostrou:
    // { "success": true, "data": { ... } }
    if (!($data['success'] ?? false) || empty($data['data'])) {
        Log::error('WazerPay - Resposta inesperada ao criar cobrança PIX', ['response' => $data]);
        return response()->json(['message' => 'Erro ao criar cobrança PIX.'], 500);
    }

    $charge = $data['data'];

    // Bônus (mesma lógica BsPay)
    $use_bonus    = $request->has('use_bonus') ? $request->use_bonus : '1';
    $accept_bonus = $request->has('accept_bonus') ? (bool)$request->input('accept_bonus') : true;

    $timestamp     = time();
    $signatureData = $stringGenerate . '|' . $timestamp . '|' . $amountCents . '|' . $user->id;
    $signature     = hash_hmac('sha256', $signatureData, env('PAYMENT_SIGNATURE_SECRET', 'default_secret_change_this'));

    // Criar transação e depósito no banco local
    $transaction = self::generateTransactionWazer($stringGenerate, $amountReal, $signature, $timestamp, $accept_bonus, $use_bonus);
    self::generateDepositWazer($stringGenerate, $amountReal, $accept_bonus, $use_bonus);

    // Facebook Pixel (mantendo seu padrão)
    try {
        $bsPayController = new \App\Http\Controllers\Gateway\BsPayController();
        $bsPayController->enviarFacebookPixel(
            $user,
            $amountCents / 100,
            $transaction,
            'AddToCart'
        );
    } catch (\Exception $e) {
        Log::error('WazerPay - Erro ao enviar evento AddToCart para Facebook', [
            'user_id'        => $user->id,
            'amount'         => $amountCents / 100,
            'transaction_id' => $stringGenerate,
            'error'          => $e->getMessage(),
        ]);
    }

    $addtocartEventId = "addtocart_" . $stringGenerate;
    $purchaseEventId  = "purchase_" . $stringGenerate;

    Log::info('WazerPay - Event IDs gerados', [
        'transaction_id'   => $stringGenerate,
        'addtocartEventId' => $addtocartEventId,
        'purchaseEventId'  => $purchaseEventId,
    ]);

    return [
        'status'           => true,
        'idTransaction'    => $stringGenerate,
        'qrcode'           => $charge['pix_copy_paste'] ?? $charge['pix_qr_code'] ?? null,
        'addtocartEventId' => $addtocartEventId,
        'purchaseEventId'  => $purchaseEventId,
    ];
}


    private static function generateDepositWazer($idTransaction, $amount, $accept_bonus = 1, $use_bonus = '1')
    {
        try {
            Deposit::create([
                'payment_id' => $idTransaction,
                'user_id'    => auth('api')->user()->id,
                'amount'     => $amount,
                'type'       => 'pix',
                'status'     => 0,
                'accept_bonus' => $accept_bonus,
                'use_bonus'    => $use_bonus,
                'gateway'      => 'wazerpay',
            ]);

            Log::info('WazerPay - Depósito criado com sucesso', [
                'payment_id'   => $idTransaction,
                'user_id'      => auth('api')->user()->id,
                'amount'       => $amount,
                'accept_bonus' => $accept_bonus,
                'use_bonus'    => $use_bonus,
            ]);
        } catch (\Exception $e) {
            Log::error('WazerPay - Erro ao criar depósito', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    private static function generateTransactionWazer($idTransaction, $amount, $signature, $timestamp, $accept_bonus = 1, $use_bonus = '1')
    {
        try {
            $setting = Helper::getSetting();

            $transaction = Transaction::create([
                'payment_id'          => $idTransaction,
                'user_id'             => auth('api')->user()->id,
                'payment_method'      => 'pix',
                'price'               => $amount,
                'currency'            => $setting->currency_code,
                'status'              => 0,
                'signature'           => $signature,
                'signature_timestamp' => $timestamp,
                'accept_bonus'        => $accept_bonus,
                'use_bonus'           => $use_bonus,
                'gateway'             => 'wazerpay',
            ]);

            Log::info('WazerPay - Transação criada com sucesso', [
                'payment_id'   => $idTransaction,
                'user_id'      => auth('api')->user()->id,
                'amount'       => $amount,
                'accept_bonus' => $accept_bonus,
                'use_bonus'    => $use_bonus,
            ]);

            return $transaction;
        } catch (\Exception $e) {
            Log::error('WazerPay - Erro ao criar transação', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Consulta status (reutiliza a mesma lógica do BsPayTrait)
     */
    public static function consultStatusTransactionWazer($request)
    {
        // Mesma lógica que consultStatusTransaction no BsPayTrait
        $transaction = \App\Models\Transaction::where('payment_id', $request->idTransaction)
            ->where('status', 1)
            ->first();

        if (!empty($transaction)) {
            // FinishTransaction/FinalizePayment já deve ter sido chamado via webhook
            return response()->json(['status' => 'PAID']);
        }

        return response()->json(['status' => 'NOPAID'], 400);
    }
}
