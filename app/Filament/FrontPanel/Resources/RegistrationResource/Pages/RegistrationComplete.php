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

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $resource = RegistrationResource::class;
    public ?string $qrCode;
    public ?string $qrCodeScanning;
    public string $message = '';

    public function getView(): string
    {
        return 'filament.front-panel.resources.registration-resource.pages.registration-complete';
    }

    public function mount(int|string $record): void
    {
        /**
         * @var Registration $this ->record
         */
        $this->record = $this->resolveRecord($record);
        $this->qrCode = self::convertToBase64(QrCodeGenerator::make()
            ->id($this->record->id)
            ->qrCodePath());
        $fileScanning = public_path('images/qr-code-scanning2.jpg');
        $this->qrCodeScanning = self::convertToBase64($fileScanning);
        $this->message = 'coucou';
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

    private static function convertToBase64(string $filePath): ?string
    {
        $imageData = base64_encode(file_get_contents($filePath));
        $mimeType = mime_content_type($filePath);
        $base64Image = "data:$mimeType;base64,$imageData";

        return $base64Image;
    }
}
