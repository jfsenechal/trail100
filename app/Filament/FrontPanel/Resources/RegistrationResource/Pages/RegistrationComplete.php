<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Invoice\Buyer;
use App\Invoice\Invoice;
use App\Invoice\Seller;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
        /*   $invoice = Invoice::make('receipt')
               ->seller(new Seller())
               ->buyer(
                   new Buyer([
                       'name' => fake()->firstName(),
                       'address' => fake()->streetAddress(),
                       'phone' => fake()->phoneNumber(),
                   ]),
               )
               ->registration($this->record)
               ->totalAmount($this->record->totalAmount())
               ->status('not paid')
               ->date(Carbon::today());

           try {
               dd($invoice->download());
           } catch (\Exception $exception) {
               dd($exception);
           }*/
    }

    public function logo(): ?string
    {
        $path = public_path('images/logoMarcheur.jpg');
        if (file_exists($path)) {
            $imageData = base64_encode(file_get_contents($path));
            $mimeType = mime_content_type($path);
            $base64Image = "data:$mimeType;base64,$imageData";

            return $base64Image;
        } else {
            return null;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Export pdf')
                ->icon('tabler-file-type-pdf')
                ->action(function (Registration $record) {
                    $this->generatePdf($record);
                }),
        ];
    }

    private function generatePdf(Registration $record): Response
    {
        $invoice = Invoice::make('Invoice-'.$record->id)
            ->name(Str::slug($record->email.''.$record->id))
            ->seller(new Seller())
            ->buyer(
                new Buyer([
                    'name' => fake()->firstName(),
                    'address' => fake()->streetAddress(),
                    'phone' => fake()->phoneNumber(),
                ]),
            )
            ->registration($record)
            ->totalAmount($record->totalAmount())
            ->status('not paid')
            ->date($record->created_at)
            ->logo($this->logo())
            ->save('invoices');
        try {
            return $invoice->download();
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }

    private function exportPdf(): Response
    {
        $data = [];
        $pdf = Pdf::loadView('filament.pdf.invoice', $data);

        return $pdf->download('invoice.pdf');
    }

}
