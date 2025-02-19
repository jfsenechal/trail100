<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions\Action;

class CreateRegistration extends CreateRecord
{
    protected static string $resource = RegistrationResource::class;
    protected static bool $canCreateAnother = false;

    public function getTitle(): string|Htmlable
    {
        return __('messages.form.registration.actions.new.title');
    }

    /**
     * For label
     */
    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('messages.form.registration.actions.create.label'))
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    public function getHeading22(): string
    {
        return __('messages.form.walker.actions.create.heading');
    }

    public function getSubheading(): string
    {
        return __('messages.form.walker.actions.create.subheading');
    }

    public function create22(bool $another = false): void
    {
        $this->authorizeAccess();
        $this->beginDatabaseTransaction();
        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeCreate($data);
        $this->authorizeAccess();
        $this->beginDatabaseTransaction();
        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeCreate($data);

        foreach ($this->data['walkers'] as $item) {
            try {
                //$record = Walker::create($item);
            } catch (Halt $exception) {
                dd($exception);
            }
        }
        $this->commitDatabaseTransaction();
        $this->rememberData();

        $this->getCreatedNotification()?->send();
        $redirectUrl = $this->getRedirectUrl();

        $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
    }

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
}

/*
FilamentView::registerRenderHook(
    PanelsRenderHook::CONTENT_START,
    fn(): View => view('filament.information.impersonation-banner'),
    scopes: CreateRegistration::class,
);

FilamentView::registerRenderHook(
    PanelsRenderHook::CONTENT_END,
    fn(): View => view('filament.information.impersonation-banner'),
    scopes: CreateRegistration::class,
);
    */
