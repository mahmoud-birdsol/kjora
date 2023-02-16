<?php

namespace App\Actions\Verification;

use App\Models\User;
use App\Notifications\IdentityVerifiedNotification;

class SendVerifiedNotification
{
    /**
     * Send account verified notification.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __invoke(User $user): void
    {
        $user->notify(new IdentityVerifiedNotification());
    }
}
