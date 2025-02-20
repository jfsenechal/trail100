<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct() {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('jf@marche.be', config('APP_NAME')),
            subject: 'Registration completed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url = config('app.url');

        //CustomerResource::getUrl('create');
        return new Content(
            markdown: 'mail.registration-completed',
            with: [
                'textbtn' => __('messages.btn.access_platform.label'),
                'url' => $url,
            ],
        //    text: 'mail.orders.shipped-text',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
