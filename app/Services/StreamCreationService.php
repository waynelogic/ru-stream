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
    public static function create(Request $request, StreamType $type)
    {
        $request->validate(
            rules: [
                'title' => ['required', 'min:3', 'max:50'],
            ],
            attributes: [
                'title' => 'Название',
            ]
        );
        $obUser = auth()->user();
        $obAccount = AccountManager::account($type, $request->account_id, $obUser);

        $start_immediately = $request->start_immediately ?? false;
        $data = [
            'user_id' => (int) $obUser->id,
            'title' => (string) $request->title,
            'options' => $request->options ?? [],
            'type' => $type,
            'is_active' => true,
            'description' => (string) ($request->description ?? null),
            'repeat_interval' => AutoRepeatInterval::from($request->repeat_interval ?? AutoRepeatInterval::HOUR->value),
            'start_at' => $start_immediately
                ? Carbon::now()
                : Carbon::parse($request->start_at),
        ];
        if ($type->isStory()) {
            $data['story_id'] = $request->video_id;
        } else {
            $data['video_id'] = $request->video_id;
        }
        $obStream = $obAccount->streams()->create($data);;

        return $obStream;
    }
}
