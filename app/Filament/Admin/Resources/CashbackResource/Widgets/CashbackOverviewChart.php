<?php

namespace App\Filament\Admin\Resources\CashbackResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CashbackUser;
use Filament\Support\RawJs;
use Carbon\Carbon;

class CashbackOverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Total Resgatado (Últimos 30 dias)';
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 1;
  	protected int | string | array $columnSpan ='full';

    // Altura do gráfico
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Agrupa dados dos últimos 30 dias
        $data = CashbackUser::where('status', 'claimed')
            ->where('redeemed_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(redeemed_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepara labels e valores
        $labels = [];
        $values = [];

        // Preenche dias vazios se necessário, ou usa direto
        foreach ($data as $row) {
            $labels[] = Carbon::parse($row->date)->format('d/m');
            $values[] = $row->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Valor Resgatado (R$)',
                    'data' => $values,
                    'borderColor' => '#ec4899', // Pink do seu tema
                    'backgroundColor' => 'rgba(236, 72, 153, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    // Formatação para moeda brasileira no tooltip
    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                            }
                            return label;
                        }",
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'ticks' => [
                        'callback' => "function(value) {
                            return 'R$ ' + value;
                        }",
                    ],
                ],
            ],
        ];
    }
}
