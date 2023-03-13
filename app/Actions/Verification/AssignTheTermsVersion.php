<?php

namespace App\Actions\Verification;

use App\Models\TermsAndConditions;
use App\Models\User;

class AssignTheTermsVersion
{
    /**
     * Assign the user terms  as version,
     *
     * @param  \App\Models\User  $user
     * @param  TermsAndConditions  $termsAndConditions
     * @return void
     */
    public function __invoke(User $user , TermsAndConditions $termsAndConditions): void
    {
        $user->update(['accepted_terms_and_conditions_version'=>$termsAndConditions->version]);
    }
}
