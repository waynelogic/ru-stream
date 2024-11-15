<?php namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class Video extends FileModel
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function generatePoster(): void
    {
        try {
            // Получаем видеофайл из коллекции 'videos'
            $obVideoFile = $this->getFirstMedia('videos');
            $media = FFMpeg::fromDisk('public')->open($obVideoFile->getPathRelativeToRoot());

            // Устанавливаем длительность и сохраняем её в базе данных
            $this->duration = $media->getDurationInMiliseconds();
            $this->save();

            // Генерируем постер
            $frameTimeInSeconds = 10; // Момент кадра в секундах
            $posterName = 'video_poster'.$this->id.'.jpg';
            $tempPath = storage_path('app/public/'.$posterName);

            $media->getFrameFromSeconds($frameTimeInSeconds)->export()->save($tempPath);

            // Добавляем изображение в коллекцию 'posters' и удаляем временный файл
            $this->addMedia($tempPath)->toMediaCollection('posters');
            unlink($tempPath);

        } catch (\Exception $e) {
            Log::error('Не удалось создать постер для видео с ID '.$this->id.': '.$e->getMessage());
        }
    }
}
