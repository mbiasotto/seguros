<?php

namespace App\Mail;

use App\Models\Establishment;
use App\Models\EstablishmentOnboarding;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstablishmentWelcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * O estabelecimento que receberá o e-mail de boas-vindas.
     */
    public $establishment;

    /**
     * O token de onboarding para acesso seguro.
     */
    public $onboarding;

    /**
     * Create a new message instance.
     */
    public function __construct(Establishment $establishment, EstablishmentOnboarding $onboarding)
    {
        $this->establishment = $establishment;
        $this->onboarding = $onboarding;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem-vindo ao SeguraEssa.app - Complete seu cadastro',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.establishment-welcome',
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