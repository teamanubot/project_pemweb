<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SsoPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('sso')
            ->path('sso')
            ->colors([
                'primary' => Color::Red,
            ])
            ->login()
            ->discoverResources(in: app_path('Filament/Sso/Resources'), for: 'App\\Filament\\Sso\\Resources')
            ->discoverPages(in: app_path('Filament/Sso/Pages'), for: 'App\\Filament\\Sso\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Sso/Widgets'), for: 'App\\Filament\\Sso\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Dashboard')
                    ->icon('heroicon-o-home'),

                NavigationGroup::make()
                    ->label('Academics')
                    ->icon('heroicon-o-academic-cap'),

                NavigationGroup::make()
                    ->label('Content & Modules')
                    ->icon('heroicon-o-book-open'),

                NavigationGroup::make()
                    ->label('Assessments')
                    ->icon('heroicon-o-pencil-square'),

                NavigationGroup::make()
                    ->label('Student Affairs')
                    ->icon('heroicon-o-user'),

                NavigationGroup::make()
                    ->label('Finance & Payroll')
                    ->icon('heroicon-o-currency-dollar'),

                NavigationGroup::make()
                    ->label('Organization Settings')
                    ->icon('heroicon-o-building-office'),

                NavigationGroup::make()
                    ->label('Administration')
                    ->icon('heroicon-o-shield-check'),
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
            ->authGuard('student')
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\EnsureUserIsStudent::class,
            ]);
    }
}
