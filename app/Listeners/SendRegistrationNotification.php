<?php

namespace App\Listeners;

use App\Events\RegistrationProcessed;
use App\Invoice\Invoice;
use App\Invoice\QrCode\QrCodeGenerator;
use App\Mail\RegistrationCompleted;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

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
        try {
            QrCodeGenerator::generateAndSaveIt($registration);
        } catch (BindingResolutionException|\Exception $e) {
            dd($e->getMessage());
        }

        try {
            Invoice::generatePdfAndSaveIt($registration);
        } catch (BindingResolutionException|\Exception $e) {
            dd($e->getMessage());
        }

        try {
            Mail::to(new Address('jf@marche.be', $registration->email))->send(new RegistrationCompleted($registration));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
