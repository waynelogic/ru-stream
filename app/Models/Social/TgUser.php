<?php namespace App\Models\Social;

use App\Enums\StreamType;
use App\Services\Telegram;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TgUser extends AbstractAuthModel implements HasMedia
{
    use InteractsWithMedia;

    protected $casts = [
        'phone' => 'integer'
    ];

    public function scopeWithStreams($builder, StreamType $type)
    {
        return $builder->with(['streams' => function ($query) use ($type) {
            $query->where('type', $type)->with($type->isStory() ? 'story' : 'video');
        }]);
    }

    public function getApiChatsAttribute() : array
    {
        $obTg = Telegram::make($this->phone);

        $arChatList = [];

        $chats = $obTg->channels->getAdminedPublicChannels()['chats'];

        foreach ($chats as $chat) {
            $arChatList[] = [
                'id' => $chat['id'],
                'title' => $chat['title'],
                'username' => $chat['username'],
            ];
        }

        return $arChatList;
    }

    public function getViewNameAttribute(): string
    {
        return $this->name;
    }

    public function getViewAvatarAttribute(): string
    {
        return $this->getFirstMediaUrl('tg_avatars');
    }
}
