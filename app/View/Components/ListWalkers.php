<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ListWalkers extends Component
{
    public function __construct(public array|Collection $walkers, public string $amount) {}

    public function render(): View|Closure|string
    {
        return view('components.list-walkers');
    }
}
