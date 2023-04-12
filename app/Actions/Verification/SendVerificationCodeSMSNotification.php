<?php

namespace App\Actions\Verification;

use App\Models\User;
use App\Notifications\VerificationCodeNotification;

class SendVerificationCodeSMSNotification
{
    /**
     * Send a verification for the phone number
     */
    public function __invoke(int $code, User $user): void
    {
        $user->notify(new VerificationCodeNotification($code));
    }
}
