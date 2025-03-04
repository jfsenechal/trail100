<?php

namespace App\Filament\AdminPanel\Resources\RegistrationResource\Pages;

use App\Filament\AdminPanel\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    private int $registrationsAll;
    private int $registrationsNotPaidCount;
    private int $registrationsPaidCount;

    public function __construct()
    {
        $this->registrationsAll = Registration::get()->count();
        $this->registrationsNotPaidCount = Registration::whereNull('payment_date')->count();
        $this->registrationsPaidCount = Registration::whereNotNull('payment_date')->count();
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->label('Toutes')
                ->badge(function (): int {
                    return $this->registrationsAll;
                }),
            'not_paid' => Tab::make('Not paid')
                ->badge(function (): int {
                    return $this->registrationsNotPaidCount;
                })
                ->label('Non payé')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereNull('payment_date');
                }),
            'paid' => Tab::make('Paid')
                ->label('Payé')
                ->badge(function (): int {
                    return $this->registrationsPaidCount;
                })
                ->modifyQueryUsing(function (Builder $query) {
                    return Registration::whereNotNull('payment_date');
                }),
        ];
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
