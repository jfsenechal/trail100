<?php

namespace App\Listeners;

use App\Events\RegistrationProcessed;
use App\Invoice\Invoice;
use App\Invoice\QrCode\QrCodeGenerator;
use App\Mail\RegistrationCompleted;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Events\LocaleUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class SendLocaleNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate pdf
     * Generate Qrcode
     * Send mail with pdf
     *
     */
    public function handle(LocaleUpdated $event): void
    {
            Log::debug('JIJI event '.$event->locale);

    }
}
