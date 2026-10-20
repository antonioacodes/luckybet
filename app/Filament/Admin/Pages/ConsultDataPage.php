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

class ConsultDataPage extends Page
{
    use InteractsWithForms;

  	protected static ?string $title = 'Consulta de Dados';
  
    protected static string $view = 'filament.pages.consult-data-page';

    public ?array $data = [];
    public Setting $setting;

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
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
                Section::make('API de CPF')
              	->description(new HtmlString('
                    <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                        Insira aqui sua chave para utilizar a API de CPF. Para registrar e resgatar sua chave gratuitamente acesse:
                        <a class="dark:text-white" 
                           style="
                                font-size: 12px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #eab308;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://apicpf.com" 
                           target="_blank">
                            API CPF.com
                        </a>
                    </div>
                '))
                    ->schema([
                        TextInput::make('api_cpf_token')
                            ->label('Chave da API')
                            ->placeholder('Cole aqui o Token da API')
                      		->helperText('A utilização da API de CPF é indispensável, pois todo o sistema de registro da plataforma utiliza ela. Ao registrar ela valida o CPF do usuário e consulta e registra todos os dados necessários para a conclusão do registro e para o funcionamento do Trackeamtno Facebook Ads.')
                            ->maxLength(191),
                    ])
              ->columns(1),
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
            $setting->api_cpf_token   = Arr::get($payload, 'api_cpf_token');

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
                'API CPF ALTERADO',
                'O Administrador ' . auth()->user()->name .
                ' (ID: ' . auth()->user()->id . ') alterou as chaves da API CPF para: ' .
                $setting->api_cpf_token 
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