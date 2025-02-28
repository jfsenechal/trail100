<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWalker extends ViewRecord
{
    protected static string $resource = WalkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
