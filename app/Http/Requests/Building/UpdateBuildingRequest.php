<?php

declare(strict_types=1);

namespace App\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $buildingId = $this->route('building')?->id ?? $this->route('building');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'real_estate_number' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('buildings', 'real_estate_number')->ignore($buildingId),
            ],
            'license_number' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('buildings', 'license_number')->ignore($buildingId),
            ],
            'total_floors' => ['sometimes', 'required', 'integer', 'min:1'],
            'has_basement' => ['sometimes', 'required', 'boolean'],
            'has_garage' => ['sometimes', 'required', 'boolean'],
            'ownership_type' => ['sometimes', 'required', 'string', 'max:100'],
            'is_illegal' => ['sometimes', 'required', 'boolean'],
            'coordinates' => ['sometimes', 'nullable', 'array'],
            'coordinates.lat' => ['nullable', 'numeric', 'between:-90,90'],
            'coordinates.lng' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
