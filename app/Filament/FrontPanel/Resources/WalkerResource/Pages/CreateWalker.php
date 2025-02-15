<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use App\Models\Walker;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateWalker extends CreateRecord
{
    protected static string $resource = WalkerResource::class;
    protected static bool $canCreateAnother = false;

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
            ->keyBindings(['mod+s']);
    }

    public function create(bool $another = false): void
    {
        foreach ($this->data['walkers'] as $item) {
            $result = Walker::create($item);
            dd($result);
        }
        parent::create($another);
    }
}
