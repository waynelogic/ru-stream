<?php namespace App\Models\Social;

use App\Enums\StreamType;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use VK\Client\VKApiClient;
use GuzzleHttp\Client;
use VK\Exceptions\Api\VKApiAccessVideoException;
use VK\Exceptions\Api\VKApiWallAddPostException;
use VK\Exceptions\Api\VKApiWallAdsPublishedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class VkUser extends AbstractAuthModel
{
    public function play(Stream $stream) : bool
    {
        if ($stream->is_story) {
            if (isset($stream->payload)) {
                $this->storySetStats($stream);
                $this->storyRemove($stream);
            }
            return $this->storyPublish($stream);
        } else {
            if (isset($stream->payload->video_id)) {
                $this->removeVideo($stream);
            }
            return $this->startStream($stream);
        }
    }

    public function stop(Stream $stream) : bool
    {
        if ($stream->is_story) {
            return true;
        } else {
            return $this->stopStream($stream);
        }
    }

    public function remove(Stream $stream)
    {
        if ($stream->is_story) {
            if (isset($stream->payload)) {
                $this->storySetStats($stream);
                $this->storyRemove($stream);
            }
            return true;
        } else {
            if (isset($stream->payload->video_id)) {
                return $this->removeVideo($stream);
            }
            return true;
        }
    }


    public function getClient() : VKApiClient
    {
        return new VKApiClient();
    }
    /*
     * Story
     */
    public function storyPublish(Stream $stream) : bool
    {
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

    public function storyRemove(Stream $stream): bool
    {
        $response = $this->getClient()->stories()->delete($this->getAccessToken(), [
            'owner_id' => $stream->payload->owner_id,
            'story_id' => $stream->payload->id,
        ]);
        if (!$response) return false;
        $stream->payload = null;
        $stream->save();

        return true;
    }

    public function storySetStats(Stream $stream): bool
    {
        $response = $this->getClient()->stories()->getStats($this->getAccessToken(), [
            'owner_id' => $stream->payload->owner_id,
            'story_id' => $stream->payload->id,
        ]);

        if (!isset($response['views'])) return false;

        $stats = [
            'views' => 'views',
            'reposts' => 'shares',
            'likes' => 'likes',
            'comments' => 'replies'
        ];

        foreach ($stats as $stat => $key) {
            $stream->addStat($stat, (int) ($response[$key]['count'] ?? 0));
        }

        $stream->save();

        return true;
    }

    /*
     * Stream
     */
    public function startStream(Stream $stream): bool
    {
        $response = $this->getClient()->video()->startStreaming($this->getAccessToken(), [
            'name' => $stream->title,
            'description' => $stream->public_description,
            'wallpost' => 1,
            'publish' => 1
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
    public function removeVideo(Stream $stream) : bool
    {
        $this->getClient()->video()->delete($this->getAccessToken(), [
            'video_id' => $stream->payload->video_id,
            'owner_id' => $stream->payload->owner_id,
        ]);
        $stream->payload = null;
        $stream->save();
        return true;
    }

    public function stopStream(Stream $stream): bool
    {
        // Останавливаем стрим
        $stop = $this->getClient()->video()->stopStreaming($this->getAccessToken(), [
            'video_id' => $stream->payload->video_id,
        ]);
        if (!isset($stop['unique_viewers'])) return false;

        // Собираем статистику
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
        $stream->save();

        return true;
    }



    public function getAccessToken()
    {
        if ($this->access_token && $this->expires_at > now()) return $this->access_token;

        session()->put('state', $state = Str::random(40));

        $response = $this->post('https://id.vk.com/oauth2/auth', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refresh_token,
            'client_id' => env('VK_APP_ID'),
            'device_id' => $this->device_id,
            'state' => $state,
        ]);

        $this->access_token = $response->access_token;
        $this->refresh_token = $response->refresh_token;
        $this->expires_at = now()->addSeconds($response->expires_in);
        $this->save();

        return $this->access_token;
    }

    public function post(string $url, array $params = [])
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($params),
            ],
        ]);
        try {
            $result = file_get_contents($url, false, $context);

            return json_decode($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function apiGroups() : Attribute
    {
        return Attribute::make(
            get: function () {
                $response = $this->getClient()->groups()->get($this->getAccessToken(), [
                    'user_id' => $this->vk_id,
                    'filter' => 'admin',
                    'extended' => 1,
                ]);
                return $response['items'];
            },
        );
    }
    public function apiGroupById($id)
    {
        return $this->getClient()->groups()->getById($this->getAccessToken(), [
            'group_id' => $id,
        ])[0];
    }

    public function scopeWithStreams($builder, StreamType $type)
    {
        return $builder->with(['streams' => function ($query) use ($type) {
            $query->where('type', $type)->with($type->isStory() ? 'story' : 'video');
        }]);
    }
    public function getViewNameAttribute(): string
    {
        return $this->full_name;
    }

    public function getViewAvatarAttribute(): string
    {
        return $this->avatar_url;
    }
}
