<?php

namespace App\Http\Responses;

use App\Models\Club;
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

        return Inertia::render('Auth/Register', [
            'countries' => $countries,
            'positions' => $positions,
        ])->toResponse($request);
    }
}
