<?php namespace App\Models\Social;

use App\Enums\StreamType;

class TgUser extends AbstractAuthModel
{

    public function scopeWithStreams($builder, StreamType $type)
    {
        return $builder->with(['streams' => function ($query) use ($type) {
            $query->where('type', $type)->with($type->isStory() ? 'story' : 'video');
        }]);
    }

    public function getViewNameAttribute(): string
    {
        // TODO: Implement getViewNameAttribute() method.
    }

    public function getViewAvatarAttribute(): string
    {
        // TODO: Implement getViewAvatarAttribute() method.
    }
}
