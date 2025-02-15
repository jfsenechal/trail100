<?php

namespace App\Constant;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DisplayNameEnum: string implements HasLabel, HasIcon
{
    case ANONYMOUS = 'anonymous';
    case FIRST_NAME = 'first_name';
    case FULL_NAME = 'full_name';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ANONYMOUS => __('messages.display_name.anonymous.label'),
            self::FIRST_NAME => __('messages.display_name.first_name.label'),
            self::FULL_NAME => __('messages.display_name.full_name.label'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ANONYMOUS => 'heroicon-m-pencil',
            self::FIRST_NAME => 'heroicon-m-eye',
            self::FULL_NAME => 'heroicon-m-check',
        };
    }
}
