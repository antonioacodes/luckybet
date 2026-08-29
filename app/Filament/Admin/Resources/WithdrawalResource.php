<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Filament\Resources\WithdrawalResource\RelationManagers;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Report;
use App\Models\Setting;
use App\Traits\Gateways\BsPayTrait;
use App\Traits\Gateways\WazerPayWithdrawTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class WithdrawalResource extends Resource
{
  	use WazerPayWithdrawTrait;
  
    protected static ?string $model = Withdrawal::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationLabel = 'Saques';
    protected static ?string $modelLabel = 'Saques';
    protected static ?string $navigationGroup = 'Administração';
    protected static ?string $slug = 'todos-saques';
    protected static ?int $navigationSort = 3;

    /** @dev @victormsalatiel */
    public static function canAccess(): bool
    {
        // garante que existe usuário autenticado antes de chamar hasRole()
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['type', 'bank_info', 'user.name', 'user.last_name', 'user.cpf', 'user.phone', 'user.email'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 0)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('status', 0)->count() > 5 ? 'success' : 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cadastro de Saques')
                    ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuários')
                    ->placeholder('Selecione um usuário')
                    ->options(function () {
                        return User::query()
                            ->orderBy('name')
                            ->get()
                            ->mapWithKeys(function (User $u) {
                                $label = $u->name;
                                if (is_null($label) || $label === '') {
                                    $label = 'Sem Nome Definido';
                                }
                                return [$u->id => (string) $label];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Valor')
                            ->required()
                            ->default(0.00),
                        Forms\Components\TextInput::make('type')
                            ->label('Tipo')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\FileUpload::make('proof')
                            ->label('Comprovante')
                            ->placeholder('Carregue a imagem do comprovante')
                            ->image()
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Toggle::make('status')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(['id', 'id'])
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nome')
                    ->searchable(['users.name', 'users.last_name'])
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->badge()
                    ->color('warning')
                    ->label('Valor')
                    ->formatStateUsing(fn (Withdrawal $record): string => $record->symbol . ' ' . $record->amount)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pix_type')
                    ->label('Tipo')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => \Helper::formatPixType($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('pix_key')
                    ->badge()
                    ->label('Chave Pix'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // -------------------------------------------------
                // CANCELAR SAQUE
                // -------------------------------------------------
                Action::make('deny_payment')
                    ->label('Cancelar')
                    ->icon('heroicon-o-banknotes')
                    ->color('danger')
                    ->visible(fn (Withdrawal $withdrawal): bool => $withdrawal->status === 0)
                    ->action(function (Withdrawal $withdrawal) {
                        // Marca o saque como cancelado (status = 2)
                        $withdrawal->update(['status' => 2]);

                        // Relatório de auditoria
                        \Helper::CreateReport(
                            'Saque cancelado',
                            'O Administrador '.auth()->user()->name.
                            ' cancelou o saque ID '.$withdrawal->id.
                            ' (R$ '.$withdrawal->amount.') para o usuário '.$withdrawal->user_name
                        );

                        // Notificação ao admin
                        Notification::make()
                            ->title('✅ Saque cancelado')
                            ->success()
                            ->body('O saque foi marcado como cancelado.')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar cancelamento')
                    ->modalSubheading('Deseja realmente cancelar este saque?')
                    ->modalButton('Cancelar'),

                // -------------------------------------------------
                // APROVAR PAGAMENTO VIA PIXUP
                // -------------------------------------------------
                Action::make('approve_payment')
                    ->label('Pagar via Pixup')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->visible(function (Withdrawal $withdrawal): bool {
                        // Só mostrar se ainda está pendente
                        // E se Pixup estiver habilitado nas settings
                        $setting = Setting::first();
                        return $withdrawal->status === 0
                            && $setting
                            && ($setting->bspay_is_enable ?? 0) == 1;
                    })
                    ->action(function (Withdrawal $withdrawal) {
                        Log::info('Iniciando aprovação de saque via Pixup', [
                            'withdrawal_id' => $withdrawal->id,
                            'admin_id'      => auth()->id(),
                        ]);

                        // Usa a trait que já contém a lógica de comunicação com a API da Pixup
                        $result = BsPayTrait::sendPixPayment($withdrawal);

                        if (is_array($result) && ($result['status'] ?? false) === true) {
                            // Atualiza o registro com o status pago e guarda o ID da transação Pixup
                            $withdrawal->update([
                                'status'         => 1,                     // 1 = pago
                                'transaction_id'=> $result['transactionId'],
                                // Mantém compatibilidade com o campo "proof"
                                'proof'          => $result['external_id'],
                            ]);

                            // Relatório de auditoria
                            \Helper::CreateReport(
                                'Saque aprovado via Pixup',
                                'O Administrador '.auth()->user()->name.
                                ' pagou um saque de R$ '.$withdrawal->amount.
                                ' para o usuário '.$withdrawal->user_name.
                                ' (chave '.$withdrawal->pix_key.', tipo '.$withdrawal->pix_type.').
                                ID Pixup: '.$withdrawal->transaction_id
                            );

                            // Notificação de sucesso
                            Notification::make()
                                ->title('✅ Saque aprovado')
                                ->success()
                                ->body('Pagamento enviado com sucesso. ID da transação: '.$withdrawal->transaction_id)
                                ->send();
                        } else {
                            // Falha – a trait já registrou o erro nos logs
                            Notification::make()
                                ->title('❌ Falha ao aprovar saque')
                                ->danger()
                                ->body('Não foi possível comunicar com a Pixup. Consulte o log para detalhes.')
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar pagamento')
                    ->modalSubheading('Deseja realmente pagar este saque via Pixup?')
                    ->modalButton('Confirmar'),

                    Action::make('approve_payment_wazerpay')
    ->label('Pagar via WazerPay')
    ->color('success')
    ->icon('heroicon-o-banknotes')
    ->visible(function (Withdrawal $record): bool {
        return $record->status == 0 && \App\Models\Setting::first()?->wazerpay_is_enable;
    })
    ->requiresConfirmation()
    ->action(function (Withdrawal $record) {
        Log::info('Iniciando aprovação de saque via WazerPay', [
            'withdrawal_id' => $record->id,
            'admin_id'      => auth()->id(),
        ]);

        $result = self::sendWazerPixWithdrawal($record);

        if (!($result['status'] ?? false)) {
            Notification::make()
                ->title('❌ Falha ao pagar via WazerPay')
                ->body($result['message'] ?? 'Erro ao criar saque no WazerPay.')
                ->danger()
                ->send();

            return;
        }

        // Opcional: salvar info do WazerPay no saque
        $record->gateway = 'wazerpay';
        $record->wazerpay_withdrawal_id = $result['withdrawalId'] ?? null;
        $record->status = 1; // aprovado/pago no seu sistema
        $record->save();

        Notification::make()
            ->title('✅ Saque enviado via WazerPay')
            ->body('Saque criado com sucesso no WazerPay. ID: ' . ($result['withdrawalId'] ?? 'N/A'))
            ->success()
            ->send();
    })
    ->modalHeading('Confirmar pagamento via WazerPay')
    ->modalSubheading('Deseja realmente enviar este saque via WazerPay (PIX)?')
    ->modalButton('Confirmar'),


                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Admin\Resources\WithdrawalResource\Pages\ListWithdrawals::route('/'),
            'create' => \App\Filament\Admin\Resources\WithdrawalResource\Pages\CreateWithdrawal::route('/create'),
            'edit'   => \App\Filament\Admin\Resources\WithdrawalResource\Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}
