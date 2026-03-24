<?php

declare(strict_types=1);

namespace App\Http\Requests\Family;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyRequest extends FormRequest
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
            'apartment_id' => ['required', 'integer', 'exists:apartments,id'],
            'family_book' => ['required', 'string', 'max:255', 'unique:families,family_book'],
            'health_status' => ['nullable', 'string', 'max:255'],
            'living_status' => ['required', 'string', 'max:100'],
            'last_aid_date' => ['nullable', 'date'],
            'unemployed_count' => ['required', 'integer', 'min:0'],
            'students_count' => ['required', 'integer', 'min:0'],
            'occupancy_type' => ['required', 'string', 'max:100'],
        ];
    }
}