<?php namespace Waynelogic\FilamentCms\Database\Traits;

use Illuminate\Database\Eloquent\Model;

trait Defaultable
{
    public static function bootDefaultable()
    {
        static::saving(function (Model $model) {
            if ($model->default) {
                static::where('id', '!=', $model->id)->update(['is_default' => false]);
            }
        });
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public static function getDefault()
    {
        return static::default()->first();
    }
}
