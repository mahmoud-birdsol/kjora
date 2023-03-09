<?php

namespace App\Actions\Verification;

use App\Models\User;

class VerifyUser
{
    /**
     * @var \App\Actions\Verification\SendVerifiedNotification
     */
    private SendVerifiedNotification $sendVerifiedNotification;

    /**
     * @param  \App\Actions\Verification\SendVerifiedNotification  $sendVerifiedNotification
     */
    public function __construct(SendVerifiedNotification $sendVerifiedNotification)
    {
        $this->sendVerifiedNotification = $sendVerifiedNotification;
    }

    /**
     * Mark the user identity as verified, and notify them.
     */
    public function __invoke(User $user): void
    {
        $user->markAccountAsVerified();

        ($this->sendVerifiedNotification)($user);
    }
}
