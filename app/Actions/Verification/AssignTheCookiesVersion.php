<?php

namespace App\Actions\Verification;

use App\Models\CookiePolicy;
use App\Models\User;

class AssignTheCookiesVersion
{
    /**
     * Assign the user cookies  as version,
     */
    public function __invoke(User $user, CookiePolicy $cookiePolicy): void
    {
        $user->update(['accepted_cookie_policy_version' => $cookiePolicy->version]);
    }
}
