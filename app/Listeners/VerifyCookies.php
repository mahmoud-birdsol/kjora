<?php

namespace App\Listeners;

use App\Actions\Verification\AssignTheCookiesVersion;
use App\Models\CookiePolicy;
use Illuminate\Auth\Events\Registered;

class VerifyCookies
{
    private AssignTheCookiesVersion $assignTheCookiesVersion;

    public function __construct(AssignTheCookiesVersion $assignTheCookiesVersion)
    {
        $this->assignTheCookiesVersion = $assignTheCookiesVersion;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;
        $lastCookiesPolicy = CookiePolicy::latest()->whereNotNull('published_at')->first();

        if (! is_null($lastCookiesPolicy)) {
            ($this->assignTheCookiesVersion)($user, $lastCookiesPolicy);
        }
    }
}
