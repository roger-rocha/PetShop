<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Models\Loja;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
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
use Maartenpaauw\Filament\Cashier\Stripe\BillingProvider;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName("PetShop")
            ->favicon(asset('images/paw-solid.svg'))
            ->tenant(Loja::class)
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
            //->tenantBillingProvider(new BillingProvider('basic'))
            //->requiresTenantSubscription()
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->sidebarCollapsibleOnDesktop()
            ->passwordReset()
            ->maxContentWidth('full')
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Red,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'success' => Color::Green,
                'teal' => Color::Teal,
                'slate' => Color::Slate,
                'warning' => Color::Amber,
                'sky' => Color::Sky,
                'fuchsia' => Color::Fuchsia,
                'purple' => Color::Purple,
                'pink' => Color::Pink,
                'rose' => Color::Rose,
                'indigo' => Color::Indigo,
                'yellow' => Color::Yellow,
                'orange' => Color::Orange,
                'cyan' => Color::Cyan,
                'neutral' => Color::Neutral,
                'stone' => Color::Stone,
                'lime' => Color::Lime,
                'violet' => Color::Violet,
            ])
            ->plugins([
                EnvironmentIndicatorPlugin::make()
                    ->visible(fn() => app()->environment(['local', 'testing', 'hml', 'homologacao', 'staging', 'development']))
                    ->showBorder(false)
                    ->visible(true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web')
            ->authPasswordBroker('users')
            ->navigationGroups([
                'Pets',
                'Produtos',
                'Financeiro',
                'Usuários',
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->userMenuItems([
                MenuItem::make()
                    ->label('Release')
                    ->url('/release-public')
                    ->icon('heroicon-o-rocket-launch'),
                // ...
            ]);
    }


}
