<?php

namespace App\Http\Controllers;

use App\Actions\Verification\CreateVerificationCode;
use App\Services\FlashMessage;
use Illuminate\Http\Request;

class ResendVerificationCodeController extends Controller
{
    /**
     * Resend the verification code
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\Verification\CreateVerificationCode $createVerificationCode
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function __invoke(
        Request $request,
        CreateVerificationCode $createVerificationCode
    )
    {
        ($createVerificationCode)($request->user());


        FlashMessage::make()->success(
            message: __('Verification code sent.')
        )->closeable()->send();

        return back();
    }
}
