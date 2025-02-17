<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TextInput::configureUsing(function (TextInput $config) {
            $config->inlineLabel();
        });
        Select::configureUsing(function (Select $config) {
            $config->inlineLabel();
        });
        DatePicker::configureUsing(function (DatePicker $config) {
            $config->inlineLabel();
        });
        Section::configureUsing(function (Section $config) {
            $config
                ->columns()
                ->compact();
        });
    }
}
