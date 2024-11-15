<?php namespace App\Concerns;

use App\Models\Social\VkUser;
use App\Models\Story;
use App\Models\Video;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Client
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function videos() : HasMany
    {
        return $this->hasMany(Video::class);
    }
    public function stories() : HasMany
    {
        return $this->hasMany(Story::class);
    }
    public function vk_user(): HasMany
    {
        return $this->hasMany(VkUser::class);
    }
}
