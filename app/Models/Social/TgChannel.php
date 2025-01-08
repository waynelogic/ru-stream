<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TgChannel extends AbstractAuthModel implements HasMedia
{
    use InteractsWithMedia;


    public function tg_user() : BelongsTo
    {
        return $this->belongsTo(TgUser::class);
    }

    public function getViewNameAttribute(): string
    {
        return $this->name;
    }

    public function getViewAvatarAttribute(): string
    {
        return $this->getFirstMediaUrl('tg_channel_avatar');
    }
}
