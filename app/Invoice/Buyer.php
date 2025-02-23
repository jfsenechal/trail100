<?php

namespace App\Invoice;

use App\Models\Registration;

class Buyer
{
    public string $name;
    public string $email;
    public ?string $city = '';
    public ?string $address = '';
    public ?string $phone = '';

    public static function newFromRegistration(Registration $registration): self
    {
        $firstWalker = $registration->walkers()->first();
        $buyer = new self();
        $buyer->name = $registration->email;
        $buyer->email = $registration->email;

        if ($firstWalker) {
            $buyer->name = $firstWalker->first_name.' '.$firstWalker->last_name;
            $buyer->address = $firstWalker->street;
            $buyer->city = $firstWalker->city;
            $buyer->phone = $firstWalker->phone;
        }

        return $buyer;
    }

}
