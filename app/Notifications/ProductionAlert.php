<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProductionAlert extends Notification
{
    public $power;

    public function __construct($power) {
        $this->power = $power;
    }

    public function via($notifiable) {
        return ['database', 'mail']; // غيصيفط فـ Database و Email
    }

    // هادي اللي كتسجل في الـ Notifications table (باش تبان في الـ Bell icon)
    public function toArray($notifiable) {
        return [
            'message' => 'انخفاض في الإنتاج: ' . $this->power . ' واط',
            'power' => $this->power
        ];
    }

    // هادي اللي كتصيفط الإيميل
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('SmartSol - Alerte Production')
            ->line('تم تسجيل انخفاض في إنتاج الطاقة.')
            ->line('الإنتاج الحالي: ' . $this->power . ' واط')
            ->line('الحد الأدنى: 100 واط')
            ->action('Vérifier vos panneaux', url('/dashboard'))
            ->line('— SmartSol Team');
    }
}