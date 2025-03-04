<?php

namespace App\Filament\Actions;

use App\Invoice\Invoice;
use App\Models\Registration;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class InvoiceDownloadAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'invoiceDownload';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Facture')
            ->icon('tabler-file-type-pdf')
            ->color('info')
            ->action(function (Registration $registration) {
                $invoicePath = Invoice::make()
                    ->registration($registration)
                    ->invoicePath();
                if (!$invoicePath) {
                    try {
                        Invoice::generateWithQrCode($registration);
                        $invoicePath = Invoice::make()
                            ->registration($registration)
                            ->invoicePath();
                    } catch (\Exception $exception) {
                        Notification::make()
                            ->danger()
                            ->title(__('Error : ').$exception->getMessage())
                            ->send();
                        $this->halt();
                    }
                }

                return Invoice::downloadPdfFromPath($invoicePath);
            });
    }
}
