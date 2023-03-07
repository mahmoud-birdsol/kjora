<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPhoneRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationCodeController extends Controller
{
    /**
     * Show the verification code form
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Verification/Create', [
            'user' => $request->user()
        ]);
    }

    /**
     * Verify the phone of the user
     *
     * @param \App\Http\Requests\VerifyPhoneRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(VerifyPhoneRequest $request)
    {
        $request->user()->verifyPhone();

        $request->session()->flash('message', [
            'type' => 'success',
            'content' => __('Thank you for verifying your phone'),
        ]);

        return redirect()->route('home');
    }
}
