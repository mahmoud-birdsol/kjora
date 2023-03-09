<?php

namespace App\Http\Controllers;

use App\Actions\Verification\CreateVerificationCode;
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

        $request->session()->put('message', [
            'type' => 'success',
            'content' => 'Verification code sent.',
        ]);

        return back();
    }
}
