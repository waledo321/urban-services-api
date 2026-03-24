<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Family */
class FamilyResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'apartment_id' => $this->apartment_id,
            'family_book' => $this->family_book,
            'health_status' => $this->health_status,
            'living_status' => $this->living_status,
            'last_aid_date' => $this->last_aid_date,
            'unemployed_count' => $this->unemployed_count,
            'students_count' => $this->students_count,
            'occupancy_type' => $this->occupancy_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'apartment' => new ApartmentResource($this->whenLoaded('apartment')),
            'shops' => ShopResource::collection($this->whenLoaded('shops')),
            'graves' => GraveResource::collection($this->whenLoaded('graves')),
            'complaints' => ComplaintResource::collection($this->whenLoaded('complaints')),
        ];
    }
}