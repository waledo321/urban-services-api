<?php

declare(strict_types=1);

namespace App\Http\Requests\Grave;

use Illuminate\Foundation\Http\FormRequest;

class StoreGraveRequest extends FormRequest
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
            'block_name' => ['required', 'string', 'max:100'],
            'row_number' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'in:available,occupied'],
        ];
    }
}