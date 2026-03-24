<?php

declare(strict_types=1);

namespace App\Http\Requests\Apartment;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'building_id' => ['required', 'integer', 'exists:buildings,id'],
            'floor_type' => ['required', 'string', 'max:100'],
            'water_meter' => ['nullable', 'string', 'max:100'],
            'electricity_meter' => ['nullable', 'string', 'max:100'],
            'landline' => ['nullable', 'string', 'max:50'],
            'is_sealed' => ['required', 'boolean'],
        ];
    }
}