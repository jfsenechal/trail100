<?php

namespace App\Invoice\Facades;

use Illuminate\Support\Facades\Facade;

class QrCodeGenerator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'qrCodeGenerator';
    }
}
