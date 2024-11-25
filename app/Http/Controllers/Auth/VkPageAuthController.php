<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StreamType;
use App\Http\Controllers\Controller;
use App\Models\Social\VkUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use VK\Client\VKApiClient;

class VkPageAuthController extends Controller
{
    public $client_id;

    public VKApiClient $vk;

    public function __construct()
    {
        $this->client_id = env('VK_APP_ID');
        $this->vk = new VKApiClient;
    }

    public function redirect(Request $request, StreamType $type = null)
    {
        if ($type) {
            $request->session()->put('back_type', $type);
        }
        $request->session()->put('state', $state = Str::random(40));

        $request->session()->put('code_verifier', $code_verifier = Str::random(128));

        $codeChallenge = strtr(rtrim(base64_encode(hash('sha256', $code_verifier, true)), '='), '+/', '-_');

        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => env('VK_APP_ID'),
            'redirect_uri' => env('VK_APP_REDIRECT'),
            'scope' => 'email phone wall notify friends video stories groups notifications phone_number',
            'state' => $state,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            'prompt' => 'consent',
        ]);

        $baseUrl = 'https://id.vk.com/authorize';

        return redirect($baseUrl.'?'.$query);
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

        $codeVerifier = $request->session()->pull('code_verifier');

        $request->session()->put('device_id', $device_id = $request->device_id);

        $data = $this->post('https://id.vk.com/oauth2/auth', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'code_verifier' => $codeVerifier,
            'client_id' => env('VK_APP_ID'),
            'device_id' => $device_id,
            'redirect_uri' => env('VK_APP_REDIRECT'),
            'state' => $state,
        ]);

        $obVkUser = VkUser::firstOrNew(['vk_id' => $data->user_id]);
        $obVkUser->fill([
            'user_id' => auth()->user()->id,
            'refresh_token' => $data->refresh_token,
            'access_token' => $data->access_token,
            'id_token' => $data->id_token,
            'expires_at' => Carbon::now()->addSeconds($data->expires_in),
            'device_id' => $device_id,
            'is_active' => true,
        ])->save();

        $this->fillUserData($obVkUser, $data->access_token);


        $backType = $request->session()->pull('back_type', StreamType::VKPage);
        if ($backType) {
            $obVkUser->attach($backType);
            return redirect(route('stream.index', $backType));
        }

        return redirect(route('dashboard'));
    }

    public function fillUserData(VkUser $obVkUser, $access_token)
    {
        $userData = $this->post('https://id.vk.com/oauth2/user_info', [
            'access_token' => $access_token,
            'client_id' => env('VK_APP_ID'),
        ])->user;

        $obVkUser->fill([
            'full_name' => $userData->first_name.' '.$userData->last_name,
            'first_name' => $userData->first_name,
            'last_name' => $userData->last_name,
            'email' => $userData->email,
            'phone' => $userData->phone,
            'avatar_url' => $userData->avatar,
        ])->save();
    }

    public function post(string $url, array $params = [])
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($params),
            ],
        ]);
        try {
            $result = file_get_contents($url, false, $context);

            return json_decode($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
