<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class WelcomeSms extends Notification
{
    use Queueable;

    // 1. حدد القنوات بجوج: Mail و Vonage
    public function via(object $notifiable): array
    {
        return ['mail', 'vonage'];
    }

    // 2. كود الإيميل
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Welcome to SmartSol')
                    ->line('مرحباً بك في تطبيقنا!')
                    ->action('ادخل للحساب', url('/dashboard'))
                    ->line('شكراً لانضمامك!');
    }

    // 3. كود الـ SMS
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
                ->content('مرحباً بك في SmartSol! شكراً لانضمامك. قم بزيارة حسابك لمزيد من التفاصيل ☀️ طاقة أنظف، إدارة أذكى.')
                ->unicode(); // هاد السطر مهم جداً للعربية
    }
}



