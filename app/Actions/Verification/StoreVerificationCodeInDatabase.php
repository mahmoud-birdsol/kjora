<?php

namespace App\Actions\Verification;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoreVerificationCodeInDatabase
{
    /**
     * Stores the code in the table
     */
    public function __invoke(User $user, int $code): void
    {
        DB::table(config('verification.verification_codes_table'))
            ->insert([
                'user_id' => $user->id,
                'code' => $code,
                'created_at' => Carbon::now(),
            ]);
    }
}
