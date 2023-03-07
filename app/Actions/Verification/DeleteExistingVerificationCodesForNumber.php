<?php

namespace App\Actions\Verification;

use Illuminate\Support\Facades\DB;

class DeleteExistingVerificationCodesForNumber
{
    /**
     * Delete the verification code for this phone number if it exists
     *
     * @param string $phone
     * @return void
     */
    public function __invoke(string $phone): void
    {
        DB::table(config('verification.verification_codes_table'))
            ->where('phone', $phone)
            ->delete();
    }
}
