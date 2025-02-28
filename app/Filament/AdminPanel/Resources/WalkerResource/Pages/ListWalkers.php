<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;
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
