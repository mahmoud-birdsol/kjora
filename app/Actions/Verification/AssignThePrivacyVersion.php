<?php

namespace App\Actions\Verification;

use App\Models\PrivacyPolicy;
use App\Models\User;

class AssignThePrivacyVersion
{
    /**
     * Assign the user privacy  as version,
     */
    public function __invoke(User $user, PrivacyPolicy $privacyPolicy): void
    {
        $user->update(['accepted_privacy_policy_version' => $privacyPolicy->version]);
    }
}
