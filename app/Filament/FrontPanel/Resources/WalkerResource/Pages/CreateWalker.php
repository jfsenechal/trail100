<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Filament\Support\Exceptions\Halt;

class CreateWalker extends CreateRecord
{
    protected static string $resource = WalkerResource::class;
    protected static bool $canCreateAnother = false;
    protected static ?string $title = 'messages.form.walker.actions.create.title';

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            //  ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            //  $this->getCancelFormAction(),
        ];
    }

    /**
     * For change label
     * @return Action
     */
    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('messages.form.walker.actions.create.label'))
            ->extraAttributes(['class' => 'primary'])
            ->submit('create')
            ->requiresConfirmation()
            ->keyBindings(['mod+s']);
    }

    /**
     * Change title
     * @return string|Htmlable
     */
    public function getTitle(): string|Htmlable
    {
        return __('messages.form.walker.actions.create.title');
    }

    public function getHeading(): string
    {
        return __('messages.form.walker.actions.create.heading');
    }

    public function getSubheading(): string
    {
        return __('messages.form.walker.actions.create.subheading');
    }

    public function create(bool $another = false): void
    {
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

}

FilamentView::registerRenderHook(
    PanelsRenderHook::CONTENT_START,
    fn(): View => view('filament.information.impersonation-banner'),
    scopes: \App\Filament\FrontPanel\Resources\WalkerResource\Pages\CreateWalker::class,
);

FilamentView::registerRenderHook(
    PanelsRenderHook::CONTENT_END,
    fn(): View => view('filament.information.impersonation-banner'),
    scopes: \App\Filament\FrontPanel\Resources\WalkerResource\Pages\CreateWalker::class,
);

