<?php

namespace App\Http\Middleware;

use App\Http\Resources\SubscriptionResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = auth()->user();
        return [
            ...parent::share($request),
            'subscriptions' => SubscriptionResource::collection($user?->subscriptions()->get() ?? collect()),
            'flashy' => session('flashy'),
            'notifications' => $user?->notifications()->get(),
            'data' => session('data'),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
