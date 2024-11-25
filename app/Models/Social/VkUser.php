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


    public function getAccessToken()
    {
        if ($this->access_token && $this->expires_at > now()) return $this->access_token;

        request()->session()->put('state', $state = Str::random(40));

        $client = new Client(['http_errors' => false]);
        $response = $client->post('https://id.vk.com/oauth2/auth', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->refresh_token,
                'client_id' => env('VK_APP_ID'),
                'device_id' => $this->device_id,
                'state' => $state,
            ]
        ]);

        $response = json_decode($response->getBody());
        $this->access_token = $response->access_token;
        $this->refresh_token = $response->refresh_token;
        $this->expires_at = now()->addSeconds($response->expires_in);
        $this->save();

        return $this->access_token;
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
}
