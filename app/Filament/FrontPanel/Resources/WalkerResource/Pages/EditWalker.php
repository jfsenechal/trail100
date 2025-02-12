<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWalker extends EditRecord
{
    protected static string $resource = WalkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
