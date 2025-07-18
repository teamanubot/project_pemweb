<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\MenuItem;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class InstructorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('instructor')
            ->path('instructor')
            ->spa()
            ->colors([
                'primary' => Color::Pink,
            ])
            ->login()
            ->maxContentWidth(MaxWidth::SevenExtraLarge)
            ->sidebarCollapsibleOnDesktop()
            ->profile(\App\Filament\Pages\Auth\EditProfile::class, isSimple: false)
            ->discoverResources(in: app_path('Filament/Instructor/Resources'), for: 'App\\Filament\\Instructor\\Resources')
            ->discoverPages(in: app_path('Filament/Instructor/Pages'), for: 'App\\Filament\\Instructor\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Instructor/Widgets'), for: 'App\\Filament\\Instructor\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => \Illuminate\Support\Facades\Auth::user()?->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),
                // 'profile' => \Filament\Navigation\MenuItem::make()
                //     ->label(fn () => auth()->user()->name)
                //     ->icon('heroicon-m-user-circle'),
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 2,
                        'lg' => 3,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 2,
                        'lg' => 3,
                    ]),
                \Hasnayeen\Themes\ThemesPlugin::make(),
                \Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin::make()->color('#29b'),
                \DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin::make()
                    ->showEmptyPanelOnMobile(false)
                    ->formPanelPosition('right')
                    ->formPanelWidth('40%')
                    ->emptyPanelBackgroundImageOpacity('70%')
                    ->emptyPanelBackgroundImageUrl('https://images.pexels.com/photos/2310713/pexels-photo-2310713.jpeg?_gl=1*2dwux8*_ga*MTkzNDAyNjQ3NC4xNzUyMjY0MDIx*_ga_8JE65Q40S6*czE3NTIyNjQwMjEkbzEkZzEkdDE3NTIyNjQwMjMkajU4JGwwJGgw'),
                \Awcodes\LightSwitch\LightSwitchPlugin::make()
                    ->position(\Awcodes\LightSwitch\Enums\Alignment::BottomCenter)
                    ->enabledOn([
                        'auth.login',
                        'auth.password',
                    ]),
                \Awcodes\Overlook\OverlookPlugin::make()
                    ->includes([
                        \App\Filament\Admin\Resources\UserResource::class,
                    ]),
                \Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->shouldRegisterNavigation(false)
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens(false)
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
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
            ->authGuard('instructor')
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\EnsureUserIsInstructor::class,
            ]);
    }
}
