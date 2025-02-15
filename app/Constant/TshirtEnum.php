<?php

namespace App\Constant;

enum TshirtEnum: string
{
    case XS = 'XS';
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = 'XXL';

    public function label(): string
    {
        return match ($this) {
            self::XS => self::XS->value,
            self::S => self::S->value,
            self::M => self::M->value,
            self::L => self::L->value,
            self::XL => self::XL->value,
            self::XXL => self::XXL->value,
        };
    }

}
