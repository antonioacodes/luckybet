<?php

namespace App\Filament\Admin\Pages;

use App\Models\Gateway;
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

class GatewayPage extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.gateway-page';

    public ?array $data = [];
    public Gateway $setting;

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
        $gateway = Gateway::first();
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
                Section::make('PixUP/BsPay')
                    ->description('Insira suas credenciais para o Gateway de Pagamento')
                              ->description(new HtmlString('
                    <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                        Insira suas credenciais para o Gateway de Pagamento. <br>Registre-se gratuitamente e envie a documentação para obter as Chaves :
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #00a4da;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://pixupbr.com" 
                           target="_blank">
                            PixUP
                        </a>
                        <span class="px-4">ou</span>
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #00e88a;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://bspay.co" 
                           target="_blank">
                            Bspay
                        </a>
                    </div>
                '))
                    ->schema([
                        TextInput::make('bspay_uri')
                            ->label('Client URL')
                            ->placeholder('Digite a url da api')
                      		->readonly()
                      		->helpertext('Essa URL é padrão, tanto para PixUP quanto para Bspay.')
                            ->maxLength(191),
                        TextInput::make('bspay_cliente_id')
                            ->label('Client ID')
                            ->placeholder('Digite o client ID')
                      		->helpertext('ID único do Client encontrado após se registrar na parte do seu Perfil.')
                            ->maxLength(191),
                        TextInput::make('bspay_cliente_secret')
                            ->label('Client Secret')
                            ->placeholder('Digite o client secret')
                      		->helpertext('Chave secreta única, encontrada ao gerar as credenciais.')
                            ->maxLength(191),
                    ])
              ->columns(3),
               // Section::make('DigitoPay')
                  //  ->description('Ajustes de credenciais para a DigitoPay')
                   // ->schema([
                     //   TextInput::make//('digitopay_uri')
                   //         ->label('Client URI')
                           // ->placeholder//('Digite a url da api')
                //            ->default('https://si5n56mrnjzvt5gr2f536ildr40sqzke.lambda-url.sa-east-1.on.aws/')
                  //          ->maxLength(191),
                 //       TextInput::make('digitopay_cliente_id')
              //              ->label('Client ID')
             //               ->placeholder('Digite o client ID')
          //                  ->maxLength(191),
          //              TextInput::make('digitopay_cliente_secret')
             //               ->label('Client Secret')
                            //->placeholder//('Digite o client secret')
                         //   ->maxLength(191),
                 //   ])->columns(3),
                // Section::make('Mercado Pago')
                //     ->description('Chaves do Mercado Pago API')
                //     ->schema([
                //         TextInput::make('mp_client_id')
                //             ->label('Mercado Pago Client ID')
                //             ->placeholder('Digite Mercado Pago Client ID')
                //             ->maxLength(191),
                //         TextInput::make('mp_client_secret')
                //             ->label('Mercado Pago Cliene Secret')
                //             ->placeholder('Digite Mercado Pago Cliene Secret')
                //             ->maxLength(191),
                //         TextInput::make('mp_public_key')
                //             ->label('Mercado Pago Public Key')
                //             ->placeholder('Digite Mercado Pago Public Key')
                //             ->maxLength(191),
                //         TextInput::make('mp_access_token')
                //             ->label('Mercado Pago Access Token')
                //             ->placeholder('Digite Mercado Pago Access Token')
                //             ->maxLength(191),
                //     ])->columns(2),
                // Section::make('SharkPay')
                //     ->description('Chaves da SharkPay')
                //     ->schema([
                //         TextInput::make('public_key')
                //             ->label('Chave Publica')
                //             ->placeholder('Digite a chave publica')
                //             ->maxLength(191),
                //         TextInput::make('private_key')
                //             ->label('Chave Privada')
                //             ->placeholder('Digite a chave privada')
                //             ->maxLength(191),
                //     ])->columns(2),
                // Section::make('Stripe')
                //     ->description('Ajustes de credenciais para a Stripe')
                //     ->schema([
                //         TextInput::make('stripe_public_key')
                //             ->label('Chave Publica')
                //             ->placeholder('Digite a chave publica')
                //             ->maxLength(191)
                //             ->columnSpanFull(),
                //         TextInput::make('stripe_secret_key')
                //             ->label('Chave Privada')
                //             ->placeholder('Digite a chave privada')
                //             ->maxLength(191)
                //             ->columnSpanFull(),
                //         TextInput::make('stripe_webhook_key')
                //             ->label('Chave Webhook')
                //             ->placeholder('Digite a chave do webhook')
                //             ->maxLength(191)
                //             ->columnSpanFull(),
                //     ]),
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

            $setting = Gateway::first();
            if(!empty($setting)) {
                if($setting->update($this->data)) {
                    if(!empty($this->data['stripe_public_key'])) {
                        $envs = DotenvEditor::load(base_path('.env'));

                        $envs->setKeys([
                            'STRIPE_KEY' => $this->data['stripe_public_key'],
                            'STRIPE_SECRET' => $this->data['stripe_secret_key'],
                            'STRIPE_WEBHOOK_SECRET' => $this->data['stripe_webhook_key'],
                        ]);

                        $envs->save();
                    }

                    Notification::make()
                        ->title('Chaves Alteradas')
                        ->body('Suas chaves foram alteradas com sucesso!')
                        ->success()
                        ->send();
                }
            }else{
                if(Gateway::create($this->data)) {
                    Notification::make()
                        ->title('Chaves Criadas')
                        ->body('Suas chaves foram criadas com sucesso!')
                        ->success()
                        ->send();
                }
            }


            \Helper::CreateReport('SUITPAY ALTERADA!', 'O Administrador '.  auth()->user()->name. ' de ID: '. auth()->user()->id .' Alterou as chaves da SuitPay para: ' . $setting->suitpay_cliente_id);
        } catch (Halt $exception) {
            Notification::make()
                ->title('Erro ao alterar dados!')
                ->body('Erro ao alterar dados!')
                ->danger()
                ->send();
        }
    }
}
