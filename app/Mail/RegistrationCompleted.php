<?php

namespace App\Mail;

use App\Filament\FrontPanel\Resources\RegistrationResource;
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

        return new Content(
            markdown: 'mail.registration-completed',
            with: [
                'textbtn' => __('messages.email.registration.confirm.btn.label'),
                'url' => RegistrationResource::getUrl('complete', ['record' => $this->registration]),
                'logo' => $this->logo,
            ],
        );
    }

    public function attachments(): array
    {
        $fileName = 'invoice-4_AA_00001.pdf';
        $filePath = storage_path('data/invoices/invoice-4_AA_00001.pdf');

        if (file_exists($filePath)) {
            return [
                Attachment::fromStorageDisk('invoices', $fileName)
                    ->as('name.pdf')
                    ->withMime('application/pdf'),
                Attachment::fromPath($this->logo)
                    ->as('logoMarcheur.jpg')
                    ->withMime('image/jpg'),
            ];
        }

        return [];
    }

}
