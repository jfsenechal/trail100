<?php

namespace App\Providers;

use App\Invoice\Invoice;
use App\Invoice\QrCode\QrCodeGenerator;
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
        $this->app->singleton('qrCodeGenerator', function ($app) {
            return new QrCodeGenerator();
        });
        $this->app->singleton('invoice', function ($app) {
            return new Invoice();
        });
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

    /**
     * Setup the configuration for Invoices.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/invoices.php', 'invoices');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['qrCodeGenerator'];
    }
}
