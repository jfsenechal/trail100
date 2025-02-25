<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Invoice\Facades\QrCodeGenerator;
use App\Invoice\Invoice;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class RegistrationComplete extends Page
{
    use InteractsWithRecord;

    public ?string $qrCode;

    protected static string $resource = RegistrationResource::class;

    protected static string $view = 'filament.front-panel.resources.registration-resource.pages.registration-complete';

    public function mount(int|string $record): void
    {
        /**
         * @var Registration $this ->record
         */
        $this->record = $this->resolveRecord($record);
        $this->qrCode = QrCodeGenerator::make()
            ->id($this->record->id)
            ->qrCodePath();
    }

    public function getTitle(): string|Htmlable
    {
        return __('messages.form.registration.actions.edit.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label(__('invoices::messages.invoice.payment.pdf.link.label'))
                ->icon('tabler-file-type-pdf')
                ->action(function (Registration $record) {
                    $invoicePath = Invoice::make()
                        ->registration($record)
                        ->invoicePath();

                    return Invoice::downloadPdfFromPath($invoicePath);
                }),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }
}
