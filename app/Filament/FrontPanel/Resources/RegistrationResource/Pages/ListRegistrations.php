<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected static string $view = 'filament.resources.registrations-list';

    public function urlNew(): string
    {
        return RegistrationResource::getUrl('create');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
