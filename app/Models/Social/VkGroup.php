<?php

namespace App\Models\Social;

use App\Enums\StreamType;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiAccessVideoException;
use VK\Exceptions\Api\VKApiWallAddPostException;
use VK\Exceptions\Api\VKApiWallAdsPublishedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class VkGroup extends AbstractAuthModel
{
    public function getClient() : VKApiClient
    {
        return new VKApiClient();
    }

    /**
     * @throws VKApiAccessVideoException
     * @throws VKApiWallAdsPublishedException
     * @throws VKApiException
     * @throws VKClientException
     * @throws VKApiWallAddPostException
     */
    public function startStream(Stream $stream): bool
    {
        if (isset($stream->payload->video_id)) {
            $this->removeVideo($stream);
        }

        $response = $this->getClient()->video()->startStreaming($this->getAccessToken(), [
            'name' => $stream->title,
            'description' => $stream->public_description,
            'wallpost' => 1,
            'publish' => 1,
            'group_id' => $this->vk_id
        ]);

        if (isset($response['post_id'])) {
            $stream->payload = $response;
            $stream->rtmp_url = $response['stream']['url'];
            $stream->rtmp_key = $response['stream']['key'];
            $stream->save();
            return true;
        }
        return false;
    }

    /**
     * @throws VKApiException
     * @throws VKClientException
     */
    public function removeVideo(Stream $stream)
    {
        $this->getClient()->video()->delete($this->getAccessToken(), [
            'video_id' => $stream->payload->video_id,
            'owner_id' => $stream->payload->owner_id,
        ]);
        $stream->payload = null;
    }

    /**
     * @throws VKApiException
     * @throws VKClientException
     */
    public function stopStream(Stream $stream): bool
    {
        $stop = $this->getClient()->video()->stopStreaming($this->getAccessToken(), [
            'video_id' => $stream->payload->video_id,
            'group_id' => $this->vk_id
        ]);
        if (!isset($stop['unique_viewers'])) return false;

        $response = $this->getClient()->video()->get($this->getAccessToken(), [
            'owner_id' => $stream->payload->owner_id,
            'videos' => $stream->payload->owner_id . '_' . $stream->payload->video_id,
            'count' => 1
        ]);

        if (!isset($response['items'][0])) return false;

        $vkVideo = $response['items'][0];

        $stream->addStat('comments', (int) $vkVideo['comments']);
        $stream->addStat('reposts', (int) $vkVideo['reposts']['count']);
        $stream->addStat('likes', (int) $vkVideo['likes']['count']);
        $stream->addStat('views', (int) $vkVideo['views']);
        $stream->payload = null;
        $stream->save();

        return true;
    }

    public function getAccessToken() : string
    {
        return $this->vk_user->getAccessToken();
    }


    public function vk_user() : BelongsTo
    {
        return $this->belongsTo(VkUser::class, 'vk_user_id');
    }

    public function scopeWithStreams($builder, StreamType $type)
    {
        return $builder->with('streams.video');
    }

    public function getViewNameAttribute(): string
    {
        return $this->name;
    }

    public function getViewAvatarAttribute(): string
    {
        return $this->avatar_url;
    }
}
