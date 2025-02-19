<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\App;

class Information extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    //protected ?string $heading = 'Custom Page Heading';
    //protected ?string $subheading = 'Custom Page Subheading';

    public array $log = ['reason' => 'super'];
    public string $locale = '';

    public function __construct()
    {
        $this->localeLanguage();
    }

    public function localeLanguage(): void
    {
        $this->locale = App::getLocale() ?? 'en';
    }

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
    }

    public function getView(): string
    {
        //dd($this->locale);
        return 'filament.pages.'.$this->locale.'.information';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function getTitle(): string|Htmlable
    {
        return __('Information');
    }

}
