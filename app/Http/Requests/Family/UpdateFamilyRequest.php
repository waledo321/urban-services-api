<?php

declare(strict_types=1);

namespace App\Http\Requests\Family;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFamilyRequest extends FormRequest
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
        $familyId = $this->route('family')?->id ?? $this->route('family');

        return [
            'apartment_id' => ['sometimes', 'required', 'integer', 'exists:apartments,id'],
            'family_book' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('families', 'family_book')->ignore($familyId),
            ],
            'health_status' => ['sometimes', 'nullable', 'string', 'max:255'],
            'living_status' => ['sometimes', 'required', 'string', 'max:100'],
            'last_aid_date' => ['sometimes', 'nullable', 'date'],
            'unemployed_count' => ['sometimes', 'required', 'integer', 'min:0'],
            'students_count' => ['sometimes', 'required', 'integer', 'min:0'],
            'occupancy_type' => ['sometimes', 'required', 'string', 'max:100'],
        ];
    }
}
