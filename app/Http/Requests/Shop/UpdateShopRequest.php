<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
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
            'owner_family_id' => ['sometimes', 'required', 'integer', 'exists:families,id'],
            'profession' => ['sometimes', 'required', 'string', 'max:255'],
            'occupancy_type' => ['sometimes', 'required', 'string', 'max:100'],
        ];
    }
}