<?php

namespace App\Models\Social;

use App\Enums\StreamType;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class VkGroup extends AbstractAuthModel
{
    public function getClient() : VKApiClient
    {
        return new VKApiClient();
    }

    public function startStream(Stream $stream): bool
    {
        return true;
//        if (isset($stream->payload->video_id)) {
//            $this->removeVideo($stream);
//        }
//
//        $response = $this->getClient()->video()->startStreaming($this->getAccessToken(), [
//            'name' => $stream->title,
//            'description' => $stream->public_description,
//            'wallpost' => 1,
//            'publish' => 1
//        ]);
//
//        if (isset($response['post_id'])) {
//            $stream->payload = $response;
//            $stream->rtmp_url = $response['stream']['url'];
//            $stream->rtmp_key = $response['stream']['key'];
//            $stream->save();
//            return true;
//        }
//        return false;
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
        return true;

        $stop = $this->getClient()->video()->stopStreaming($this->getAccessToken(), [
            'video_id' => $stream->payload->video_id,
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

    public function publishStory(Stream $stream) : bool
    {
        if (isset($stream->payload)) {
            $this->removeStory($stream);
        }

        $videoFilePath = $stream->story->getFirstMedia('stories')->getPath();

        $options = $stream->options;
        // Получеем адрес
        $address = $this->getClient()->stories()->getVideoUploadServer($this->getAccessToken(), [
            'add_to_news' => 1,
            'link_text' => $options['link_text'] ?? '',
            'link_url' => $options['link_url'] ?? '',
        ]);

        // Загружаем видео
        $uploadResponse = $this->getClient()->getRequest()->upload($address['upload_url'], 'video_file', $videoFilePath);

        $result = $this->getClient()->stories()->save($this->getAccessToken(), [
            'upload_results' => $uploadResponse['upload_result'],
        ]);
        if (!isset($result['items'][0])) {
            return false;
        };
        $obItem = $result['items'][0];
        $stream->payload = $obItem;

        Log::info($result);

        return true;
    }

    public function removeStory(Stream $stream)
    {
        $response = $this->getClient()->stories()->getStats($this->getAccessToken(), [
            'owner_id' => $stream->payload->owner_id,
            'story_id' => $stream->payload->id,
        ]);
        if (!isset($response['views'])) {
            return false;
        }
        $stream->addStat('views', (int) $response['views']['count']);
        $stream->addStat('reposts', (int) $response['shares']['count']);
        $stream->addStat('likes', (int) $response['likes']['count']);
        $stream->addStat('comments', (int) $response['replies']['count']);

        $response = $this->getClient()->stories()->delete($this->getAccessToken(), [
            'owner_id' => $stream->payload->owner_id,
            'story_id' => $stream->payload->id,
        ]);
        if (!$response) {
            return false;
        }
        $stream->payload = null;
        $stream->save();

        return true;
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
