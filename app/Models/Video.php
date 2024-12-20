<?php namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class Video extends FileModel
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $appends = ['video_url', 'poster_url'];
    protected $casts = [
        'duration' => 'float',
    ];

    public function videoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('videos')
        );
    }

    public function posterUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('posters')
        );
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function streams() : HasMany
    {
        return $this->hasMany(Stream::class);
    }

    public function generatePoster(): void
    {
        try {
            // Получаем видеофайл из коллекции 'videos'
            $obVideoFile = $this->getFirstMedia('videos');
            $media = FFMpeg::fromDisk('public')->open($obVideoFile->getPathRelativeToRoot());

            // Устанавливаем длительность и сохраняем её в базе данных
            $this->duration = $media->getDurationInSeconds();

            // Генерируем постер
            $frameTimeInSeconds = 10; // Момент кадра в секундах

            $posterName = 'video_poster_' . $this->id . '.jpg';
            $media->getFrameFromSeconds($frameTimeInSeconds)->export()->save($posterName);
            $this->addMediaFromDisk($posterName, 'public')->toMediaCollection('posters');
            $this->save();
        } catch (\Exception $e) {
            Log::error('Не удалось создать постер для видео с ID '.$this->id.': '.$e->getMessage());
        }
    }
}
