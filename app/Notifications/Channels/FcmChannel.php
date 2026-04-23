<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\Services\FirebaseNotificationService;
use Illuminate\Notifications\Notification;

final class FcmChannel
{
    public function __construct(
        private readonly FirebaseNotificationService $firebaseNotificationService,
    ) {}

    public function send(object $notifiable, Notification $notification): void
    {
        $token = $notifiable->fcm_token ?? null;

        if (! is_string($token) || $token === '') {
            return;
        }

        if (! method_exists($notification, 'toFcm')) {
            return;
        }

        /** @var array{title: string, body: string, data?: array<string, mixed>} $payload */
        $payload = $notification->toFcm($notifiable);

        $this->firebaseNotificationService->sendPushNotification(
            $token,
            $payload['title'],
            $payload['body'],
            $payload['data'] ?? [],
        );
    }
}
