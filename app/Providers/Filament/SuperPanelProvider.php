<?php

namespace App\Providers\Filament;

use App\Filament\Super\Pages\Auth\EditProfile;
use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;

class SuperPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('super')
            ->path('super')
            ->favicon(asset('images/paw-solid.svg'))
            ->maxContentWidth('full')
            ->brandName("PetShop Suporte")
            ->login()
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Super/Resources'), for: 'App\\Filament\\Super\\Resources')
            ->discoverPages(in: app_path('Filament/Super/Pages'), for: 'App\\Filament\\Super\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Super/Widgets'), for: 'App\\Filament\\Super\\Widgets')
            ->plugins([
                EnvironmentIndicatorPlugin::make()
                    ->visible(fn() => app()->environment(['local', 'testing', 'hml', 'homologacao', 'staging', 'development']))
                    ->showBorder(false)
                    ->visible(true),
                FilamentExceptionsPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make()
            ])
            ->navigationGroups([
                'Usuários',
                'Admin',
            ])
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
            ]);
    }
}
