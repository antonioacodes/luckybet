<?php

namespace App\Filament\Admin\Resources\SettingResource\Pages;

use App\Filament\Admin\Resources\SettingResource;
use App\Models\Setting;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BonusSetting extends Page implements HasForms
{
    use HasPageSidebar, InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.bonus-setting';

    /**
     * @dev @victormsalatiel
     * @param Model $record
     * @return bool
     */
    public static function canView(Model $record): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return string|Htmlable
     */
    public function getTitle(): string | Htmlable
    {
        return __('Bônus de Depósito e Sistema Vip');
    }

    public Setting $record;
    public ?array $data = [];

    /**
     * @dev victormsalatiel - Meu instagram
     * @return void
     */
    public function mount(): void
    {
        $setting = Setting::first();
        $this->record = $setting;
        $this->form->fill($setting->toArray());
    }

    /**
     * @return void
     */
    public function save()
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

            $setting = Setting::find($this->record->id);

            if($setting->update($this->data)) {
                Cache::put('setting', $setting);

                Notification::make()
                    ->title('Dados alterados')
                    ->body('Dados alterados com sucesso!')
                    ->success()
                    ->send();

                redirect(route('filament.admin.resources.settings.bonus', ['record' => $this->record->id]));

            }
        } catch (Halt $exception) {
            return;
        }
    }

    /**
     * @dev victormsalatiel - Meu instagram
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajuste de Bônus de Depósito e Vip')
                    ->description('Formulário para ativar Bônus de Depósito e Sistema Vip (Level e Bônus)')
                    ->schema([
                        Toggle::make('bonus_is_enable')
                            ->inline(false)
                            ->label('Ativar/Desativar Bônus de Depósito')
                      		->helperText('Caso ativado, a opção de ativar Bônus de Depósito(100%) aparecerá no modal, se desativado ela some do modal.'),
                        Toggle::make('free_rounds_enabled')->label('Ativar/Desativar Rodadas Grátis')->helperText('Desative para bloquear novos bônus de rodadas grátis solicitados pela plataforma.'),
                        Toggle::make('activate_vip_bonus')
                            ->inline(false)
                            ->label('Ativar/Desativar Sistema Vip e Bônus')
                      		->helperText('Caso ativado, a cada 1 Real apostado o usuário ganha 1 Ponto Vip, e você pode configurar as pontuações de Levels e premiações para cada Nível Vip.'),
                    ])->columns(2)
            ])
            ->statePath('data') ;
    }
}
