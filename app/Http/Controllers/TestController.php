<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Stream;
use App\Models\Video;
use App\Notifications\Registered;
use App\Services\StreamManagementService;
use App\Notifications\SubscriptionChanged;
use App\Services\SubscriptionManager;

class TestController extends Controller
{
    public function index()
    {
        $manager = app(SubscriptionManager::class);
        $manager->renewAllEnding();
//        dd($obVideo->generatePoster());

//        $command = "ls -la";
//
//        $process = proc_open($command, [
//            0 => ["pipe", "r"],
//            1 => ["pipe", "w"],
//            2 => ["pipe", "w"],
//        ], $pipes);
//
//        $pid = proc_get_status($process);
//        dd($pid);

//        $user = auth()->user();
//        $user->notify(new Registered());
//        $arPricingPlans = \App\Models\PricingPlan::all();
//        foreach ($arPricingPlans as $pricingPlan) {
//            $pricingPlan->yearly_price = $pricingPlan->monthly_price * 12;
//            $pricingPlan->save();
//        }
//        dd($arPricingPlans);
//        StreamManagementService::instance()->stopExpiredStreams();
    }
}
