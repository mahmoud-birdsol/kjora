<?php

namespace App\Actions\Verification;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoreVerificationCodeInDatabase
{
    /**
     * Stores the code in the table
     *
     * @param string $phone
     * @param int $code
     * @return void
     */
    public function __invoke(string $phone, int $code): void
    {
        DB::table(config('verification.verification_codes_table'))
            ->insert([
                'phone' => $phone,
                'code' => $code,
                'created_at' => Carbon::now(),
            ]);
    }
}
