<?php

namespace App\Http\Responses;

class RegisterSuccessfulResponse implements \Laravel\Fortify\Contracts\RegisterResponse
{

    /**
     * {@inheritDoc}
     */
    public function toResponse($request)
    {
        return redirect()->route('phone.verify');
    }
}
