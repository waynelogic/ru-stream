<?php

namespace App\Services;

use App\Models\Subscription;
use App\Notifications\Subscription\SubscriptionRemoved;
use App\Notifications\Subscription\SubscriptionTimeRemaining;
use App\Notifications\Subscription\SubscriptionUpdated;

class SubscriptionManager
{
    public function notifyAllEnding(): void
    {
        $subscriptions = Subscription::query()->where('ends_at', '<', now()->addDays(5))->get();
        foreach ($subscriptions as $subscription) {
            $result = $this->notifyUser($subscription);
            if (!$result) {
                \Log::info('Failed to notify user with subscription ' . $subscription->id);
            }
        }
    }

    private function notifyUser($subscription) : bool
    {
        $user = $subscription->user;
        $remainingDays = (int) round(now()->diffInDays($subscription->ends_at));
        $user->notify(new SubscriptionTimeRemaining($subscription->pricing_plan, $remainingDays));
        return true;
    }

    public function renewAllEnding()
    {
        $subscriptions = Subscription::query()->where('ends_at', '<', now())->get();
        foreach ($subscriptions as $subscription) {
            $result = $subscription->renew();
            $pricingPlan = $subscription->pricing_plan;
            $user = $subscription->user;
            if (!$result) {
                $subscription->delete();
                $user->notify(new SubscriptionRemoved($pricingPlan));
            } else {
                $user->notify(new SubscriptionUpdated($pricingPlan));
            }
        }
    }
}
