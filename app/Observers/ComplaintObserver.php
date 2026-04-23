<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Complaint;
use App\Models\User;
use App\Notifications\ComplaintStatusUpdatedNotification;
use Illuminate\Support\Facades\Log;

class ComplaintObserver
{
    public function updated(Complaint $complaint): void
    {
        // After persist, dirty flags are cleared; use wasChanged() to detect attribute changes.
        if (! $complaint->wasChanged('status')) {
            return;
        }

        $complaint->loadMissing('family.user');

        $user = $complaint->family?->user;

        if (! $user instanceof User) {
            Log::info('Complaint status updated but no family user to notify.', [
                'complaint_id' => $complaint->getKey(),
                'family_id' => $complaint->family_id,
            ]);

            return;
        }

        $user->notify(new ComplaintStatusUpdatedNotification($complaint));

        Log::info('Complaint status update notification dispatched.', [
            'complaint_id' => $complaint->getKey(),
            'user_id' => $user->getKey(),
            'status' => $complaint->status,
        ]);
    }
}
