<?php

declare(strict_types=1);

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
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
            'family_id' => ['required', 'integer', 'exists:families,id'],
            'description' => ['required', 'string'],
            'ai_category' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:50'],
            'status' => ['sometimes', 'required', 'string', 'max:50'],
        ];
    }
}