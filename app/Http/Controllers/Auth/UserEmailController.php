<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserEmailController extends Controller
{
    /**
     * Display the update  user name view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Auth/UpdateEmail');

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
            'password' => ['required', 'current_password'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        #Match The Old Password
        if(!Hash::check($request->password, auth()->user()->password)){
            $request->session()->flash('message', [
                'type' => 'error',
                'body' => "Password Doesn't match!",
            ]);
            return redirect()->back();
        }
        $user = Auth::user();
        $user->update([
            'email' => $request->get('email'),
            'email_verified_at'=>null
        ]);
//        $request->session()->flash('message', [
//            'type' => 'success',
//            'body' => 'User name changed successfully',
//        ]);
        return redirect()->route('home');

    }
}
