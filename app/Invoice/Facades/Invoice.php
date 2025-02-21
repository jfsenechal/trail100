<?php

namespace App\Invoice\Facades;

use Illuminate\Support\Facades\Facade;

class Invoice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'invoice';
    }
}
