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
        $locale = $this->getLocaleByOrder($request);
        self::setLanguage($locale);

        return $next($request);
    }

    public static function setLanguage(?string $locale): void
    {
        $locale = in_array($locale, AppConstant::$languages) ? $locale : config('app.fallback_locale');

        App::setLocale($locale);
        Session::put('locale', $locale);
    }

    public static function getLanguage(): string
    {
        return Session::get('locale', App::getLocale());
    }

    private function getLocaleByOrder($request): string
    {
        /**
         * Force with language menu
         */
        if ($locale = $request->route('locale')) {
            return $locale;
        }

        /**
         * If register in preference
         */
        if ($locale = Session::get('locale')) {
            return $locale;
        }

        /**
         * With browser params
         */
        if ($locale = request()->getPreferredLanguage()) {
            return $locale;
        }

        /**
         * Get the application's current locale
         */
        if ($locale = app()->getLocale()) {
            return $locale;
        }

        return config('app.fallback_locale');
    }
}
