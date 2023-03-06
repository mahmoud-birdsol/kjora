<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class PasswordController extends Controller
{
    /**
     * Display the password edit view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Auth/UpdatePassword');

    }
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
         $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', Password::defaults()],
        ]);
        #Match The Old Password
        if(!Hash::check($request->current_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }
        $user = Auth::user();
        $user->password =  Hash::make($request->get('new_password'));
        $user->save();

        return back();
    }
}
