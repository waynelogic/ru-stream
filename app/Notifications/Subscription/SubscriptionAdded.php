<?php namespace App\Notifications\Subscription;

class SubscriptionAdded extends SubscriptionBase
{
    public function __construct($pricingPlan)
    {
        parent::__construct($pricingPlan);

        $this->message = 'Подписка на план '.$this->pricingPlan->name.' была успешно оформлена.';

        $this->title = 'Подписка оформлена';
    }
}
