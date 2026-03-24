<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Shop */
class ShopResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'building_id' => $this->building_id,
            'owner_family_id' => $this->owner_family_id,
            'profession' => $this->profession,
            'occupancy_type' => $this->occupancy_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'owner_family' => new FamilyResource($this->whenLoaded('ownerFamily')),
        ];
    }
}