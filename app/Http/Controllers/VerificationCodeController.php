<?php

namespace App\Http\Controllers;

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
}
