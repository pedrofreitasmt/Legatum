<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContatoEnviadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Legatum - Contato Enviado',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contato',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
