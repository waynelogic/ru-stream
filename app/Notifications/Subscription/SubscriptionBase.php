<?php

namespace App\Notifications\Subscription;

use App\Enums\NotifyCategory;
use App\Models\PricingPlan;
use App\Notifications\NotificationBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionBase extends NotificationBase
{
    use Queueable;

    public PricingPlan $pricingPlan;
    public string $title;
    public string $message;


    /**
     * Create a new notification instance.
     */
    public function __construct($pricingPlan)
    {
        $this->pricingPlan = $pricingPlan;
    }
    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'category' => NotifyCategory::SUBSCRIPTION
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject( env('APP_NAME') . ' : ' . $this->title)
            ->greeting("Доброе время суток, {$notifiable->login}!")
            ->line($this->message)
            ->action('Перейти в личный кабинет', url(route('dashboard')))
            ->line('Благодарим Вас за использование нашего приложения!')
            ->salutation("С уважением, команда " . env('APP_NAME'));
    }
}
