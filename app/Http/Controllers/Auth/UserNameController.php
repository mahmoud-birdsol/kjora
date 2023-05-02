<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserNameController extends Controller
{
    /**
     * Display the update  user name view.
     *
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Auth/UpdateUserName');
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
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_num','regex:/^\S*$/u'],
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
            'username' => preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->get('username')),
        ]);
        FlashMessage::make()->success(
            message: __('User name changed successfully')
        )->closeable()->send();

        return redirect()->route('home');
    }
}
