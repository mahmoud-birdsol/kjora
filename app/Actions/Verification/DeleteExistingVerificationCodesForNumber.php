<?php

namespace App\Actions\Verification;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteExistingVerificationCodesForNumber
{
    /**
     * Delete the verification code for this phone number if it exists
     */
    public function __invoke(User $user): void
    {
        DB::table(config('verification.verification_codes_table'))
            ->where('user_id', $user->id)
            ->delete();
    }
}
