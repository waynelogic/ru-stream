<?php namespace App\Notifications\Subscription;


class SubscriptionTimeRemaining extends SubscriptionBase
{
    public function __construct($pricingPlan, $days)
    {
        parent::__construct($pricingPlan);

        $message = [
            'Срок подписки на план '.$pricingPlan->name.' истекает.',
            'Осталось дней: '.$days.'.',
        ];

        $this->message = implode(' ', $message);

        $this->title = 'Подписка истекает';
    }
}
