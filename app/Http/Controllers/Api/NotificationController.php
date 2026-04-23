<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends BaseApiController
{
    public function updateFcmToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'fcm_token' => ['required', 'string', 'max:4096'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->forceFill([
            'fcm_token' => $validated['fcm_token'],
        ])->save();

        return $this->successResponse('FCM token updated successfully.');
    }
}
