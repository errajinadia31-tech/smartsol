<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class LowProductionSmsNotification extends Notification
{
    use Queueable;

    public $production;

    public function __construct($production)
    {
        $this->production = $production;
    }

    public function via($notifiable)
    {
        return ['vonage'];
    }

    public function toVonage($notifiable)
{
    return (new VonageMessage)
    ->content(
        "SmartSol Alert: Production faible detectee. "
        . "Production actuelle: {$this->production} W. "
        . "Veuillez verifier vos panneaux solaires."
    );

    }
}