<?php

namespace App\Filament\Admin\Resources\CashbackResource\Pages;

use App\Filament\Admin\Resources\CashbackResource;
use App\Models\CashbackSetting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class ListCashbacks extends ListRecords
{
    protected static string $resource = CashbackResource::class;

    // Injeta o gráfico no topo da página
    protected function getHeaderWidgets(): array
    {
        return [
            CashbackResource\Widgets\CashbackOverviewChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Botão para Editar as Regras (Porcentagem e Periodicidade)
            Actions\Action::make('settings')
                ->label('Configurar Regras')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('primary')
                ->modalHeading('Configurações de Cashback')
                ->modalDescription('Defina a porcentagem de retorno e a frequência de análise.')
                ->fillForm(function (): array {
                    // Carrega os dados atuais ou padrões
                    $setting = CashbackSetting::first();
                    return $setting ? $setting->toArray() : [
                        'percentage' => 10,
                        'periodicity' => 'weekly',
                        'name' => 'Cashback Padrão'
                    ];
                })
                ->form([
                    TextInput::make('name')
                        ->label('Nome da Campanha')
                        ->placeholder('Ex: Cashback Semanal VIP')
                        ->required(),

                    TextInput::make('percentage')
                        ->label('Porcentagem (%)')
                        ->helperText('Quanto o usuário recebe de volta sobre as perdas.')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(100)
                        ->suffix('%')
                        ->required(),

                    Select::make('periodicity')
                        ->label('Periodicidade')
                        ->helperText('Define o intervalo de cálculo das perdas.')
                        ->options([
                            'daily' => 'Diário (Ontem)',
                            'weekly' => 'Semanal (Últimos 7 dias)',
                            'monthly' => 'Mensal (Últimos 30 dias)',
                        ])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    // Salva ou Atualiza
                    $setting = CashbackSetting::first();

                    if ($setting) {
                        $setting->update($data);
                    } else {
                        CashbackSetting::create($data);
                    }

                    Notification::make()
                        ->title('Configurações salvas com sucesso!')
                        ->success()
                        ->send();
                }),
        ];
    }
}
