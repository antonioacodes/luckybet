<?php

namespace App\Filament\Admin\Resources\MissionResource\RelationManagers;

use App\Models\Mission;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $title = 'Participantes da Missão';
    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuário')
                    ->placeholder('Selecione um usuário')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('progress')
                    ->label('Progresso Atual')
                    ->numeric()
                    ->default(0)
                    ->helperText('Progresso atual do usuário (spins ou valor apostado)')
                    ->columnSpan(1),


                Forms\Components\Toggle::make('completed')
                    ->label('Missão Completa')
                    ->helperText('Marque se o usuário completou a missão')
                    ->columnSpan(1),

                Forms\Components\Toggle::make('claimed')
                    ->label('Prêmio Resgatado')
                    ->helperText('Marque se o usuário já resgatou o prêmio')
                    ->columnSpan(1),
            ])->columns(2);
    }

    /**
     * @param Table $table
     * @return Table
     */
public function table(Table $table): Table
{
    return $table
        ->recordTitleAttribute('user.name')
        ->columns([
            Tables\Columns\TextColumn::make('user.id')
                ->label('ID')
                ->badge()
                ->color('gray')
                ->sortable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Usuário')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('progress')
                ->label('Progresso')
                ->badge()
                ->color(fn ($record) => $record->completed ? 'success' : 'warning'),

            Tables\Columns\IconColumn::make('completed')
                ->label('Completa')
                ->boolean()
                ->sortable(),

            Tables\Columns\IconColumn::make('claimed')
                ->label('Resgatada')
                ->boolean()
                ->sortable(),

            Tables\Columns\TextColumn::make('completed_at')
                ->label('Completada em')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('claimed_at')
                ->label('Resgatada em')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Participou em')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\Filter::make('completed')
                ->label('Apenas Completas')
                ->query(fn ($query) => $query->where('completed', true)),

            Tables\Filters\Filter::make('pending')
                ->label('Pendentes')
                ->query(fn ($query) => $query->where('completed', false)),

            Tables\Filters\Filter::make('claimed')
                ->label('Prêmio Resgatado')
                ->query(fn ($query) => $query->where('claimed', true)),

            Tables\Filters\Filter::make('unclaimed')
                ->label('Prêmio Não Resgatado')
                ->query(fn ($query) => $query->where('completed', true)->where('claimed', false)),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make()
                ->label('Adicionar Participante'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('complete')
                ->label('Completar')
                ->icon('heroicon-o-check-circle')
                ->visible(fn ($record) => !$record->completed)
                ->action(function ($record) {
                    $record->update([
                        'completed' => true,
                        'progress' => $record->progress,
                        'completed_at' => now(),
                    ]);
                })
                ->requiresConfirmation()
                ->color('success'),

            Tables\Actions\Action::make('claim')
                ->label('Resgatar')
                ->icon('heroicon-o-gift')
                ->visible(fn ($record) => $record->completed && !$record->claimed)
                ->action(function ($record) {
                    $record->update([
                        'claimed' => true,
                        'claimed_at' => now(),
                    ]);
                })
                ->requiresConfirmation()
                ->color('warning'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('mission_users.created_at', 'desc');
  }
  public function getTableQuery(): Builder|Relation|null
  {
      return parent::getTableQuery()?->with('user');
  }
}
