<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => (string) ($this['token'] ?? ''),
            'token_type' => (string) ($this['token_type'] ?? 'Bearer'),
            'user' => $this['user'] ?? null,
        ];
    }
}