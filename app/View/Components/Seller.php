<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seller extends Component
{
    public ?string $name;
    public ?string $address;
    public ?string $city;
    public ?string $bank_account;
    public ?string $phone;
    public ?string $code;
    public ?string $email;

    public function __construct()
    {
        $this->name = config('invoices.seller.name');
        $this->address = config('invoices.seller.address');
        $this->code = config('invoices.seller.code');
        $this->city = config('invoices.seller.city');
        $this->bank_account = config('invoices.seller.bank_account');
        $this->email = config('invoices.seller.email');
        $this->phone = config('invoices.seller.phone');
    }

    public function render(): View|Closure|string
    {
        return view('components.seller');
    }
}
