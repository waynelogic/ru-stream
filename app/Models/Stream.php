<?php

namespace App\Models;

use App\Enums\AutoRepeatInterval;
use App\Enums\StreamType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Log;

class Stream extends Model
{
    protected $appends = ['is_story'];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
        'type' => StreamType::class,
        'repeat_interval' => AutoRepeatInterval::class,
        'start_at' => 'datetime',
        'expires_at' => 'datetime',
        'next_at' => 'datetime',
        'options' => 'json',
        'payload' => 'object',
        'stats' => 'object'
    ];

    protected static function booted(): void
    {
        parent::booted();

        static::deleting(function (Stream $stream) {
            $stream->remove();
        });
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsStoryAttribute() : bool
    {
        return $this->type->isStory();
    }

    public function getPublicDescriptionAttribute(): string
    {
        $text = '';
        if ($this->description) {
            $text = $this->description . "\n";
        }
        $text .= 'Трансляция создана с помощью сервиса RU:STREAM: ' . $this->user->referral_link;
        return $text;
    }

    public function play(): bool
    {
        if (!$this->is_active) return false;

        $obStreamable = $this->streamable;
        $result = $obStreamable->play($this);

        if (!$result) return false;

        // Устанавливаем время истечения
        $this->expires_at = now()->addSeconds(
            $this->is_story ? $this->story->duration : $this->video->duration + 10
        );

        // Если это не story, запускаем RTMP
        if (!$this->is_story && !$this->startRtmp()) {
            return false;
        }

        // Устанавливаем следующее время повторения
        $this->is_online = true;
        $this->next_at = $this->expires_at->copy()->addMinutes($this->repeat_interval->value);
        $this->play_count++;
        $this->save();

        Log::info('Stream - ' . $this->id . ' started');

        return true;
    }

    public function stop()
    {
        $obStreamable = $this->streamable;
        $result = $obStreamable->stop($this);

        if ($result) {
            $this->is_online = false;
            $this->save();
            Log::info('Stream - ' . $this->id . ' stopped');
        }

        return $result;
    }

    public function remove()
    {
        return $this->streamable->remove($this);
    }


    // RTMP
    public function startRtmp() : bool
    {
        // Устанавливаем параметры RTMP
        $inputPath = $this->video->getMedia('videos')->first()->getPath();
        $outputUrl = $this->rtmp_url . $this->rtmp_key;

        // Экранируем параметры RTMP
        $escapedInputPath = escapeshellarg($inputPath);
        $escapedOutputUrl = escapeshellarg($outputUrl);

        $command = "ffmpeg -re -i {$escapedInputPath} -b:v 4000k -f flv {$escapedOutputUrl}";

        $process = proc_open($command, [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"],
        ], $pipes);

        $this->pid = proc_get_status($process)['pid'];

        return true;
    }
    public function stopRtmp(): bool
    {
        return true;
    }
    public function isRtmpRunning()
    {

    }

    public function video() : BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    // Relations
    public function story() : BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function streamable() : MorphTo
    {
        return $this->morphTo();
    }

    public function addStat(string $key, int $value, bool $add = true): void
    {
        $stats = $this->stats ?? new \stdClass();
        $stats->$key = $add ? ($stats->$key ?? 0) + $value : $value;
        $this->stats = $stats;
    }
}
