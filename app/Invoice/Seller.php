<?php

namespace App\Invoice;

class Seller
{
    public string $name;

    public string $address;

    public string $code;

    public string $city;

    public string $bank_account;

    public string $email;

    public string $phone;

    public static function withDefaultValues(): self
    {
        $seller = new self();
        $seller->name = config('invoices.seller.name');
        $seller->address = config('invoices.seller.address');
        $seller->code = config('invoices.seller.code');
        $seller->city = config('invoices.seller.city');
        $seller->bank_account = config('invoices.seller.bank_account');
        $seller->email = config('invoices.seller.email');
        $seller->phone = config('invoices.seller.phone');

        return $seller;
    }
}
