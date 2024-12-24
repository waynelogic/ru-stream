<?php

namespace App\Http\Controllers;

use App\Enums\StreamType;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\VkUserResource;
use App\Models\Stream;
use App\Models\User;
use App\Services\AccountManager;
use App\Services\StreamCreationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StreamController extends Controller
{
    public User $user;

    /**
     * Display a listing of the resource.
     */
    public function index(StreamType $type)
    {
        $this->user = auth()->user();

        $subscription = $this->user->subscriptions()->where('type', $type->value)->first();
        ['view' => $view, 'data' => $data] = match ($type) {
            StreamType::VKPage => ['view' => 'Stream/VKPage', 'data' => []],
            StreamType::VKStories => ['view' => 'Stream/VKStories', 'data' => []],
            StreamType::VKGroup => ['view' => 'Stream/VKGroup', 'data' => $this->indexVKGroup()],
            StreamType::Telegram => ['view' => 'Stream/TelegramGroup', 'data' => []],
        };
        $data['videoCount'] = $type->isStory() ? $this->user->stories()->count() : $this->user->videos()->count();
        $data['type'] = $type;
        $data['accounts'] = AccountManager::accounts($type, $this->user)->withStreams($type)->get();
        $data['subscription'] = $subscription ? new SubscriptionResource($subscription) : null;

        return Inertia::render($view, $data);
    }

    private function indexVKGroup()
    {
        return [
            'vkAccounts' => Inertia::lazy(fn () => $this->user->vk_user()->get()->append('api_groups')),
        ];
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, StreamType $type, int $account_id)
    {
        $user = auth()->user();
        $obAccount = AccountManager::account($type, $account_id, $user);
        return Inertia::render('Stream/Create', [
            'account' => $obAccount,
            'type' => $type,
            'videos' => fn() => $type->isStory() ? $user->stories()->get() : $user->videos()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StreamType $type)
    {
        $obStream = StreamCreationService::create($request, $type);
        if (!$obStream instanceof Stream)  return back()->flashError('Произошла ошибка');

        if (!$request->start_immediately) {
            return redirect()->route('streams.index', $type)->flashSuccess('Трансляция создана');
        }

        $obStream->play();
        return redirect()->route('streams.index', $type)->flashSuccess('Трансляция запущена');
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
    public function destroy(int $id)
    {
        $user = auth()->user();
        $obStream = Stream::find($id);
        if ($obStream->user_id !== $user->id) {
            return back()->flashError('Трансляция принадлежит другому пользователю');
        }
        $obStream->delete();
        return back()->flashSuccess('Трансляция удалена');
    }

    public function attachAccount(Request $request, StreamType $type)
    {
        $obAccount = AccountManager::account($type, $request->account_id);

        $success = $obAccount->attach($type);
        if ($success) {
            return back()->flashSuccess('Аккаунт привязан');
        }
        return back()->flashError('Произошла ошибка');
    }

    public function detachAccount(Request $request, StreamType $type)
    {
        $obAccount = AccountManager::account($type, $request->account_id);

        $success = $obAccount->detach($type);
        if ($success) {
            return back()->flashSuccess('Аккаунт отвязан');
        }
        return back()->flashError('Произошла ошибка');
    }


    protected function findAndValidateStream(int $stream_id, bool $shouldBeActive)
    {
        $stream = Stream::find($stream_id);

        if (!$stream) return 'Трансляция не найдена';

        if ($stream->user_id !== auth()->id()) return 'Трансляция принадлежит другому пользователю';

        if ($stream->is_active !== $shouldBeActive) {
            return 'Трансляция уже ' . ($shouldBeActive ? 'запущена' : 'остановлена');
        }

        return $stream;
    }

    public function play(int $id)
    {
        $result = $this->findAndValidateStream($id, false);
        if (is_string($result)) return back()->flashError($result);
        $result->is_active = true;
        $result->save();
        return back()->flashSuccess('Трансляция запущена');
    }

    public function stop(int $id)
    {
        $result = $this->findAndValidateStream($id, true);
        if (is_string($result)) return back()->flashError($result);
        $result->is_active = false;
        $result->save();
        if ($result->is_online) {
            $result->stop();
        }
        return back()->flashSuccess('Трансляция остановлена');
    }
}
