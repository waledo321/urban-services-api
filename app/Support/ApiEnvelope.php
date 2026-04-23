<?php

declare(strict_types=1);

namespace App\Support;

use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Single source of truth for the public API JSON envelope.
 *
 * Keep field names and shapes aligned with {@see ApiResponseTrait}
 * and exception rendering in bootstrap/app.php.
 */
final class ApiEnvelope
{
    public static function success(string $message, mixed $data = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null,
        ], $status);
    }

    public static function error(string $message, mixed $errors = null, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors,
        ], $status);
    }

    /**
     * @param  non-empty-string  $prefix
     */
    public static function isApiRequest(Request $request, string $prefix = 'api/'): bool
    {
        return $request->is($prefix.'*');
    }
}
