<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Building */
class BuildingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'real_estate_number' => $this->real_estate_number,
            'license_number' => $this->license_number,
            'total_floors' => $this->total_floors,
            'has_basement' => $this->has_basement,
            'has_garage' => $this->has_garage,
            'ownership_type' => $this->ownership_type,
            'is_illegal' => $this->is_illegal,
            'coordinates' => $this->coordinates,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'apartments' => ApartmentResource::collection($this->whenLoaded('apartments')),
            'shops' => ShopResource::collection($this->whenLoaded('shops')),
        ];
    }
}