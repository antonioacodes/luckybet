<?php

namespace App\Filament\Admin\Pages;

use App\Models\GamesKey;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class GamesKeyPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.games-key-page';

    protected static ?string $title = 'Chaves dos Jogos';

    // protected static ?string $slug = 'chaves-dos-jogos';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }


    public ?array $data = [];
    public ?GamesKey $setting;

    /**
     * @return void
     */
    public function mount(): void
    {
        $gamesKey = GamesKey::first();
        if(!empty($gamesKey)) {
            $this->setting = $gamesKey;
            $this->form->fill($this->setting->toArray());
        }else{
            $this->form->fill();
        }
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
                  ->schema([
                Section::make('PlayFiver v2')
                    ->description('Credenciais para consultar jogos e iniciar sessões da API PlayFivers.')
                    ->schema([
                        TextInput::make('playfiver_url')->label('URL da API')->default('https://api.playfivers.com')->url()->maxLength(191),
                        TextInput::make('playfiver_code')->label('Código do agente')->maxLength(191),
                        TextInput::make('playfiver_token')->label('Token do agente')->password()->revealable()->maxLength(191),
                        TextInput::make('playfiver_secret')->label('Chave secreta')->password()->revealable()->maxLength(191),
                    ])->columns(2),
                Section::make('iGamingplay Slots')
                              ->description(new HtmlString('
                    <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                        A API da iGamingplay fornece diversos jogos de slots e ao vivo.<br> Em caso de dúvidas ou problemas, entre em contato para obter suporte  :
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 140px;
                                display: flex;
                                background-color: #ff0080;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://igamingplay.app" 
                           target="_blank">
                           
                            Painel iGamingplay
                        </a>
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #5865f2;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://discord.gg/2PqR8fED" 
                           target="_blank">
                            Suporte
                        </a>
                    </div>
                '))
                    ->schema([
                            TextInput::make('igamingplay_code')
                                ->label('Código do Agente')
                                ->placeholder('Digite aqui o código do agente')
                                ->maxLength(191),

                            TextInput::make('igamingplay_token')
                                ->label('Agente Token')
                                ->placeholder('Digite aqui o token do agente')
                                ->maxLength(191),
                            TextInput::make('igamingplay_callback_token')
                                ->label('Agente Secreto')
                                ->placeholder('Digite aqui o código secreto. Token de callback')
                                ->maxLength(191),  
                    ])
              ->columns(3),
            ])
            ->statePath('data');
    }


    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            if(env('APP_DEMO')) {
                Notification::make()
                    ->title('Atenção')
                    ->body('Você não pode realizar está alteração na versão demo')
                    ->danger()
                    ->send();
                return;
            }

            $setting = GamesKey::first();
            if(!empty($setting)) {
                if($setting->update($this->data)) {
                    Notification::make()
                        ->title('Chaves Alteradas')
                        ->body('Suas chaves foram alteradas com sucesso!')
                        ->success()
                        ->send();
                }
            }else{
                if(GamesKey::create($this->data)) {
                    Notification::make()
                        ->title('Chaves Criadas')
                        ->body('Suas chaves foram criadas com sucesso!')
                        ->success()
                        ->send();
                }
            }


        } catch (Halt $exception) {
            Notification::make()
                ->title('Erro ao alterar dados!')
                ->body('Erro ao alterar dados!')
                ->danger()
                ->send();
        }
    }
}

