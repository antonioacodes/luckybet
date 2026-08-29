<?php

namespace App\Traits\Gateways;

use App\Models\Gateway;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait WazerPayWithdrawTrait
{
    protected static string $wazerApiKeyWithdraw;
    protected static ?int $wazerWithdrawStatusCode = null;
    protected static ?string $wazerWithdrawErrorBody = null;

    private static function loadWazerWithdrawCredentials(): bool
    {
        $gateway = Gateway::first();

        if (!$gateway || empty($gateway->wazerpay_api_key)) {
            Log::error('WazerPay Withdraw - API Key não configurada em gateways');
            return false;
        }

        self::$wazerApiKeyWithdraw = $gateway->wazerpay_api_key;
        return true;
    }

    /**
     * Cria um saque PIX na WazerPay para o Withdrawal informado
     */
public static function sendWazerPixWithdrawal(Withdrawal $withdrawal): array
{
    if (! self::loadWazerWithdrawCredentials()) {
        return [
            'status'  => false,
            'message' => 'Chave WazerPay para saque não configurada.',
        ];
    }

    $user = $withdrawal->user ?? User::find($withdrawal->user_id);

    // 1) Valor em centavos
    $amountCents = (int) round($withdrawal->amount * 100);

    // 2) Normalizar pix_key se for CPF
    $pixKey = $withdrawal->pix_key;
    $pixType = $withdrawal->pix_type;

    if ($pixType === 'cpf') {
        // Remove tudo que não for dígito
        $pixKeyDigits = preg_replace('/\D+/', '', (string) $pixKey);

        // Logar antes/depois para debug
        \Log::info('WazerPay Withdraw - Normalizando CPF PIX', [
            'original' => $pixKey,
            'digits'   => $pixKeyDigits,
        ]);

        $pixKey = $pixKeyDigits;
    }

    // 3) Montar destination de acordo com a doc
    $destination = [
        'type'     => 'pix',
        'pix_key'  => $pixKey,
        'pix_type' => $pixType,
    ];

    $payload = [
        'amount'     => $amountCents,       // em centavos
        'method'     => 'pix',
        'is_instant' => false,
        'destination'=> $destination,
        'notes'      => 'Saque cassino - user #' . $withdrawal->user_id,
        'metadata'   => [
            'internal_withdrawal_id' => $withdrawal->id,
            'user_id'                => $withdrawal->user_id,
            'gateway'                => 'wazerpay',
        ],
    ];

    $url = 'https://api.wazerpay.com.br/api/v1/withdrawals';

    \Log::info('WazerPay Withdraw - Enviando saque PIX', [
        'url'     => $url,
        'headers' => [
            'X-API-Key'    => self::$wazerApiKeyWithdraw,
            'Content-Type' => 'application/json',
        ],
        'payload' => $payload,
    ]);

    try {
        $response = Http::withHeaders([
            'X-API-Key'    => self::$wazerApiKeyWithdraw,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        self::$wazerWithdrawStatusCode = $response->status();
        self::$wazerWithdrawErrorBody  = $response->body();

        \Log::info('WazerPay Withdraw - Resposta bruta', [
            'status' => self::$wazerWithdrawStatusCode,
            'body'   => self::$wazerWithdrawErrorBody,
        ]);

        if (! $response->successful()) {
            return [
                'status'  => false,
                'message' => 'Erro HTTP na criação do saque WazerPay: '.$response->body(),
            ];
        }

        $data = $response->json();

        if (!($data['success'] ?? false) || empty($data['data'])) {
            return [
                'status'  => false,
                'message' => 'Resposta inesperada ao criar saque WazerPay',
                'raw'     => $data,
            ];
        }

        $wd = $data['data'];
        $withdrawalId = $wd['id'] ?? null;

        \Log::info('WazerPay Withdraw - Saque criado com sucesso', [
            'withdrawal_id'         => $withdrawal->id,
            'wazerpay_withdrawalId' => $withdrawalId,
            'status'                => $wd['status'] ?? null,
        ]);

        return [
            'status'       => true,
            'message'      => 'Saque criado com sucesso no WazerPay',
            'withdrawalId' => $withdrawalId,
            'wazer_status' => $wd['status'] ?? null,
        ];
    } catch (\Exception $e) {
        \Log::error('WazerPay Withdraw - Exceção ao criar saque', [
            'message' => $e->getMessage(),
        ]);

        return [
            'status'  => false,
            'message' => 'Exceção ao criar saque WazerPay: '.$e->getMessage(),
        ];
    }
}

}
