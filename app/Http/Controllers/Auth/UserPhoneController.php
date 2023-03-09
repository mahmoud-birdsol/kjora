<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Verification\CreateVerificationCode;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Notifications\VerificationCodeNotification;
use App\Services\FlashMessage;
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
        $countries = Country::active()->orderBy('name')->get();

        return Inertia::render('Auth/UpdatePhone',[
            'countries' => $countries,

        ]);

    }
    /**
     * Update the user's phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request , CreateVerificationCode $createVerificationCode )
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'phone' => ['required', 'phone', 'unique:users,phone,'. auth()->user()->id ]
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
        ($createVerificationCode)($user);
        FlashMessage::make()->success(
            message: 'Phone changed successfully'
        )->closeable()->send();

        return redirect()->route('phone.verify');

    }
}