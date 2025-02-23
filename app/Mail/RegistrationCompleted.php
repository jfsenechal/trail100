<?php

namespace App\Mail;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Invoice\Facades\Invoice;
use App\Invoice\Seller;
use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * https://maizzle.com/docs/components // todo
 */
class RegistrationCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $logo = null;
    public ?string $qrcode = null;

    public function __construct(public readonly Registration $registration) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('APP_NAME')),
            subject: __('messages.email.registration.confirm.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $this->logo = public_path('images/logoMarcheur.jpg');
        if (!file_exists($this->logo)) {
            $this->logo = null;
        }

        $this->qrcode = public_path('images/logoMarcheur.jpg');
        if (!file_exists($this->qrcode)) {
            $this->qrcode = null;
        }

        return new Content(
            markdown: 'mail.registration-completed',
            with: [
                'textbtn' => __('messages.email.registration.confirm.btn.label'),
                'url' => RegistrationResource::getUrl('complete', ['record' => $this->registration]),
                'logo' => $this->logo,
                'seller' => Seller::withDefaultValues(),
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        $attachments[] =
            Attachment::fromPath($this->logo)
                ->as('logoMarcheur.jpg')
                ->withMime('image/jpg');

        $invoicePath = Invoice::make()
            ->uuid($this->registration->uuid)
            ->invoicePath();

        $invoiceFileName = Invoice::make()
            ->uuid($this->registration->uuid)
            ->invoiceFileName();

        if (is_file($invoicePath)) {
            $attachments[] =
                Attachment::fromStorageDisk('invoices', $invoiceFileName)
                    ->as('name.pdf')
                    ->withMime('application/pdf');
        }

        return $attachments;
    }

}
