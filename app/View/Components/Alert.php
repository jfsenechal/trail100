<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $message = '';

    public function __construct(
        public string $type,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
