<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationComplete extends Page
{
    use InteractsWithRecord;

    protected static string $resource = RegistrationResource::class;

    protected static string $view = 'filament.front-panel.resources.registration-resource.pages.registration-complete';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Export pdf')
                ->icon('tabler-file-type-pdf')
                ->action(fn() => dump('pdf')),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }

    private function exportPdf(): \Illuminate\Http\Response
    {
        $data = [];
        $pdf = Pdf::loadView('filament.pdf.invoice', $data);
        return $pdf->download('invoice.pdf');
    }

}
