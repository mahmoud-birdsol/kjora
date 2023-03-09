<?php

namespace App\Http\Responses;

use App\Models\Country;
use App\Models\Position;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\RegisterViewResponse;

class RegisterResponse implements RegisterViewResponse
{
    /**
     * {@inheritDoc}
     */
    public function toResponse($request)
    {
        $countries = Country::active()->orderBy('name')->get();
        $positions = Position::all();

        $defaultCountryId = nova_get_setting('default_country');
        $defaultClub = Club::find(nova_get_setting('default_club'));

        return Inertia::render('Auth/Register', [
            'countries' => $countries,
            'positions' => $positions,
            'defaultClub' => $defaultClub,
            'defaultCountryId' => $defaultCountryId
        ])->toResponse($request);
    }
}
