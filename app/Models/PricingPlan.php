<?php namespace App\Models;

use App\Enums\StreamType;

class PricingPlan extends Model
{
    protected $casts = [
        'type' => StreamType::class,
        'monthly_price' => 'float',
        'max_accounts_count' => 'integer',
        'max_streams_count' => 'integer',
        'active' => 'boolean',
        'labels' => 'json',
        'most_popular' => 'boolean',
    ];
}
