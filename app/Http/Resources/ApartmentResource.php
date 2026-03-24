<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Apartment */
class ApartmentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'building_id' => $this->building_id,
            'floor_type' => $this->floor_type,
            'water_meter' => $this->water_meter,
            'electricity_meter' => $this->electricity_meter,
            'landline' => $this->landline,
            'is_sealed' => $this->is_sealed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'families' => FamilyResource::collection($this->whenLoaded('families')),
        ];
    }
}