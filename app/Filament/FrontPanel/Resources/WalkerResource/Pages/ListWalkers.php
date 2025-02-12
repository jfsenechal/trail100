<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWalkers extends ListRecords
{
    protected static string $resource = WalkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
