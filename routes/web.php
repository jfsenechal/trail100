<?php

use App\Filament\FrontPanel\Resources\Pages\Information;
use App\Filament\Pages\Homepage;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class);
Route::get('/information', Information::class);
