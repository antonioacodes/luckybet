<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Setting;
use App\Services\WhitelabelBillingService;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class WhitelabelPaymentWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.whitelabel-payment-widget';

    public ?string $token = null;

    public static function canView(): bool
    {
        $settings = Setting::query()->first();

        return (bool) ($settings?->whitelabel_enabled ?? false);
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    /**
     * Método chamado pelo formulário (wire:submit.prevent="confirmToken").
     * O service é injetado automaticamente pelo container.
     */
    public function confirmToken(WhitelabelBillingService $billingService): void
    {
        $token = trim((string) $this->token);

        \Log::info('confirmToken chamado', [
            'token_digitado' => $token,
        ]);

        if ($token === '') {
            Notification::make()
                ->title('Token obrigatório')
                ->danger()
                ->body('Informe o token atual para confirmar o pagamento.')
                ->send();

            return;
        }

        if (! $billingService->verifyAndRefreshToken($token)) {
            Notification::make()
                ->title('Token inválido')
                ->danger()
                ->body('O token informado está incorreto ou o whitelabel não está habilitado.')
                ->send();

            return;
        }

        // Token ok
        $this->token = null;

        Notification::make()
            ->title('Pagamento confirmado')
            ->success()
            ->body('Token validado e atualização do vencimento realizada com sucesso.')
            ->send();

        $this->dispatch('$refresh');
    }

    public function getViewData(): array
    {
        $settings = Setting::query()->first();

        if (! $settings || ! $settings->whitelabel_enabled || ! $settings->whitelabel_next_payment_at) {
            return [
                'visible' => false,
            ];
        }

        $now = Carbon::now();

        $due = $settings->whitelabel_next_payment_at instanceof Carbon
            ? $settings->whitelabel_next_payment_at
            : Carbon::parse($settings->whitelabel_next_payment_at);

        $graceDays = $settings->whitelabel_grace_days ?? 1;
        $limit = $due->copy()->addDays($graceDays);

        $status  = 'info';
        $message = '';

        if ($now->lessThan($due)) {
            $status  = 'info';
            $message = "Próximo pagamento em {$due->format('d/m/Y')} (com {$graceDays} dia(s) de tolerância).";
        } elseif ($now->between($due, $limit)) {
            $status  = 'warning';
            $message = "Pagamento vencido em {$due->format('d/m/Y')}. Você está no período de tolerância até {$limit->format('d/m/Y')}.";
        } else {
            $status  = 'danger';
            $message = "Período de tolerância encerrado. O cassino está em manutenção até a confirmação do pagamento.";
        }

        return [
            'visible'   => true,
            'status'    => $status,
            'message'   => $message,
            'due'       => $due,
            'limit'     => $limit,
            'graceDays' => $graceDays,
        ];
    }
}