<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\MissionResource\Pages;
use App\Models\Currency;
use App\Models\Game;
use App\Models\Mission;
use App\Models\Provider;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MissionResource extends Resource
{
    protected static ?string $model = Mission::class;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationLabel = 'Missões';
    protected static ?string $modelLabel = 'Missão';
    protected static ?string $pluralModelLabel = 'Missões';
    protected static ?string $slug = 'centro-missoes';
    protected static ?string $navigationGroup = 'Gamificação';
    protected static ?int $navigationSort = 1;

    /**
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações Básicas')
                    ->description('Configure as informações principais da missão')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Missão em Destaque')
                            ->helperText('Missões em destaque aparecem no topo da página com layout maior')
                            ->default(false)
                            ->inline(false)
                            ->columnSpanFull(),

                        Textarea::make('challenge_name')
                            ->required()
                            ->label('Nome da Missão')
                            ->placeholder('Ex: Sorte Diária, Desafio Fortune Tiger')
                            ->maxLength(191)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('challenge_image')
                            ->label('URL da Imagem da Missão')
                            ->url()
                            ->placeholder('https://exemplo.com/imagem-missao.jpg')
                            ->helperText('Cole a URL completa da imagem ou deixe vazio para usar a imagem do jogo automaticamente')
                            ->suffixIcon('heroicon-o-photo')
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('preview')
                                    ->icon('heroicon-o-eye')
                                    ->action(function ($state) {
                                        // Abre preview da imagem
                                    })
                            )
                            ->columnSpanFull(),

                        Textarea::make('challenge_description')
                            ->label('Descrição')
                            ->required()
                            ->placeholder('Descreva a missão de forma clara e atrativa')
                            ->columnSpanFull(),

                        Textarea::make('challenge_rules')
                            ->label('Regras da Missão')
                            ->required()
                            ->placeholder('Explique como o usuário deve completar a missão')
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible(),

                Section::make('Configuração do Desafio')
                    ->description('Defina o tipo e objetivo da missão')
                    ->schema([
                        Select::make('challenge_type')
                            ->label('Tipo de Desafio')
                            ->required()
                            ->options([
                                'spins' => '🎰 Número de Giros (Spins)',
                                'wallet' => '💰 Valor Apostado (Wallet)',
                            ])
                            ->default('spins')
                            ->reactive()
                            ->helperText('Escolha se o usuário deve girar X vezes ou apostar X reais')
                            ->columnSpan(1),

                        TextInput::make('challenge_total')
                            ->label(fn (Get $get): string => 
                                $get('challenge_type') === 'spins' 
                                    ? 'Quantidade de Giros' 
                                    : 'Valor Total a Apostar'
                            )
                            ->required()
                            ->numeric()
                            ->default(10)
                            ->helperText(fn (Get $get): string => 
                                $get('challenge_type') === 'spins' 
                                    ? 'Quantas vezes o usuário deve girar'
                                    : 'Quanto o usuário deve apostar no total (em R$)'
                            )
                            ->prefix(fn (Get $get): string => 
                                $get('challenge_type') === 'wallet' ? 'R$' : ''
                            )
                            ->columnSpan(1),

                        Select::make('challenge_provider')
                            ->label('Provedor do Jogo')
                            ->options(Provider::where('status', 1)->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->required()
                            ->helperText('Selecione o provedor do jogo')
                            ->afterStateUpdated(fn ($state, callable $set) => $set('challenge_gameid', null))
                            ->columnSpan(1),

                        Select::make('challenge_gameid')
                            ->label('Jogo Específico')
                            ->options(function (Get $get) {
                                $providerId = $get('challenge_provider');
                                if (!$providerId) {
                                    return [];
                                }
                                return Game::where('provider_id', $providerId)
                                    ->where('status', 1)
                                    ->pluck('game_name', 'game_id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Selecione o jogo onde a missão deve ser completada. *Apenas jogos Pragmatic Play funcionam com prêmio de Rodadas.')
                            ->disabled(fn (Get $get): bool => !$get('challenge_provider'))
                            ->columnSpan(1),

                        TextInput::make('challenge_link')
                            ->label('Link Personalizado (Opcional)')
                            ->helperText('Link para onde o usuário será redirecionado ao clicar em "Jogar"')
                            ->url()
                            ->maxLength(191)
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible(),

                Section::make('Recompensas')
                    ->description('Configure as recompensas da missão')
                    ->schema([
                        Select::make('reward_type')
                            ->label('Tipo de Recompensa')
                            ->required()
                            ->options([
                                'bonus' => '💵 Bônus em Dinheiro',
                                'freespins' => '🎡 Rodadas Grátis',
                            ])
                            ->default('bonus')
                            ->reactive()
                            ->helperText('Escolha o tipo de premiação')
                            ->columnSpan(1),

                        TextInput::make('challenge_bonus')
                            ->label('Valor do Bônus')
                            ->required(fn (Get $get): bool => $get('reward_type') === 'bonus')
                            ->visible(fn (Get $get): bool => $get('reward_type') === 'bonus')
                            ->numeric()
                            ->default(0.00)
                            ->prefix('R$')
                            ->helperText('Valor em dinheiro que o usuário receberá')
                            ->columnSpan(1),

                        TextInput::make('reward_freespins')
                            ->label('Quantidade de Rodadas Grátis')
                            ->required(fn (Get $get): bool => $get('reward_type') === 'freespins')
                            ->visible(fn (Get $get): bool => $get('reward_type') === 'freespins')
                            ->numeric()
                            ->default(0)
                            ->helperText('Quantidade de rodadas grátis que o usuário receberá')
                            ->columnSpan(1),

                        Select::make('challenge_currency')
                            ->label('Moeda')
                            ->required()
                            ->options(Currency::all()->pluck('code', 'code'))
                            ->default(Wallet::where('active', 1)->first()?->currency ?? 'BRL')
                            ->searchable()
                            ->helperText('Moeda utilizada na missão')
                            ->columnSpan(1),
                    ])->columns(2)->collapsible(),

                Section::make('Período de Validade')
                    ->description('Defina quando a missão estará ativa')
                    ->schema([
                        Forms\Components\DateTimePicker::make('challenge_start_date')
                            ->label('Data e Hora de Início')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->helperText('Quando a missão começa a valer')
                            ->default(now())
                            ->columnSpan(1),

                        Forms\Components\DateTimePicker::make('challenge_end_date')
                            ->label('Data e Hora de Término')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->helperText('Quando a missão expira')
                            ->after('challenge_start_date')
                            ->default(now()->addDays(7))
                            ->columnSpan(1),
                    ])->columns(2)->collapsible(),
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('challenge_image')
                ->label('Imagem')
                ->circular()
                ->defaultImageUrl(url('/images/placeholder-game.png'))
                ->getStateUsing(function ($record) {
                    // Se tiver imagem personalizada
                    if ($record->challenge_image) {
                        return $record->challenge_image;
                    }
                    
                    // Buscar do jogo
                    if ($record->challenge_gameid) {
                        $game = \App\Models\Game::where('game_id', $record->challenge_gameid)->first();
                        if ($game && $game->cover) {
                            if (filter_var($game->cover, FILTER_VALIDATE_URL)) {
                                return $game->cover;
                            }
                            return asset('storage/' . $game->cover);
                        }
                    }
                    
                    return url('/images/placeholder-game.png');
                }),

            Tables\Columns\IconColumn::make('is_featured')
                ->label('Destaque')
                ->boolean()
                ->trueIcon('heroicon-o-star')
                ->falseIcon('heroicon-o-star')
                ->trueColor('warning')
                ->falseColor('gray')
                ->sortable(),

            Tables\Columns\TextColumn::make('challenge_name')
                ->label('Nome da Missão')
                ->searchable()
                ->sortable()
                ->weight('bold'),

            Tables\Columns\TextColumn::make('challenge_type')
                ->label('Tipo')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'spins' => 'info',
                    'wallet' => 'success',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'spins' => '🎰 Spins',
                    'wallet' => '💰 Wallet',
                    default => $state,
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('challenge_total')
                ->label('Meta')
                ->sortable(),

            Tables\Columns\TextColumn::make('reward_type')
                ->label('Recompensa')
                ->badge()
                ->color(fn ($record) => $record && $record->reward_type === 'bonus' ? 'success' : 'warning')
                ->formatStateUsing(function ($record) {
                    if (!$record) return '-';
                    
                    if ($record->reward_type === 'bonus') {
                        return '💵 R$ ' . number_format($record->challenge_bonus, 2, ',', '.');
                    }
                    return '🎡 ' . $record->reward_freespins . ' Rodadas';
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('challenge_start_date')
                ->label('Início')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('challenge_end_date')
                ->label('Término')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn ($record): string => match (true) {
                    !$record => 'gray',
                    now()->lt($record->challenge_start_date) => 'warning',
                    now()->gt($record->challenge_end_date) => 'danger',
                    default => 'success',
                })
                ->formatStateUsing(fn ($record): string => match (true) {
                    !$record => '-',
                    now()->lt($record->challenge_start_date) => '⏰ Em Breve',
                    now()->gt($record->challenge_end_date) => '❌ Expirada',
                    default => '✅ Ativa',
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('users_count')
                ->label('Participantes')
                ->counts('users')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Criada em')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('challenge_type')
                ->label('Tipo de Desafio')
                ->options([
                    'spins' => '🎰 Spins',
                    'wallet' => '💰 Wallet',
                ]),

            Tables\Filters\SelectFilter::make('reward_type')
                ->label('Tipo de Recompensa')
                ->options([
                    'bonus' => '💵 Bônus',
                    'freespins' => '🎡 Rodadas Grátis',
                ]),

            Tables\Filters\Filter::make('is_featured')
                ->label('Em Destaque')
                ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

            Tables\Filters\Filter::make('active')
                ->label('Ativas')
                ->query(fn (Builder $query): Builder => 
                    $query->where('challenge_start_date', '<=', now())
                          ->where('challenge_end_date', '>=', now())
                ),

            Tables\Filters\Filter::make('upcoming')
                ->label('Em Breve')
                ->query(fn (Builder $query): Builder => 
                    $query->where('challenge_start_date', '>', now())
                ),

            Tables\Filters\Filter::make('expired')
                ->label('Expiradas')
                ->query(fn (Builder $query): Builder => 
                    $query->where('challenge_end_date', '<', now())
                ),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            
            Tables\Actions\Action::make('toggle_featured')
                ->label(fn ($record) => $record && $record->is_featured ? 'Remover Destaque' : 'Destacar')
                ->icon(fn ($record) => $record && $record->is_featured ? 'heroicon-o-star' : 'heroicon-s-star')
                ->color(fn ($record) => $record && $record->is_featured ? 'gray' : 'warning')
                ->action(function ($record) {
                    if ($record) {
                        $record->update(['is_featured' => !$record->is_featured]);
                    }
                })
                ->requiresConfirmation(fn ($record) => $record && !$record->is_featured)
                ->modalHeading('Destacar Missão')
                ->modalDescription('Tem certeza que deseja destacar esta missão? Ela aparecerá em destaque para os usuários.')
                ->modalSubmitActionLabel('Sim, destacar'),

            Tables\Actions\Action::make('view_participants')
                ->label('Ver Participantes')
                ->icon('heroicon-o-users')
                ->color('info')
                ->url(fn ($record): string => $record ? static::getUrl('edit', ['record' => $record]) . '#users' : '#'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                
                Tables\Actions\BulkAction::make('feature')
                    ->label('Marcar como Destaque')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->action(fn (Collection $records) => $records->each->update(['is_featured' => true]))
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),

                Tables\Actions\BulkAction::make('unfeature')
                    ->label('Remover Destaque')
                    ->icon('heroicon-o-star')
                    ->color('gray')
                    ->action(fn (Collection $records) => $records->each->update(['is_featured' => false]))
                    ->deselectRecordsAfterCompletion(),
            ]),
        ])
        ->defaultSort('created_at', 'desc');
}

    /**
     * @return string[]
     */
    public static function getRelations(): array
    {
        return [
            \App\Filament\Admin\Resources\MissionResource\RelationManagers\UsersRelationManager::class
        ];
    }

    /**
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\MissionResource\Pages\ListMissions::route('/'),
            'create' => \App\Filament\Admin\Resources\MissionResource\Pages\CreateMission::route('/create'),
            'edit' => \App\Filament\Admin\Resources\MissionResource\Pages\EditMission::route('/{record}/edit'),
        ];
    }

    /**
     * @return string
     */
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('challenge_start_date', '<=', now())
            ->where('challenge_end_date', '>=', now())
            ->count();
    }

    /**
     * @return string
     */
    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
