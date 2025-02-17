<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {dd($request);
        $locale = $request->route('locale') ?? Session::get('locale', config('app.locale'));

        if (!in_array($locale, ['en', 'fr', 'nl'])) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
