<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Information extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.information';
    //protected ?string $heading = 'Custom Page Heading';
    //protected ?string $subheading = 'Custom Page Subheading';

    public array $log = ['reason' => 'super'];

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
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
