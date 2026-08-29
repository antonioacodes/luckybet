<?php

namespace App\Filament\Admin\Resources\UserResource\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    // importante pra Filament injetar o usuário atual da página
    public ?User $record = null;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        if (! $this->record) {
            return [];
        }

        $userId = $this->record->id;

        // Total apostado (todas as bets)
        $totalBets = Order::where('user_id', $userId)
            ->where('type', 'bet')
            ->sum('amount');

        // Total de ganhos (todas as wins)
        $totalWins = Order::where('user_id', $userId)
            ->where('type', 'win')
            ->sum('amount');

        // Total de perdas = Total Apostado - Total Ganho
        $totalLosses = $totalBets - $totalWins;

        // Garante que não seja negativo
        $totalLosses = max($totalLosses, 0);

        return [
            Stat::make('Total de Ganhos', 'R$ ' . number_format($totalWins, 2, ',', '.'))
                ->description('Total de vitórias em jogos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total de Perdas', 'R$ ' . number_format($totalLosses, 2, ',', '.'))
                ->description('Total apostado menos ganhos')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Total Apostado', 'R$ ' . number_format($totalBets, 2, ',', '.'))
                ->description('Soma de todas as apostas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),
        ];
    }

}
