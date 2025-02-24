<?php

namespace App\Providers\Filament;

use App\Filament\FrontPanel\Resources\Pages\Information;
use App\Http\Middleware\SetLocaleLanguage;
use App\Models\Role;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class FrontPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('front')
            ->path('front')
            ->colors([
                'primary' => Color::Pink,
            ])
            ->viteTheme('resources/css/filament/front/theme.css')
            ->brandLogo('/images/logoMarcheur.jpg')
            ->favicon(asset('/favicon/favicon.svg'))
            ->font('Poppins')
            ->discoverResources(
                in: app_path('Filament/FrontPanel/Resources'),
                for: 'App\\Filament\\FrontPanel\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/FrontPanel/Pages'),
                for: 'App\\Filament\\FrontPanel\\Pages',
            )
            ->pages([
                Information::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/FrontPanel/Widgets'),
                for: 'App\\Filament\\FrontPanel\\Widgets',
            )
            ->widgets([
                //  Widgets\AccountWidget::class,
                //  Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                //  AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetLocaleLanguage::class
            ])
            ->authMiddleware([
                //   Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make('dashboard admin')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->label(fn(): string => __('messages.navigation.admin.dashboard'))
                    ->url('/admin')
                    ->visible(function (): bool {
                        $isAdmin = auth()->user()?->hasRole(Role::ROLE_ADMIN);

                        return $isAdmin ?? false;
                    }),
            ]);
    }
}


FilamentView::registerRenderHook(
    PanelsRenderHook::TOPBAR_START,
    fn(): View => view('filament.pages.brandlogo'),
);


FilamentView::registerRenderHook(
    PanelsRenderHook::TOPBAR_END,
    fn(): View => view('filament.pages.parts._select_language'),
);

FilamentView::registerRenderHook(
    PanelsRenderHook::HEAD_END,
    fn(): View => view('filament.favicon'),
);
