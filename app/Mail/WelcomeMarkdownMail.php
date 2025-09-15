<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; 

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our App',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.welcome_mail', 
            with: ['user' => $this->user]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
