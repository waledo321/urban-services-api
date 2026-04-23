<?php

declare(strict_types=1);

namespace App\Traits;

use App\Support\ApiEnvelope;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function successResponse(string $message, mixed $data = null, int $code = 200): JsonResponse
    {
        return ApiEnvelope::success($message, $data, $code);
    }

    protected function errorResponse(string $message, mixed $errors = null, int $code = 400): JsonResponse
    {
        return ApiEnvelope::error($message, $errors, $code);
    }
}
