<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The reset URL.
     *
     * @var string
     */
    public $resetUrl;

    /**
     * Create a new message instance.
     *
     * @param string $resetUrl
     * @return void
     */
    public function __construct(string $resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Redefinição de Senha - SeguraEssa.app',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.password-reset',
            with: [
                'resetUrl' => $this->resetUrl,
            ],
        );
    }
}
