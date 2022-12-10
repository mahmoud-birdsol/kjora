<?php

namespace App\Actions\Verification;

use App\Models\User;
use App\Notifications\VerificationReminderNotification;

class SendVerificationReminder
{
    /**
     * Send verification reminder notification to the specified user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __invoke(User $user): void
    {
        $user->notify(new VerificationReminderNotification());
    }
}
