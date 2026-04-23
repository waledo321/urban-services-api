<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Complaint;
use App\Notifications\Channels\FcmChannel;
use App\Services\FirebaseNotificationService;
use Illuminate\Notifications\Notification;

class ComplaintStatusUpdatedNotification extends Notification
{
    public function __construct(
        public readonly Complaint $complaint,
    ) {}

    /**
     * @return array<int, string|class-string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if ($this->notifiableHasFcmToken($notifiable)) {
            $channels[] = FcmChannel::class;
        }

        return $channels;
    }

    private function notifiableHasFcmToken(object $notifiable): bool
    {
        return isset($notifiable->fcm_token)
            && is_string($notifiable->fcm_token)
            && $notifiable->fcm_token !== '';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'complaint_id' => $this->complaint->getKey(),
            'status' => $this->complaint->status,
            'message' => 'تم تحديث حالة الشكوى الخاصة بك إلى: '.$this->complaint->status,
        ];
    }

    /**
     * Payload for {@see FcmChannel} / {@see FirebaseNotificationService}.
     *
     * @return array{title: string, body: string, data: array<string, mixed>}
     */
    public function toFcm(object $notifiable): array
    {
        return [
            'title' => __('Complaint status updated'),
            'body' => __('Your complaint #:id is now :status.', [
                'id' => (string) $this->complaint->getKey(),
                'status' => $this->complaint->status,
            ]),
            'data' => [
                'complaint_id' => (string) $this->complaint->getKey(),
                'status' => (string) $this->complaint->status,
                'type' => 'complaint_status_updated',
            ],
        ];
    }
}
