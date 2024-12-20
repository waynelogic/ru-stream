<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use SoftDeletes;

    protected $casts = [
        'price' => 'decimal:2',
        'max_usage' => 'integer',
        'locked' => 'boolean',
    ];

    public function users() : BelongsToMany
    {
        return $this
            ->belongsToMany(User::class)
            ->withTimestamps();
    }


    public function updateAvailability(): void
    {
        if ($this->users()->count() >= $this->max_usage) {
            $this->locked = true;
            $this->save();
        }
    }
}
