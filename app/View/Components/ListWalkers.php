<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListWalkers extends Component
{
    public function __construct(public array $walkers, public string $amount) {}

    public function render(): View|Closure|string
    {
        return view('components.list-walkers');
    }
}
