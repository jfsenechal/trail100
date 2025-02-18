<?php

namespace App\Http;

use App\Http\Middleware\SetLocaleLanguage;

class Kernel
{
    protected $routeMiddleware = [
        'SetLocaleLanguage' => SetLocaleLanguage::class,
    ];
}
