<?php

namespace App\Mail;

use App\Models\accreditation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccreditationToken extends Mailable
{
    use Queueable, SerializesModels;

    public $accreditation;
    public $member;

    /**
     * Create a new message instance.
     */
    public function __construct(accreditation $accreditation)
    {
        $this->accreditation = $accreditation;
        $this->member = $accreditation->member;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Accreditation Token',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.accreditation_token',
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
