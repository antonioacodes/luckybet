<?php

namespace App\Filament\Admin\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\Report;
use Illuminate\Support\Arr;

class FacebookAdsPage extends Page
{
    use InteractsWithForms;

  	protected static ?string $title = 'Trackeamento Facebook Ads';
  
    protected static string $view = 'filament.pages.facebook-ads-page';

    public ?array $data = [];
    public Setting $setting;

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        $gateway = Setting::first();
        if(!empty($gateway)) {
            $this->setting = $gateway;
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
                Section::make('Facebook Ads')
                    ->description('Insira aqui suas credenciais para utilizar o Trackeamento do Facebook Ads.')
                    ->schema([
                        TextInput::make('fb_api_token')
                            ->label('Token da API')
                            ->placeholder('Cole aqui o Token da API')
                      		->helperText('A utilização da API do Facebook aprimora suas campanhas, enviando diversos dados para que o Facebook otimize a entrega dos anúncios.')
                            ->maxLength(191),
                        TextInput::make('fb_pixel_token')
                            ->label('ID do Pixel')
                            ->placeholder('Cole aqui o ID do Pixel')
                      		->helperText('A utilização do Pixel em conjunto com a API do Facebook refina ainda mais os dados enviados para o Facebook, trazendo ótimos resultados.')
                            ->maxLength(191),
                        TextInput::make('fb_testevent_token')
                            ->label('Evento de Teste')
                            ->placeholder('Cole aqui ID do TestEvents')
                      		->helperText('Insira apenas para realizar testes no Facebook Test Events, após isso deixe vazio.')
                            ->integer()
                      		->maxLength(6),
                    ])
              ->columns(2),
            ])
            ->statePath('data');
    }


    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            // Pegamos o estado atual do formulário (é o mesmo que $this->data,
            // mas garante que estamos usando o que foi enviado)
            $payload = $this->form->getState();

            // firstOrNew traz o registro existente ou cria um modelo “em memória”
            $setting = Setting::firstOrNew([]);

            // Atualiza apenas as colunas que interessam
            $setting->fb_api_token   = Arr::get($payload, 'fb_api_token');
            $setting->fb_pixel_token = Arr::get($payload, 'fb_pixel_token');
          	$setting->fb_testevent_token = Arr::get($payload, 'fb_testevent_token');

            // Salva (INSERT ou UPDATE, dependendo se já existia)
            $setting->save();

            // Notificação de sucesso
            Notification::make()
                ->title('Credenciais salvas')
                ->body('Os tokens do Facebook foram atualizados com sucesso.')
                ->success()
                ->send();

            // Registro de auditoria (caso o seu Helper exista)
            \Helper::CreateReport(
                'FACEBOOK ADS ALTERADO',
                'O Administrador ' . auth()->user()->name .
                ' (ID: ' . auth()->user()->id . ') alterou as chaves do Facebook Ads para: ' .
                $setting->fb_api_token . ' // ' . $setting->fb_pixel_token
            );
        } catch (Halt $e) {
            // Qualquer exceção (validação, erro de banco, etc.)
            Notification::make()
                ->title('Erro ao salvar')
                ->body('Não foi possível salvar as credenciais. Verifique os campos e tente novamente.')
                ->danger()
                ->send();
        }
    }
}