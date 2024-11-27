<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Stream;
use App\Models\Video;
use App\Notifications\Registered;
use App\Services\StreamManagementService;
use App\Notifications\SubscriptionChanged;
class TestController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->notify(new Registered());
//        $arPricingPlans = \App\Models\PricingPlan::all();
//        foreach ($arPricingPlans as $pricingPlan) {
//            $pricingPlan->yearly_price = $pricingPlan->monthly_price * 12;
//            $pricingPlan->save();
//        }
//        dd($arPricingPlans);
//        StreamManagementService::instance()->stopExpiredStreams();
    }
}
