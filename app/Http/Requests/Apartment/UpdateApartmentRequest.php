<?php

declare(strict_types=1);

namespace App\Http\Requests\Apartment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'building_id' => ['sometimes', 'required', 'integer', 'exists:buildings,id'],
            'floor_type' => ['sometimes', 'required', 'string', 'max:100'],
            'water_meter' => ['sometimes', 'nullable', 'string', 'max:100'],
            'electricity_meter' => ['sometimes', 'nullable', 'string', 'max:100'],
            'landline' => ['sometimes', 'nullable', 'string', 'max:50'],
            'is_sealed' => ['sometimes', 'required', 'boolean'],
        ];
    }
}