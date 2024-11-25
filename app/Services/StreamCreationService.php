<?php namespace App\Services;

use App\Enums\AutoRepeatInterval;
use App\Enums\StreamType;
use App\Models\Social\AbstractAuthModel;
use App\Models\Stream;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StreamCreationService
{
    public User $user;

    public AbstractAuthModel $obAccount;
    public bool $start_immediately = true;

    public array $data = [];
    public function __construct (
        public Request $request,
        public StreamType $type
    )
    {
        $this->user = auth()->user();
    }
    public static function create(Request $request, StreamType $type)
    {
        $obService = new self($request, $type);
        $obService->setDefaultValues();
        match ($type) {
            StreamType::VKPage => $obService->createVKPage($request),
            StreamType::VKStories => $obService->createVKStories($request),
            StreamType::VKGroup => $obService->createVKGroup($request),
            StreamType::YouTube => throw new \Exception('To be implemented'),
            StreamType::Telegram => throw new \Exception('To be implemented'),
        };
        return $obService->createStream();
    }

    public function createStream() : ?Stream
    {
        $obStream = $this->obAccount->streams()->create($this->data);;
        if ($obStream) return $obStream;
        return null;
    }

    private function createVKPage(): void
    {
        $obAccount = $this->user->vk_user()->where('id', $this->request->account_id)->first();

        $this->data['video_id'] = $this->request->video_id;

        $this->obAccount = $obAccount;
    }

    public function createVKStories(): void
    {
        $obAccount = $this->user->vk_user()->where('id', $this->request->account_id)->first();
        $this->data['story_id'] = $this->request->video_id;
        $this->data['options'] = $this->request->options ?? [];

        $this->obAccount = $obAccount;
    }

    private function createVKGroup(Request $request)
    {
        $obAccount = $this->user->vk_groups()->where('id', $this->request->account_id)->first();

        $this->data['video_id'] = $this->request->video_id;

        $this->obAccount = $obAccount;
    }

    public function setDefaultValues(): void
    {
        $this->request->validate(
            rules: [
                'title' => ['required', 'min:3', 'max:50'],
            ],
            attributes: [
                'title' => 'Название',
            ]
        );

        $this->start_immediately = $this->request->start_immediately ?? false;
        $this->data = [
            'user_id' => (int) $this->user->id,
            'title' => (string) $this->request->title,
            'type' => $this->type,
            'is_active' => true,
            'description' => (string) ($this->request->description ?? null),
            'repeat_interval' => AutoRepeatInterval::from($this->request->repeat_interval ?? AutoRepeatInterval::HOUR->value),
            'start_at' => $this->start_immediately
                ? Carbon::now()
                : Carbon::parse($this->request->start_at),
        ];
    }
}
