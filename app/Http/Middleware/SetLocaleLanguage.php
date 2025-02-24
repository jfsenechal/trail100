<?php

namespace App\Http\Middleware;

use App\Constant\AppConstant;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleLanguage
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale') ?? Session::get('locale') ?? config('app.fallback_locale');
        self::setLanguage($locale);

        return $next($request);
    }

    public static function setLanguage(?string $locale): void
    {
        $locale = in_array($locale, AppConstant::$languages) ? $locale : config('app.fallback_locale');

        App::setLocale($locale);
        Session::put('locale', $locale);
    }

    public static function getLanguage( ): string
    {
        return Session::get('locale', App::getLocale());
    }

}
