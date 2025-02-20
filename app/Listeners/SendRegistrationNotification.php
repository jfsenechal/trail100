<?php

namespace App\Listeners;

use App\Events\RegistrationProcessed;
use App\Invoice\Invoice;
use App\Mail\RegistrationCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegistrationNotification
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
    public function handle(RegistrationProcessed $event): void
    {
        $registration = $event->registration();

        Invoice::downloadPdf();
        Mail::to('jf@marche.be')->send(new RegistrationCompleted());

    }
}
