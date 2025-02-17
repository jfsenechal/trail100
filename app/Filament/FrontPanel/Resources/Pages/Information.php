<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use Filament\Pages\Page;

class Information extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.information';

    public array $log=['reason'=>'super'];

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
    }

    public static function canAccess(): bool
    {
        return true;
    }
}
