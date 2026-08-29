<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Withdrawal;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WithdrawalsChart extends ChartWidget
{
    protected static ?string $heading = 'Saques Últimos 7 dias (R$)';
    protected static ?string $maxHeight = '300px'; // Mantido para layout

    // Removido o $columnSpan para evitar o erro de redeclaração

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // Pega os dados dos últimos 7 dias para simplificar
        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->subDays(6)->startOfDay(); // Últimos 7 dias

        $data = Withdrawal::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total_withdrawals')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $withdrawals = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $formattedDate = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('d/m');
            $withdrawals[] = $data->firstWhere('date', $formattedDate)?->total_withdrawals ?? 0;
            $currentDate->addDay();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Saques',
                    'data' => $withdrawals,
                    'borderColor' => '#FF6384',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        // Retornando opções mínimas para evitar qualquer erro de callback
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    // Removido o getFilters() conforme solicitado
    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
