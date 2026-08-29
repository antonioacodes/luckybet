<?php
namespace App\Filament\Admin\Widgets;
use App\Models\Deposit;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class DepositsChart extends ChartWidget
{
    protected static ?string $heading = 'Depósitos Últimos 7 dias (R$)';
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
        $data = Deposit::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total_deposits')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $labels = [];
        $deposits = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $formattedDate = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('d/m');
            $deposits[] = $data->firstWhere('date', $formattedDate)?->total_deposits ?? 0;
            $currentDate->addDay();
        }
        return [
            'datasets' => [
                [
                    'label' => 'Depósitos',
                    'data' => $deposits,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
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