<?php

namespace App\Http\Controllers\Auth;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Http\Request;

class TelegramAuthController
{
    public $MadelineProto;

    public function __construct()
    {
        $settings = (new AppInfo)
            ->setApiId(config('madeline-proto.api_id'))
            ->setApiHash(config('madeline-proto.api_hash'));

        $this->MadelineProto = new API('session.madeline', $settings);
        //        $this->MadelineProto->start();
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
        $this->MadelineProto->phoneLogin($phoneNumber);

        return back()->flashSuccess('Phone number sent');
    }

    public function completePhoneLogin($request)
    {
        $request->validate([
            'code' => 'required',
        ]);
        $code = $request->input('code');
        if (! mb_check_encoding($code, 'UTF-8')) {
            $code = mb_convert_encoding($code, 'UTF-8', 'auto');
        }
        $authorization = $this->MadelineProto->completePhoneLogin($code);
        dd($authorization);

        if (isset($authorization['_']) && $authorization['_'] === 'account.password') {
            return response()->json(['status' => '2FA required', 'hint' => $authorization['hint']]);
        } elseif (isset($authorization['_']) && $authorization['_'] === 'account.needSignup') {
            return response()->json(['status' => 'Signup required']);
        }
    }
}
