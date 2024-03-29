<?php

namespace App\Http\Responses;

use App\Services\FlashMessage;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse as ProfileInformationUpdatedResponseContract;

class ProfileInformationUpdatedResponse implements ProfileInformationUpdatedResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        FlashMessage::make()->success(
            message: __('Congratulations your account has been successfully updated.')
        )->closeable()->send();

        return redirect()->route('home');
    }
}
