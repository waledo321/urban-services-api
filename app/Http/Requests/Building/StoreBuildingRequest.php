<?php

declare(strict_types=1);

namespace App\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'real_estate_number' => ['required', 'string', 'max:255', 'unique:buildings,real_estate_number'],
            'license_number' => ['required', 'string', 'max:255', 'unique:buildings,license_number'],
            'total_floors' => ['required', 'integer', 'min:1'],
            'has_basement' => ['required', 'boolean'],
            'has_garage' => ['required', 'boolean'],
            'ownership_type' => ['required', 'string', 'max:100'],
            'is_illegal' => ['required', 'boolean'],
            'coordinates' => ['nullable', 'array'],
            'coordinates.lat' => ['nullable', 'numeric', 'between:-90,90'],
            'coordinates.lng' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
