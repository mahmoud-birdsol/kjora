<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Position;
use Inertia\Inertia;
use Inertia\Response;

class UserProfileController extends Controller
{
    /**
     * Display the user profile page.
     *
     * @return \Inertia\Response
     */
    public function show(): Response
    {
        $countries = Country::active()->orderBy('name')->get();
        $positions = Position::all();

        return Inertia::render('Profile/Show', [
            'countries' => $countries,
            'positions' => $positions,
        ]);
    }
}
