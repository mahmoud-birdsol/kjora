<?php

namespace App\Actions\Verification;

use App\Models\User;
use App\Notifications\IdentityVerifiedNotification;

class SendVerifiedNotification
{
    /**
     * Send account verified notification.
     */
    public function __invoke(User $user): void
    {
        $user->notify(new IdentityVerifiedNotification());
    }
}
