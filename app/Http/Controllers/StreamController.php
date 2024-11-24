<?php

namespace App\Http\Controllers;

use App\Enums\StreamType;
use App\Http\Resources\VideoResource;
use App\Http\Resources\VkUserResource;
use App\Models\Stream;
use App\Models\User;
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

        ['view' => $view, 'data' => $data] = match ($type) {
            StreamType::VKPage => ['view' => 'Stream/VKPage', 'data' => $this->indexVKPage()],
            StreamType::VKStories => ['view' => 'Stream/VKStories', 'data' => $this->indexVKStories()],
            StreamType::VKGroup => throw new \Exception('To be implemented'),
            StreamType::YouTube => throw new \Exception('To be implemented'),
            StreamType::Telegram => throw new \Exception('To be implemented'),
        };
        $data['videoCount'] = $type->isStory() ? $this->user->stories()->count() : $this->user->videos()->count();
        $data['type'] = $type;
        $data['accounts'] = $this->account($type)->withStreams($type)->get();

        return Inertia::render($view, $data);
    }

    public function account(StreamType $type, int $account_id = null)
    {
        $accounts = match ($type) {
            StreamType::VKPage, StreamType::VKStories => auth()->user()->vk_user(),
            StreamType::VKGroup => throw new \Exception('To be implemented'),
            StreamType::YouTube => throw new \Exception('To be implemented'),
            StreamType::Telegram => throw new \Exception('To be implemented'),
        };
        if ($account_id) {
            return $accounts->where('id', $account_id)->first();
        }
        return $accounts;
    }

    private function indexVKPage()
    {
//        dd($this->user->vk_user()->withStreams(StreamType::VKPage)->get());
        return [
//            'accounts' => $this->user->vk_user()->withStreams(StreamType::VKPage)->get(),
//            'videoCount' => $this->user->videos()->count(),
        ];
    }

    public function indexVKStories()
    {
        return [
//            'accounts' => $this->user->vk_user()->with('streams.story')->get(),
//            'videoCount' => $this->user->stories()->count(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, StreamType $type, int $account_id)
    {
        $obAccount = $this->account($type, $account_id);
        return Inertia::render('Stream/Create', [
            'account' => $obAccount,
            'type' => $type,
            'videos' => fn() => $type->isStory() ? auth()->user()->stories()->get() : auth()->user()->videos()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StreamType $type)
    {
        $obStream = StreamCreationService::create($request, $type);
        if (!$obStream instanceof Stream) {
            return back()->flashError('Произошла ошибка');
        }
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
        $obStream = Stream::find($id);
        $obStream->delete();
        return back()->flashSuccess('Трансляция удалена');
    }

    public function attachAccount(Request $request, StreamType $type)
    {
        $obAccount = $this->findAccount($type);

        $success = $obAccount->attach($type);
        if ($success) {
            return back()->flashSuccess('Аккаунт привязан');
        }
        return back()->flashError('Произошла ошибка');
    }

    public function detachAccount(Request $request, StreamType $type)
    {
        $obAccount = $this->findAccount($type);

        $success = $obAccount->detach($type);
        if ($success) {
            return back()->flashSuccess('Аккаунт отвязан');
        }
        return back()->flashError('Произошла ошибка');
    }

    public function findAccount($type)
    {
        $accounts = match ($type) {
            StreamType::VKPage, StreamType::VKStories => auth()->user()->vk_user(),
            StreamType::VKGroup => throw new \Exception('To be implemented'),
            StreamType::YouTube => throw new \Exception('To be implemented'),
            StreamType::Telegram => throw new \Exception('To be implemented'),
        };
        $obAccount = $accounts->where('id', \request()->account_id)->first();
        if (!$obAccount) {
            throw new \Exception('Аккаунт не найден');
        }
        return $obAccount;
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
        return back()->flashSuccess('Трансляция остановлена');
    }


}
