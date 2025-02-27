<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Invoice\Facades\Invoice;
use App\Invoice\QrCode\QrCodeGenerator;
use App\Mail\RegistrationCompleted;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Translation\Translator;

class CreateRegistration extends CreateRecord
{
    protected static string $resource = RegistrationResource::class;
    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        $registration = Registration::with('walkers')->withCount('walkers')->first();

        try {
         //   QrCodeGenerator::generateAndSaveIt($registration);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        try {
        //    Invoice::generatePdfAndSaveIt($registration);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

       // Mail::to(new Address('jf@marche.be', $registration->email))->send(new RegistrationCompleted($registration));
        parent::mount();
    }

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
