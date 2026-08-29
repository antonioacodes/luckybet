<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Admin\Pages\AdvancedPage;
use App\Filament\Admin\Pages\DashboardAdmin;
use App\Filament\Admin\Pages\DigitoPayPaymentPage;
use App\Filament\Admin\Pages\GamesKeyPage;
use App\Filament\Admin\Pages\FacebookAdsPage;
use App\Filament\Admin\Pages\ConsultDataPage;
use App\Filament\Admin\Pages\GatewayPage;
use App\Filament\Admin\Pages\HelpPage;
use App\Filament\Admin\Pages\LayoutCssCustom;
use App\Filament\Admin\Widgets\WhitelabelPaymentWidget;
use App\Filament\Admin\Pages\SettingMailPage;
use App\Filament\Admin\Pages\SettingSpin;
use App\Filament\Admin\Pages\SuitPayPaymentPage;
use App\Filament\Admin\Resources\AffiliateWithdrawResource;
use App\Filament\Admin\Resources\BannerResource;
use App\Filament\Admin\Resources\CategoryResource;
use App\Filament\Admin\Resources\DepositResource;
use App\Filament\Admin\Resources\GameResource;
use App\Filament\Admin\Resources\MissionResource;
use App\Filament\Admin\Resources\OrderResource;
use App\Filament\Admin\Resources\CashbackResource;
use App\Filament\Admin\Resources\ProviderResource;
use App\Filament\Admin\Resources\SettingResource;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\Admin\Resources\VipResource;
use App\Filament\Admin\Resources\WalletResource;
use App\Filament\Admin\Resources\WithdrawalResource;
use App\Livewire\AdminWidgets;
use App\Livewire\WalletOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Admin\Resources\ReportResource;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @param Panel $panel
     * @return Panel
     */

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('igamingsolutions/admin')
            ->path('igamingsolutions/admin')
            ->login()
          	->authGuard('web')
            ->colors([
                'danger' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Blue,
                'primary' => Color::Yellow,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])

            ->font('Inter')
            ->brandLogo(fn () => view('filament.components.logo'))
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                DashboardAdmin::class,
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->sidebarCollapsibleOnDesktop()
            ->collapsibleNavigationGroups(true)
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                WhitelabelPaymentWidget::class,
                WalletOverview::class,
                AdminWidgets::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    ((auth('web')->user()?->hasRole('admin') ?? false) ?? false) ?
                        NavigationGroup::make()
                        ->items([
                            NavigationItem::make('dashboard')
                                ->icon('heroicon-o-home')
                                ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                                ->url(fn (): string => DashboardAdmin::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.pages.settings')),

                            NavigationItem::make('settings')
                                ->icon('heroicon-o-cog-6-tooth')
                                ->label(fn (): string => 'Configurações')
                                ->url(fn (): string => SettingResource::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.pages.settings'))
                                ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),
                          
                            NavigationItem::make('help')
                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                ->label(fn (): string => 'Precisa de Ajuda?')
                                ->url(fn (): string => HelpPage::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.help-page'))
                                ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),

                            NavigationItem::make('withdraw_affiliates')
                                ->icon('heroicon-o-banknotes')
                                ->label(fn (): string => 'Saques de Afiliados')
                                ->url(fn (): string => AffiliateWithdrawResource::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.sub-affiliates.index'))
                                ->visible(fn(): bool => (auth()->user()?->hasRole('admin') ?? false)),

                        ]) : NavigationGroup::make()
                    ,
                     (auth('web')->user()?->hasRole('admin') ?? false) ?
                        NavigationGroup::make('Integrações')
                            ->items([
                              NavigationItem::make('facebook-ads')
                                  ->icon('heroicon-o-megaphone')
                                  ->label(fn (): string => 'Trackeamento Facebook Ads')
                                  ->url(fn (): string => FacebookAdsPage::getUrl())
                                  ->isActiveWhen(fn () => request()->routeIs('filament.pages.facebook-ads-page'))
                                  ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),
                              
                                NavigationItem::make('gateway')
                                    ->icon('heroicon-o-cog-6-tooth')
                                    ->label(fn (): string => 'Gateway de Pagamentos')
                                    ->url(fn (): string => GatewayPage::getUrl())
                                    ->isActiveWhen(fn () => request()->routeIs('filament.pages.gateway-page'))
                                    ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),

                              /*NavigationItem::make('games-key')
                                  ->icon('heroicon-o-puzzle-piece')
                                  ->label(fn (): string => 'Provedores de Jogos ')
                                  ->url(fn (): string => GamesKeyPage::getUrl())
                                  ->isActiveWhen(fn () => request()->routeIs('filament.pages.games-key-page'))
                                  ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),*/
                              
                            NavigationItem::make('setting-mail')
                                ->icon('heroicon-o-cog-6-tooth')
                                ->label(fn (): string => 'Definições de Email')
                                ->url(fn (): string => SettingMailPage::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.pages.setting-mail-page'))
                                ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),

                              
                              NavigationItem::make('consulta-cpf')
                                  ->icon('heroicon-o-document-chart-bar')
                                  ->label(fn (): string => 'Consulta de Dados')
                                  ->url(fn (): string => ConsultDataPage::getUrl())
                                  ->isActiveWhen(fn () => request()->routeIs('filament.pages.consult-data-page'))
                                  ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),
                              
                              
                            ])
                        : NavigationGroup::make()
                    ,
					((auth('web')->user()?->hasRole('admin') ?? false) ?? false) ?
                        NavigationGroup::make('Customização')
                            ->items([
                                

                                NavigationItem::make('custom-layout')
                                    ->icon('heroicon-o-paint-brush')
                                    ->label(fn (): string => 'Cores e Estilos')
                                    ->url(fn (): string => LayoutCssCustom::getUrl())
                                    ->isActiveWhen(fn () => request()->routeIs('filament.pages.layout-css-custom'))
                                    ->visible(fn(): bool => ((auth('web')->user()?->hasRole('admin') ?? false) ?? false)),
                              ...BannerResource::getNavigationItems()
                            ])
                        : NavigationGroup::make()
                    ,
                    ((auth('web')->user()?->hasRole('admin') ?? false) ?? false) ?
                        NavigationGroup::make('Funcionalidades')
                            ->items([
                                ...MissionResource::getNavigationItems(),
                                ...VipResource::getNavigationItems(),
                              	...CashbackResource::getNavigationItems(),
                            ])
                        : NavigationGroup::make()
                    ,
                    ((auth('web')->user()?->hasRole('admin') ?? false) ?? false) ?
                        NavigationGroup::make('Meus Jogos')
                            ->items([
                                ...CategoryResource::getNavigationItems(),
                                ...ProviderResource::getNavigationItems(),
                                ...GameResource::getNavigationItems(),
                                ...OrderResource::getNavigationItems(),
                            ])
                        : NavigationGroup::make()
                    ,
                    ((auth('web')->user()?->hasRole('admin') ?? false) ?? false) ?
                        NavigationGroup::make('Administração')
                            ->items([
                                ...UserResource::getNavigationItems(),
                                ...WalletResource::getNavigationItems(),
                                ...DepositResource::getNavigationItems(),
                                ...WithdrawalResource::getNavigationItems(), 
                            ])
                        : NavigationGroup::make()
                    ,

                    ((auth('web')->user()?->hasRole('admin') ?? false) ?? false) ?
                        NavigationGroup::make(__(config('filament-spatie-roles-permissions.navigation_section_group', 'filament-spatie-roles-permissions::filament-spatie.section.roles_and_permissions')))
                            ->items([
                                NavigationItem::make(__('filament-spatie-roles-permissions::filament-spatie.section.role'))
                                    ->icon('heroicon-o-user-group')
                                    ->isActiveWhen(fn () => request()->routeIs([
                                        'filament.admin.resources.roles.index',
                                        'filament.admin.resources.roles.create',
                                        'filament.admin.resources.roles.view',
                                        'filament.admin.resources.roles.edit',
                                    ]))
                                    ->url(fn (): string => '/admin/roles'),
                                NavigationItem::make(__('filament-spatie-roles-permissions::filament-spatie.section.permission'))
                                    ->icon('heroicon-o-lock-closed')
                                    ->isActiveWhen(fn () => request()->routeIs([
                                        'filament.admin.resources.permissions.index',
                                        'filament.admin.resources.permissions.create',
                                        'filament.admin.resources.permissions.view',
                                        'filament.admin.resources.permissions.edit',
                                    ]))
                                    ->url(fn (): string => '/admin/permissions'),
                            ])
                        : NavigationGroup::make()
                    ,
                    NavigationGroup::make('maintenance')
                        ->label('Manutenção')
                        ->items([

                            NavigationItem::make('Limpar o cache')
                                ->url(url('/clear'), shouldOpenInNewTab: false)
                                ->icon('heroicon-o-trash')
                        ])
                    ,
                ]);
            })
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\CheckAdminRole::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ;
    }
}
