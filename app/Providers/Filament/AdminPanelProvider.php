<?php

namespace App\Providers\Filament;

use App\Filament\AdminPanel\Resources\WalkerResource\Widgets\WalkersCountWidget;
use App\Filament\Pages\Auth\Login;
use App\Http\Middleware\SetLocaleLanguage;
use App\Models\Role;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
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
use Filament\View\PanelsRenderHook;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->favicon(asset('/favicon/favicon.svg'))
            ->discoverResources(in: app_path('Filament/AdminPanel/Resources'), for: 'App\\Filament\\AdminPanel\\Resources')
            ->discoverPages(in: app_path('Filament/AdminPanel/Pages'), for: 'App\\Filament\\AdminPanel\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/AdminPanel/Widgets'), for: 'App\\Filament\\AdminPanel\\Widgets')
            ->widgets([
             WalkersCountWidget::class
             //   Widgets\FilamentInfoWidget::class,
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
                SetLocaleLanguage::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

FilamentView::registerRenderHook(
    PanelsRenderHook::HEAD_END,
    fn(): View => view('filament.favicon'),
);
