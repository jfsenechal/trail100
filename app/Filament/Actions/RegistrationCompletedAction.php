<?php

namespace App\Filament\Actions;

use App\Events\RegistrationProcessed;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Checkbox;
use Filament\Notifications\Notification;
use Filament\Support\Facades\FilamentView;

class RegistrationCompletedAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'registrationCompleted';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->form([
                Checkbox::make('newsletter_accepted')
                    ->label(__('messages.form.registration.actions.newsletter_accepted.label'))
                    ->required(false),
                Checkbox::make('gdpr_accepted')
                    ->required()
                    ->label(__('messages.form.registration.actions.gdpr_accepted.label')),
            ])
            ->label(__('messages.form.registration.actions.header.finish.label'))
            /*  ->modalSubmitAction(function (StaticAction $action, Registration $record) {
                  if ($record->walkers->count() === 0) {
                      $action
                          ->label('no walkers')
                          ->disabled();
                  }
              })*/
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-check')
            ->color('success')
            ->modalIconColor('warning')
            ->modalHeading(__('messages.form.registration.actions.modal.finish.title'))
            ->modalDescription(__('messages.form.registration.actions.modal.finish.description'))
            ->modalSubmitActionLabel(__('messages.form.registration.actions.modal.finish.label'))
            ->mountUsing(function (StaticAction $action) {
                $action
                    ->label('no walkers')
                    ->disabled();
            })
            ->action(function (array $data, Registration $record): void {
                if ($record->walkers->count() === 0) {
                    Notification::make()
                        ->danger()
                        ->title(__('messages.form.registration.notification.nowalkers.title'))
                        ->body(__('messages.form.registration.notification.nowalkers.body'))
                        ->send();

                    return;
                }

                $record->gdpr_accepted = $data['gdpr_accepted'] ?? false;
                $record->newsletter_accepted = $data['newsletter_accepted'] ?? false;
                $record->setCompleted();
                $record->save();

                RegistrationProcessed::dispatch($record);

                Notification::make()
                    ->success()
                    ->title(__('messages.form.registration.notification.finish.title'))
                    ->body(__('messages.form.registration.notification.finish.body'))
                    ->send();

                $this->getSavedNotification()?->send();
                $redirectUrl = $this->getRedirectUrl();

                $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
            });
    }
}
