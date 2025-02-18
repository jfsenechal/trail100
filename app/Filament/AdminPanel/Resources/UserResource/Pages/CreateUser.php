<?php

namespace App\Filament\AdminPanel\Resources\UserResource\Pages;

use App\Filament\AdminPanel\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

}
