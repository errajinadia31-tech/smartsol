<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to SmartSol')
            ->line('مرحباً بك في تطبيق SmartSol!')
            ->action('ادخل للحساب', url('/login'))
            ->line('شكراً لانضمامك!');
    }
}