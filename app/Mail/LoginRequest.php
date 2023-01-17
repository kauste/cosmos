<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginRequest extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Login Request',
        );
    }

    public function content()
    {
        return new Content(
            view: 'email',
            with: ['email'=> $this->email],
        );
    }
}
