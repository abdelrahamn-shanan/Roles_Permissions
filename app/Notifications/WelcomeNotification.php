<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail']; // we want to send email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Welcome to Our App')
                    ->greeting('Hello ' . $this->user->name . '!')
                    ->line('We are excited to have you on board.')
                    ->line('Thank you for joining us!')
                    ->action('Visit Our Website', url('/'))
                    ->line('Best regards, Laravel Team');
    }
}
