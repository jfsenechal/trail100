<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRegistration extends ViewRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->disabled(fn(Registration $record): bool => $record->isFinished())
                ->label(
                fn() => $this->record->isFinished() ? 'Complete' : 'Edit',
            ),
        ];
    }

    public function getSubheading(): string
    {
        return __('messages.registration.finished.subheading');
    }
}
