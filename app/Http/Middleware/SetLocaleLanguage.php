<?php

namespace App\Http\Middleware;

use App\Constant\AppConstant;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SetLocaleLanguage
{
    public function handle($request, Closure $next)
    {
        if ($locale = $request->route('locale')) {
            Log::debug('JIJI request '.$locale);
            self::setLanguage($locale);

            return $next($request);
        } elseif ($locale = Session::get('locale')) {
            Log::debug('JIJI session '.$locale);
            $this->setLanguage($locale);

            return $next($request);
        } else {
            Log::debug('JIJI other '.$locale);
            $this->setLanguage($locale);

            return $next($request);
        }

        return $next($request);
    }

    public static function setLanguage(?string $locale): void
    {
        if (!$locale) {
            $locale = config('app.fallback_locale');
        }

        if (!in_array($locale, AppConstant::$languages)) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
    }

    public static function getLanguage( ): string
    {
        if ($locale = Session::get('locale', null)) {
            return $locale;
        }

        return App::getLocale();
    }


}
