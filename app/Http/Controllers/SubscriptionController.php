<?php

namespace App\Http\Controllers;

use App\Enums\StreamType;
use App\Models\PricingPlan;
use App\Models\User;
use App\Notifications\Subscription\SubscriptionAdded;
use App\Notifications\Subscription\SubscriptionChanged;
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
        // Находим план. Если его нет, то возвращаем ошибку.
        $obPricingPlan = PricingPlan::query()->where('id', (int) $request->plan)->first();
        if (!$obPricingPlan)  return back()->flashError('План не найден');

        // Если у пользователя недостаточно средств, то возвращаем ошибку.
        $obUser = auth()->user();
        $intPrice = $obPricingPlan->monthly_price;
        if ($obUser->balance < $intPrice) return back()->flashError('Недостаточно средств');

        // Если у пользователя уже есть подписка, то удаляем ее.
        $obCurrent = $this->findCurrent($obPricingPlan->type);
        if ($obCurrent) {
            $obCurrent->delete();
        }

        // Создаем подписку
        $obUser->subscriptions()->create([
            'pricing_plan_id' => $obPricingPlan->id,
        ]);
        // Уменьшаем баланс
        $obUser->balance -= $intPrice;
        $obUser->save();

        if ($obCurrent) {
            $obUser->notify(new SubscriptionChanged($obPricingPlan, $obCurrent->pricing_plan));
            return back()->flashSuccess('Подписка была изменена на план '. $obPricingPlan->name);
        } else {
            $obUser->notify(new SubscriptionAdded($obPricingPlan));
            return back()->flashSuccess('Подписка на план '. $obPricingPlan->name.' была оформлена');
        }
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
        $obSubscription = auth()->user()->subscriptions()->find($id);
        if (!$obSubscription) return back()->flashError('Подписка не найдена');
        $data = $request->validate([
            'auto_renew' => ['boolean'],
        ]);

        $obSubscription->update($data);

        return back()->flashSuccess('Подписка обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function findCurrent(StreamType $type)
    {
        return auth()->user()?->subscriptions()->where('type', $type->value)->with('pricing_plan')->first() ?? null;
    }
}
