<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Events\RegistrationProcessed;
use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        $record = $parameters['record'] ?? null;
        if ($record instanceof Registration) {
            return !$record->isFinished();
        }

        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return __('messages.form.registration.actions.edit.title');
    }

    public function getSubheading(): string
    {
        return __('messages.form.registration.actions.edit.subheading');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('finish')
                ->disabled(fn(Registration $record) => $record->walkers->count() === 0)
                ->label(
                    fn(Registration $record) => $record->walkers->count(
                    ) === 0 ? 'Must be at least 1 walker to complete' : 'I finished',
                )
                ->modalSubmitAction()
                ->requiresConfirmation()
                ->modalIcon('heroicon-o-check')
                ->color('success')
                ->modalIconColor('warning')
                ->modalHeading(__('messages.form.registration.actions.finish.title'))
                ->modalDescription(__('messages.form.registration.actions.finish.description'))
                ->modalSubmitActionLabel(__('messages.form.registration.actions.finish.label'))
                ->action(function (Registration $record, array $data): void {
                    if ($record->walkers->count() < 1) {
                        Notification::make()
                            ->danger()
                            ->title('Unable to finish')
                            ->body('You need at least one walker to finish the registration.')
                            ->send();
                        $this->halt();
                    }
                    $record->setFinished();
                    $record->save();

                    RegistrationProcessed::dispatch($record);

                    Notification::make()
                        ->success()
                        ->title('Finish')
                        ->body('Super.')
                        ->send();

                    $this->getSavedNotification()?->send();
                    $redirectUrl = $this->getRedirectUrl();

                    $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
                }),
        ];
    }

    public function getFormActions(): array
    {
        return [
            Actions\Action::make('zeze')->label('zeze'),
            Actions\Action::make('zozo')->label('zozo'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        $resource = static::getResource();

        if ($resource::hasPage('complete') && $resource::canView($this->getRecord())) {
            return $resource::getUrl('complete', ['record' => $this->getRecord()]);
        }

        return null;
    }
}
