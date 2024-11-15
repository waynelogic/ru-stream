<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $obPricingPlan = PricingPlan::query()->where('id', (int) $request->plan)->first();
        if (!$obPricingPlan)  return back()->flashError('План не найден');

        $obUser = auth()->user();
        $intPrice = $obPricingPlan->monthly_price;
        if ($obUser->balance < $intPrice) return back()->flashError('Недостаточно средств');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
