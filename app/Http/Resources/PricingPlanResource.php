<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PricingPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'max_accounts_count' => $this->max_accounts_count,
            'max_streams_count' => $this->max_streams_count,
            'most_popular' => $this->most_popular,
            'price' => [
                'monthly' => $this->monthly_price,
                'annually' => $this->yearly_price
            ]
        ];
    }
}
