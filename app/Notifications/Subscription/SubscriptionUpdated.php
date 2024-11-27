<?php namespace App\Notifications\Subscription;

class SubscriptionUpdated extends SubscriptionBase
{
    public function __construct($pricingPlan)
    {
        parent::__construct($pricingPlan);

        $this->message = 'Подписка на план '.$this->pricingPlan->name.' была успешно продлена.';

        $this->title = 'Подписка продлена';
    }
}
