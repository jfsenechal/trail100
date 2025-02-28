<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;
use Filament\Actions;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\EditRecord;

class EditWalker extends EditRecord
{
    protected static string $resource = WalkerResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getRecord()->name();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
