<?php

namespace App\Constant;

enum TshirtEnum: string
{
    case NO = 'NONE';
    case XS = 'XS';
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = 'XXL';

    public function label(): string
    {
        return match ($this) {
            self::NO => self::NO->value,
            self::XS => self::XS->value,
            self::S => self::S->value,
            self::M => self::M->value,
            self::L => self::L->value,
            self::XL => self::XL->value,
            self::XXL => self::XXL->value,
        };
    }

    public function getIconColor(): string
    {
        return match ($this) {
            self::NO => 'gray',
            self::XS => 'gray',
            default => 'success',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::NO => 'gray',
            default => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NO => 'tabler-shirt-off',
            default => 'tabler-shirt',
        };
    }

}
