<?php

namespace App\Actions\Verification;

use App\Models\CookiePolicy;
use App\Models\PrivacyPolicy;
use App\Models\User;

class AssignTheCookiesVersion
{
    /**
     * Assign the user cookies  as version,
     *
     * @param  \App\Models\User  $user
     * @param   CookiePolicy $cookiePolicy
     * @return void
     */
    public function __invoke(User $user , CookiePolicy $cookiePolicy): void
    {
        $user->update(['accepted_cookie_policy_version'=>$cookiePolicy->version]);
    }
}
