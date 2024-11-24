<?php namespace App\Models;

use App\Enums\StreamType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{

    protected $casts = [
        'type' => StreamType::class,
        'auto_renew' => 'boolean',
        'start_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->type = $model->pricing_plan->type;
            $model->auto_renew = true;
            $model->start_at = now();
            $model->ends_at = now()->addMonth();
        });
    }

    public function pricing_plan() : BelongsTo
    {
        return $this->belongsTo(PricingPlan::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPercentageAttribute(): float|int
    {
        return $this->start_at && $this->ends_at
            ? round(Carbon::now()->diffInDays($this->ends_at) * 100 / $this->start_at->diffInDays($this->ends_at))
            : 0;
    }
}
