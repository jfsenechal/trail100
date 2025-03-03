<?php

namespace App\Filament\Pages;

use App\Models\Walker;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Homepage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.home';
    // protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string|Htmlable
    {
        return __('invoices::messages.page.welcome.title');
    }

    /**
     * @var Collection<int, Walker> $walkers
     */
    public Collection $walkers;

    public string $locale = '';

    public function __construct()
    {
        $this->localeLanguage();
    }

    public function localeLanguage(): void
    {
        $this->locale = App::getLocale() ?? 'en';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function mount(): void
    {
        $this->walkers = DB::table('walkers')->get();
    }

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.simple';
    }

    protected function getHeaderActions22(): array
    {
        return [
            Action::make(__('Register'))
                ->label(__('messages.filament.pages.home.register'))
                ->url(route('filament.front.auth.register')),
        ];
    }


}
