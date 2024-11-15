<?php

namespace Waynelogic\FilamentCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SettingModel extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    public $timestamps = false;
    protected $casts = [
        'value' => 'array',
    ];

    protected $expandoColumn = 'value';

    protected $fillable = [
        'key',
        'value',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->code = $this->settingsCode;
    }

    public static function instance()
    {
        $model = new static;

        $item = $model->getSettingsRecord();

        if (!$item) {
            $model->initSettingsData();
            $item = $model;
        }

        return $item;
    }

    public static function get($key, $default = null)
    {
        return static::instance()->{$key} ?? $default;
    }

    public static function set($key, $value = null)
    {
        $data = is_array($key) ? $key : [$key => $value];

        $obj = static::instance();

        $obj->forceFill($data);

        return $obj->save();
    }

    private function getSettingsRecord()
    {
        return static::query()->where('code', $this->settingsCode)->first();
    }

    private function initSettingsData()
    {
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $attributes = $model->getAttributes();

            $filteredAttributes = Arr::except($attributes, ['code', 'value', 'created_at', 'updated_at', 'id']);

            $model->value = json_encode($filteredAttributes);

            foreach ($filteredAttributes as $key => $value) {
                unset($model->$key);
            }
        });

        static::retrieved( function ($model) {
            $attributes = json_decode($model->value, true);

            if (is_array($attributes)) {
                foreach ($attributes as $key => $value) {
                    $model->setAttribute($key, $value);
                }
            }
        });
    }

    public function getCacheKey()
    {
        return 'system::setting.' . $this->settingsCode;
    }

}
