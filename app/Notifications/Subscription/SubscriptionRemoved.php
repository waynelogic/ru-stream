<?php namespace App\Notifications\Subscription;

class SubscriptionRemoved extends SubscriptionBase
{
    public function __construct($pricingPlan)
    {
        parent::__construct($pricingPlan);

        $this->message = 'Подписка на план '.$this->pricingPlan->name.' была отменена.';

        $this->title = 'Подписка отменена';
    }
}
