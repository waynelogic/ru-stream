<?php

namespace App\Http\Controllers\Auth;

use App\Models\Social\TgUser;
use App\Services\Telegram;
use App\Services\TryCatch;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\RPCError\PasswordHashInvalidError;

class TelegramAuthController
{
    public function Client(int $phone = null) : API
    {
        if (is_null($phone)) {
            $phone = session()->get('current_telegram_phone');
        }
        return Telegram::make($phone);
    }

    public function index(Request $request, $method)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}($request);
        } else {
            abort(404);
        }
    }

    public function sendPhoneNumber(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);
        $sPhoneNumber = $request->input('phone');

        $intPhoneNumber = (int) preg_replace("/[^,.0-9]/", '', $sPhoneNumber);
        session()->put('current_telegram_phone', $intPhoneNumber);

        try {
            $this->Client($intPhoneNumber)->phoneLogin($intPhoneNumber);
        } catch (\Exception $e) {
            return back()->flashError($e->getMessage());
        }

        return back()->flashSuccess('Код отправлен');
    }

    public function completePhoneLogin($request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $code = $request->input('code');

        try {
            $authorization = $this->Client()->completePhoneLogin($code);
        } catch (Exception $e) {
            return back()->flashError($e->getMessage());
        }

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

        try {
            $authorization = $this->Client()->complete2faLogin($password);
        } catch (Exception | \danog\MadelineProto\RPCErrorException $e) {
            return back()->flashError($e->getMessage());
        } catch (PasswordHashInvalidError $e) {
            return back()->flashError($e->getMessage());
        }
        $this->createUser();

        return response()->json(['status' => 'Logged in']);
    }

    public function createUser()
    {
        $tg = $this->Client();
        $phone = (int) session()->get('current_telegram_phone');

        $obTgUser = TgUser::query()->where('phone', $phone)->firstOrNew();

        $arUser = $tg->getSelf();

        $obTgUser->fill([
            'phone' => (int) session()->get('current_telegram_phone'),
            'user_id' => (int) auth()->user()->id,
            'tg_id' => (int) $arUser['id'],
            'name' => $arUser['username'],
        ]);

        $photoInfo = $tg->getPropicInfo($obTgUser->tg_id);
        $path = Telegram::path($phone, 'avatar.jpg');
        $photoInfo->downloadToFile($path);
        $obTgUser->clearMediaCollection('tg_avatars');
        $obTgUser->addMedia($path)->toMediaCollection('tg_avatars');

        $obTgUser->save();
    }
}
