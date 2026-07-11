<?php

namespace App\Notifications;

use App\Models\Grievance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GrievanceStatusNotification extends Notification
{
    use Queueable;

    public Grievance $grievance;

    public function __construct(Grievance $grievance)
    {
        $this->grievance = $grievance;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Grievance #{$this->grievance->ticket_id} Status Update")
            ->greeting("Dear {$notifiable->name},")
            ->line("Your grievance <strong>#{$this->grievance->ticket_id}</strong> has been updated.")
            ->line("Current status: <strong>" . ucfirst($this->grievance->status) . "</strong>")
            ->line("Subject: {$this->grievance->subject}")
            ->action('View Grievance', url("/citizen/grievances/{$this->grievance->id}"))
            ->line('Thank you for using our grievance portal.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'grievance_id' => $this->grievance->id,
            'ticket_id' => $this->grievance->ticket_id,
            'status' => $this->grievance->status,
            'subject' => $this->grievance->subject,
        ];
    }
}
