<?php

namespace App\Http\Controllers;

use App\Http\Resources\PricingPlanResource;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    public function index()
    {
        $arPricingPlans = PricingPlan::query()->get();

        return inertia('App/PricingPlans', [
            'pricingPlans' => PricingPlanResource::collection($arPricingPlans)
        ]);
    }
}
