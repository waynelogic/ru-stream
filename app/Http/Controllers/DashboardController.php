<?php namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Models\Story;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $arVideos = $user->videos()->get()->append(['video_url', 'poster_url']);
        $arStories = $user->stories()->get()->append(['video_url', 'poster_url']);


        return Inertia::render('Dashboard/Index', [
            'videos' => $arVideos,
            'stories' => $arStories,
            'referred' => $user->referred()->get(),
            'partner' => $user->partner,
        ]);
    }

    public function payment(Request $request)
    {
        $data = $request->validate(
            rules: [
                'amount' => ['required', 'numeric', 'min:100', 'max:15000'],
            ],
            messages: [
                'amount.required' => 'Введите сумму',
                'amount.numeric' => 'Введите корректную сумму',
                'amount.min' => 'Минимальная сумма 100',
                'amount.max' => 'Максимальная сумма 15000',
            ]
        );

        $obUser = auth()->user();
        $obUser->balance += $data['amount'];
        $obUser->save();

        return back()->flashSuccess('Пополнение прошло успешно');
    }

    public function usePromoCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'exists:promo_codes,code'],
        ], [
            'code.required' => 'Вы не ввели промокод',
            'code.exists' => 'Промокод не найден',
        ]);

        // Находим промокод
        $promoCode = PromoCode::where('code', $request->code)->first();

        // Проверка на существование
        if (!$promoCode) return back()->withErrors(['code' => 'Промокод не найден'])->flashError('Промокод не найден');

        // Проверка на доступность
        if ($promoCode->locked) return back()->withErrors(['code' => 'Промокод не доступен'])->flashError('Промокод не доступен');

        // Проверка на повторное использование
        $user = auth()->user();
        if ($user->promo_codes()->where('code', $promoCode->code)->exists()) {
            return back()->withErrors(['code' => 'Промокод уже использован'])->flashError('Промокод уже использован');
        }
        $this->attachPromoCode($promoCode, $user);
        return back()->banner('Промокод успешно использован');
    }

    private function attachPromoCode(PromoCode $promoCode, $user): void
    {
        $user->promo_codes()->attach($promoCode->id);
        $user->balance += $promoCode->price;
        $promoCode->checkAvailability();
        $user->save();
    }
}
