<?php

use App\Filament\FrontPanel\Resources\Pages\Information;
use App\Filament\FrontPanel\Resources\Pages\Rgpd;
use App\Filament\Pages\Homepage;
use App\Http\Middleware\SetLocaleLanguage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::prefix('{locale}')->middleware(SetLocaleLanguage::class)->group(function () {
    Route::get('/', Homepage::class);
    Route::get('/grpd', Rgpd::class);
    Route::get('/information', Information::class)->name('information');
});

Route::get('/change-language/{locale}', function () {
    $locale = request('locale');

    if (in_array($locale, ['en', 'fr', 'nl', 'de'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    return back();
})->name('change.language');
