<?php

namespace App\Listeners;

use App\Actions\Verification\CreateVerificationCode;
use Illuminate\Auth\Events\Registered;

class SendVerificationCodeNotification
{
    /**
     * Handle the event.
     *
     * @throws \Exception
     */
    public function handle(Registered $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;
        $createVerificationCode = resolve(CreateVerificationCode::class);
        if (! $user->hasVerifiedPhone()) {
            ($createVerificationCode)($user);
        }
    }
}
