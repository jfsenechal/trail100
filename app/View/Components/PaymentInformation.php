<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PaymentInformation extends Component
{
    public string $for;
    public string $bankAccount;
    public string $template = 'components.payment-information';

    public function __construct(
        public string $amount,
        public string $communication,
        public bool $markdown = false,
    ) {
        $this->for = config('app.name');
        $this->bankAccount = config('invoices.seller.bank_account');
        if ($this->markdown) {
            $this->template = 'components.payment-information-markdown';
        }
    }

    public function render(): View|Closure|string
    {
        return view($this->template);
    }
}
