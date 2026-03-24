<?php

declare(strict_types=1);

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintRequest extends FormRequest
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
            'family_id' => ['sometimes', 'required', 'integer', 'exists:families,id'],
            'description' => ['sometimes', 'required', 'string'],
            'ai_category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'priority' => ['sometimes', 'required', 'string', 'max:50'],
            'status' => ['sometimes', 'required', 'string', 'max:50'],
        ];
    }
}