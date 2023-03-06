<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserPhoneController extends Controller
{
    /**
     * Display the update  user phone view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Auth/UpdatePhone');

    }
    /**
     * Update the user's phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'phone' => ['required', 'phone']
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
            'phone' => $request->get('phone'),
            'phone_verified_at'=>null
        ]);

//        $request->session()->flash('message', [
//            'type' => 'success',
//            'body' => 'User name changed successfully',
//        ]);
        return redirect()->route('home');

    }
}
