<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CashbackResource\Pages;
use App\Filament\Admin\Resources\CashbackResource\Widgets\CashbackOverviewChart;
use App\Models\CashbackUser;
use App\Models\CashbackSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class CashbackResource extends Resource
{
    protected static ?string $model = CashbackUser::class;

    // Ícone e Labels
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Cashback';
    protected static ?string $modelLabel = 'Histórico de Cashback';
    protected static ?string $pluralModelLabel = 'Históricos de Cashback';
    protected static ?string $navigationGroup = 'Funcionalidades';
    protected static ?int $navigationSort = 2; // Logo após VIP

    public static function form(Form $form): Form
    {
        // Formulário apenas para visualização (Read-only) se clicar em editar
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Usuário')
                    ->disabled(),

                Forms\Components\TextInput::make('amount')
                    ->label('Valor')
                    ->prefix('R$')
                    ->disabled(),

                Forms\Components\TextInput::make('status')
                    ->label('Status')
                    ->disabled(),

                Forms\Components\DateTimePicker::make('redeemed_at')
                    ->label('Data do Resgate')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'warning',
                        'claimed' => 'success',
                        'expired' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Disponível',
                        'claimed' => 'Resgatado',
                        'expired' => 'Expirado',
                        'pending' => 'Pendente',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('redeemed_at')
                    ->label('Resgatado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Não resgatado'),

                Tables\Columns\TextColumn::make('expiration_date')
                    ->label('Expira em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Disponível',
                        'claimed' => 'Resgatado',
                        'expired' => 'Expirado',
                    ]),
            ])
            ->actions([
                // Apenas visualização, geralmente não editamos histórico financeiro
                // Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashbacks::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CashbackOverviewChart::class,
        ];
    }
}
