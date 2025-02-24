<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Events\RegistrationProcessed;
use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Session;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;
    protected ?bool $hasUnsavedDataChangesAlert = true;

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
        return __('messages.form.registration.actions.edit.title', locale: Session::get('locale'));
    }

    public function getSubheading(): string
    {
        return __('messages.form.registration.actions.edit.subheading', locale: Session::get('locale'));
    }

    public function getFormActions(): array
    {
        return [
            Actions\Action::make('finish')
                ->form([
                    Checkbox::make('newsletter_accepted')
                        ->label(__('messages.form.registration.actions.newsletter_accepted.label', locale: Session::get('locale')))
                        ->required(false),
                    Checkbox::make('gdpr_accepted')
                        ->required()
                        ->label(__('messages.form.registration.actions.gdpr_accepted.label', locale: Session::get('locale'))),
                ])
                ->label(__('messages.form.registration.actions.header.finish.label', locale: Session::get('locale')))
                ->modalSubmitAction(function (StaticAction $action, Registration $record) {
                    if ($record->walkers->count() !== 0) {
                        $action
                            ->label('no walkers')
                            ->disabled();
                    }
                })
                ->requiresConfirmation()
                ->modalIcon('heroicon-o-check')
                ->color('success')
                ->modalIconColor('warning')
                ->modalHeading(__('messages.form.registration.actions.modal.finish.title', locale: Session::get('locale')))
                ->modalDescription(__('messages.form.registration.actions.modal.finish.description', locale: Session::get('locale')))
                ->modalSubmitActionLabel(__('messages.form.registration.actions.modal.finish.label', locale: Session::get('locale')))
                ->mountUsing(function (StaticAction $action) {
                    $action
                        ->label('no walkers')
                        ->disabled();
                })
                ->action(function (array $data, Registration $record, StaticAction $action): void {
                    if ($record->walkers->count() === 0) {
                        $action
                            ->label('no walkers')
                            ->disabled();

                        Notification::make()
                            ->danger()
                            ->title('Unable to finish')
                            ->body('You need at least one walker to finish the registration.')
                            ->send();

                        return;
                    }

                    $record->gdpr_accepted = $data['gdpr_accepted'];
                    $record->newsletter_accepted = $data['newsletter_accepted'];
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    protected function hasUnsavedDataChangesAlert22(): bool
    {
        return $this->record;//todo condition
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
