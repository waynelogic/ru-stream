<?php

namespace App\Notifications;

use App\Enums\NotifyCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationBase extends Notification
{
    use Queueable;

    public bool $bd = true;

    public bool $mail = true;

    /**
     * Create a new notification instance.
     */
//    public function __construct()
//    {
//        //
//    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $arVia = [];
        if ($this->bd) $arVia[] = 'database';
        if ($this->mail) $arVia[] = 'mail';
        return $arVia;
    }
}
