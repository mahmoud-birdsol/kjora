<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPhoneRequest;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationCodeController extends Controller
{
    /**
     * Show the verification code form
     *
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Auth/VerifyPhone', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Verify the phone of the user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(VerifyPhoneRequest $request)
    {
        $request->user()->verifyPhone();

        FlashMessage::make()->success(
            message: __('thank-you-for-verifying-your-phone')
        )->closeable()->send();

        return redirect()->route('home');
    }
}
