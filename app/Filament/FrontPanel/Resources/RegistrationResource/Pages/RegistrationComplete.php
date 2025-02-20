<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Invoice\Invoice;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class RegistrationComplete extends Page
{
    use InteractsWithRecord;

    protected static string $resource = RegistrationResource::class;

    protected static string $view = 'filament.front-panel.resources.registration-resource.pages.registration-complete';

    public function mount(int|string $record): void
    {
        /**
         * @var Registration $this ->record
         */
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Download invoice (pdf)')
                ->icon('tabler-file-type-pdf')
                ->action(function (Registration $record) {
                    return Invoice::downloadPdf();
                }),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }
}
