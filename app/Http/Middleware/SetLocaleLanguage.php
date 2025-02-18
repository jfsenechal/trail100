<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleLanguage
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale') ?? Session::get('locale', config('app.locale'));

        if (!in_array($locale, ['en', 'fr', 'nl', 'de'])) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
