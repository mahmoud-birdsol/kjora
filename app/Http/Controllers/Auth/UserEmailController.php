<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserEmailController extends Controller
{
    /**
     * Display the update  user name view.
     *
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Auth/UpdateEmail');
    }

    /**
     * Update the user's password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->user()->id],
        ]);
        //Match The Old Password
        if (! Hash::check($request->password, auth()->user()->password)) {
            FlashMessage::make()->error(
                message: __('Password Doesnt match!')
            )->closeable()->send();

            return redirect()->back();
        }
        $user = Auth::user();
        $user->update([
            'email' => $request->get('email'),
            'email_verified_at' => null,
        ]);
        $user->sendEmailVerificationNotification();

        FlashMessage::make()->success(
            message: __('email-changed-successfully-please-verify-your-mail')
        )->closeable()->send();

        return redirect()->route('home');
    }
}
