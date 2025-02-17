<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use App\Models\Walker;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

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
    public function getTitle(): string | Htmlable
    {
        return __('messages.form.walker.actions.create.title');
    }

    public function create(bool $another = false): void
    {
        $this->authorizeAccess();
        $this->beginDatabaseTransaction();
        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeCreate($data);
        dd($data);
        foreach ($this->data['walkers'] as $item) {
            $record = Walker::create($item);
            dd($record);
        }
        parent::create($another);
    }
}
