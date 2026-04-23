<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging as MessagingContract;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Kreait\Firebase\Exception\MessagingException;
use Throwable;

final class FirebaseNotificationService
{
    /**
     * @return array<string, string>
     */
    private function normalizeDataPayload(array $data): array
    {
        $normalized = [];

        foreach ($data as $key => $value) {
            $normalized[(string) $key] = is_scalar($value)
                ? (string) $value
                : (string) json_encode($value);
        }

        return $normalized;
    }

    /**
     * @return array{missing: bool, reason: string|null}
     */
    private function firebaseCredentialsProblem(): array
    {
        $project = config('firebase.default');

        if (! is_string($project) || $project === '') {
            return ['missing' => true, 'reason' => 'firebase.default is not configured.'];
        }

        /** @var mixed $raw */
        $raw = config("firebase.projects.{$project}.credentials");

        if ($raw === null || $raw === '') {
            return ['missing' => true, 'reason' => 'No Firebase credentials path or value (FIREBASE_CREDENTIALS / GOOGLE_APPLICATION_CREDENTIALS).'];
        }

        if (is_string($raw)) {
            $trim = ltrim($raw);
            if (str_starts_with($trim, '{')) {
                return ['missing' => false, 'reason' => null];
            }

            $path = $raw;
            if (! str_starts_with($path, '/') && ! preg_match('/^[A-Za-z]:[\\\\\\/]/', $path)) {
                $path = base_path($path);
            }

            if (! is_file($path) || ! is_readable($path)) {
                return ['missing' => true, 'reason' => "Firebase credentials file not found or unreadable at: {$path}"];
            }
        }

        return ['missing' => false, 'reason' => null];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function sendPushNotification(
        string $fcmToken,
        string $title,
        string $body,
        array $data = [],
    ): bool {
        if ($fcmToken === '') {
            Log::warning('FCM send skipped: empty registration token.');

            return false;
        }

        $cred = $this->firebaseCredentialsProblem();

        if ($cred['missing']) {
            Log::notice('FCM send skipped: '.$cred['reason']);

            return false;
        }

        try {
            $messaging = $this->resolveMessaging();
        } catch (Throwable $e) {
            Log::error('FCM send failed: could not resolve Firebase Messaging.', [
                'exception' => $e->getMessage(),
            ]);

            return false;
        }

        if ($messaging === null) {
            return false;
        }

        try {
            $payload = [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ];

            $normalized = $this->normalizeDataPayload($data);

            if ($normalized !== []) {
                $payload['data'] = $normalized;
            }

            $messaging->send($payload);

            Log::info('FCM message sent.', [
                'token_prefix' => mb_substr($fcmToken, 0, 12).'…',
            ]);

            return true;
        } catch (InvalidArgumentException $e) {
            Log::error('FCM send failed: invalid arguments.', ['exception' => $e->getMessage()]);

            return false;
        } catch (MessagingException $e) {
            Log::error('FCM send failed: messaging API error.', ['exception' => $e->getMessage()]);

            return false;
        } catch (Throwable $e) {
            Log::error('FCM send failed: unexpected error.', ['exception' => $e->getMessage()]);

            return false;
        }
    }

    private function resolveMessaging(): MessagingContract
    {
        return app(MessagingContract::class);
    }
}
