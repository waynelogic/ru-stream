<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'type' => $this->type,
            'pp_id' => $this->pricing_plan_id,
            'name' => $this->pricing_plan->name,
            'auto_renew' => $this->auto_renew,
            'start_at' => $this->start_at,
            'trial_ends_at' => $this->trial_ends_at,
            'ends_at' => $this->ends_at,
            'percentage' => $this->percentage,
            'max_accounts_count' => $this->pricing_plan->max_accounts_count,
            'max_streams_count' => $this->pricing_plan->max_streams_count
        ];
    }
}
