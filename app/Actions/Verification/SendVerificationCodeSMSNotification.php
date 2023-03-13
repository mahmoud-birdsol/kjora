<?php

namespace App\Actions\Verification;

use App\Models\User;
use App\Notifications\VerificationCodeNotification;
use Illuminate\Support\Facades\Log;

class SendVerificationCodeSMSNotification
{
    /**
     * Send a verification for the phone number
     *
     * @param int $code
     * @param \App\Models\User $user
     * @return void
     */
    public function __invoke(int $code, User $user): void
    {
        $user->notify(new VerificationCodeNotification($code));
    }
}
