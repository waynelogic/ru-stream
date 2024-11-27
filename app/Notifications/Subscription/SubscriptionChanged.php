<?php namespace App\Notifications\Subscription;

class SubscriptionChanged extends SubscriptionBase
{
    public function __construct($pricingPlan, $oldPlan)
    {
        parent::__construct($pricingPlan);

        $this->message = 'Подписка на план '. $oldPlan->name.' была успешно изменена на '. $pricingPlan->name.'.';

        $this->title = 'Подписка была изменена';
    }
}
