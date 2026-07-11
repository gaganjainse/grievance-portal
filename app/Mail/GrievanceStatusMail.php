<?php

namespace App\Mail;

use App\Models\Grievance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GrievanceStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public Grievance $grievance;

    public function __construct(Grievance $grievance)
    {
        $this->grievance = $grievance;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Grievance #{$this->grievance->ticket_id} Status Update: " . ucfirst($this->grievance->status),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.grievance-status',
        );
    }
}
