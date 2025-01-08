<?php

namespace App\Http\Controllers;

use App\Models\Social\TgUser;
use App\Models\Story;
use App\Models\Stream;
use App\Models\Video;
use App\Notifications\Registered;
use App\Services\StreamManagementService;
use App\Notifications\SubscriptionChanged;
use App\Services\SubscriptionManager;
use App\Services\Telegram;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings\Auth;
use danog\MadelineProto\Settings\Templates;
use Inertia\Inertia;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TestController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        $phone = 79895123444;
        $obTg = Telegram::make($phone);

        $arChatList = [];

        $chats = $obTg->channels->getAdminedPublicChannels()['chats'];
        foreach ($chats as $chat) {
            $arChatList[] = [
                'id' => $chat['id'],
                'title' => $chat['title'],
                'username' => $chat['username'],
            ];
        }
        dd($arChatList);


//        $photoInfo->downloadToFile(\Storage::disk('public')->path($path));
//        $obTgUser->fill([
//            'phone' => (int) session()->get('current_telegram_phone'),
//            'user_id' => (int) auth()->user()->id,
//            'tg_id' => (int) $arUser['id'],
//            'name' => $arUser['username'],
//        ]);
//        $obTgUser->save();

//        $phone = 79897090215;
//        if (is_null($phone)) {
//            $phone = session()->get('current_telegram_phone');
//        }
//        $appInfo = (new AppInfo)
//            ->setApiId(config('madeline-proto.api_id'))
//            ->setApiHash(config('madeline-proto.api_hash'));
//
//        $settings = (new Settings())->setAppInfo($appInfo);
//
//        $obApi = new API(\Storage::path('madeline-proto/' . $phone), $settings);
//        $obApi->start();


//        $obTg = Telegram::make(79895123444);
//        $arChannels = $obTg->channels->getAdminedPublicChannels();
//
//        dd($obTg->channels->getAdminedPublicChannels());
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
