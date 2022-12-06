<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinPlatformRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Token;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class JoinPlatformController extends Controller
{
    /**
     * Display the form to join the platform and reset password.
     *
     * @param  string  $token
     * @return \Inertia\Response
     */
    public function create(string $token): Response
    {
        $user = Token::make('join_platform_tokens')->find($token)->authenticatable();

        return Inertia::render('Auth/JoinPlatform', [
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Update the user information, authenticate and redirect to dashboard.
     *
     * @param  \App\Http\Requests\JoinPlatformRequest  $request
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(JoinPlatformRequest $request, string $token): RedirectResponse
    {
        $token = Token::make('join_platform_tokens')->find($token);

        $token->authenticatable()->forceFill($request->only([
            'name',
            'password',
        ]))->update();

        Auth::guard($token->guard())->login($token->authenticatable());

        return $token->guard() == 'admin'
            ? redirect('/nova')
            : redirect(RouteServiceProvider::HOME);
    }
}
