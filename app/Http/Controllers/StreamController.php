<?php

namespace App\Http\Controllers;

use App\Enums\StreamType;
use App\Http\Resources\VkUserResource;
use App\Models\User;
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
        $data['type'] = $type;

        return Inertia::render($view, $data);
    }

    private function indexVKPage()
    {
        return [
            'accounts' => VkUserResource::collection($this->user->vk_user()->get()),
            'videoCount' => $this->user->videos()->count(),
        ];
    }

    public function indexVKStories()
    {
        return [
            'accounts' => VkUserResource::collection($this->user->vk_user()->get()),
            'videoCount' => $this->user->stories()->count(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, StreamType $type, int $account_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
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

}
