<?php

use App\Filament\FrontPanel\Resources\Pages\Information;
use App\Filament\FrontPanel\Resources\Pages\Rgpd;
use App\Filament\Pages\Homepage;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/{locale}', Homepage::class)->middleware(['setLocale']);
Route::get('/rgpd/{locale}', Rgpd::class)->middleware(['setLocale']);
Route::get('/information/{locale}', Information::class)->middleware(SetLocale::class);

Route::post('/change-language', function () {
    $locale = request('locale');
    if (in_array($locale, ['en', 'fr', 'nl'])) {
        Session::put('locale', $locale);
    }

    return back();
})->name('change.language');
