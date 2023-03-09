<?php

namespace App\Listeners;

use App\Actions\Verification\CreateVerificationCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationCodeNotification
{
    /**
     * Handle the event.
     *
     * @param \Illuminate\Auth\Events\Registered $event
     * @return void
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
