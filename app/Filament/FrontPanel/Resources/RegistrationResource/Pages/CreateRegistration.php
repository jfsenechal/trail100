<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRegistration extends CreateRecord
{
    protected static string $resource = RegistrationResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        if ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
            return $resource::getUrl('edit', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        if ($resource::hasPage('view') && $resource::canView($this->getRecord())) {
            return $resource::getUrl('view', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        return $resource::getUrl('index');
    }

    public function create22(bool $another = false): void
    {
        $this->authorizeAccess();
        $this->beginDatabaseTransaction();
        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeCreate($data);
    }
}
