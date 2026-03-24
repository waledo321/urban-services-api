<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
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
            'owner_family_id' => ['required', 'integer', 'exists:families,id'],
            'profession' => ['required', 'string', 'max:255'],
            'occupancy_type' => ['required', 'string', 'max:100'],
        ];
    }
}