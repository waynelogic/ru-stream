<?php

namespace App\Http\Controllers\Auth;

use App\Models\Social\TgUser;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Http\Request;
use Storage;
class TelegramAuthController
{
    public function Client(int $phone = null)
    {
        if (is_null($phone)) {
            $phone = session()->get('current_telegram_phone');
        }
        $settings = (new AppInfo)
            ->setApiId(config('madeline-proto.api_id'))
            ->setApiHash(config('madeline-proto.api_hash'));

        return new API(Storage::path('madeline-proto/' . $phone), $settings);
    }

    public function index(Request $request, $method)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}($request);
        } else {
            abort(404);
        }
    }

    public function sendPhoneNumber($request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phoneNumber = $request->input('phone');

        $current_telegram_phone = preg_replace("/[^,.0-9]/", '', $phoneNumber);
        session()->put('current_telegram_phone', $current_telegram_phone);


        try {
            $this->Client($current_telegram_phone)->phoneLogin($phoneNumber);
        } catch (\danog\MadelineProto\Exception $e) {
            return back()->withError($e->getMessage());
        }

        return back()->flashSuccess('Phone number sent');
    }

    public function completePhoneLogin($request)
    {
        $request->validate([
            'code' => 'required',
        ]);
        $code = $request->input('code');
        $authorization = $this->Client()->completePhoneLogin($code);

        if (isset($authorization['_']) && $authorization['_'] === 'account.password') {
            session()->put('data', [
                'status' => '2FA required',
                'hint' => $authorization['hint'],
            ]);
        } elseif (isset($authorization['_']) && $authorization['_'] === 'account.needSignup') {
            session()->put('data', [
                'status' => 'Signup required',
            ]);
        }

        return back();
    }


    public function complete2faLogin(Request $request)
    {
        $password = $request->input('password');
        $authorization = $this->Client()->complete2faLogin($password);

        $obTgUser = TgUser::query()->where('phone', session()->get('current_telegram_phone'))->firstOrNew();

        $arUser = $authorization['user'];
        $obTgUser->fill([
            'phone' => session()->get('current_telegram_phone'),
            'user_id' => auth()->user()->id,
            'tg_id' => $arUser['id'],
            'name' => $arUser['username'],
        ]);
        $obTgUser->save();

        return response()->json(['status' => 'Logged in']);
    }
}
