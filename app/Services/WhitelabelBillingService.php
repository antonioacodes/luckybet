<?php

namespace App\Services;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WhitelabelBillingService
{
    /**
     * Retorna true se whitelabel estiver vencido (passou da data + tolerância).
     */
    public function isExpired(): bool
    {
        $settings = Setting::query()->first();

        if (! $settings || ! $settings->whitelabel_enabled) {
            return false;
        }

        if (! $settings->whitelabel_next_payment_at) {
            return false;
        }

        $now = Carbon::now();

        $dueDate = $settings->whitelabel_next_payment_at instanceof Carbon
            ? $settings->whitelabel_next_payment_at
            : Carbon::parse($settings->whitelabel_next_payment_at);

        $graceDays = $settings->whitelabel_grace_days ?? 1;
        $limitDate = $dueDate->copy()->addDays($graceDays);

        return $now->greaterThan($limitDate);
    }

    /**
     * Verifica o token, renova token e data de vencimento.
     */
    public function verifyAndRefreshToken(string $inputToken): bool
    {
        /** @var Setting|null $settings */
        $settings = Setting::query()->first();

        if (! $settings || ! $settings->whitelabel_enabled) {
            Log::info('verifyAndRefreshToken: whitelabel desativado ou sem settings');
            return false;
        }

        Log::info('verifyAndRefreshToken: comparando token', [
            'token_digitado' => $inputToken,
            'token_banco'    => $settings->whitelabel_token,
        ]);

        if (! hash_equals((string) $settings->whitelabel_token, (string) $inputToken)) {
            Log::info('verifyAndRefreshToken: token inválido');
            return false;
        }

        $newToken   = $this->generateToken();
        $newDueDate = now()->addDays(7); // aqui define o próximo vencimento

        $settings->update([
            'whitelabel_token'                   => $newToken,
            'whitelabel_last_token_confirmed_at' => now(),
            'whitelabel_next_payment_at'         => $newDueDate,
        ]);

        Log::info('verifyAndRefreshToken: token e data atualizados', [
            'novo_token' => $newToken,
            'novo_venc'  => $newDueDate->toDateTimeString(),
        ]);

        return true;
    }

    public function generateToken(): string
    {
        return bin2hex(random_bytes(16));
    }
}