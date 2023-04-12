<?php

namespace App\Actions\Verification;

use App\Models\User;

class CreateVerificationCode
{
    private DeleteExistingVerificationCodesForNumber $deleteExistingVerificationCodesForNumber;

    private GenerateRandomCodeNumber $generateRandomCodeNumber;

    private StoreVerificationCodeInDatabase $storeVerificationCodeInDatabase;

    private SendVerificationCodeSMSNotification $sendVerificationCodeSMSNotification;

    public function __construct(
        DeleteExistingVerificationCodesForNumber $deleteExistingVerificationCodesForNumber,
        GenerateRandomCodeNumber $generateRandomCodeNumber,
        StoreVerificationCodeInDatabase $storeVerificationCodeInDatabase,
        SendVerificationCodeSMSNotification $sendVerificationCodeSMSNotification
    ) {
        $this->deleteExistingVerificationCodesForNumber = $deleteExistingVerificationCodesForNumber;
        $this->generateRandomCodeNumber = $generateRandomCodeNumber;
        $this->storeVerificationCodeInDatabase = $storeVerificationCodeInDatabase;
        $this->sendVerificationCodeSMSNotification = $sendVerificationCodeSMSNotification;
    }

    /**
     * Create a verification code for the mobile number
     *
     * @throws \Exception
     */
    public function __invoke(User $user): void
    {
        $code = ($this->generateRandomCodeNumber)();

        ($this->deleteExistingVerificationCodesForNumber)($user);
        ($this->storeVerificationCodeInDatabase)($user, $code);
        ($this->sendVerificationCodeSMSNotification)($code, $user);
    }
}
